<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GenerateFillableForModel extends Command
{
    protected $signature = 'make:fillable {model}';
    protected $description = 'Generate $fillable property for the specified model based on the table columns.';

    public function handle()
    {
        $modelName = $this->argument('model');
        $modelClass = "App\\Models\\{$modelName}";

        if (!$this->modelExists($modelClass)) {
            $this->error("Model {$modelClass} does not exist.");
            return;
        }

        $model = new $modelClass(); // Get the model instance
        $tableName = $model->getTable(); // Get the table name

        if (!$this->tableExists($tableName)) {
            $this->error("Table {$tableName} does not exist.");
            return;
        }

        $fillableColumns = $this->getFillableColumns($tableName);

        if (empty($fillableColumns)) {
            $this->error("No fillable columns found for table {$tableName}.");
            return;
        }

        $this->updateModelFile($modelName, $fillableColumns);
    }

    protected function modelExists($modelClass)
    {
        return class_exists($modelClass);
    }

    protected function tableExists($tableName)
    {
        return DB::getSchemaBuilder()->hasTable($tableName);
    }

    protected function getFillableColumns(string $tableName)
    {
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        return array_filter($columns, function ($column) {
            return !in_array($column, ['id', 'created_at', 'updated_at']);
        });
    }

    protected function updateModelFile($modelName, $fillableColumns)
    {
        $modelPath = app_path("Models/{$modelName}.php");

        if (!File::exists($modelPath)) {
            $this->error("Model file ({$modelPath}) does not exist.");
            return;
        }

        $content = File::get($modelPath);

        if (Str::contains($content, '$fillable')) {
            $this->error("The model already contains a \$fillable array.");
            return;
        }

        $fillableArray = $this->generateFillableArray($fillableColumns);
        $fillableStub = $this->generateFillableStub($fillableArray);

        $newContent = str_replace('}', $fillableStub . "\n}", $content);

        File::put($modelPath, $newContent);

        $this->info("The \$fillable array has been added to the {$modelName} model.");
    }


    protected function generateFillableArray($fillableColumns)
    {
        return "'" . implode("',\n    '", $fillableColumns) . "'";
    }

    protected function generateFillableStub($fillableArray)
    {
        return <<<EOT

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected \$fillable = [
        {$fillableArray}
    ];



EOT;
    }

}
