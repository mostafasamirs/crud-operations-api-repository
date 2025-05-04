<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\StoreNotificationRequest;
use App\Http\Resources\Dashboard\AdminData\Notification\NotificationResources;
use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    use ApiTrait;

    protected const RESOURCE = NotificationResources::class;


    public function __construct(protected NotificationRepositoryInterface $notificationRepository)
    {
        foreach (Notification::getPermissions() as $permission => $methods) {
            $middleware = new Middleware("permission:$permission");
            $middleware->only($methods);
        }
    }

    /**
     * @return JsonResponse
     * Retrieve a paginated list of notifications.
     */
    public function index()
    {
        $notifications = $this->notificationRepository->index(config('app.paginate'));
        return $this->returnData((self::RESOURCE)::collection($notifications)->response()->getData(), lang('api::notification.notifications'));
    }

    /**
     * @param StoreNotificationRequest $request
     * @return JsonResponse
     * Store a new notification with translations.
     */
    public function store(StoreNotificationRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations']);
            $notification = $this->notificationRepository->create($data);
            $this->notificationRepository->addTranslations($notification->id, $translations);
            DB::commit();
            return $this->returnData(new (self::RESOURCE)($notification), lang('api::notification.notification_created_successfully'));

        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }

    }

    /**
     * @param Notification $notification
     * @return JsonResponse
     * Display a specific notification.
     */
    public function show(string $uuid)
    {
        $notification = $this->notificationRepository->show($uuid);
        return $this->returnData(new (self::RESOURCE)($notification), lang('api::notification.notification_show_successfully'));

    }

    /**
     * @param Notification $notification
     * @return JsonResponse
     * Delete a notification.
     */
    public function destroy(string $uuid)
    {
        $this->notificationRepository->destroy($uuid);
        return $this->successMessage(lang('api::notification.notifications_deleted_successfully'));

    }
}
