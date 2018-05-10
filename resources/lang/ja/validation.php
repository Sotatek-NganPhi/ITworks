<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute không đồng ý',
    'active_url'           => ':attribute URL không hợp lệ',
    'after'                => 'Vui lòng nhập ngày sau :date',
    'after_or_equal'       => 'Vui lòng nhập ngày sau :date',
    'alpha'                => ':attribute chỉ có thể sử dụng bảng chữ cái.',
    'alpha_dash'           => ':attribute bạn không thể sử dụng bảng chữ cái. Vui lòng nhập số và "-".',
    'alpha_num'            => ':attribute chỉ có thể sử dụng bảng chữ cái và số.',
    'array'                => ':attribute Định dạng dữ liệu khác nhau.',
    'before'               => ':attribute vui lòng nhập ngày trước :date.',
    'before_or_equal'      => ':attribute vui lòng nhập ngày trước :date.',
    'between'              => [
        'numeric' => ':attribute vui lòng nhập từ :min đến :max',
        'file'    => ':attribute vui lòng nhập từ :min đến :max',
        'string'  => ':attribute phải có ít nhất :min ký tự hoặc tối đa :max ký tự',
        'array'   => ':attribute vui lòng nhập các mục bên dưới :min đến :max',
    ],
    'boolean'              => ':attribute vui lòng nhập đúng hoặc sai.',
    'confirmed'            => ':attribute Xác nhận không khớp.',
    'date'                 => ':attribute Không phải là ngày hợp lệ.',
    'date_format'          => ':attribute Không khớp với định dạng :format.',
    'different'            => ':attribute và :other không thể giống nhau',
    'digits'               => ':attribute vui lòng nhập với :digits.',
    'digits_between'       => ':attribute vui lòng nhập ít nhất :min ký tự hoặc tối đa :max ký tự',
    'dimensions'           => ':attribute Kích thước hình ảnh khác nhau.',
    'distinct'             => ':attribute Dữ liệu giống nhau.',
    'email'                => ':attribute Không phải là địa chỉ email hợp lệ.',
    'exists'               => ':attribute Không hợp lệ.',
    'file'                 => ':attribute Không phải là một tập tin.',
    'filled'               => ':attribute Không phải là giá trị hợp lệ.',
    'image'                => ':attribute Không phải là một hình ảnh.',
    'in'                   => ':attribute Không hợp lệ.',
    'in_array'             => ':attribute Không tồn tại :other',
    'integer'              => ':attribute Phải là số.',
    'ip'                   => ':attribute Không phải là IP hợp lệ.',
    'ipv4'                 => ':attribute Không phải là IPv4 hợp lệ.',
    'ipv6'                 => ':attribute Không phải là IPv6 hợp lệ.',
    'json'                 => ':attribute Không phải là JSON.',
    'max'                  => [
        'numeric' => ':attribute Bạn không thể nhập nhiều hơn :max số',
        'file'    => ':attribute Không thể chọn file lớn hơn :max kilobyte',
        'string'  => ':attribute Bạn không thể nhập nhiều hơn :max ký tự',
        'array'   => ':attribute Không thể nhiều hơn :max.',
    ],
    'mimes'                => ':attribute Vui lòng nhập định dạng của :values',
    'mimetypes'            => ':attribute Vui lòng nhập định dạng của :values.',
    'min'                  => [
        'numeric' => ':attribute phải ít nhất :min giá trị.',
        'file'    => ':attribute phải ít nhất :min kilobyte.',
        'string'  => ':attribute phải ít nhất :min ký tự.',
        'array'   => ':attribute phải ít nhất :min giá trị.',
    ],
    'not_in'               => ':attribute Không hợp lệ.',
    'numeric'              => ':attribute Vui lòng nhập số.',
    'present'              => ':attribute Phải tồn tại.',
    'regex'                => ':attribute Định dạng khác.',
    'required'             => 'Vui lòng nhập trường này',
    'required_if'          => ':attributeは、:otherが:valueのときは入力してください。',
    'required_unless'      => ':attributeは、:otherが:valueでないときは入力してください。',
    'required_with'        => ':attributeは、:valuesがあるときは入力されなければなりません。',
    'required_with_all'    => ':attributeは、:valuesがあるときは入力されなければなりません。',
    'required_without'     => ':attributeは、:valuesがないときは入力されなければなりません。',
    'required_without_all' => ':attributeは、:valuesがないときは入力されなければなりません。',
    'same'                 => ':attributeと:otherはマッチしなければなりません。',
    'size'                 => [
        'numeric' => ':attributeは、:sizeでなければなりません。',
        'file'    => ':attributeは、:sizeキロバイトでなければなりません。',
        'string'  => ':attributeは、:size文字でなければなりません。',
        'array'   => ':attributeは、:sizeアイテムでなければなりません。',
    ],
    'string'               => ':attributeは、文字でなければなりません。',
    'timezone'             => ':attributeは、無効なタイムゾーンです。',
    'unique'               => ':attributeはユニークでなければなりません。',
    'uploaded'             => ':attributeは、アップロードに失敗しました。',
    'url'                  => ':attributeは無効です。',

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
            'rule-name' => 'custom-message',
        ],
        'privacy_policy' => [
            'accepted' => 'Nếu bạn không đồng ý với polycy, chúng tôi không thể đồng ý với yêu cầu của bạn',
        ],
        'video' => [
            'youtube' => 'The URL must be from Youtube',
        ],
        'referral_code' => [
            'exists' => 'Mã công ty sai',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'username' => 'Tên đăng nhập',
        'password' => 'Mật khẩu',
        'first_name' => 'Họ',
        'last_name' => 'Tên',
        'first_name_phonetic' => '姓(カタカナ)',
        'last_name_phonetic' => '名(カタカナ)',
        'gender' => 'Giới tính',
        'birthday' => 'Ngày sinh',
        'postal_code' => '郵便番号',
        'address' => 'Địa chỉ',
        'phone_number' => 'Số điện thoại',
        'email' => 'Email',
        'line_id' => 'LINE ID',
        'current_situation_id' => 'Hiện trạng',
        'jumping_condition_id' => '転職意欲',
        'education_id' => 'Trình độ học vấn',
        'final_academic_school' => 'Học tại',
        'graduated_at' => 'Thời gian tốt nghiệp)',
        'is_married' => '配偶者',
        'worked_companies_number' => '経験社数',
        'lastest_company_name' => '直近の社名',
        'lastest_employment_mode_id' => '直近の雇用形態',
        'lastest_industry_id' => '現在または直近の勤務先の業種',
        'lastest_annual_income' => '年収',
        'lastest_company_size_id' => '従業員数',
        'lastest_position_id' => '役職',
        'jumping_date_id' => '希望転職時期',
        'prefectures' => '希望勤務地',
        'employment_modes' => '雇用形態',
        'mail_receivable' => '企業からのスカウトメールを受け取る',
        'user.email' => 'Email',
        'user.gender' => 'Giới tính',
        'user.birthday' => 'Ngày sinh',
        'user.mail_receivable' => '企業からのスカウトメールを受け取る',
        'user.name' => 'Tên',
        'user.name_phonetic' => 'フリガナ',
        'user.postal_code' => '郵便番号',
        'user.address' => 'Địa chỉ',
        'user.phone_number' => 'Số điện thoại',
    ],

];
