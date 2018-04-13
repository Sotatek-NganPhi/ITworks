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

    'accepted'             => ':attributeに同意されていません。',
    'active_url'           => ':attributeは有効なURLではありません。',
    'after'                => ':attributeは、:date以降の日付で入力してください。',
    'after_or_equal'       => ':attributeは、:date以降の日付で入力してください。',
    'alpha'                => ':attributeは、アルファベットだけ使用できます。',
    'alpha_dash'           => ':attributeは、アルファベットは使えません。数字と"-"を入力してください。',
    'alpha_num'            => ':attributeは、アルファベットと数字だけ使用できます。',
    'array'                => ':attributeは、データ・フォーマットが違います。',
    'before'               => ':attributeは、:date以前の日付で入力してください。',
    'before_or_equal'      => ':attributeは、:date以前の日付で入力してください。',
    'between'              => [
        'numeric' => ':attributeは、:minと:maxの間で入力してください。',
        'file'    => ':attributeは、:minと:max キロバイトの間で入力してください。',
        'string'  => ':attributeは、:min文字以上:max文字以下で入力してください。',
        'array'   => ':attributeは、:min以上:maxアイテム以下で入力してください。',
    ],
    'boolean'              => ':attributeは、trueかfalseで入力してください。',
    'confirmed'            => ':attributeは、確認がマッチしてません。',
    'date'                 => ':attributeは、有効な日付ではありません。',
    'date_format'          => ':attributeは、:formatのフォーマットにマッチしません。',
    'different'            => ':attributeと:otherは、同じにはできません。',
    'digits'               => ':attributeは、:digits桁で入力してください。',
    'digits_between'       => ':attributeは、:min桁以上:max桁以下で入力してください。',
    'dimensions'           => ':attributeの画像サイズが違います。',
    'distinct'             => ':attributeのデータが同じになっています。',
    'email'                => ':attributeは、有効なメールアドレスではありません。',
    'exists'               => ':attributeは無効です。',
    'file'                 => ':attributeはファイルではありません。',
    'filled'               => ':attributeは有効な値ではありません。',
    'image'                => ':attributeは画像ではありません。',
    'in'                   => ':attributeは無効です。',
    'in_array'             => ':attributeは、存在しません。:other',
    'integer'              => ':attributeは、数字でなければなりません。',
    'ip'                   => ':attributeは、有効なIPではありません。',
    'ipv4'                 => ':attributeは、有効なIPv4ではありません。',
    'ipv6'                 => ':attributeは、有効なIPv6ではありません。',
    'json'                 => ':attributeは、JSONではありません。',
    'max'                  => [
        'numeric' => ':attributeは、:max以上で入力できません。',
        'file'    => ':attributeは、:maxキロバイト以上で入力できません。',
        'string'  => ':attributeは、:max文字以上で入力できません。',
        'array'   => ':attributeは、:maxアイテム以上にはできません。',
    ],
    'mimes'                => ':attributeは、:valuesのフォーマットで入力してください。',
    'mimetypes'            => ':attributeは、:valuesのフォーマットで入力してください。',
    'min'                  => [
        'numeric' => ':attributeは、少なくとも:min以下でなければなりません。',
        'file'    => ':attributeは、少なくとも:minキロバイト以下でなければなりません。',
        'string'  => ':attributeは、少なくとも:min文字以下でなければなりません。',
        'array'   => ':attributeは、少なくとも:minアイテム以下でなければなりません。',
    ],
    'not_in'               => ':attributeは、無効です。',
    'numeric'              => ':attributeは数字で入力してください。',
    'present'              => ':attributeは、存在しなければなりません。',
    'regex'                => ':attributeのフォーマットが違います。',
    'required'             => ':attributeを入力してください。',
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
            'accepted' => '個人情報に同意されない場合は、お問い合わせフォームをご利用いただけません',
        ],
        'video' => [
            'youtube' => 'The URL must be from Youtube',
        ],
        'referral_code' => [
            'exists' => '代理店コードが間違っています。',
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
        'username' => 'ログイン ID',
        'password' => 'パスワード',
        'first_name' => '姓',
        'last_name' => '名',
        'first_name_phonetic' => '姓(カタカナ)',
        'last_name_phonetic' => '名(カタカナ)',
        'gender' => '性別',
        'birthday' => '生年月日',
        'postal_code' => '郵便番号',
        'address' => '住所',
        'phone_number' => '電話番号',
        'email' => 'メールアドレス',
        'line_id' => 'LINE ID',
        'current_situation_id' => '就業状況',
        'jumping_condition_id' => '転職意欲',
        'education_id' => '最終学歴',
        'final_academic_school' => '最終学歴（学校名）',
        'graduated_at' => '最終学歴（卒業年月)',
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
        'user.gender' => '性別',
        'user.birthday' => '生年月日',
        'user.mail_receivable' => '企業からのスカウトメールを受け取る',
        'user.name' => '氏名',
        'user.name_phonetic' => 'フリガナ',
        'user.postal_code' => '郵便番号',
        'user.address' => '住所',
        'user.phone_number' => '電話番号z',
    ],

];
