<?php

use App\Enums\DefaultType;
use App\Enums\GuardType;
use App\Enums\LanguageType;
use App\Enums\StatusType;

return[
    'change_status_successfully'=> 'تغيير الحالة بنجاح',
    'not_found'=> 'لم يتم العثور على البيانات',
    'user_not_found'=> 'لم يتم العثور على المستخدم',
    'code_not_found'=> 'لم يتم العثور على الكود',
    'data_not_found'=> 'لم يتم العثور على البيانات',
    'data_not_found_check_id'=> 'لم يتم العثور على البيانات',
    'login_success'=> 'تسجل الدخول بنجاح',
    'logout_successful'=> 'تسجل الخروج بنجاح',
    'user_not_authenticated'=> 'لم تتم مصادقة المستخدم',
    'password_reset_successfully'=> 'إعادة تعيين كلمة المرور بنجاح',
    'password_reset_subject'=> 'موضوع إعادة تعيين كلمة المرور',
    'password_reset'=> 'إعادة تعيين كلمة المرور',
    'invalid_credentials'=> 'بيانات اعتماد غير صالحة',
    'account_disabled'=> ' الحساب معطل',
    'the_verification_code_has_expired'=> ' انتهت صلاحية رمز التحقق',
    'invalid_model_class'=> ' فئة النموذج غير صالحة',
    'code_verified_successfully'=> ' تم التحقق من الكود بنجاح',
    'default_type_' . DefaultType::getActive() => 'النوع الافتراضي النشط',
    'default_type_' . DefaultType::getNotActive() => 'النوع الافتراضي غير النشط',
    'guard_type_' . GuardType::getAdmin() => 'للمسؤول',
    'language_type_' . LanguageType::getArabic() => 'اللغة العربية',
    'language_type_' . LanguageType::getEnglish() => 'اللغة الإنجليزية',
    'status_type_' . StatusType::getActive() => 'الحالة نشطة',
    'status_type_' . StatusType::getNotActive() => 'الحالة غير نشطة',
    'slug_unique' => 'قيمة الـ slug مستخدمة من قبل، يرجى اختيار قيمة مختلفة.',

];
