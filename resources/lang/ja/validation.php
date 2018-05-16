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

    'accepted'             => 'Không đồng ý :attribute',
    'active_url'           => 'URL :attribute không hợp lệ',
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
    'not_in'               => ':attribute không hợp lệ.',
    'numeric'              => ':attribute vui lòng nhập số.',
    'present'              => ':attribute phải tồn tại.',
    'regex'                => ':attribute Định dạng khác.',
    'required'             => 'Vui lòng nhập trường :attribute',
    'required_if'          => ':attribute phải được nhập nếu :other là :value',
    'required_unless'      => ':attribute phải được nhập nếu :other không là :value',
    'required_with'        => ':attribute phải được nhập khi có :value.',
    'required_with_all'    => ':attribute phải được nhập khi có :value.',
    'required_without'     => ':attribute phải được nhập khi không có :value.',
    'required_without_all' => ':attribute phải được nhập khi không có :value.',
    'same'                 => ':attribute và :other phải khớp.',
    'size'                 => [
        'numeric' => ':attribute phải là :size',
        'file'    => ':attribute phải là :size kilobite',
        'string'  => ':attribute phải là :size ký tự',
        'array'   => ':attribute phải là :size phần tử',
    ],
    'string'               => ':attribute phải có định dạng email',
    'timezone'             => ':attribute thời gian không hợp lệ',
    'unique'               => ':attribute là duy nhất',
    'uploaded'             => ':attribute tải lên không thành công.',
    'url'                  => ':attribute không hợp lệ.',

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
            'accepted' => 'Nếu bạn không đồng ý với policy, chúng tôi không thể đồng ý với yêu cầu của bạn',
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
        'gender' => 'Giới tính',
        'birthday' => 'Ngày sinh',
        'address' => 'Địa chỉ',
        'phone_number' => 'Số điện thoại',
        'email' => 'Email',
        'education_id' => 'Trình độ học vấn',
        'final_academic_school' => 'Học tại',
        'graduated_at' => 'Thời gian tốt nghiệp',
        'prefectures' => 'Tỉnh',
        'mail_receivable' => 'Email nhận thông báo từ công ty',
        'user.email' => 'Email',
        'user.gender' => 'Giới tính',
        'user.birthday' => 'Ngày sinh',
        'user.mail_receivable' => 'Email nhận thông báo từ công ty',
        'user.name' => 'Tên',
        'user.address' => 'Địa chỉ',
        'user.phone_number' => 'Số điện thoại',
    ],

];
