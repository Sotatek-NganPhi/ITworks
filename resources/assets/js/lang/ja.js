export default {
  'app_name': 'GOEN',
  'menu': {
    'job': '求人原稿を\n作る・編集する',
    'company': '管理者・企業を\n登録',
    'candidate': '応募者・登録者を\n見る・メールする',
    'content_settings': 'コンテンツを\n設定・編集する',
    'analysis': 'サイトを\n分析する',
    'field_settings': '入力項目を\n設定する',
    'search_keys': '検索キーの\n登録・変更する',
    'metadata': 'サイトの\n初期設定をする',
    'logout' : 'ログアウト'
  },
  'sub_menu' : {
      'job' : {
        'job_list' : '求人原稿',
        'import' : 'CSVファイルで一括登録する'
      },
      'company' : {
        'company' : '掲載企業情報',
        'admin' : '管理者情報',
        'agency' : '代理店リスト'
      },
      'candidate' : {
        'candidate' : '登録者情報',
        'candidate_mail' : '登録者に希望条件メールを送信する',
        'applicant' : '応募者情報',
        'company_mail' : '掲載企業にメールを送信する',
        'mail_logs' :  'メール配信履歴',
        'mail_setting' : 'メルマガの設定をする',
        'inbox' : '受信トレイ ',
      },
      'content' : {
        'special' : '特集',
        'link' : 'リンク集',
        'urgen' : '急募情報',
        'pickup' : 'ピックアップ情報',
        'expo' : '説明会情報',
        'campaign' : 'キャンペーン情報',
        'announcement' : 'アナウンス情報',
        'video' : 'ビデオ',
        'interview' : 'インタビュー'
      },
      'analysis' : {
        'overal' : 'アクセス解析（全体）',
        'search' : 'アクセス解析（検索）',
        'merit' : 'メリット別のクリック数を見る',
        'type' : '職種別のクリック数を見る',
        'rank' : '原稿アクセスランキング'
      },
      'field_settings' : {
        'job' : '仕事情報',
        'company' : '掲載企業情報',
        'applicant' : '応募者情報',
        'managers' : '管理者情報'
      },
      'search_key' : {
        'region' : '地方検索キー',
        'prefecture' : '都道府県検索キー',
        'job' : '仕事検索キー',
        'employment_mode' : '雇用形態（検索用）検索キー',
        'working' : '勤務時間検索キー',
        'current_status' :'現在の状況(属性)検索キー',
        'payroll' : '給与検索キー',
        'certificate' : '保有資格検索キー',
        'agency' : 'Agency'
      },
      'metadata' : {
        
      },
  },
  'utils_choice' : {
      'mail_type' : {
    'automatic' : '自動',
    'company' : '企業',
    'condition' : '希望条件'
  },
    'platforms' : {
      'PC' : 'PC',
      'mobile' : 'スマートフォン',
    },
    'gender' : {
      'male' : '男性',
      'female' : '女性'
    },
    'maritals' : {
      'married' : '既婚',
      'unmarried' : '未婚',
    },
    'manager' : {
      'system' : ' 運営元管理者',
      'company' : '掲載企業管理者'
    },
    'booleans' : {
      'yes' : '有効',
      'no' : '無効',
      'not_specified' : '無指定'
    },
    'status' : {
      'effectiveness' : '有効',
      'invalid' : '無効'
    },
    'yes_no_option' : {
      'yes' : '有効',
      'no' : '無効'
    },
    'item_to_use' : {
      'not_specified' : '無指定',
      'merit' : 'メリット',
      'job_category' : '職種'
    },
    'time' : {
      'all' : '全',
      'this_month' : '今月',
      'last_month' : '先月',
    },
    'mail_time' : {
      '2_months_ago' : '先々月',
      'last_month' : '先月',
      'this_month' : '今月'
    }
  },
  'job_csv': {
    'register_company_title': '掲載企業登録',
    'register_company_description': '掲載企業未登録の場合、掲載企業情報を先ず登録してください。',
    'register_company_link': '【掲載企業情報登録画面へ】',
    'register_csv_title': '仕事情報一括取り込み',
    'register_csv_description': '掲載企業登録済の場合、[1]のステップは飛ばします。仕事情報マスタデータのCSVには登録済みの掲載企業IDを入力してください。',
    'register_csv_link': '【仕事情報一括取り込み画面へ】',
  },
  'region': { 
    'name': '地方名',
    'all': '全地方',
  },
  'campaign': { 
    'list_title': 'キャンペーン一覧',
    'banner_path': 'バナー',
    'content': '内容',
  },
  'job_list' : {
    'job_list_title' : 'ジョブリスト',
    'id' : '仕事ID',
    'posting_period' : '掲載期間',
    'list_title': '求人一覧',
    'search_title': '求人検索',
    'work_no': 'Work No',
    'use' : '使用する',
    'not_use' : '使用しない',
    'agency_name': '代理店名 ',
    'company_name': '掲載企業名',
    'posting_situation': '掲載状況',
    'salary' : '給与',
    'job_category': '職種（検索用）',
    'original_state': '原稿の状態',
    'post_start_date': '掲載開始日',
    'post_end_date': '掲載終了日',
    'outside': '掲載期間外',
    'all' : '無効(保留)',
    'invalid': '無効(保留) ',
    'posting': '掲載中',
    'add_new_route': '路線を追加す',
    'entries' : '応募件数',
    'mobile_view' : 'スマホ電話応募アクセス件数',
    'pc_view' : 'PC電話応募アクセス件数'

  },
  'company': {
    'name': '代理店名',
    'name_phonetic': '掲載企業フリガナ',
    'street_address': '住所',
    'short_description': '事業内容',
    'company_hp': '会社HP',
    'expire_date': '有効期限',
    'manager': '担当者名',
    'search_title' : '企業検索',
    'list_title' : '企業一覧'
  },
    'expo': {
    'organizer_name': '主催',
    'time': '時間',
    'start_date': '開催日',
    'end_date': '終 了日',
    'presentation_name': '説明会名',
    'content': '開催内容',
    'pr': 'PR',
    'map_url': '地図のURL',
    'cs_email': '問い合わせメールアドレス',
    'cs_phone': '問い合わせ電話',
    'reservation_count': '予約者数',
    'booking_list': '予約者一覧',
  },  
  'company_list': {
    'list_title': '掲載企業一覧',
    'search_title': '掲載企業検索'
  },
   'expo_list': {
    'list_title': '説明会一覧',
    'search_title': '説明会検索'
  },
   'reservation_list': {
    'list_title': '予約者一覧',
    'search_title': '予約者検索',
    'full_name': '予約者名',
    'email': '予約者メールアドレス',
  },
   'reservation': { 
    'full_name': '予約者名',
    'full_name_phonetic': '予約者フリガナ',
  },
    'common_action': {
    'edit': '変更',
    'delete': '削除',
    'ok': 'Ok',
    'pick' : '選択',
    'cancel': 'キャンセル',
    'download' : 'CSVでダウンロードする',
    'new': '新規登録',
    'save' : '登録',
    'preview': 'プレビュー',
    'send_email': ' メール配信'
  },
    'common_field': {
    'id': 'ID',
    'basic_info': '基本情報',
    'from' : '開始日',
    'to' : '終了日',
    'is_active': '状態 ',
    'active': '有効',
    'in_active': '無効',
    'not_specified': '無指定',
    'phone_number': '電話番号',
    'contact_name': '連絡者名',
    'year': '年',
    'month': '月',
    'day': '日',
    'date': '年月日',
    'address': '住所',
    'email': 'メールアドレス',
    'gender': '性別',
    'start_at': '開始日',
    'end_at': '終了日',
    'current_job': '現在の仕事',
    'title': 'タイトル',
    'time': '時間',
    'release': '公開',
    'private': '非公開',
    'birthday': '生年月日',
    'postal_code': '郵便番号',
    'age': '年齢',
    'line_id': 'LINE ID',
    'view': '仕事詳細情報閲覧数',
    'password': 'パスワード',
    'password_confirmation': '確認パスワード',
    'subject': "主題"

  },
  'form_action': {
    'search': '検索',
    'clear': 'クリア',
    'download_csv': 'CSVでダウンロードする',
    'preview': 'プレビュー',
    'reply' : '返信'
  },
    'pickup': {
    'search_title': 'ピックアップ検索',
    'items': '使用する項目',
    'item_merit': 'メリット',
    'item_category': '職種（検索用）',
    'title': 'タイトル',
    'post_start_date': '掲載開始日',
    'post_end_date': '掲載終了日',
    'platform': '表示対象',
    'platform_pc': 'PC',
    'platform_mobile': 'スマートフォン',
    'status': {
      'title': '状態',
      'effectiveness': '有効 ',
      'invalid': '無効',
      'not_specified': '無指定'
    },
    'pickup_list_title': 'ピックアップ一覧',
    'description': '説明',
    'icon' : {
      'pc' : 'PC画像',
      'mobile' : 'スマートフォン画像',
    },
  },
    'special_promotion': {
    'name': '特集名',
    'platform': '表示対象',
    'start': '掲載開始日',
    'end': '掲載終了日',
    'list_title': '特集検索一覧',
    'search_title': '特集検索',
    'region': '地方名',
    'job' : '',
    'icon' : {
      'pc': 'PC画像',
      'mobile': 'スマートフォン画像',
    }
  },
  
  'link': {
    'region_name': '地方名',
    'link_title': 'リンクタイトル',
    'url_pc':'PCの URL',
    'url_mobile':'スマートフォンのURL',
    'image':'画像',
    'image_pc':'PC画像',
    'image_mobile':'スマートフォン画像',
    'start_date':'掲載開始日',
    'end_date':'掲載終了日',
    'list_title':'リンク一覧',
    'search_title': 'リンク検索'
  },

  'platform' : {
    'pc': 'PC',
    'mobile': 'スマートフォン'
  },

  'admin_list' : {
    'id': '管理者ID',
    'list_title': '管理者一覧',
    'search_title': '管理者検索',
    'type': '種別',
    'full_name': '名前',
    'user_name': 'ユーザー名',
    'email' : 'メールアドレス',
    'company_list': '管理される企業一覧',
    'manage': '管理',
  },

  'candidate' :{
    'name':'氏名',
    'first_name':'名',
    'last_name':'名字',
    'name_phonetic':'フリガナ',
    'first_name_phonetic':'名フリガナ ',
    'last_name_phonetic':'名字フリガナ',
    'username': 'ユーザー名',
    'registed_date': '登録日',
    'mail_receivable': 'メールを受け取れる',
    'platform': '表示対象',
    'sendmail':'メールを送る',
    'search_title':'登録者検索',
    'list_title':'登録者一覧',
    'search_info': "候補者の情報で検索する",
    'search_condition': "候補者の条件で検索する",
    'prefecture': '希望の市区町村',
    'category_level2': '希望の職種 (メジャー)',
    'category_level3': '希望の職種 (マイナー)',
    'salary': '給与',
    'working_shift': '希望の時間帯',
    'employment_mode': '希望の雇用形態',
    'merit': '希望のメリット',
    'current_situation': '現在の状況',
    'size': '従業員数',
  },
  'applicant' :{
    'title': {
      'one':'仕事情報検索',
      'two': '応募者検索',
      'job_list':'仕事情報一覧',
      'applicant_list':'応募者情報一覧'
    },
     'state': {
      'title':'状態（仕事情報）',
      'effectiveness':'有効',
      'invalid':'無効',
    },
    'company_posting':'掲載企業名',
    'start':'掲載開始日',
    'end':'掲載終了日',
    'posting': '掲載期間',
    'count': '応募件数',
    'entries': {
      'title': '応募件数',
      'button':'応募件数が1件以上あるものだけを表示する  ',
    },
    'entry_id':'応募ID',
    'phonetic':'フリガナ',
    'task_id': '仕事ID',
    'age': '年齢',
    'company_name': '会社名',
    'male': '男性',
    'female':'女性',
    'birthday':'生年月日',
    'prefecture':'都道府県',
    'address':'住所',
    'mail':'メールアドレス',
    'Pc': "PC",
    'Phone':'スマートフォン',
    'applicants':'応募機器',
    'expire_date':'応募期間',
    'situation':'状況',
    'reading':'閲覧状況',
    'read':'既読',
    'unread':'未読',
    'academy':'最終学歴　学校名',
    'faculty':'学部/学科',
    'year':'卒業年度',
    'industry':'業種',
    'other':'その他PRしたい学歴',
    'qualification':'保有資格',
    'last_company':'直近の職歴　会社名',
    'period':'在職期間',
    'marry':'既婚未婚',
    'married':'既婚 ',
    'unmarried':'未婚',
    'detail': {
      'email': 'メールアドレス',
      'first_name':'名',
      'last_name':'名字',
      'furigana_first_name':'名フリガナ ',
      'furigana_last_name':'名字フリガナ',
      'gender': '性別',
      'phone_number': '電話番号',
      'birthday': '生年月日',
      'address': '住所',
    },
    'id': '仕事ID',
    'job_id': '仕事のID',
    'first_name': 'ファーストネーム',
    'last_name': '苗字',
    'first_name_phonetic': '名詞',
    'last_name_phonetic': '名字',
    'phone_number': '電話番号',
    'postal_code': '郵便番号',
    'current_situation_id': '就業状況',
    'education_id': '最終学歴',
    'lastest_industry_id': '現在または直前の勤務先の業種',
    'lastest_position_id': '役職',
    'language_conversation_level_id': '会話レベル',
    'language_experience_id': '実務経験',
    'driver_license_id': '自動車免許',
  },
  'announcement_list' : {
    'search_title' :'アナウンス検索',
    'list_title' : 'アナウンス一覧'
  },

  'job': {
    'id': '仕事ID',
    'work_no': 'Work No.',
    'description': 'メインキャッチ',
    'seniors_hometown': '先輩の出身校',
    'company_name': ' 企業名',
    'salary': ' 給与',
    'working_hours': ' 勤務時間',
    'application_condition': ' 応募条件',
    'message': 'メッセージ',
    'holiday_vacation': '休日休暇',
    'interview_place': ' 面接地',
    'receptionist': ' 受付担当者',
    'email_receive_applicant': ' 応募先メールアドレス ',
    'email_company': '企業メールアドレス ',
    'sales_person_mail': '営業担当者メールアドレス',
    'remarks': '備考欄',
    'search': '検索',
  },
  'errors': {
    'after': '{Field}は{arg_1st}の後に入力さなければなりません。',
    'alpha_dash': '{field}には英数字、ダッシュ、アンダースコアを使用できます。',
    'alpha_num': '{field}には英数字だけが含まなければなりません。',
    'alpha_spaces': '{field}には英数字とスペースだけが含まなければなりません。',
    'alpha': '{field}にはアルファベット文字だけが含まれていますがありません。',
    'before': '{Field}は{arg_1st}の前に入力さなければなりません。',
    'between': '{Field}は{arg_1st}と{arg_2st}の間に入力さなければなりません。',
    'confirmed': '{field}で{field}の確認が一致しません。',
    'date_format': '{Field}は{arg_1st}の形式で入力さなければなりません。',
    'digits': '{field}は数字で、{arg_1st}の数字が含まれていなければなりません。',
    'email': '{field}には正しいメールアドレスを入力してください.',
    'ext': '{field}には正しいファイルを入力してください.',
    'image': '{field}には イメージを入力してください.',
    'in': '{field}には正しいバリューを入力してください.',
    'max': '{field} は{arg_1st}字以下で入力してください.',
    'min': '{field} は{arg_1st}字以上で入力してください.',
    'not_in': '{field}には正しいバリューを入力してください.',
    'numeric': '{field}には数字だけが含まなければなりません。',
    'regex': '{field}の形式が正しくありません',
    'required': ' {field}必須入力です',
    'size': '{field}のサイズは{arg_1st} KB未満でなければなりません。  ',
    'url': '{field}のURLが有効じゃありません。'
  },

  'search_keys' : {
      'item_name' : '項目名',
      'field_name': 'フィールド名',
      'category' : 'カテゴリ',
      'order_display' : '表示順',
      'status' : '有効と無効',
      'search_item' : {
        'region' : '地域名',
        'prefecture' : '都道府県名',
        'category' : '職種名',
        'employment_mode' : '項目名',
        'working' : '項目名',
        'current_status' : '項目名',
        'payroll' : '項目名',
        'certificate' : '項目名',
      },

  },

  'job_edit' : {
    'routes' : '路線',
    'salary' : '給与（検索用）',
    'working_days' : '希望の勤務日数・時間',
    'working_hours' : ' 希望の勤務時間',
    'working_shifts' : ' 希望の時間帯',
    'working_periods' : '希望の勤務期間',
    'current_situation' : '現在の状況',
    'merit' : 'メリット',
    'group_1' : '基本情報',
    'group_2' : 'TOP見出し部分',
    'group_3' : '募集要項',
    'group_4' : 'イメージ',
    'group_5' : '募集について',
    'group_6' : '検索用',
  },
  'message' : {
    'before_update' : '変更を保存しますか?',
    'before_delete' : 'このデータを削除したいですか?',
    'before_send' : 'このメールを送りたいですか?'
  },
  'certificate' : {
    'title_search': '保有資格検索',
    'title_list': '保有資格一覧',
    'group_name': '保有資格グループ',
    'certificate_name': '保有資格名',
    'certificate': '保有資格',
  },
  'auto_mail' : {
    'title': {
      'delivery_setting': 'メルマガ配信の設定',
      'content_settings': 'メール内容の設定',
    },
    'interval':'配信間隔',
    'status' : {
      'title':'配信状態',
      'choice_1' : ' 有効',
      'choice_2' : '無効',
    },
    'date':'次回配信日',
    'notif':'メルマガは以下の時間帯に自動配信されます。\n【PC・スマートフォンサイト】午前9:00～10:00',
    'from_address':{
      'title':'Fromアドレス',
      'work':'例）お仕事探しの○○',
      'email':'例）xxxx@xxxx.com',
    },
    'subject':'件名',
    'header':'ヘッダ',
    'footer':'フッタ',
    'work_number':'送信する仕事情報',
    'item':{
      'title':'本文の項目',
    },
    'form_action': {
      'clear':'　クリア　',
      'preview':'プレビュー',
      'next':'　次へ　',
      'back':'戻る',
      'register':'登録',
      'close':'　閉じる　',
    }
  },
    'field_settings' : {
    'item_name' : '項目名',
    'search_title' : 'の入力項目検索',
    'edit_title' : '入力項目情報',
    'list_title' : 'の入力項目一覧',
    'list_name' : {
      'jobs' : '仕事情報',
      'companies' : '掲載企業情報',
      'applicants' : '応募者情報',
      'managers' : '管理者情報'
    },
  },
  'analysis_ranking' : {
    'title' : '昨日の原稿アクセス数ランキング',
    'rank' : 'ランキング',
    'task_id' : '仕事ID',
    'access_count' : 'アクセス数',
    'description' : 'メインキャッチ'
  },
  'analysis_search' : {
    'platform' : '表示対象',
    'title' : '検索',
    'time' : '取得月',
    'result' : '解析結果',
    'rank' : 'ランキング',
    'region' : '地方',
    'job_type' : '職種',
    'count' : 'アクセス数',
    'merit' : 'メリット'
  },
  'candidate_list' : {
    'basic_info' : '基本情報',
    'additional_info' : '追加情報',
    'current' : '現在または直前の勤務先',
    'expect' : '希望',
    'other' :'他'
  },
    'mail_logs': {
    'month' : 'Delivery Month',
    'type' : 'Mail Type',
    'search_title' : 'メール配信履歴検索',
    'list_title' : 'メール配信履歴一覧',
    'time_created' : '配信日'
  },
  'inbox' : {
    'search_title' : '会話検索',
    'list_title' : '会話情報一覧',
    'show_action' : '詳細 '
  },
  'video' : {
    'search_title': 'ビデオ検索',
    'list_title': 'ビデオ情報一覧',
    'update_thumbnail': 'デフォルトのサムネイルを使用する',
    'region': '地方'
  },
  'request' : {
    'request_success' : '成功しました',
  }
};
