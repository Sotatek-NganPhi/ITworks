@extends('app.layout')

@section('title')
    Special｜{{$results["site_name"]->value}}
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
                            <div class="detail"><a href="/job/{{$jobs['job_id']}}">Chi tiết</a></div>
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
                                    <th>ĐIều kiện ứng tuyển</th>
                                    <td>{{$jobs['application_condition']}}&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>Thời gian ứng tuyển</th>
                                    <td>{{$jobs['post_start_date']}} - {{$jobs['post_end_date']}}&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
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