@extends('app.layout')

@section('title', $job->description . '（ID：'. $job->id . '）｜ホーム')

@section('page_content')
    <div id="search">
        @if(isset($isSuccess))
            <ul class="breadcrumb">
                <li>
                    <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
                </li>
                <li>
                    <span>携帯に送る完了</span>
                </li>
            </ul>
            <div class="_form">
                <h4>送信が完了しました。</h4>
                <br>
                <p>{{$configs["site_name"]}}をご利用いただき、ありがとうございます。</p>
                <p>送信が完了しました。</p>
            </div>
            <ul class="breadcrumb">
                <li>
                    <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
                </li>
                <li>
                    <span>携帯に送る完了</span>
                </li>
            </ul>
        @else
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
                        <div class="detail_item"><a href="/job/{{$job->id}}">詳細</a></div>
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

            <div class="_form">
                <h4>この仕事情報を携帯電話へ送信する</h4>
                <h5>携帯電話にこの仕事情報のURLを送信します。</h5>
                <br>
                <p>下記フォームに携帯電話のメールアドレスを入力して「送信」ボタンを押してください。</p>
                <div class="_form_action">
                    <form action="{{ route('send_job_send_mobile', $job->id) }}" method="post">
                        {{ csrf_field() }}
                        <input type="email" class="input-form" name="mail" size="30" required>
                        <input type="submit" class="btn-form" name="Submit" value="送信">
                    </form>
                </div>
            </div>
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
        @endif
    </div>
@endsection