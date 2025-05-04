<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TranslationTranslation extends Model
{
    use LogsActivity;
    protected $fillable = ['locale', 'value'];

    public function translation()
    {
        return $this->belongsTo(Translation::class);
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

//    protected static function boot()
//    {
//        parent::boot();
//        static::saved(function () {
//            Cache::forget('translations.all');
//        });
//    }
}
