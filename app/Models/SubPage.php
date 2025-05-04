<?php

namespace App\Models;
use App\Enums\PagePositionEnum;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SubPage extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity;
    protected $with = ['translations'];
    protected $fillable = ['is_active','position','slug'];
    protected $table = 'sub_pages';
    public $translatedAttributes = [
        'title',
        'description',
        'short_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_tags',
    ];

    protected $casts = [
        'position' => PagePositionEnum::class,
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }


    public function translations()
    {
        return $this->hasMany(SubPageTranslation::class);
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
            'sub-pages.index' => ['index', 'show'],
            'sub-pages.create' => ['create', 'store'],
            'sub-pages.edit' => ['edit', 'update'],
            'sub-pages.destroy' => ['destroy'],
            'sub-pages.restore'=>['restore'],
            'sub-pages.forceDelete'=>['forceDelete'],
            'sub-pages.trashed'=>['trashed']
        ];
    }
}
