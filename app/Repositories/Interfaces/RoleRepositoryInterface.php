<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface RoleRepositoryInterface
{
    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function index(int $perPage): LengthAwarePaginator;

    /**
     * @param string $uuid
     * @return mixed
     */
    public function show(string $uuid);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param string $uuid
     * @param array $data
     * @return mixed
     */
    public function update(string $uuid, array $data);

    /**
     * @param string $uuid
     * @return mixed
     */
    public function destroy(string $uuid);

//    public function changeStatus(string $uuid, bool $status);

    /**
     * @param $data
     * @param array $translations
     * @return mixed
     */
    public function addRoles($dataModel, $data);

    /**
     * @param int $data
     * @param array $translations
     * @return mixed
     */
    public function updateRoles(int $data, array $translations);

    /**
     * @return mixed
     */
    public function getGroupedPermissions();
}
