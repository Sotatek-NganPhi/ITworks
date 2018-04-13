@extends('app.layout')

@section('title')
    キラキラ特集｜{{$results["site_name"]->value}}
@endsection

@section('page_content')
    <div id="page_content">
            <ul class="breadcrumb">
                <li>
                    <a href="/" title="{{$results["pc_site_title"]->value}}">
                        <span itemprop="title">{{$results["site_name"]->value}}</span>
                    </a>
                    　≫　
                </li>
                <li>
                    <a href="{{ url('/about/special/' . $special_promotion_id) }}"><span>{{$results["jobs"][0]['special_name']}}</span></a>
                </li>
            </ul>

            <div id="main" class="list-job">
                @foreach ($results["jobs"] as $jobs)
                    <div class="job-view">
                        <div class="list_title">
                            <h2><a href="/job/{{$jobs['job_id']}}">{{$jobs['company_name']}}</a></h2>
                            <div class="detail"><a href="/job/{{$jobs['job_id']}}">詳細</a></div>
                        </div>
                        <div class="__description">
                            <div class="salary">{{$jobs['salary']}}</div>
                            <div class="company">&nbsp;</div>
                        </div>
                        <div class="__sub_title">
                            <h3>{{$jobs['description']}}</h3>
                        </div>
                        <div class="main-photo">
                            <a href="{{route("job_detail", ["id" => $jobs['job_id']])}}">
                                <img src="{{$jobs['main_image']}}" alt="{{$jobs['main_caption']}}"/>
                            </a>
                        </div>
                        <div class="spec">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <th>応募条件</th>
                                    <td>{{$jobs['application_condition']}}&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>掲載期間</th>
                                    <td>{{$jobs['post_start_date']}} - {{$jobs['post_end_date']}}&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="list-photo-other">
                                @if(isset($jobs['sub_image1']))
                                    <a href="{{route("job_detail", ["id" => $jobs['job_id']])}}"><img
                                                src="{{$jobs['sub_image1']}}"
                                                alt="{{$jobs['sub_caption1']}}"></a>
                                @endif
                                @if(isset($jobs['sub_image2']))
                                    <a href="{{route("job_detail", ["id" => $jobs['job_id']])}}"><img
                                                src="{{$jobs['sub_image2']}}"
                                                alt="{{$jobs['sub_caption2']}}"></a>
                                @endif
                                @if(isset($jobs['sub_image3']))
                                    <a href="{{route("job_detail", ["id" => $jobs['job_id']])}}"><img
                                                src="{{$jobs['sub_image3']}}"
                                                alt="{{$jobs['sub_caption3']}}"></a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                    {{ $results["jobs"]->links('app.home.pagination') }}
            </div>

            <ul class="breadcrumb">
                <li>
                    <a href="/" title="{{$results["pc_site_title"]->value}}">
                        <span itemprop="title">{{$results["site_name"]->value}}</span>
                    </a>
                    　≫　
                </li>
                <li>
                    <a href="{{ url('/about/special/' . $special_promotion_id) }}"><span>{{$results["jobs"][0]['special_name']}}</span></a>
                </li>
            </ul>
    </div>

@endsection