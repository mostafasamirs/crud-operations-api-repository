<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleRepository implements RoleRepositoryInterface
{
    public function __construct(protected Role $model)
    {
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function index(int $perPage): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param string $uuid
     * @return mixed
     */
    public function destroy(string $uuid)
    {
        $data = $this->show($uuid);
        $data->syncPermissions([]);
        $data->delete();
        return $data;
    }

    /**
     * @param string $uuid
     * @return mixed
     */
    public function show(string $uuid)
    {
        return $this->model->where('uuid', $uuid)->firstOrFail();
    }

//    /**
//     * @param string $uuid
//     * @param bool $status
//     * @return mixed
//     */
//    public function changeStatus(string $uuid, bool $status)
//    {
//        $data = $this->show($uuid);
//        $data->update(['is_active' => $status]);
//        return $data;
//    }

    /**
     * @param string $uuid
     * @param array $data
     * @return mixed
     */
    public function update(string $uuid, array $data)

    {
        $showData = $this->show($uuid);
        $showData->update($data);
        return $showData;
    }

    /**
     * @param $dataModel
     * @param $data
     */

    public function addRoles($dataModel, $data)
    {
        if (isset($data['permissionArray'])) {
            foreach ($data['permissionArray'] as $permission => $value) {
                if ($value == 'allow') {
                    $this->model->findOrFail($dataModel)->givePermissionTo($permission);

                }
            }
        }
    }

    /**
     * @param int $roleId
     * @param array $data
     */
    public function updateRoles(int $roleId, array $data)
    {
        $role = $this->show($roleId);
        $role->syncPermissions([]);
        if (!empty($data['permissionArray'])) {
            foreach ($data['permissionArray'] as $permission => $value) {
                if ($value == 'allow') {
                    $role->givePermissionTo($permission);
                }
            }
        }
        return $role;
    }


    /**
     * @return array
     */
    public function getGroupedPermissions(): array
    {
        $permissions = $this->model->where('guard_name', 'admin')->get();

        return $permissions->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        })->toArray();
    }


}
