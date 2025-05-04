<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Slider extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes ,LogsActivity ,Translatable;

    protected $fillable = [
        'uuid',
        'website_link',
        'mobile_link',
        'is_active',
        'slug',
    ];

    public $translatedAttributes = [
        'title',
        'description',
        'short_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_tags',
    ];
    protected $with = ['translations'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

    public function translations(): HasMany
    {
        return $this->hasMany(SliderTranslation::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });

        static::deleting(function ($model) {
            $model->slug = Str::slug($model->name) . "-{$model->id}";
            $model->save();
        });
    }

    public static function getPermissions()
    {
        return [
            'sliders.index' => ['index', 'show'],
            'sliders.create' => ['create', 'store'],
            'sliders.edit' => ['edit', 'update'],
            'sliders.destroy' => ['destroy'],
            'sliders.restore'=>['restore'],
            'sliders.forceDelete'=>['forceDelete'],
            'sliders.trashed'=>['trashed']
        ];
    }



}
