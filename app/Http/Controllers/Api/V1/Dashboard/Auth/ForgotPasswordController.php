<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Auth;


use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Jobs\SendPasswordResetEmailJob;
use App\Models\Admin;
use App\Models\AuthenticatableOtp;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController extends Controller
{
    use ApiTrait;

    /**
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     * Handle a forgot password request:
     * - Validates the request.
     * - Finds an active admin by email.
     * - Generates and stores a verification code.
     * - Dispatches an email job for password reset.
     * - Returns a success response.
     */
    public function __invoke(ForgotPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = Admin::where('is_active', StatusType::getActive())->whereEmail($data['email'])->first();

        if (is_null($user)) {
            return $this->errorMessage(__('general.user_not_found'));
        }

        $verificationCode = AuthenticatableOtp::generateCode(100000, 999999);
        AuthenticatableOtp::updateOrCreate(
            [
                'authenticatable_id' => $user->id,
                'authenticatable_type' => get_class($user),
            ],
            [
                'code' => $verificationCode,
                'email' => $user->email,
                'active' => true,
            ]
        );

        $emailData = [
            'message' => __('general.password_reset_subject'),
            'verificationCode' => $verificationCode,
            'name' => $user->name ?? 'mostafa',
            'lang' => $user->lang ?? 'en',
        ];

        // Dispatch the email job
        dispatch(new SendPasswordResetEmailJob($user->email, __('general.password_reset_subject'), $emailData));
        return $this->successMessage(__('general.password_reset'));
    }

}
