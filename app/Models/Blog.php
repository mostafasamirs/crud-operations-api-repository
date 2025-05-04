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

class Blog extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes ,LogsActivity ,Translatable;
    protected $with = ['translations'];
    protected $fillable = [
        'is_active',
        'link',
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

    public function translations(): HasMany
    {
        return $this->hasMany(BlogTranslation::class);
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
            'blogs.index' => ['index', 'show'],
            'blogs.create' => ['create', 'store'],
            'blogs.edit' => ['edit', 'update'],
            'blogs.destroy' => ['destroy'],
            'blogs.restore'=>['restore'],
            'blogs.forceDelete'=>['forceDelete'],
            'blogs.trashed'=>['trashed']
        ];
    }
}
