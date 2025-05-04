<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface ContactUsRepositoryInterface
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
     * @return int
     */
    public function getTrashedCount(): int;

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getArchived(int $perPage): LengthAwarePaginator;

}
