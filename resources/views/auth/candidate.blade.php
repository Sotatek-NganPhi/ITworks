@extends('app.layout')

@section('title')
    情報を登録する｜{{$configs["pc_site_title"]}}
@endsection

@section('vue-js')
    <script src="/js/app/home/register_form.js"></script>
@endsection

@section('page_content')
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>情報を登録する</span>
            </li>
            @if(Auth::check())
                <form method="get" action="{{route('logout')}}" class="form-logout">
                    <button type="submit" class="btn-logout">ログアウト</button>
                </form>
            @endif
        </ul>

        <div id="__component">
            <h3>情報を登録する</h3>
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

            <form class="app_form" id="register_from" method="POST" action="{{ route(old('formAction')) }}">
                {{ csrf_field() }}
                <input hidden name="formAction" value="{{old('formAction')}}">
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
                        <th class="norequired">転職意欲</th>
                        <td>
                            <select class="form-control" name="jumping_condition_id">
                                <option value="">---</option>
                            @foreach($jumpingConditions as $jumpingCondition)
                                <option value="{{$jumpingCondition->id}}"
                                    {{ old('jumping_condition_id') == $jumpingCondition->id ? 'selected' : '' }}
                                >{{$jumpingCondition->description}}</option>
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
                            <input class="form-control" name="final_academic_school" value="{{ old('final_academic_school') }}" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th class="norequired">最終学歴（卒業年月）</th>
                        <td>
                            <date-picker name="graduated_at" locale="ja" value="{{ old('graduated_at') }}" format="YYYY-MM-DD"></date-picker>
                        </td>
                    </tr>
                    <tr>
                        <th class="norequired">配偶者</th>
                        <td>
                            <input type="radio" value="1" name="is_married" id="married"
                                {{ old('is_married') == 1?  'checked' : '' }}
                            >
                            <label for="married">有り</label><br>
                            <input type="radio" value="0" name="is_married" id="not-married"
                                {{ old('is_married') == 0 ? 'checked' : '' }}
                            >
                            <label for="not-married">無し</label><br>
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
                            <input class="form-control" type="number" name="worked_companies_number" value="{{ old('worked_companies_number') }}" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th class="required">社名</th>
                        <td>
                            <input class="form-control" name="lastest_company_name" value="{{ old('lastest_company_name') }}" size="40">
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
                            <input class="form-control" type="text" name="lastest_annual_income" value="{{ old('lastest_annual_income') }}" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th class="required">従業員数</th>
                        <td>
                            <select class="form-control" name="lastest_company_size_id">
                                <option value="">---</option>
                            @foreach($companySizes as $companySize)
                                <option value="{{$companySize->id}}"
                                    {{ old('lastest_company_size_id') == $companySize->id ? 'selected' : '' }}
                                >{{$companySize->description}}</option>
                            @endforeach
                            </select>
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

                <h4>希望条件</h4>
                <table>
                    <tbody>
                    <tr>
                        <th class="required">希望転職時期</th>
                        <td>
                            <select class="form-control" name="jumping_date_id">
                            @foreach($jumpingDates as $jumpingDate)
                                <option value="{{$jumpingDate->id}}"
                                    {{ old('jumping_date_id') == $jumpingDate->id ? 'selected' : '' }}
                                >{{$jumpingDate->description}}</option>
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="required">希望勤務地</th>
                        <td>
                            @foreach($regions as $region)
                            <h4 >{{$region->name}}</h4><br>
                                <div class="entries">
                                @foreach($region->prefectures as $prefecture)
                                    <label class="checkbox-inline">
                                        <input type="checkbox"
                                            name="prefectures[]"
                                            value="{{$prefecture->id}}"
                                            {{ in_array($prefecture->id, old('prefectures', []))?  'checked' : '' }}
                                        >
                                        {{$prefecture->name}}
                                    </label>
                                @endforeach
                                </div>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="required">雇用形態</th>
                        <td>
                            @foreach($employmentModes as $employmentMode)
                            <label>
                                <input type="checkbox"
                                    name="employment_modes[]"
                                    value="{{$employmentMode->id}}"
                                    {{ in_array($employmentMode->id, old('employment_modes', []))?  'checked' : '' }}
                                >
                                {{$employmentMode->description}}
                            </label><br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="norequired">希望業種</th>
                        <td>
                            @foreach($industries as $industry)
                            <label>
                                <input type="checkbox"
                                    name="industries[]"
                                    value="{{$industry->id}}"
                                    {{ in_array($industry->id, old('industries', []))?  'checked' : '' }}
                                >
                                {{$industry->name}}
                            </label><br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="norequired">従業員数</th>
                        <td>
                            @foreach($companySizes as $companySize)
                            <label>
                                <input type="checkbox"
                                    name="company_sizes[]"
                                    value="{{$companySize->id}}"
                                    {{ in_array($companySize->id, old('company_sizes', []))?  'checked' : '' }}
                                >
                                {{$companySize->description}}
                            </label><br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="norequired">給与</th>
                        <td>
                            @foreach($salaries as $salary)
                            <label>
                                <input type="checkbox"
                                    name="salaries[]"
                                    value="{{$salary->id}}"
                                    {{ in_array($salary->id, old('salaries', []))?  'checked' : '' }}
                                >
                                {{$salary->description}}
                            </label><br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="norequired">希望の勤務日数・時間</th>
                        <td>
                            @foreach($workingDays as $workingDay)
                            <label>
                                <input type="checkbox"
                                    name="working_days[]"
                                    value="{{$workingDay->id}}"
                                    {{ in_array($workingDay->id, old('working_days', []))?  'checked' : '' }}
                                >
                                {{$workingDay->name}}
                            </label><br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="norequired">希望の勤務時間</th>
                        <td>
                            @foreach($workingHours as $workingHour)
                            <label>
                                <input type="checkbox"
                                    name="working_hours[]"
                                    value="{{$workingHour->id}}"
                                    {{ in_array($workingHour->id, old('working_hours', []))?  'checked' : '' }}
                                >
                                {{$workingHour->name}}
                            </label><br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="norequired">希望の勤務期間</th>
                        <td>
                            @foreach($workingPeriods as $workingPeriod)
                            <label>
                                <input type="checkbox"
                                    name="working_periods[]"
                                    value="{{$workingPeriod->id}}"
                                    {{ in_array($workingPeriod->id, old('working_periods', []))?  'checked' : '' }}
                                >
                                {{$workingPeriod->name}}
                            </label><br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="norequired">職種</th>
                        <td>
                            @foreach($categoryLevel3s as $categoryLevel3)
                            <label>
                                <input type="checkbox"
                                    name="category_level_3s[]"
                                    value="{{$categoryLevel3->id}}"
                                    {{ in_array($categoryLevel3->id, old('category_level_3s', []))?  'checked' : '' }}
                                >
                                {{$categoryLevel3->name}}
                            </label><br>
                            @endforeach
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
                            <input class="form-control" type="text" name="toeic" value="{{ old('toeic') }}" size="40" maxlength="6">
                        </td>
                    </tr>
                    <tr>
                        <th class="norequired">TOEFL</th>
                        <td>
                            <input class="form-control" type="text" name="toefl" value="{{ old('toefl') }}" size="40" maxlength="6">
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
                                            @if($certificate->certificate_group_id == $certificate_group->id)
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
                            <textarea class="form-control candidate-job-description" name="lastest_job_description" size="40" maxlength="2000">{{ old('lastest_job_description') }}</textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <h4>スカウトについて</h4>
                <table>
                    <tbody>
                    <tr>
                        <th class="required">企業からのスカウトメールを受け取る</th>
                        <td>
                            <input type="radio" value="1" name="mail_receivable" id="receive"
                                {{ old('mail_receivable') ? 'checked' : '' }}
                            >
                            <label for="receive">受け取る</label><br>
                            <input type="radio" value="0" name="mail_receivable" id="not-receive"
                                {{ !old('mail_receivable') ? 'checked' : '' }}
                            >
                            <label for="not-receive">受け取らない</label><br>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input type="submit" value="確認" name="submit">
                <input type="submit" value="下書き保存" class="draft" name="submit">
            </form>
        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>情報を登録する</span>
            </li>
        </ul>
    </div>
@endsection