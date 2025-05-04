<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class NewsArticleTranslation extends Model
{
    use LogsActivity;
    protected $table = 'news_articles_translations';

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
    public function news()
    {
        return $this->belongsTo(NewsArticle::class);
    }


}
