<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Traits\LogsActivity;

class City extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity,Translatable;
    protected $with = ['translations', 'country'];
    protected $fillable = ['country_id','is_active'];

    public $translatedAttributes = [
        'name',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }
    public function translations(): HasMany
    {
        return $this->hasMany(CityTranslation::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public static function getPermissions()
    {
        return [
            'cities.index' => ['index', 'show'],
            'cities.create' => ['create', 'store'],
            'cities.edit' => ['edit', 'update'],
            'cities.destroy' => ['destroy'],
            'cities.restore'=>['restore'],
            'cities.forceDelete'=>['forceDelete'],
            'cities.trashed'=>['trashed']
        ];
    }


}
