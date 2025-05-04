<?php

namespace App\Repositories;

use App\Models\ContactUs;
use App\Repositories\Interfaces\ContactUsRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactUsRepository implements ContactUsRepositoryInterface
{
    public function __construct(protected ContactUs $model)
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
     * @param string $uuid
     * @return mixed
     */
    public function destroy(string $uuid)
    {
        $data = $this->show($uuid);
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

    /**
     * @param string $uuid
     * @return Model|SoftDeletes|mixed
     */
    public function restore(string $uuid)
    {
        $data = $this->model->onlyTrashed()->where('uuid', $uuid)->firstOrFail();
        $data->restore();
        return $data;
    }

    /**
     * @param string $uuid
     * @return Model|SoftDeletes|mixed
     */
    public function forceDelete(string $uuid)
    {
        $data = $this->model->onlyTrashed()->where('uuid', $uuid)->firstOrFail();
        $data->forceDelete();
        return $data;
    }

    /**
     * @return int
     */
    public function getTrashedCount(): int
    {
        return $this->model->onlyTrashed()->count();
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getArchived(int $perPage): LengthAwarePaginator
    {
        return $this->model->onlyTrashed()->paginate($perPage);
    }

}
