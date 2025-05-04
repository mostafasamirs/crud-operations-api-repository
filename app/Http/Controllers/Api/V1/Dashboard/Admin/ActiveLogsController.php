<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Spatie\Activitylog\Models\Activity;

class ActiveLogsController extends Controller
{
    use ApiTrait;


    /**
     *  Handle activity log retrieval.
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $logs = Activity::latest()->paginate(config('app.paginate'));
        return $this->returnData($logs);
    }

}
