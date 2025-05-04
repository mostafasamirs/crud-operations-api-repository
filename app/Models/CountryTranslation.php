<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CountryTranslation extends Model
{
    use LogsActivity;
    protected $table = 'country_translations';
    protected $fillable = [
        'name',
        'locale',
        'default_currency',
        'nationality'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
