@extends('app.layout')

@section('title')
    WEB履歴書　完了｜{{$configs["pc_site_title"]}}
@endsection

@section('vue-js')
    <script src="/js/app/home/register_form.js"></script>
    <style>
        .vue-datepicker input {
            margin: 0px;
            height: 37px;
        }

        .candidate-edit input {
            width: inherit;
        }
    </style>
    <script>
      $('#confirm').click(function () {
        $("input[name='confirm']").val('true');
        var form = document.getElementById('inquiry');
        form.submit();
      });

      $('#back').click(function () {
        $("input[name='back']").val('true');
        var form = document.getElementById('inquiry');
        form.submit();
      });
    </script>
@endsection

@section('page_content')
    <div id="page_content">
        @include('app.common.breadcrumbs', ['crumbs' => [
                  ['url' => route('index'), 'name' => $configs["site_name"]],
                  ['url' => route('member_home'), 'name' => 'MY PAGE TOP'],
                  ['url' => '#', 'name' => 'WEB履歴書修正完了']
              ]])
        @include('app.member.header')


        <div id="__component">
            <h3>WEB履歴書の確認</h3>
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
                    <form method="POST" action="/member/resume_register" id="inquiry" class="inquiry">
                        {{ csrf_field() }}
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
                            <input hidden name="is_married"
                                   value="{{ isset($inputs['is_married']) ? $inputs['is_married'] : ''}}">

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
                            <input hidden name="lastest_company_name"
                                   value="{{ isset($inputs['lastest_company_name']) ? $inputs['lastest_company_name'] : ''}}">
                            <input hidden name="lastest_employment_mode_id"
                                   value="{{ isset($inputs['lastest_employment_mode_id']) ? $inputs['lastest_employment_mode_id'] : ''}}">

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
                                    <th class="required">現在の状況</th>
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
                <p>履歴書の登録が完了しました。</p>
            @else
                <div id="register_from">
                    <form class="inquiry" method="POST" name="form" id="inquiry"
                          action="/member/resume_register">
                        {{ csrf_field() }}
                        <table>
                            <tbody class="candidate-edit">
                            <tr>
                                <th class="required">ログインID</th>
                                <td>
                                    <input disabled class="form-control" value="{{ old('email') }}">
                                    <input type="hidden" name="email" value="{{ old('email') }}">
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
                                    <div class="postal-code">
                                        <postal-code name="postal_code" value="{{  old('postal_code') }}"></postal-code>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="required">住所</th>
                                <td>
                                    <input class="form-control" name="address" value="{{ old('address') }}" size="40">
                                </td>
                            </tr>
                            <tr>
                                <th class="required">電話番号</th>
                                <td>
                                    <phone-input name="phone_number" value="{{ old('phone_number') }}"
                                           size="40"></phone-input>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <h4>プロフィール</h4>
                        <table>
                            <tbody>
                            <tr>
                                <th class="required">現在の状況</th>
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
                                    <date-picker name="graduated_at" locale="ja" value="{{ old('graduated_at') }}"
                                                 format="YYYY-MM-DD" required></date-picker>
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
                                <th class="required">直近の職歴　会社名</th>
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
                                    <input class="form-control" type="text" name="toeic" value="{{ old('toeic') }}"
                                           size="40" maxlength="6">
                                </td>
                            </tr>
                            <tr>
                                <th class="norequired">TOEFL</th>
                                <td>
                                    <input class="form-control" type="text" name="toefl" value="{{ old('toefl') }}"
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
                            </tbody>
                        </table>
                        <input type="submit" value="確認" name="submit">
                        <input type="submit" value="下書き保存" class="draft" name="submit">
                    </form>
                </div>
            @endif
        </div>
        @include('app.common.breadcrumbs', ['crumbs' => [
          ['url' => route('index'), 'name' => $configs["site_name"]],
          ['url' => route('member_home'), 'name' => 'MY PAGE TOP'],
          ['url' => '#', 'name' => 'WEB履歴書修正完了']
      ]])
    </div>
@endsection