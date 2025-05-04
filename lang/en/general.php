<?php

use App\Enums\DefaultType;
use App\Enums\GuardType;
use App\Enums\LanguageType;
use App\Enums\StatusType;

return[
    'change_status_successfully' => 'Status changed successfully',
    'not_found' => 'Data not found',
    'user_not_found' => 'User not found',
    'code_not_found' => 'Code not found',
    'data_not_found' => 'Data not found',
    'data_not_found_check_id' => 'Data not found',
    'login_success' => 'Login successful',
    'logout_successful' => 'Logout successful',
    'user_not_authenticated' => 'User not authenticated',
    'password_reset_successfully' => 'Password reset successfully',
    'password_reset_subject' => 'Password reset subject',
    'password_reset' => 'Password reset',
    'invalid_credentials' => 'Invalid credentials',
    'account_disabled' => 'Account disabled',
    'the_verification_code_has_expired' => 'The verification code has expired',
    'invalid_model_class' => 'Invalid model class',
    'code_verified_successfully' => 'Code verified successfully',

    'default_type_' . DefaultType::getActive() => 'Active Default Type',
    'default_type_' . DefaultType::getNotActive() => 'Inactive Default Type',
    'guard_type_' . GuardType::getAdmin() => 'Admin',
    'language_type_' . LanguageType::getArabic() => 'Arabic Language',
    'language_type_' . LanguageType::getEnglish() => 'English Language',
    'status_type_' . StatusType::getActive() => 'Active Status',
    'status_type_' . StatusType::getNotActive() => 'Inactive Status',
    'slug_unique' => 'The slug value is already in use. Please choose a different one.',

];
