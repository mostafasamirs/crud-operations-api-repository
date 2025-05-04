<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface SettingRepositoryInterface
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
     * @param $validatedData
     * @return mixed
     */
    public function update($validatedData);
}
