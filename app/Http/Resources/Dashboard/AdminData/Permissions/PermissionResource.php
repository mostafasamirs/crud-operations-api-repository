<?php

namespace App\Http\Resources\Dashboard\AdminData\Permissions;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Check if the resource is a collection (grouped permissions)
        if ($this->resource instanceof Collection) {
            return $this->resource->map(fn($permission) => [
                'id' => $permission->id,
                'name' => $permission->name,
            ])->values()->toArray();
        }

        // Default transformation for single permission
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
