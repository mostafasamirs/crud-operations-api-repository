<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Auth;

use App\Enums\GuardType;
use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Dashboard\Auth\LoggedIn\LoggedInDashboardResource;
use App\Models\Admin;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ApiTrait;


    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * Handle admin login:
     * - Validates credentials and account status.
     * - Generates an auth token for active users.
     * - Returns user data, roles, and permissions.
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {

        // Retrieve user by email for the 'admin' guard type
        $admin = Admin::whereEmail($request->email)->first();
        // If user not found or password mismatch, return invalid credentials error
        if (!$admin && !Hash::check($request->password, $admin->password)) {
            return $this->errorMessage(__('general.invalid_credentials'));
        }
        // Check account status and return appropriate error messages
        if (StatusType::isNotActive($admin->is_active)) {
            return $this->errorMessage(__('general.account_disabled'));
        }
        if (StatusType::isActive($admin->is_active)) {
        // If user is active, generate authentication token and prepare response
        $token = $admin->createToken(GuardType::getAdmin())->plainTextToken;
        // Optionally, update FCM token if needed
        // $admin->update(['fcm_token' => $request->fcm_token]);
            setPermissionsTeamId($admin->hasRole('admin') ? 0 : 1);
            $admin->load('roles', 'permissions');
            // Get permissions and roles for the authenticated user
            $permissions = $admin->getAllPermissions()->pluck('name');
            $roles = $admin->getRoleNames();

        // Prepare the response data
        $responseData = [
            'user' => new LoggedInDashboardResource($admin, $token, GuardType::getAdmin()),
            'roles' => $roles,
            'permissions' => $permissions,
        ];
        }
        // Return success response with user data and message
        return $this->returnData($responseData, __('general.login_success', ['name' => $admin->name]));
    }
}
