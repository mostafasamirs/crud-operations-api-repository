<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface NotificationRepositoryInterface
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

    /**
     * @param $data
     * @param array $translations
     * @return mixed
     */
    public function addTranslations(int $data, array $translations);

    /**
     * @param $data
     * @param array $translations
     * @return mixed
     */
    public function updateTranslations(int $data, array $translations);
}
