<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CityTranslation extends Model
{
    use LogsActivity;
    protected $table = 'city_translations';
    protected $fillable = ['name','locale',];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }

}
