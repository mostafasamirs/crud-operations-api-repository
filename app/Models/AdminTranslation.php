<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AdminTranslation extends Model
{
    use LogsActivity;

    protected $table = 'admin_translations';
    protected $fillable=[
        'first_name',
        'second_name',
        'third_name',
        'last_name',
        'locale',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
