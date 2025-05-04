<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class NotificationTranslation extends Model
{
    use LogsActivity;
    protected $table = 'notification_translations';
    protected $fillable =[
        'locale',
        'title',
        'body',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
