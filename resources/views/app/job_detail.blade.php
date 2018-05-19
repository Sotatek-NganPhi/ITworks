@extends('app.layout')

@section('title', 'Job')

@section('script')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css"/>
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function () {
        $("form").submit(function () {
          $("form *").filter(":input").each(function () {
            if ($(this).val() == '')
              $(this).prop("disabled", true);
          });
        });
        if (typeof(Storage) !== "undefined") {
          var jobId = {!! $job->id !!};
          var recentIds = [];
          var recentIdsStr = localStorage.getItem('recentViewedJobIds');
          if (recentIdsStr) {
            recentIds = JSON.parse(localStorage.getItem('recentViewedJobIds'));
          }
          recentIds.unshift(jobId);
          recentIds = _.uniq(recentIds);
          localStorage.setItem("recentViewedJobIds", JSON.stringify(recentIds));
        }
      });
    </script>
    <style>
        .stick-single-row {
            width: 98% !important;
            margin-bottom: 10px !important;
        }
    </style>
@endsection

@section('vue-js')
    <script src="/js/app/home/job_detail.js"></script>
@endsection

@section('page_content')
    <div id="job_detail">
        <div id="page_content">
            <ul class="breadcrumb">
                <li>
                    <a href="/" title="{{$configs["pc_site_title"]}}">
                        <span>{{$configs["site_name"]}}</span>
                    </a>
                    　≫　
                </li>
                <li>
                    <a href="javascript:void(0)"><span>{{ $job->company_name }} Chi tiết công việc</span></a>
                </li>
            </ul>
            @php ($mark = rand(1, 3))
            <div class="detail_item">
                <div class="title">
                    <h2>{{$job->description}}</h2>
                    <div class="list-btn">
                        <div class="btn"><a href="{{ route('job_register', $job->id) }}">Nộp đơn ứng tuyển</a></div>
                        @if(!$isBookmark)
                            <div class="btn"><a href="{{ route('show_job_clips', $job->id) }}">Lưu việc làm</a></div>
                        @else
                            <div class="btn" disabled><a href="javascript:void(0)">Lưu việc làm</a></div>
                        @endif
                    </div>
                </div>
                <div class="__sub_title">
                    <h3>{!! nl2br($job->company_name) !!}</h3>
                </div>
            @if(auth::check())
                <div class="send_mail_box">
                    <div class="btn_send_mail">
                        <h5 class="mail">
                            <a href="{{ route('job_register', $job->id) }}">
                                <span class="glyphicon glyphicon-envelope"></span>Nộp đơn
                            </a>
                        </h5>
                    </div>
                </div>

                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <th colspan="2" class="__title">Chi tiết công việc</th>
                    </tr>

                    @foreach ($optionalFields as $fieldName)
                        @if (isset($job[$fieldName]))
                        <tr>
                            @if (isset($fieldSettings['jobs'][$fieldName]))
                            <th>{!! nl2br($fieldSettings['jobs'][$fieldName]->display_name) !!}</th>
                            @else
                            <th>{{ $fieldName }}</th>
                            @endif
                            <td>{!! nl2br( $job[$fieldName]) !!}</td>
                        </tr>
                        @endif
                    @endforeach

                    <tr>
                        <th>Thời gian nhận hồ sơ</th>
                        <td>{{$job->post_start_date}}-{{$job->post_end_date}}</td>
                    </tr>

                    </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <th colspan="2" class="__title_company">Thông tin công ty</th>
                    </tr>
                    <tr class="ClientName">
                        <th>Tên công ty</th>
                        <td>{!! nl2br($job->company->name) !!}</td>
                    </tr>
                    <tr class="ClientAddress">
                        <th>Địa chỉ</th>
                        <td>{!! nl2br($job->company->street_address) !!}</td>
                    </tr>
                    <tr class="ClientAddress">
                        <th>Tên người liên hệ</th>
                        <td>{!! nl2br($job->company->contact_name) !!}</td>
                    </tr>
                    <tr class="ClientAddress">
                        <th>Số điện thoại</th>
                        <td>{!! nl2br($job->company->phone_number) !!}</td>
                    </tr>
                    <tr>
                        <th>Mô tả ngắn gọn</th>
                        <td>{!! nl2br($job->company->short_description) !!}</td>
                    </tr>
                    </tbody>
                </table>
                <br>
                <div class="send_mail_box">
                    <div class="btn_send_mail">
                        <h5 class="mail"><a href="{{ route('job_register', $job->id) }}">
                                <span class="glyphicon glyphicon-envelope"></span>Nộp đơn
                            </a>
                        </h5>
                    </div>
                </div>
            @else
                <div class="clear"></div>
                <div class="blur-mask mark-{{$mark}}">
                    <a class="button-outer" href="{{ url('login') }}">
                        <div class="signup-button">
                            Bạn cần đăng nhập để xem chi tiết công việc
                        </div>
                      </a>
                </div>
            @endif
                <div class="recommend-jobs">
                    <div class="recent-viewed-jobs"
                         :class="!!similarCategoryHistoryJob.length ? '': 'stick-single-row'"
                         v-if="!!historyJob.length">
                        <div class="title">Các công việc đã xem gần đây</div>
                        <div class="recent-viewed-carousel">
                            <div class="small-slider">
                                <div class="slide" v-for="job in historyJob" v-cloak>
                                    <div class="img">
                                        <a :href="/job/ + job.id">
                                            <img :src="job.main_image" alt="">
                                        </a>
                                    </div>
                                    <div class="job-list-detail">
                                        <div class="catch">
                                            <a :href="/job/ + job.id">@{{ job.description }}</a>
                                        </div>
                                        <p v-if="joinList(job.prefectures, 'name')" class="area">
                                            @{{ joinList(job.prefectures, 'name') }}</p>
                                        <p v-if="joinList(job.routes, 'station.name')" class="station">
                                            @{{ joinList(job.routes, 'station.name') }}</p>
                                        <p v-if="joinList(job.salaries, 'description')" class="wage">
                                            @{{ joinList(job.salaries, 'description') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="breadcrumb">
                <li>
                    <a href="/" title="{{$configs["pc_site_title"]}}">
                        <span>{{$configs["site_name"]}}</span>
                    </a>
                    　≫　
                </li>
                <li>
                    <a href="javascript:void(0)"><span>{{ $job->company_name }} Chi tiết công việc</span></a>
                </li>
            </ul>
            <input hidden name="job_id" value="{{$job->id}}">
        </div>
    </div>

@endsection
