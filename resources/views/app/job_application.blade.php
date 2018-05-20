@extends('app.layout')

@section('title')
    IT works
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
                  ['url' => route('job_detail', [ 'id' => $job->id]), 'name' => 'Chi tiết công việc'],
                  ['url' => '#', 'name' => 'Nộp đơn']
              ]])
            <div id="application-form">
                @if(!isset($submitted))
                <div class="detail_item">
                    <div class="job-header">
                        <a href="{{route('job_detail', [ 'id' => $job->id])}}">{{ $job->company_name }}</a>
                    </div>
                    <div class="job-content">
                        <label for="_1" class="detail-button">Chi tiết</label>
                        <input id="_1" type="checkbox">
                        <div class="expandable-content">
                            <div class="__sub_title">
                                <h3>{{ $job->description }}</h3>
                            </div>
                            <div class="job-detail">
                                <div class="spec">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                        <tr>
                                            <th>Điều kiện ứng tuyển</th>
                                            <td>{{ $job->application_condition }}</td>
                                        </tr>
                                        <tr>
                                            <th>Thời gian nhận hồ sơ</th>
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
                    <h3>Vui lòng điền vào mẫu</h3>
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
                                    <input hidden name="gender"
                                           value="{{ isset($inputs['gender']) ? $inputs['gender'] : ''}}">
                                    <input hidden name="birthday"
                                           value="{{ isset($inputs['birthday']) ? $inputs['birthday'] : ''}}">
                                    <input hidden name="address"
                                           value="{{ isset($inputs['address']) ? $inputs['address'] : ''}}">
                                    <input hidden name="phone_number"
                                           value="{{ isset($inputs['phone_number']) ? $inputs['phone_number'] : ''}}"></input>
                                    <input hidden name="graduated_at"
                                           value="{{ isset($inputs['graduated_at']) ? $inputs['graduated_at'] : ''}}">
                                    <input hidden name="education"
                                           value="{{ isset($inputs['education']) ? $inputs['education'] : ''}}">
                                    <input hidden name="final_academic_school"
                                           value="{{ isset($inputs['final_academic_school']) ? $inputs['final_academic_school'] : ''}}">

                                    @if(isset($inputs['certificates']))
                                        @foreach($inputs['certificates'] as $certificate)
                                            <input hidden name="certificates[]"
                                                   value="{{ $certificate }}">
                                        @endforeach
                                    @endif

                                    <input hidden name="language"
                                           value="{{ isset($inputs['language']) ? $inputs['language'] : ''}}">
                                    <input hidden name="language_level"
                                           value="{{ isset($inputs['language_level']) ? $inputs['language_level'] : ''}}">
                                @endif

                                <div>
                                    <table>
                                        <tbody>
                                        <tr>
                                            <th class="required">Email</th>
                                            <td>
                                                {{ isset($inputs['email']) ? $inputs['email'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">Họ và tên</th>
                                            <td>
                                                {{ isset($inputs['first_name']) ? $inputs['first_name'] : '' }}
                                                {{ isset($inputs['last_name']) ? $inputs['last_name'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">Giới tính</th>
                                            <td>
                                                {{ isset($inputs['gender']) ? $inputs['gender'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">Ngày sinh</th>
                                            <td>
                                                {{ isset($inputs['birthday']) ? $inputs['birthday'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">Địa chỉ</th>
                                            <td>
                                                {{ isset($inputs['address']) ? $inputs['address'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="required">Số điện thoại</th>
                                            <td>
                                                {{ isset($inputs['phone_number']) ? $inputs['phone_number'] : '' }}
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tr>
                                            <th class="required">Trình độ học vấn</th>
                                            <td>
                                                {{ isset($inputs['education']) ? $inputs['education'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="norequired">Học tại</th>
                                            <td>
                                                {{ isset($inputs['final_academic_school']) ? $inputs['final_academic_school'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="norequired">Thời gian tốt nghiệp</th>
                                            <td>
                                                {{ isset($inputs['graduated_at']) ? $inputs['graduated_at'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="norequired">Ngoại ngữ</th>
                                            <td>
                                                {{ isset($inputs['language']) ? $inputs['language'] : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="norequired">Trình độ ngoại ngữ</th>
                                            <td>
                                                {{ isset($inputs['language_level']) ? $inputs['language_level'] : '' }}
                                            </td>
                                        </tr>
                                    </table>
                                    @if(count($errors) == 0)
                                        <input type="submit" class="confirm" id="confirm" value="Gửi">
                                    @endif
                                    <input type="hidden" name="back" value="false">
                                    <input type="hidden" name="confirm" value="false">
                                    <input type="submit" class="cancel" id="back" value="Quay lại">
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
                                        <th class="required">Email</th>
                                        <td>
                                            <input disabled class="form-control" value="{{ old('email') }}"/>
                                            <input type="hidden" name="email" value="{{ old('email') }}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">Họ và tên</th>
                                        <td>
                                            <input placeholder="Họ" class="form-control" name="first_name"
                                                   value="{{ old('first_name') }}">
                                            <br>
                                            <input placeholder="Tên" class="form-control" name="last_name"
                                                   value="{{ old('last_name') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">Giới tính</th>
                                        <td>
                                            <input type="radio" value="male" name="gender" id="gender-male"
                                                    {{ old('gender') == 'male' ? 'checked' : '' }}
                                            >
                                            <label for="gender-male">Nam</label><br>
                                            <input type="radio" value="female" name="gender" id="gender-female"
                                                    {{ old('gender') == 'female' ? 'checked' : '' }}
                                            >
                                            <label for="gender-female">Nữ</label><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">Ngày sinh</th>
                                        <td>
                                            <div class="date-picker">
                                                <date-picker name="birthday" locale="ja" value="{{ old('birthday') }}"
                                                             format="YYYY-MM-DD"></date-picker>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">Địa chỉ</th>
                                        <td>
                                            <input class="form-control" name="address" value="{{ old('address') }}"
                                                   size="40">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="required">Số điện thoại</th>
                                        <td>
                                            <input name="phone_number"
                                                   value="{{ old('phone_number') }}"
                                                   size="40"></input>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <h4>Hồ sơ</h4>
                                <table>
                                    <tbody>
                                    <tr>
                                        <th class="required">Trình độ học vấn</th>
                                        <td>
                                            <input name="education"
                                                   value="{{ old('education') }}"
                                                   size="40"></input>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="norequired">Học tại</th>
                                        <td>
                                            <input class="form-control" name="final_academic_school"
                                                   value="{{ old('final_academic_school') }}" size="40">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="norequired">Thời gian tốt nghiệp</th>
                                        <td>
                                            <date-picker name="graduated_at" locale="ja"
                                                         value="{{ old('graduated_at') }}"
                                                         format="YYYY-MM-DD"></date-picker>
                                        </td>
                                    </tr>
                                    </tr>
                                    </tbody>
                                </table>
                                <table>
                                    <tbody>
                                    <tr>
                                        <th class="norequired">Ngoại ngữ</th>
                                        <td>
                                            <input class="form-control" name="language"
                                                   value="{{ old('language') }}" size="40">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="norequired">Trình độ ngoại ngữ</th>
                                        <td>
                                            <input class="form-control" name="language_level"
                                                   value="{{ old('language_level') }}" size="40">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <input type="submit" value="Xác nhận" name="submit">
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            @include('app.common.breadcrumbs', ['crumbs' => [
                  ['url' => route('index'), 'name' => $configs["site_name"]],
                  ['url' => route('job_detail', [ 'id' => $job->id]), 'name' => 'Chi tiết công việc'],
                  ['url' => '#', 'name' => 'Nộp đơn']
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
