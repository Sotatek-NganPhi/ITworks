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
                    <a href="javascript:void(0)"><span>{{ $job->company_name }} の求人詳細</span></a>
                </li>
            </ul>
            @php ($mark = rand(1, 3))
            <div class="detail_item">
                <div class="title">
                    <h2>{{$job->description}}</h2>
                    <div class="list-btn">
                        <div class="btn"><a href="{{ route('job_register', $job->id) }}">応募する</a></div>

                        <div class="btn"><a href="{{ route('show_job_send_mobile', $job->id) }}">ケータイへ送る</a></div>

                        @if(!$isBookmark)
                            <div class="btn"><a href="{{ route('show_job_clips', $job->id) }}">クリップする</a></div>
                        @else
                            <div class="btn" disabled><a href="javascript:void(0)">クリップする</a></div>
                        @endif
                    </div>
                </div>

                <div class="__description">
                    <div class="salary salary-detail">{!! nl2br($job->salary) !!}</div>
                </div>
                <div class="__sub_title">
                    <h3>{!! nl2br($job->company_name) !!}</h3>
                </div>
                <div class="job_summary">
                    <div class="main_img_job">
                        @if(isset($job->main_image))
                            <img src="{{$job->main_image}}" alt="{{$job->main_caption}}">
                        @endif
                    </div>

                    <div class="req_job">
                        <p class="pr">{!! nl2br($job->seniors_hometown) !!}</p>
                    </div>
                </div>
            @if(auth::check())
                <div class="other_img_job">
                    @if(isset($job->sub_image1))
                        <img src="{{$job->sub_image1}}" alt="{{$job->sub_caption1}}">
                    @endif
                    @if(isset($job->sub_image2))
                        <img src="{{$job->sub_image2}}" alt="{{$job->sub_caption2}}">
                    @endif
                    @if(isset($job->sub_image3))
                        <img src="{{$job->sub_image3}}" alt="{{$job->sub_caption3}}">
                    @endif
                </div>

                <div class="other_img_job">
                    @if(isset($job->sub_caption1))
                        <p class="c01">{{$job->sub_caption1}}</p>
                    @endif
                    @if(isset($job->sub_caption2))
                        <p class="c02">{{$job->sub_caption2}}</p>
                    @endif
                    @if(isset($job->sub_caption3))
                        <p class="c03">{{$job->sub_caption3}}</p>
                    @endif
                </div>

                <div class="send_mail_box">
                    <div class="btn_send_mail">
                        <h5 class="mail">
                            <a href="{{ route('job_register', $job->id) }}">
                                <span class="glyphicon glyphicon-envelope"></span>応募する
                            </a>
                        </h5>
                    </div>
                </div>

                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <th colspan="2" class="__title">募集要項</th>
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
                        <th>掲載期間</th>
                        <td>{{$job->post_start_date}}-{{$job->post_end_date}}</td>
                    </tr>

                    </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <th colspan="2" class="__title_company">企業情報</th>
                    </tr>
                    <tr class="ClientName">
                        <th>掲載企業</th>
                        <td>{!! nl2br($job->company->name) !!}</td>
                    </tr>
                    <tr class="ClientName">
                        <th>掲載企業フリガナ</th>
                        <td>{!! nl2br($job->company->name_phonetic) !!}</td>
                    </tr>
                    <tr class="ClientAddress">
                        <th>住所</th>
                        <td>{!! nl2br($job->company->street_address) !!}</td>
                    </tr>
                    <tr class="ClientAddress">
                        <th>担当者名</th>
                        <td>{!! nl2br($job->company->contact_name) !!}</td>
                    </tr>
                    <tr class="ClientAddress">
                        <th>電話番号</th>
                        <td>{!! nl2br($job->company->phone_number) !!}</td>
                    </tr>
                    <tr>
                        <th>事業内容</th>
                        <td>{!! nl2br($job->company->short_description) !!}</td>
                    </tr>
                    <tr>
                        <th>会社HP</th>
                        <td>{!! nl2br($job->company->company_hp) !!}
                        </td>
                    </tr>

                    </tbody>
                </table>
                <br>
                <div class="send_mail_box">
                    <div class="btn_send_mail">
                        <h5 class="mail"><a href="{{ route('job_register', $job->id) }}">
                                <span class="glyphicon glyphicon-envelope"></span>応募する
                            </a>
                        </h5>
                    </div>
                </div>
            @else
                <div class="clear"></div>
                <div class="blur-mask mark-{{$mark}}">
                    <a class="button-outer" href="{{ url('register') }}">
                        <div class="signup-button">
                            会員登録をして求人情報を見る
                        </div>
                      </a>
                </div>
            @endif
                <div class="recommend-jobs">
                        <div class="recent-viewed-jobs stick-single-row" v-if="!!similarCategoryJob.length">
                            <div class="title">
                                <span class="glyphicon glyphicon-search"></span>
                                この求人情報を見た人はこれも見ている
                            </div>
                            <div class="recent-viewed-carousel">
                                <div class="big-slider">
                                    <div class="slide" v-for="job in similarCategoryJob" v-cloak>
                                        <div class="img">
                                            <a :href="/job/ + job.id"><img :src="job.main_image"></a>
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
                        <div class="recent-viewed-jobs"
                             :class="!!similarCategoryHistoryJob.length ? '': 'stick-single-row'"
                             v-if="!!historyJob.length">
                            <div class="title">最近見た求人</div>
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
                        <div class="similar-jobs"
                             :class="!!historyJob.length ? '': 'stick-single-row'"
                             v-if="!!similarCategoryHistoryJob.length">
                            <div class="title">閲覧履歴からあなたのオススメの求人</div>
                            <div class="recent-viewed-carousel">
                                <div class="small-slider">
                                    <div class="slide" v-for="job in similarCategoryHistoryJob" v-cloak>
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
                <div class="mobile-job-list">
                    <div class="jobs-list" v-if="!!similarCategoryJob.length">
                        <div class="title">この求人情報を見た人はこれも見ている</div>
                        <div class="job" v-for="job in limit(similarCategoryJob)" @click="goToJob(job.id)" v-cloak>
                            <div class="img">
                                <a :href="/job/ + job.id"><img :src="job.main_image"></a>
                            </div>
                            <div class="job-detail">
                                <div class="description">@{{ job.description }}</div>
                                <div class="sub-item">@{{ joinList(job.prefectures, 'name') }}</div>
                                <div class="sub-item">@{{ joinList(job.routes, 'station.name') }}</div>
                                <div class="sub-item">@{{ joinList(job.salaries, 'description') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="jobs-list" v-if="!!historyJob.length">
                        <div class="title">最近見た求人</div>
                        <div class="job" v-for="job in limit(historyJob)" @click="goToJob(job.id)" v-cloak>
                            <div class="img">
                                <a :href="/job/ + job.id"><img :src="job.main_image"></a>
                            </div>
                            <div class="job-detail">
                                <div class="description">@{{ job.description }}</div>
                                <div class="sub-item">@{{ joinList(job.prefectures, 'name') }}</div>
                                <div class="sub-item">@{{ joinList(job.routes, 'station.name') }}</div>
                                <div class="sub-item">@{{ joinList(job.salaries, 'description') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="jobs-list" v-if="!!similarCategoryHistoryJob.length">
                        <div class="title">閲覧履歴からあなたのオススメの求人</div>
                        <div class="job" v-for="job in limit(similarCategoryHistoryJob)" @click="goToJob(job.id)" v-cloak>
                            <div class="img">
                                <a :href="/job/ + job.id"><img :src="job.main_image"></a>
                            </div>
                            <div class="job-detail">
                                <div class="description">@{{ job.description }}</div>
                                <div class="sub-item">@{{ joinList(job.prefectures, 'name') }}</div>
                                <div class="sub-item">@{{ joinList(job.routes, 'station.name') }}</div>
                                <div class="sub-item">@{{ joinList(job.salaries, 'description') }}</div>
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
                    <a href="javascript:void(0)"><span>{{ $job->company_name }} の求人詳細</span></a>
                </li>
            </ul>
            <input hidden name="job_id" value="{{$job->id}}">
        </div>
    </div>

@endsection
