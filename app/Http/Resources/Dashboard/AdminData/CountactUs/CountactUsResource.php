<?php

namespace App\Http\Resources\Dashboard\AdminData\CountactUs;

use App\Enums\StatusType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountactUsResource extends JsonResource
{

    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message_title' => $this->message_title,
            'message_body' => $this->message_body,
            'respond_message' => $this->respond_message,
            'created_at' => showDate($this->created_at),
        ];
    }
}
