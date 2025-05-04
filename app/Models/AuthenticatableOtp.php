<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthenticatableOtp extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "authenticatable_otps";
    public const EXPIRATION_TIME = 5;
    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];
    public function authenticatable(): MorphTo
    {
        return $this->morphTo();
    }
    public function isValid()
    {
        return $this->isActive() && !$this->isExpired();
    }
    public function isActive()
    {
        return $this->active;
    }
    public function isExpired()
    {
        return $this->created_at->diffInMinutes(Carbon::now()) > static::EXPIRATION_TIME;
    }


    /**
     * @param $form
     * @param $to
     * @return int
     */
    public static function generateCode($form, $to)
    {
        return rand($form, $to);
    }


}
