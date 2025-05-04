<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SliderTranslation extends Model
{
    use LogsActivity;
    protected $table = 'slider_translations';

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

    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }
}
