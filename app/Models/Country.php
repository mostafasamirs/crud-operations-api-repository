<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Country extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity;
    protected $with = ['translations','media'];
    public $translatedAttributes = [
        'name',
        'default_currency',
        'nationality',
    ];

    protected $fillable =
        [
            'code',
            'is_active',
            'is_default',
        ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }
    public function translations(): HasMany
    {
        return $this->hasMany(CountryTranslation::class);
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
            'countries.index' => ['index', 'show'],
            'countries.create' => ['create', 'store'],
            'countries.edit' => ['edit', 'update'],
            'countries.destroy' => ['destroy'],
            'countries.restore'=>['restore'],
            'countries.forceDelete'=>['forceDelete'],
            'countries.trashed'=>['trashed']
        ];
    }
}
