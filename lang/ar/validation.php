<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    |
    |
    */

'accepted' => 'يجب قبول :attribute.',
'active_url' => 'ليس :attribute عنوان URL صالح.',
'after' => 'يجب أن يكون :attribute تاريخًا بعد :date.',
'after_or_equal' => 'يجب أن يكون :attribute تاريخًا بعد أو يساوي :date.',
'alpha' => 'يمكن أن يحتوي :attribute على حروف فقط.',
'alpha_dash' => 'يمكن أن يحتوي :attribute على حروف وأرقام وشرطات وشرطات سفلية فقط.',
'alpha_num' => 'يمكن أن يحتوي :attribute على حروف وأرقام فقط.',
'array' => 'يجب أن يكون :attribute مصفوفة.',
'before' => 'يجب أن يكون :attribute تاريخًا قبل :date.',
'before_or_equal' => 'يجب أن يكون :attribute تاريخًا قبل أو يساوي :date.',
'between' => [
    'numeric' => 'يجب أن يكون :attribute بين :min و :max.',
    'file' => 'يجب أن يكون :attribute بين :min و :max كيلوبايت.',
    'string' => 'يجب أن يكون :attribute بين :min و :max حرفًا.',
    'array' => 'يجب أن يحتوي :attribute على بين :min و :max عنصرًا.',
],
'boolean' => 'يجب أن يكون حقل :attribute صحيحًا أو خطأ.',
'confirmed' => 'تأكيد :attribute غير متطابق.',
'date' => 'ليس :attribute تاريخًا صالحًا.',
'date_equals' => 'يجب أن يكون :attribute تاريخًا يساوي :date.',
'date_format' => 'لا يتطابق :attribute مع الشكل :format.',
'different' => 'يجب أن يكون :attribute و :other مختلفين.',
'digits' => 'يجب أن يكون :attribute :digits رقمًا.',
'digits_between' => 'يجب أن يكون :attribute بين :min و :max رقمًا.',
'dimensions' => 'لـ :attribute أبعاد صورة غير صالحة.',
'distinct' => 'يحتوي حقل :attribute على قيمة مكررة.',
'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صالح.',
'ends_with' => 'يجب أن ينتهي :attribute بأحد القيم التالية: :values.',
'exists' => 'إن :attribute المحدد غير صالح.',
'file' => 'يجب أن يكون :attribute ملفًا.',
'filled' => 'يجب أن يحتوي حقل :attribute على قيمة.',
'gt' => [
    'numeric' => 'يجب أن يكون :attribute أكبر من :value.',
    'file' => 'يجب أن يكون :attribute أكبر من :value كيلوبايت.',
    'string' => 'يجب أن يكون :attribute أكبر من :value حرفًا.',
    'array' => 'يجب أن يحتوي :attribute على أكثر من :value عنصرًا.',
],
'gte' => [
    'numeric' => 'يجب أن يكون :attribute أكبر من أو يساوي :value.',
    'file' => 'يجب أن يكون :attribute أكبر من أو يساوي :value كيلوبايت.',
    'string' => 'يجب أن يكون :attribute أكبر من أو يساوي :value حرفًا.',
    'array' => 'يجب أن يحتوي :attribute على :value عنصرًا أو أكثر.',
],
'image' => 'يجب أن يكون :attribute صورة.',
'in' => 'إن :attribute المحدد غير صالح.',
'in_array' => 'لا يوجد حقل :attribute في :other.',
'integer' => 'يجب أن يكون :attribute عددًا صحيحًا.',
'ip' => 'يجب أن يكون :attribute عنوان IP صالحًا.',
'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صالحًا.',
'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صالحًا.',
'json' => 'يجب أن يكون :attribute سلسلة JSON صالحة.',
'lt' => [
    'numeric' => 'يجب أن يكون :attribute أقل من :value.',
    'file' => 'يجب أن يكون :attribute أقل من :value كيلوبايت.',
    'string' => 'يجب أن يكون :attribute أقل من :value حرفًا.',
    'array' => 'يجب أن يحتوي :attribute على أقل من :value عنصرًا.',
],
'lte' => [
    'numeric' => 'يجب أن يكون :attribute أقل من أو يساوي :value.',
    'file' => 'يجب أن يكون :attribute أقل من أو يساوي :value كيلوبايت.',
    'string' => 'يجب أن يكون :attribute أقل من أو يساوي :value حرفًا.',
    'array' => 'يجب ألا يحتوي :attribute على أكثر من :value عنصرًا.',
],
'max' => [
    'numeric' => 'يجب ألا يكون :attribute أكبر من :max.',
    'file' => 'يجب ألا يكون :attribute أكبر من :max كيلوبايت.',
    'string' => 'يجب ألا يكون :attribute أكبر من :max حرفًا.',
    'array' => 'يجب ألا يحتوي :attribute على أكثر من :max عنصرًا.',
],
'mimes' => 'يجب أن يكون :attribute ملفًا من النوع: :values.',
'mimetypes' => 'يجب أن يكون :attribute ملفًا من النوع: :values.',
'min' => [
    'numeric' => 'يجب أن يكون :attribute على الأقل :min.',
    'file' => 'يجب أن يكون :attribute على الأقل :min كيلوبايت.',
    'string' => 'يجب أن يكون :attribute على الأقل :min حرفًا.',
    'array' => 'يجب أن يحتوي :attribute على الأقل على :min عنصرًا.',
],
'not_in' => 'إن :attribute المحدد غير صالح.',
'not_regex' => 'تنسيق :attribute غير صالح.',
'numeric' => 'يجب أن يكون :attribute رقمًا.',
'password' => 'كلمة المرور غير صحيحة.',
'password_or_username' => 'كلمة المرور أو اسم المستخدم غير صحيح.',
'present' => 'يجب أن يكون حقل :attribute موجودًا.',
'regex' => 'تنسيق :attribute غير صالح.',
'required' => 'يجب ملء حقل :attribute.',
'required_if' => 'يجب ملء حقل :attribute عندما يكون :other هو :value.',
'required_unless' => 'يجب ملء حقل :attribute ما لم يكن :other ضمن :values.',
'required_with' => 'يجب ملء حقل :attribute عندما يكون :values موجودًا.',
'required_with_all' => 'يجب ملء حقل :attribute عندما تكون :values موجودة.',
'required_without' => 'يجب ملء حقل :attribute عندما لا يكون :values موجودًا.',
'required_without_all' => 'يجب ملء حقل :attribute عندما لا تكون أي من :values موجودة.',
'same' => 'يجب أن يتطابق :attribute مع :other.',
'size' => [
    'numeric' => 'يجب أن يكون :attribute :size.',
    'file' => 'يجب أن يكون :attribute :size كيلوبايت.',
    'string' => 'يجب أن يكون :attribute :size حرفًا.',
    'array' => 'يجب أن يحتوي :attribute على :size عنصرًا.',
],
'starts_with' => 'يجب أن يبدأ :attribute بأحد القيم التالية: :values.',
'string' => 'يجب أن يكون :attribute سلسلة نصية.',
'timezone' => 'يجب أن يكون :attribute منطقة زمنية صالحة.',
'unique' => 'تم أخذ :attribute بالفعل.',
'uploaded' => 'فشل تحميل :attribute.',
'url' => 'تنسيق :attribute غير صالح.',
'uuid' => 'يجب أن يكون :attribute UUID صالحًا.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

'custom' => [
    'attribute-name' => [
        'rule-name' => 'رسالة مخصصة',
    ],
],

'captcha' => 'كود التحقق غير صحيح...',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
