<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SettingTranslation extends Model
{
    use LogsActivity;
    protected $fillable = ['value'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope('locale', function (Builder $builder) {
            $builder->where('locale', app()->getLocale());
        });
    }
}
