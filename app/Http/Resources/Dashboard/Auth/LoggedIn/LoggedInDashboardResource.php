<?php

namespace App\Http\Resources\Dashboard\Auth\LoggedIn;

use App\Enums\StatusType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoggedInDashboardResource extends JsonResource
{
    private $token;

    private $guard;

    public function __construct($resource, $token, $guard)
    {
        parent::__construct($resource);
        $this->token = $token;
        $this->guard = $guard;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = $request->header('lang') ?? app()->getLocale();
        $data = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'first_name' => $this->translateOrDefault($locale)->first_name ?? $this->first_name,
            'second_name' => $this->translateOrDefault($locale)->second_name ?? $this->second_name,
            'third_name' => $this->translateOrDefault($locale)->third_name ?? $this->third_name,
            'last_name' => $this->translateOrDefault($locale)->last_name ?? $this->last_name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'identity' => $this->identity,
            'country' => $this?->country?->translations->where('locale', $request->header('lang'))->select(['id', 'name', 'default_currency', 'nationality'])->first(),
            'is_active' => StatusType::getValue($this->is_active),
            'nationality_id' => $this->nationality_id,
            'address' => $this->address,
            'image' => showFile($this->resource, 'image'),
            'guard' => $this->guard,
            'token' => $this->token,
        ];

        return $data;

    }
}
