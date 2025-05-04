<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Auth;
use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OTPRequest;
use App\Models\AuthenticatableOtp;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class VerificationOtp extends Controller
{
    use ApiTrait;


    /**
     * @param OTPRequest $request
     * @return JsonResponse
     * Verify the OTP:
     * - Validates the provided OTP and email.
     * - Checks for an existing, non-expired OTP.
     * - Marks the OTP as active.
     * - Retrieves the associated active user.
     * - Returns the user's email on success.
     */
    public function __invoke(OTPRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Fetch the latest OTP for the given email and code
        $verification = AuthenticatableOtp::where('code', $data['otp'])
            ->where('email', $data['email'])
            ->latest()
            ->first();
        if (!$verification) {
            return $this->errorMessage(__('general.code_not_found'));
        }

        // Check if the OTP is expired
        if ($verification->isExpired()) {
            return $this->errorMessage(__('general.the_verification_code_has_expired'));
        }

        // Mark the OTP as active
        $verification->update(['active' => true]);
        // Retrieve the related user model
        $modelClass = $verification->authenticatable_type;
        if (!class_exists($modelClass)) {
            return $this->errorMessage(__('general.invalid_model_class'));
        }

        $user = $modelClass::where('is_active', StatusType::getActive())
            ->where('id', $verification->authenticatable_id)
            ->first();

        if (is_null($user)) {
            return $this->errorMessage(__('general.user_not_found'));
        }

        // Optionally, you can perform additional actions here, such as logging in the user or redirecting them.
        return $this->returnData($user->email, __('general.code_verified_successfully'));
    }


}
