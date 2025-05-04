<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    use ApiTrait;


    /**
     * @param Request $request
     * @return JsonResponse
     *   Handle the logout process.
     **/
    public function __invoke(Request $request): JsonResponse
    {
        $user = Auth::id();
        if ($user) {
            $request->user()->currentAccessToken()->delete();

            return $this->successMessage(__('general.logout_successful'));
        } else {
            return $this->errorMessage(__('general.user_not_authenticated'));
        }
    }
}
