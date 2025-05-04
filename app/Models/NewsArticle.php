<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class NewsArticle extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity, Translatable;

    protected $with = ['translations'];
    protected $fillable = ['is_active', 'link','slug'];
    protected $table = 'news_articles';
    public $translatedAttributes = [
        'title',
        'description',
        'short_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_tags',
    ];
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

    public function translations(): HasMany
    {
        return $this->hasMany(NewsArticleTranslation::class);
    }
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')->performOnCollections('photo');
    }
    public static function getPermissions()
    {
        return [
            'news.index' => ['index', 'show'],
            'news.create' => ['create', 'store'],
            'news.edit' => ['edit', 'update'],
            'news.destroy' => ['destroy'],
            'news.restore'=>['restore'],
            'news.forceDelete'=>['forceDelete'],
            'news.trashed'=>['trashed']
        ];
    }

}
