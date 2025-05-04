<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SubPageTranslation extends Model
{
    use LogsActivity;
    protected $fillable = [
        'locale',
        'name',
        'description',
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

    protected $table = 'sub_pages_translations';
    public function subpage()
    {
        return $this->belongsTo(SubPage::class);
    }

}
