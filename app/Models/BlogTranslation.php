<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BlogTranslation extends Model
{
    use LogsActivity;
    protected $table = 'blogs_translations';

    protected $fillable = [
        'locale',
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

    public function article()
    {
        return $this->belongsTo(Blog::class);
    }

}
