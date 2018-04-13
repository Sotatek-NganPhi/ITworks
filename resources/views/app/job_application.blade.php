@extends('app.layout')

@section('title')
    会社案内｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <script>
      window.job = {!! $job !!}
      window.numberOfChange = 0
    </script>
    <div id="input_form">
    <div id="job_application">
        <div id="page_content">
            @include('app.common.breadcrumbs', ['crumbs' => [
                  ['url' => route('index'), 'name' => $configs["site_name"]],
                  ['url' => route('job_detail', [ 'id' => $job->id]), 'name' => '求人詳細'],
                  ['url' => '#', 'name' => '応募する']
              ]])
            <div id="application-form">
                @if(!isset($submitted))
                <div class="detail_item">
                    <div class="job-header">
                        <a href="{{route('job_detail', [ 'id' => $job->id])}}">{{ $job->company_name }}</a>
                    </div>
                    <div class="job-content">
                        <label for="_1" class="detail-button">詳細</label>
                        <input id="_1" type="checkbox">
                        <div class="expandable-content">
                            <div class="job-desc">
                                <div> {{ $job->salary }}</div>
                            </div>
                            <div class="__sub_title">
                                <h3>{{ $job->description }}</h3>
                            </div>
                            <div class="job-detail">
                                <div class="main-photo">
                                    <a href="{{route('job_detail', [ 'id' => $job->id])}}">
                                        <img src="{{$job->main_image}}" alt="">
                                    </a>
                                </div>
                                <div class="spec">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                        <tr>
                                            <th>求める人材・経験・資格</th>
                                            <td>{{ $job->application_condition }}</td>
                                        </tr>
                                        <tr>
                                            <th>掲載期間</th>
                                            <td>{{ $job->post_start_date }} - {{ $job->post_end_date }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="height:30px"></div>
                @endif
                <div id="__component">
                    <h3>応募フォームにご入力ください</h3>
                    @if (count($errors) > 0)
                        <div>
                            <ul class="errors">
                                @foreach ($errors as $error)
                                    @foreach($error as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(isset($submitted) && $submitted)
                        <div id="register_from">
                            <form method="POST" action="{{route('apply_job', ['id' => $job->id])}}"
                                  id="inquiry" class="inquiry">
                                {{ csrf_field() }}
                                <input type="hidden" name="job_id" value="{{ $job->id }}"/>
                                @if(isset($inputs))
                                    <input hidden name="email"
                                           value="{{ isset($inputs['email']) ? $inputs['email'] : '' }}">
                                    <input hidden name="first_name"
                                           value="{{ isset($inputs['first_name']) ? $inputs['first_name'] : ''}}">
                                    <input hidden name="last_name"
                                           value="{{ isset($inputs['last_name']) ? $inputs['last_name'] : ''}}">
                                    <input hidden name="first_name_phonetic"
                                           value="{{ isset($inputs['first_name_phonetic']) ? $inputs['first_name_phonetic'] : ''}}">
                                    <input hidden name="last_name_phonetic"
                                           value="{{ isset($inputs['last_name_phonetic']) ? $inputs['last_name_phonetic'] : ''}}">
                                    <input hidden name="gender"
                                           value="{{ isset($inputs['gender']) ? $inputs['gender'] : ''}}">
                                    <input hidden name="birthday"
                                           value="{{ isset($inputs['birthday']) ? $inputs['birthday'] : ''}}">
                                    <input hidden name="address"
                                           value="{{ isset($inputs['address']) ? $inputs['address'] : ''}}">
                                    <input hidden name="postal_code"
                                           value="{{ isset($inputs['postal_code']) ? $inputs['postal_code'] : ''}}">
                                    <phone-input hidden name="phone_number"
                                           value="{{ isset($inputs['phone_number']) ? $inputs['phone_number'] : ''}}"></phone-input>
                                    <input hidden name="graduated_at"
                                           value="{{ isset($inputs['graduated_at']) ? $inputs['graduated_at'] : ''}}">
                                    <input hidden name="current_situation_id"
                                           value="{{ isset($inputs['current_situation_id']) ? $inputs['current_situation_id'] : ''}}">
                                    <input hidden name="education_id"
                                           value="{{ isset($inputs['education_id']) ? $inputs['education_id'] : ''}}">
                                    <input hidden name="final_academic_school"
                                           value="{{ isset($inputs['final_academic_school']) ? $inputs['final_academic_school'] : ''}}">
                                    <input hidden name="worked_companies_number"
                                           value="{{ isset($inputs['worked_companies_number']) ? $inputs['worked_companies_number'] : ''}}">
                                    <input hidden name="lastest_industry_id"
                                           value="{{ isset($inputs['lastest_industry_id']) ? $inputs['lastest_industry_id'] : ''}}">
                                    <input hidden name="lastest_annual_income"
                                           value="{{ isset($inputs['lastest_annual_income']) ? $inputs['lastest_annual_income'] : ''}}">
                                    <input hidden name="lastest_position_id"
                                           value="{{ isset($inputs['lastest_position_id']) ? $inputs['lastest_position_id'] : ''}}">
                                    <input hidden name="lastest_company_name"
                                           value="{{ isset($inputs['lastest_company_name']) ? $inputs['lastest_company_name'] : ''}}">


                                    @if(isset($inputs['certificates']))
                                        @foreach($inputs['certificates'] as $certificate)
                                            <input hidden name="certificates[]"
                                                   value="{{ $certificate }}">
                                        @endforeach
                                    @endif

                                    <input hidden name="language_experience_id"
                                           value="{{ isset($inputs['language_experience_id']) ? $inputs['language_experience_id'] : ''}}">
                                    <input hidden name="toeic"
                                           value="{{ isset($inputs['toeic']) ? $inputs['toeic'] : ''}}">
                                    <input hidden name="toefl"
                                           value="{{ isset($inputs['toefl']) ? $inputs['toefl'] : ''}}">
                                    <input hidden name="language_conversation_level_id"
                                           value="{{ isset($inputs['language_conversation_level_id']) ? $inputs['language_conversation_level_id'] : ''}}">
                                    <input hidden name="driver_license_id"
                                           value="{{ isset($inputs['driver_license_id']) ? $inputs['driver_license_id'] : ''}}">
                                    <input hidden name="lastest_job_description"
                                           value="{{ isset($inputs['lastest_job_description']) ? $inputs['lastest_job_description'] : ''}}">
                                    <input hidden name="lastest_job_description"
                                           value="{{ isset($inputs['lastest_job_description']) ? $inputs['lastest_job_description'] : ''}}">
                                    <input hidden name="resume_pr"
                                           value="{{ isset($inputs['resume_pr']) ? $inputs['resume_pr'] : ''}}">
                                    <input hidden name="status"
                                           value="{{ isset($inputs['status']) ? $inputs['status'] : ''}}">
                                    <input hidden name="lastest_employment_mode_id"
                                           value="{{ isset($inputs['lastest_employment_mode_id']) ? $inputs['lastest_employment_mode_id'] : ''}}">
                                    <input hidden name="is_married"
                                           value="{{ isset($inputs['is_married']) ? $inputs['is_married'] : ''}}">

                                @endif

                                <div>
                                    <table>
                                        <tbody>
                                        <tr>
                                            <th class="required">ログインID</th>
                                            <td>
                                                {{ isset($inputs['email']) ? $inputs['email'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">氏名</th>
                                            <td>
                                                {{ isset($inputs['first_name']) ? $inputs['first_name'] : '' }}
                                                {{ isset($inputs['last_name']) ? $inputs['last_name'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">フリガナ</th>
                                            <td>
                                                {{ isset($inputs['first_name_phonetic']) ? $inputs['first_name_phonetic'] : '' }}
                                                {{ isset($inputs['last_name_phonetic']) ? $inputs['last_name_phonetic'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">性別</th>
                                            <td>
                                                {{ isset($inputs['gender']) ? $inputs['gender'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">生年月日</th>
                                            <td>
                                                {{ isset($inputs['birthday']) ? $inputs['birthday'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">郵便番号</th>
                                            <td>
                                                {{ isset($inputs['postal_code']) ? $inputs['postal_code'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">住所</th>
                                            <td>
                                                {{ isset($inputs['address']) ? $inputs['address'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">電話番号</th>
                                            <td>
                                                {{ isset($inputs['phone_number']) ? $inputs['phone_number'] : '' }}
                                            </td>
                                        </tr>
                                        </tbody>

                                        <tr>
                                            <th class="required">就業状況</th>
                                            <td>
                                                {{ isset($inputs['current_situation_id']) ? \App\Models\CurrentSituation::findOneById($inputs['current_situation_id'])->name : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">最終学歴</th>
                                            <td>
                                                {{ isset($inputs['education_id']) ? \App\Models\Education::findOneById($inputs['education_id'])->name : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="norequired">最終学歴（学校名）</th>
                                            <td>
                                                {{ isset($inputs['final_academic_school']) ? $inputs['final_academic_school'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="norequired">最終学歴（卒業年月）</th>
                                            <td>
                                                {{ isset($inputs['graduated_at']) ? $inputs['graduated_at'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="norequired">配偶者</th>
                                            <td>
                                                {{ isset($inputs['is_married']) ? 'はい' : 'いいえ' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">経験社数</th>
                                            <td>
                                                {{ isset($inputs['worked_companies_number']) ? $inputs['worked_companies_number'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">社名</th>
                                            <td>
                                                {{ isset($inputs['lastest_company_name']) ? $inputs['lastest_company_name'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">雇用形態</th>
                                            <td>
                                                {{ isset($inputs['lastest_employment_mode_id']) ? \App\Models\EmploymentMode::findOneById($inputs['lastest_employment_mode_id'])->description: '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">現在または直前の勤務先の業種</th>
                                            <td>
                                                {{ isset($inputs['lastest_industry_id']) ? \App\Models\Industry::findOneById($inputs['lastest_industry_id'])->name: '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">年収</th>
                                            <td>
                                                {{ isset($inputs['lastest_annual_income']) ? $inputs['lastest_annual_income']: '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">役職</th>
                                            <td>
                                                {{ isset($inputs['lastest_position_id']) ? \App\Models\Position::findOneById($inputs['lastest_position_id'])->name: '' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="norequired">実務経験</th>
                                            <td>
                                                {{ isset($inputs['language_experience_id']) ? \App\Models\LanguageExperience::findOneById($inputs['language_experience_id'])->description: '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="norequired">TOEIC</th>
                                            <td>
                                                {{ isset($inputs['toeic']) ? $inputs['toeic'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="norequired">TOEFL</th>
                                            <td>
                                                {{ isset($inputs['toefl']) ? $inputs['toefl'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="norequired">会話レベル</th>
                                            <td>
                                                {{ isset($inputs['language_conversation_level_id']) ? \App\Models\LanguageConversationLevel::findOneById($inputs['language_conversation_level_id'])->description: '' }}
                                            </td>
                                        </tr>


                                        <tr>
                                            <th class="required">自動車免許</th>
                                            <td>
                                                {{ isset($inputs['driver_license_id']) ? \App\Models\DriverLicense::findOneById($inputs['driver_license_id'])->name: '' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="norequired">保有資格</th>
                                            <td>
                                                @if(isset($inputs['certificates']))
                                                    @foreach($inputs['certificates'] as $certificate)
                                                        <p>{{\App\Models\Certificate::findOneById($certificate)->name}}</p>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="norequired">職務内容</th>
                                            <td>
                                                {{ isset($inputs['lastest_job_description']) ? $inputs['lastest_job_description'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">PR（500文字）</th>
                                            <td>
                                                {!!  isset($inputs['resume_pr']) ? nl2br($inputs['resume_pr']) : '' !!}
                                            </td>
                                        </tr>
                                    </table>
                                    @if(count($errors) == 0)
                                        <input type="submit" class="confirm" id="confirm" value="　送信する　">
                                    @endif
                                    <input type="hidden" name="back" value="false">
                                    <input type="hidden" name="confirm" value="false">
                                    <input type="submit" class="cancel" id="back" value="　戻る　">
                                </div>
                            </form>
                        </div>
                    @elseif(isset($success) && $success)
                        <p></p>
                        <div class="completed">
                            <p>{!! trans('auth.application') !!}</p>
                        </div>
                    @else
                        <div id="register_from">
                            <form class="inquiry" method="POST" name="form" id="inquiry"
                                  action="{{route('apply_job', ['id' => $job->id])}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="job_id" value="{{ $job->id }}"/>
                                <table>
                                    <tbody class="candidate-edit">
                                    <tr>
                                        <th class="required">ログインID</th>
                                        <td>
                                            <input disabled class="form-control" value="{{ old('email') }}"/>
                                            <input type="hidden" name="email" value="{{ old('email') }}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">氏名</th>
                                        <td>
                                            <input placeholder="姓" class="form-control" name="first_name"
                                                   value="{{ old('first_name') }}">
                                            <br>
                                            <input placeholder="名" class="form-control" name="last_name"
                                                   value="{{ old('last_name') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">フリガナ</th>
                                        <td>
                                            <input placeholder="姓" class="form-control" name="first_name_phonetic"
                                                   value="{{ old('first_name_phonetic') }}">
                                            <br>
                                            <input placeholder="名" class="form-control" name="last_name_phonetic"
                                                   value="{{ old('last_name_phonetic') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">性別</th>
                                        <td>
                                            <input type="radio" value="male" name="gender" id="gender-male"
                                                    {{ old('gender') == 'male' ? 'checked' : '' }}
                                            >
                                            <label for="gender-male">男性</label><br>
                                            <input type="radio" value="female" name="gender" id="gender-female"
                                                    {{ old('gender') == 'female' ? 'checked' : '' }}
                                            >
                                            <label for="gender-female">女性</label><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">生年月日</th>
                                        <td>
                                            <div class="date-picker">
                                                <date-picker name="birthday" locale="ja" value="{{ old('birthday') }}"
                                                             format="YYYY-MM-DD"></date-picker>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">郵便番号</th>
                                        <td>
                                            <postal-code name="postal_code" value="{{  old('postal_code') }}"></postal-code>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">住所</th>
                                        <td>
                                            <input class="form-control" name="address" value="{{ old('address') }}"
                                                   size="40">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">電話番号</th>
                                        <td>
                                            <phone-input name="phone_number"
                                                   value="{{ old('phone_number') }}"
                                                   size="40"></phone-input>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <h4>プロフィール</h4>
                                <table>
                                    <tbody>
                                    <tr>
                                        <th class="required">就業状況</th>
                                        <td>
                                            <select class="form-control" name="current_situation_id">
                                                @foreach($currentSituations as $currentSituation)
                                                    <option value="{{$currentSituation->id}}"
                                                            {{ old('current_situation_id') == $currentSituation->id ? 'selected' : '' }}
                                                    >{{$currentSituation->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">最終学歴</th>
                                        <td>
                                            <select class="form-control" name="education_id">
                                                <option value="">---</option>
                                                @foreach($educations as $education)
                                                    <option value="{{$education->id}}"
                                                            {{ old('education_id') == $education->id ? 'selected' : '' }}
                                                    >{{$education->name}}</option>
                                                @endforeach
                                            </select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="norequired">最終学歴（学校名）</th>
                                        <td>
                                            <input class="form-control" name="final_academic_school"
                                                   value="{{ old('final_academic_school') }}" size="40">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="norequired">最終学歴（卒業年月）</th>
                                        <td>
                                            <date-picker name="graduated_at" locale="ja"
                                                         value="{{ old('graduated_at') }}"
                                                         format="YYYY-MM-DD"></date-picker>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="norequired">配偶者</th>
                                        <td>
                                            <input type="radio" value="1" name="is_married" id="married"
                                                    {{ old('is_married') == 1 ? 'checked' : '' }}
                                            >
                                            <label for="married">既婚</label><br>
                                            <input type="radio" value="0" name="is_married" id="nomarried"
                                                    {{ old('is_married') == 0 ? 'checked' : '' }}
                                            >
                                            <label for="nomarried">未婚</label><br>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <h4>現在または直前の勤務先について</h4>
                                <table>
                                    <tbody>
                                    <tr>
                                        <th class="required">経験社数</th>
                                        <td>
                                            <input class="form-control" type="number" name="worked_companies_number"
                                                   value="{{ old('worked_companies_number') }}" size="40">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">社名</th>
                                        <td>
                                            <input class="form-control" name="lastest_company_name"
                                                   value="{{ old('lastest_company_name') }}" size="40">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">雇用形態</th>
                                        <td>
                                            <select class="form-control" name="lastest_employment_mode_id">
                                                <option value="">---</option>
                                                @foreach($employmentModes as $employmentMode)
                                                    <option value="{{$employmentMode->id}}"
                                                            {{ old('lastest_employment_mode_id') == $employmentMode->id ? 'selected' : '' }}
                                                    >{{$employmentMode->description}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">現在または直前の勤務先の業種</th>
                                        <td>
                                            <select class="form-control" name="lastest_industry_id">
                                                <option value="">---</option>
                                                @foreach($industries as $industry)
                                                    <option value="{{$industry->id}}"
                                                            {{ old('lastest_industry_id') == $industry->id ? 'selected' : '' }}
                                                    >{{$industry->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">年収</th>
                                        <td>
                                            <input class="form-control" type="text" name="lastest_annual_income"
                                                   value="{{ old('lastest_annual_income') }}" size="40">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">役職</th>
                                        <td>
                                            <select class="form-control" name="lastest_position_id">
                                                <option value="">---</option>
                                                @foreach($positions as $position)
                                                    <option value="{{$position->id}}"
                                                            {{ old('lastest_position_id') == $position->id ? 'selected' : '' }}
                                                    >{{$position->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <h4>語学スキル（英語）について</h4>
                                <table>
                                    <tbody>
                                    <tr>
                                        <th class="norequired">実務経験</th>
                                        <td>
                                            <select class="form-control" name="language_experience_id">
                                                <option value="">---</option>
                                                @foreach($languageExperiences as $languageExperience)
                                                    <option value="{{$languageExperience->id}}"
                                                            {{ old('language_experience_id') == $languageExperience->id ? 'selected' : '' }}
                                                    >{{$languageExperience->description}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="norequired">TOEIC</th>
                                        <td>
                                            <input class="form-control" type="text" name="toeic"
                                                   value="{{ old('toeic') }}"
                                                   size="40" maxlength="6">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="norequired">TOEFL</th>
                                        <td>
                                            <input class="form-control" type="text" name="toefl"
                                                   value="{{ old('toefl') }}"
                                                   size="40" maxlength="6">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="norequired">会話レベル</th>
                                        <td>
                                            <select class="form-control" name="language_conversation_level_id">
                                                <option value="">---</option>
                                                @foreach($languageConversationLevels as $languageConversationLevel)
                                                    <option value="{{$languageConversationLevel->id}}"
                                                            {{ old('language_conversation_level_id') == $languageConversationLevel->id ? 'selected' : '' }}
                                                    >{{$languageConversationLevel->description}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <h4>資格について</h4>
                                <table>
                                    <tbody>
                                    <tr>
                                        <th class="required">自動車免許</th>
                                        <td>
                                            <select class="form-control" name="driver_license_id">
                                                @foreach($driverLicenses as $driverLicense)
                                                    <option value="{{$driverLicense->id}}"
                                                            {{ old('driver_license_id') == $driverLicense->id ? 'selected' : '' }}
                                                    >{{$driverLicense->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="norequired">保有資格</th>
                                        <td>
                                            @foreach($certificate_groups as $certificate_group)
                                                <div>
                                                    <h4 class="certificate-group">{{$certificate_group->name}}</h4>
                                                    <div class="entries entries-norequired certificate-child
                                        {{!empty(array_intersect(old('certificates', []), $certificates->filter(function ($item, $key) use ($certificate_group) {
                                            return $item->certificate_group_id == $certificate_group->id;
                                            })->pluck('id')->toArray())) ? '' : 'hide-entries'}}">
                                                        @foreach($certificates as $certificate)
                                                            @if($certificate->certificate_group_id === $certificate_group->id)
                                                                <div>
                                                                    <label class="checkbox-inline">
                                                                        <input type="checkbox"
                                                                               name="certificates[]"
                                                                               value="{{$certificate->id}}"
                                                                                {{ in_array($certificate->id, old('certificates', []))?  'checked' : '' }}
                                                                        >
                                                                        {{$certificate->name}}
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <h4>直近の職務経験について</h4>
                                <table>
                                    <tbody>
                                    <tr>
                                        <th class="norequired">職務内容</th>
                                        <td>
                                    <textarea class="form-control candidate-job-description"
                                              name="lastest_job_description" size="40"
                                              maxlength="2000">{{ old('lastest_job_description') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">PR（500文字）</th>
                                        <td>
                                                <textarea cols="45" name="resume_pr" rows="5"
                                                          maxlength="500">{!! (str_replace(" ","\n", old('resume_pr'))) !!} </textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">個人情報の取り扱い</th>
                                        <td>
                                            <div class="form-cell">
                                                <div class="validate-failed">
                                                    <div style="padding-left: 20px">
                                                        <span>個人情報の取り扱いに同意されない場合は、応募できません</span>
                                                    </div>
                                                </div>
                                                <textarea name="textarea" cols="40" rows="7" readonly="" style="">
1. 個人情報の定義
個人情報とは、個人情報の保護に関する法律に規定される生存する個人に関する情報(氏名、生年月日、住所等特定の個人を識別することが可能な情報)、ならびに特定の個人と結びついて使用されるメールアドレス、パスワード、クレジットカード等の情報、および個人に関する属性情報と考えます。

2. 個人情報の取得
当社は、適法かつ公正に個人情報を取得し、不正の手段により取得することはありません。なお、当社では、当社のサービスの会員（加盟店）、閲覧ユーザー、その他のお客様から、以下のような方法で個人情報を取得することがあります。 （取得方法の例）
・当社のウェブサイトにてご入力いただくことによる取得
・当社に電話または電子メールにてお問い合わせをいただく際の通話・通信内容の記録または録音

3. 個人情報の利用目的
当社は、個人情報を以下の利用目的で利用します。また、当社では、予め本人の同意を得ずに、利用目的の範囲を超えて個人情報を取り扱うことはありません。
（当サイトのユーザー会員の個人情報）
会員管理
当社のサービス運営上必要な事項の通知・保存
各種問い合わせ対応およびアフターサービスの実施
契約や法律に基づく権利の行使または義務の履行
キャンペーン、懸賞企画、アンケートの実施
メールマガジンの配信
統計資料の作成、マーケティングデータの調査・分析、新サービスの開発

（当サイトに掲載を希望するもの）
当社の提供するサービスの提案、資料の提供、販売
説明会、セミナー等の開催
加盟店管理
加盟店審査
当社のサービス運営上必要な事項の通知
各種問い合わせ対応およびアフターサービスの実施
契約や法律に基づく権利の行使または義務の履行
キャンペーン、アンケートの実施
統計資料の作成、マーケティングデータの調査・分析、新サービスの開発
加盟店に関連する商品、サービス等のご提案

個人情報の安全管理
当社は、個人情報の漏洩、紛失、毀損および改竄の防止、その他の個人情報の安全管理が図られるよう、適切な情報セキュリティ対策ならびに従業員に対する必要かつ適切な監督を行います。

5. 個人情報の委託
当社は、当社が保有する個人情報の全部または一部を、利用目的遂行のために第三者に委託する場合は、委託先の選定に配慮するとともに、個人情報保護に関する契約を締結した上行います。

6. 個人情報の第三者提供
当社は、以下の場合に限り、個人情報を第三者に提供いたします。

（当社のサービスのユーザー会員の個人情報）
本人の同意がある場合
法令に基づく場合または法令により提供が認められる場合
人の生命、身体または財産の保護のために必要がある場合であって、本人の同意を得ることが困難である場合
公衆衛生の向上または児童の健全な育成の推進のために特に必要がある場合であって、本人の同意を得ることが困難である場合
国の機関もしくは地方公共団体またはその委託を受けた者が法令の定める事務を遂行することに対して協力する必要がある場合であって、本人の同意を得ることによって当該事務の遂行に支障を及ぼすおそれがある場合

（加盟店の個人情報）
本人の同意がある場合
法令に基づく場合または法令により提供が認められる場合
人の生命、身体または財産の保護のために必要がある場合であって、本人の同意を得ることが困難である場合
公衆衛生の向上または児童の健全な育成の推進のために特に必要がある場合であって、本人の同意を得ることが困難である場合
国の機関もしくは地方公共団体またはその委託を受けた者が法令の定める事務を遂行することに対して協力する必要がある場合であって、本人の同意を得ることによって当該事務の遂行に支障を及ぼすおそれがある場合
会員が参加加盟店に対して各種問い合わせ（アフターサービスに関する問い合わせを含みます。）をするために必要な範囲で、個人情報を提供する場合

7. 統計データの作成・利用
当社は、取得した個人情報をもとに、個人を特定できないよう加工した統計データを作成することがあります。個人を特定できない統計データについては、当社は、何ら制限なく利用することができるものとします。

8. クッキー(cookie)等の使用
当社は、当社のサービスの会員、参加加盟店その他のお客様が、当社のウェブサイトにアクセスされたことを契機として、以下のような個人を特定しない情報を取得することがあります。
閲覧に利用されたコンピュータ機器の基本情報（IPアドレス、携帯端末の機体識別情報、ブラウザの種類・バージョン、OSの種類、プラットフォームなど）、閲覧履歴(URL、アクセス日時、表示された商品など）
上記のほか、クッキー(cookie)やウェブビーコン(web beacon)の技術により自動的に取得される情報

9. 個人情報の開示・訂正・利用停止・削除
当社は、本人または代理人から個人情報の開示・訂正・利用停止・削除等を求められた時は、速やかに手続をします。ただし、手続にあたって、本人確認書類（免許証・住民票の写し等、当社が指定するもの）をご提出いただきます。

10. 継続的改善
当社は、個人情報保護体制を適切に維持する為、コンプライアンス・プログラムを定期的に見直し、その改善に努めます。

11. プライバシーポリシーに関するお問い合わせ
当社のプライバシーポリシーに関するお問い合わせは、以下までお願い致します。
住所：〒103-0025　東京都中央区茅場町1丁目9－2　第一稲村ビル3階
名前：株式会社ご縁 市川健三
                                            </textarea>
                                                <p>上記、個人情報の取り扱いに</p>
                                                <input type="radio" value="1" name="status"
                                                       id="personal_info_yes"
                                                        {{ old('status') == 1 ? 'checked' : '' }}
                                                >
                                                <label class="checkbox-inline" for="personal_info_yes">同意する</label>
                                                <input type="radio" value="0" name="status" id="personal_info_no"
                                                        {{ old('status') == 0 ? 'checked' : '' }}
                                                >
                                                <label class="checkbox-inline" for="personal_info_no">同意しない</label>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <input type="submit" value="確認" name="submit">
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            @include('app.common.breadcrumbs', ['crumbs' => [
                  ['url' => route('index'), 'name' => $configs["site_name"]],
                  ['url' => route('job_detail', [ 'id' => $job->id]), 'name' => '求人詳細'],
                  ['url' => '#', 'name' => '応募する']
              ]])
        </div>
    </div>
</div>
@endsection

@section('vue-js')
    <script src="/js/app/home/register_form.js"></script>
    <script type="text/javascript">
      $(function () {
        $(window).on('beforeunload', function (e) {
          if (window.numberOfChange > 2)
            return true
          else
            e = null
        })
      })
    </script>
    <script>
      $('#confirm').click(function () {
        $('input[name=\'confirm\']').val('true')
        var form = document.getElementById('inquiry')
        form.submit()
      })

      $('#back').click(function () {
        $('input[name=\'back\']').val('true')
        var form = document.getElementById('inquiry')
        form.submit()
      })
    </script>
@endsection
