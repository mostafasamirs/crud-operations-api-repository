<?php

namespace App\Http\Resources\Dashboard\AdminData\Role;

use App\Enums\StatusType;
use App\Http\Resources\Dashboard\AdminData\Permissions\PermissionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResources extends JsonResource
{

    public function toArray(Request $request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'is_active' => StatusType::getValue($this->is_active),
            'created_at' => showDate($this->created_at),
            'permissions' => PermissionResource::collection($this->permissions) ?? null,
        ];
        return $data;
    }
}
