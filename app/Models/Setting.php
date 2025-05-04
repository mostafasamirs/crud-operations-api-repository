<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Http\UploadedFile;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Setting extends Model implements HasMedia
{
    use LogsActivity, Translatable, InteractsWithMedia;

    protected $fillable = ['key', 'plain_value', 'field_type', 'is_translatable'];

    protected $with = ['translations'];

    protected $casts = [
        'is_translatable' => 'boolean',
    ];
    public $translatedAttributes = [
        'value'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

    public static function getPermissions()
    {
        return [
            'settings.index' => ['index', 'show'],
            'settings.edit' => ['edit', 'update'],

        ];
    }


    public static function setMany($settings)
    {

        foreach ($settings as $key => $value) {
            self::set($key, $value);
        }
    }

    public static function getHtmlFieldType($value): string
    {
        $imageExtensions = ['png', 'jpg', 'jpeg', 'gif', 'ico', 'svg', 'webp', 'bmp', 'pdf', 'mp4', 'mp3'];

        if (is_array($value)) {
            return 'select-multiple';
        }
        if (is_bool($value)) {
            return 'checkbox';
        }
        if (is_int($value)) {
            return 'number';
        }
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }
        if (is_string($value) && preg_match('/^https?:\/\//', $value)) {
            if (is_string($value) && in_array(pathinfo($value, PATHINFO_EXTENSION), $imageExtensions)) {
                return 'file';
            }
            return 'url';
        }
        if (is_string($value) && in_array(pathinfo($value, PATHINFO_EXTENSION), $imageExtensions)) {
            return 'file';
        }
        if (is_string($value) && (strlen($value) > 100 || strpos($value, "\n") !== false)) {
            return 'textarea';
        }
        if ($value instanceof UploadedFile) {
            return 'file';
        }

        return 'text';
    }


    public static function getPlainValue($value): ?string
    {
        if (is_array($value)) {
            return json_encode($value);
        }
        if (is_bool($value)) {
            return $value ? '1' : '0';
        }
        return (string)$value;
    }


    public static function set($key, $value)
    {
        $imageExtensions = ['png', 'jpg', 'jpeg', 'gif', 'ico', 'svg', 'webp', 'bmp', 'pdf', 'mp4', 'mp3'];

        if ($key === 'translatable') {
            return static::setTranslatableSettings($value);
        }

        if ($value instanceof UploadedFile || in_array(pathinfo($value, PATHINFO_EXTENSION), $imageExtensions)) {
            $setting = static::updateOrCreate(['key' => $key]);
            if($setting->getFirstMediaUrl('settings')) {
                $setting->clearMediaCollection('settings');
            }
            $setting->addMedia($value)->toMediaCollection('settings');
            $value = $setting->getFirstMediaUrl('settings');
        }


        static::updateOrCreate(
            ['key' => $key],
            ['plain_value' => static::getPlainValue($value),
                'field_type' => static::getHtmlFieldType($value)
            ]
        );
    }

    public static function get($key)
    {
        return static::whereKey($key)->first()->value ?? null;
    }

    public static function setTranslatableSettings($settings = [])
    {
        foreach ($settings as $key => $value) {
            static::updateOrCreate(['key' => $key], [
                'is_translatable' => true,
                'plain_value' => static::getPlainValue($value),
                'field_type' => static::getHtmlFieldType($value)
            ]);
        }
        return true;
    }
}
