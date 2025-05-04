<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements HasMedia
{
    use HasFactory, SoftDeletes ,LogsActivity,HasRoles,InteractsWithMedia , Translatable , HasApiTokens;
    protected $fillable = [
        'mobile',
        'email',
        'password',
        'identity',
        'is_active',
        'country_id',
        'nationality_id',
        'address',
    ];
    protected $guard_name = ['admin'];

    public $translatedAttributes = [
        'first_name',
        'second_name',
        'third_name',
        'last_name',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

    protected function password():Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Hash::make($value),
        );
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public static function getPermissions()
    {
        return [
            'admins.index' => ['index', 'show'],
            'admins.create' => ['create', 'store'],
            'admins.edit' => ['edit', 'update'],
            'admins.destroy' => ['destroy'],
            'admins.restore'=>['restore'],
            'admins.forceDelete'=>['forceDelete'],
            'admins.trashed'=>['trashed']
        ];
    }
}
