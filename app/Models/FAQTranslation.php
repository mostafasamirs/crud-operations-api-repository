<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FAQTranslation extends Model
{
    use LogsActivity;
    protected $table = 'f_a_q_translations';
    protected $fillable = [
        'locale',
        'question',
        'answer'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }
}
