@extends('app.layout')

@section('title', $job->description . '（ID：'. $job->id . '）｜ホーム')

@section('page_content')
    <div id="search">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <a><span>求人詳細</span></a>　≫
            </li>
            <li>
                <span>携帯に送る</span>
            </li>
        </ul>
        <div class="list-job">
            <div class="job-view">
                <div class="list_title">
                    <h2><a href="/job/{{$job->id}}">{{$job->description}}</a></h2>
                    <div class="detail"><a href="/job/{{$job->id}}">詳細</a></div>
                </div>
                <div class="__description">
                    <div class="salary">{{$job->salary}}</div>
                    <div class="company">&nbsp;</div>
                </div>
                <div class="__sub_title">
                    <h3>{{$job->company_name}}</h3>
                </div>
                <div class="main-photo">
                    <a href="{{route("job_detail", ["id" => $job->id])}}"><img src="{{$job->main_image}}"
                                                      alt="{{$job->main_caption}}"></a>
                </div>
                <div class="spec">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <th>応募条件</th>
                            <td>{{$job->application_condition}}</td>
                        </tr>
                        <tr>
                            <th>掲載期間</th>
                            <td>{{$job->post_start_date}} - {{$job->post_end_date}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="list-photo-other">
                        @if(isset($job->sub_image1))
                            <a href="{{route("job_detail", ["id" => $job->id])}}"><img src="{{$job->sub_image1}}"
                                                              alt="{{$job->sub_caption1}}"></a>
                        @endif
                        @if(isset($job->sub_image2))
                            <a href="{{route("job_detail", ["id" => $job->id])}}"><img src="{{$job->sub_image2}}"
                                                              alt="{{$job->sub_caption2}}"></a>
                        @endif
                        @if(isset($job->sub_image3))
                            <a href="{{route("job_detail", ["id" => $job->id])}}"><img src="{{$job->sub_image3}}"
                                                              alt="{{$job->sub_caption3}}"></a>
                        @endif
                    </div>
                </div>
                <div class="clear-both"></div>
            </div>
        </div>

        @if(Auth::check())
            <div class="_form">
                <h4>上記のお仕事をクリップします。</h4>
                <h5>クリップした仕事は『クリップボード』よりご参照いただけます。</h5><br>
                <form name="form_login" method="post" action="{{route('add_job_clips', $job->id)}}">
                    {{ csrf_field() }}
                    <input type="submit" class="btn_login" name="Submit" value="クリップする">
                </form>
            </div>
        @else
            <div class="_form">
                <h4>上記のお仕事をクリップします。</h4>
                <h5>すでにご登録の方は、このお仕事情報をクリップして、一発検索！</h5>
                <div class="_form_action">
                    <form name="form_login" method="post" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        @if (session('messages'))
                            <div class="alert alert-success">
                                {{ session('messages') }}
                            </div>
                        @endif
                        <label for="email" class="area">メールアドレス：
                            <input name="email" type="email" maxlength="255"
                                   class="input-form {{ $errors->has('email') ? ' has-error' : '' }}" size="20">
                        </label>
                        <label for="password" class="area">パスワード：
                            <input name="password" type="password"
                                   class="input-form {{ $errors->has('password') ? ' has-error' : '' }}"
                                   maxlength="255" size="20">
                        </label>
                        <input type="submit" name="Submit" class="btn_login"
                               value="ログイン">
                        <a href="#">&gt;&gt;パスワードを忘れた方</a>
                        @if (count($errors) > 0)
                            <div>
                                <ul class="errors">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
                <h5>まだサイト登録していない方は？</h5>
                <div class="regist_box">
                    にご登録いただくと、ご応募いただいたお仕事情報をストックしたり、あらかじめ履歴書を作成しておくことができます！<br>
                    まだ登録がお済みでない方は、是非この機会にご利用下さい！<br>
                    <p class="center __btn">
                        <a class="btn_register" href="{{ route('register') }}">新規会員登録（無料）</a>
                    </p>
                </div>
            </div>
        @endif
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <a><span>求人詳細</span></a>　≫
            </li>
            <li>
                <span>携帯に送る</span>
            </li>
        </ul>
    </div>
@endsection