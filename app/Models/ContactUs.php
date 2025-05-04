<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ContactUs extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'read_at',
        'uuid',
        'message_title',
        'message_body',
        'respond_message',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
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
            'contact-us.index' => ['index', 'show'],
            'contact-us.create' => ['create', 'store'],
            'contact-us.edit' => ['edit', 'update'],
            'contact-us.destroy' => ['destroy'],
            'contact-us.restore'=>['restore'],
            'contact-us.forceDelete'=>['forceDelete'],
            'contact-us.trashed'=>['trashed']
        ];
    }
}
