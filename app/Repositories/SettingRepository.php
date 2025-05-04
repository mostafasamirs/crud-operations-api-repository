<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\Interfaces\SettingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SettingRepository implements SettingRepositoryInterface
{
    public function __construct(protected Setting $model)
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
    public function show(string $uuid)
    {
        return $this->model->where('uuid', $uuid)->firstOrFail();
    }

    /**
     * @param array $validatedData
     * @return mixed
     */

    public function update($validatedData)
    {
        DB::transaction(function () use ($validatedData) {
            foreach ($validatedData as $item) {
                Setting::where('id', $item['id'])->update([
                    'key' => $item['key'],
                    'field_type' => $item['field_type'],
                    'is_translatable' => filter_var($item['is_translatable'], FILTER_VALIDATE_BOOLEAN),
                    'plain_value' => $item['plain_value'],
                ]);
            }
        });

        return $this->model->whereIn('id', array_column($validatedData, 'id'))->get()
            ->map(function ($setting) {
                return [
                    'id' => $setting->id,
                    'key' => $setting->key,
                    'field_type' => $setting->field_type,
                    'plain_value' => $setting->plain_value,
                    'is_translatable' => $setting->is_translatable,
                    'created_at' => Carbon::parse($setting->created_at)->format('d-m-Y h:i A'),
                    'updated_at' => Carbon::parse($setting->updated_at)->format('d-m-Y h:i A'),
                    'translations' => $setting->translations,
                ];
            });
    }
}
