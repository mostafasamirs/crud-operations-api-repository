<?php

namespace App\Models;


use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\LaravelPackageTools\Concerns\Package\HasTranslations;

class Translation extends Model
{
    use HasTranslations, LogsActivity , Translatable;

    protected $fillable = ['key'];

    protected $with = ['translations'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }


    protected $translatedAttributes = ['value'];

    public function translations()
    {
        return $this->hasMany(TranslationTranslation::class);
    }

    public static function getPermissions()
    {
        return [
            'translations.index' => ['index', 'show'],
            'translations.edit' => ['edit', 'update'],

        ];
    }

}
