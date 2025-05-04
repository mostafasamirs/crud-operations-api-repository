<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Auth;

use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\Admin;
use App\Models\AuthenticatableOtp;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    use ApiTrait;

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     * /**
     * Reset the admin's password:
     * - Validates the request and retrieves an active admin.
     * - Verifies the active OTP and updates the password.
     * - Deletes the OTP and returns a success message.
     */
    public function __invoke(ResetPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = Admin::where('is_active', StatusType::getActive())->whereEmail($data['email'])->first();
        if (!$user) {
            return $this->errorMessage(__('general.user_not_found'));
        }
        $verification = AuthenticatableOtp::where('authenticatable_id', $user->id)->whereActive(true)->firstOrFail();
        if ($verification) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            $verification->delete();
        }
        return $this->successMessage(__('general.password_reset_successfully'));

    }
}
