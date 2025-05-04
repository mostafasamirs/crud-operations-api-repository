<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface SliderRepositoryInterface
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
     * @param string $uuid
     * @return mixed
     */
    public function restore(string $uuid);

    /**
     * @param string $uuid
     * @return mixed
     */
    public function forceDelete(string $uuid);

    /**
     * @param string $uuid
     * @param bool $status
     * @return mixed
     */
    public function changeStatus(string $uuid, bool $status);

    /**
     * @return int
     */
    public function getTrashedCount(): int;

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getArchived(int $perPage): LengthAwarePaginator;


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
