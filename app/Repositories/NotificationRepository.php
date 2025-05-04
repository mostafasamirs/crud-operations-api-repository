<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function __construct(protected Notification $model)
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
     * @param $data
     * @param array $translations
     * @return mixed
     */

    public function addTranslations(int $data, array $translations)
    {
        return $this->model->findOrFail($data)->translations()->createMany($translations);
    }

    /**
     * @param $data
     * @param array $translations
     * @return int
     */
    public function updateTranslations(int $data, array $translations)
    {
        return $this->model->findOrFail($data)->translations()->upsert($translations, ['locale']);
    }

}
