<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Notification extends Model
{
    use LogsActivity , Translatable;
    protected $with = ['translations'];
    protected $fillable = [
        'url',
        'mobile_link',
        'app_users',
        'website_users',
        'admins',
        'managers',
        'members',
        'both',
        'system_notification',
        'sms',
        'email',
    ];

    public $translatedAttributes = [
        'title',
        'body',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

    public function translations()
    {
        return $this->hasMany(NotificationTranslation::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public static function getPermissions()
    {
        return [
            'notifications.index' => ['index', 'show'],
            'notifications.create' => ['create', 'store'],
            'notifications.edit' => ['edit', 'update'],
            'notifications.destroy' => ['destroy'],
        ];
    }

}
