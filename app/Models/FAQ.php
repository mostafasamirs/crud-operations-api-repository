<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FAQ extends Model
{
    use LogsActivity;
    protected $table = 'f_a_q_s';
    protected $with = ['translations'];
    public $translatedAttributes = [
        'question',
        'answer'
    ];

    protected $fillable = [
        'is_active',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

    public function translations(): HasMany
    {
        return $this->hasMany(FAQTranslation::class);
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
            'faqs.index' => ['index', 'show'],
            'faqs.create' => ['create', 'store'],
            'faqs.edit' => ['edit', 'update'],
            'faqs.destroy' => ['destroy'],
        ];
    }

}
