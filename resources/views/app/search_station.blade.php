@extends('app.layout')

@section('title', 'サーチ')

@section('vue-js')
    <script src="/js/app/home/search_station.js"></script>
@endsection

@section('page_content')
    <input hidden name="key_region" value="{{$region->key}}">
    <input hidden name="prefecture_id" value="{{$prefecture->id}}">
    <div id="navi_search">
        <div class="menu_home_page">
            <div class="area">
                <ol>
                    @foreach($regions as $reg)
                        <li class="{{ preg_match('/' . $reg->key .'/i', Request::url()) ? 'active' : '' }}"
                            style="width: {{ 100/count($regions) }}%;">
                            <a href="{{ route('home', $reg->key) }}"
                               title="{{$reg->key}}">{{$reg->name}}</a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
    <div id="search">
        @include('app.common.breadcrumbs', ['crumbs' => collect([
            ['url' => route("home.index"), 'name' => $configs["site_name"]],
            ['url' => route("home", $region->key), 'name' => $region->name],
            ['url' => '#', 'name' => $prefecture->name . 'の求人']
        ])])
        <div id="custom_field"></div>

        <!-- TitleArea -->
        <div class="titleArea">
            <h1>{{$region->name}}の求人</h1>
            <div class="txt">{{$region->name}}で、50歳以上を対象とした求人情報をお探しなら、はたらくご縁にお任せください!</div>
        </div>
        <!-- /TitleArea -->
        <div class="searchPanel">
            <ul class="tabArea">
                <li class="tab"><a
                            href="{{route('search_job:ward', ['region' => $region->key, 'prefecture' => $prefecture->name_en])}}">エリア<span>から選択</span></a>
                </li>
                <li class="tab {{preg_match('/lines/', Request::fullUrl()) ? 'selected' : ''}}"><a
                            href="{{route('search_job:line', ['region' => $region->key, 'prefecture' => $prefecture->name_en])}}">路線・駅から<span>から選択</span></a>
                </li>
            </ul>
            <div class="contents contentsArea">
                <div class="title">ご希望の路線名を選択してください</div>
                <div class="inputArea">
                    <ul class="inputBase">
                        @if(isset($lines))
                            @foreach($lines as $line)
                                <li class="input">
                                    <label for="{{$line->id}}" title="{{$line->name}}">
                                        <input type="checkbox" name="{{$line->id}}" id="{{$line->id}}" value="{{$line->id}}"
                                               v-model="lineSelected"
                                                {{is_array($lineSelected) ?
                                                (in_array($line->name_en, $lineSelected) ? 'checked' : '') :
                                                ($lineSelected == $line->name_en ? 'checked' : '') }}>
                                            {{str_limit($line->name, 13, '..')}}（<span class="num">{{$line->total_job}}</span>）
                                    </label>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <template v-if="stations.length > 0">
                <div class="contents contentsTrain">
                    <div class="title">ご希望の駅名を選択してください</div>
                    <div class="inputArea">
                        <ul class="inputBase">
                            <template v-for="station in stations">
                                <li class="input">
                                    <label>
                                        <input type="checkbox" :value="station.id" v-model="stationSelected">
                                        @{{ station.name }}(<span class="num">@{{ station.total_job }}</span>）
                                    </label>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </template>
            <div class="contents">
                <div class="btnArea"><input type="submit" value="この条件で検索" @click="searchJob()"></div>
            </div>
        </div>

        <form name="form2">
            <div class="form_result_search">
                <table>
                    <tbody>
                    <tr>
                        <td colspan="4" class="header">検索結果</td>
                    </tr>
                    <tr>
                        <th>市区町村</th>
                        <td>{{$prefecture->name}}</td>
                    </tr>
                    @if(!empty($free_word))
                        <tr>
                            <th>フリーワード</th>
                            <td>{{urldecode($free_word)}}</td>
                        </tr>
                    @endif
                    @if(!empty($category))
                        <tr>
                            <th>職種</th>
                            <td>{{\App\Models\CategoryLevel3::findOneById($category)->name}}</td>
                        </tr>
                    @endif
                    @if(!empty($employment_mode))
                        <tr>
                            <th>条件</th>
                            <td>{{\App\Models\EmploymentMode::findOneById($employment_mode)->description}}</td>
                        </tr>
                    @endif
                    @if(!empty($merits))
                        <tr>
                            <th>希望のメリット</th>
                            <td>
                                @foreach(\App\Models\Merit::findWhereIn('id', explode(",", urldecode($merits))) as $merit)
                                    {{$merit->name}}@if (!$loop->last) . @endif
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    <td colspan="4" class="footer">
                        <template>
                            <a href="javascript:void(0)" class="btn_close" v-if="isFindMore"
                               @click="showSearchPanel">さらに詳しく検索する</a>
                        </template>
                        <a href="javascript:void(0)" class="formResearchBtn" v-if="!isFindMore"
                           @click="showSearchPanel">さらに詳しく検索する</a>
                    </td>
                </table>
            </div>

        </form>
        <template v-cloak>
            <search-panel enable-advanced="true" :hide-btn-expand="hideBtnExpand"
                          v-show="isFindMore" v-on:search_panel_search="searchJob"></search-panel>
        </template>

        <div class="count-result">
            <p class="text">該当件数は<span class="count">{{$jobs->total()}}</span>件です</p>
        </div>
        @if($jobs->total() > 0)
            <div class="control">
                <div class="pagination">
                    @php($jobs->withPath(preg_replace('/&?page=[^&]*/', '', Request::fullUrl())))
                    @php($pagEnd = min((max(ceil($jobs->currentPage()/10), 1)) * 10, $jobs->lastPage()))
                    @php($pagStart = $pagEnd > 9 ? ($pagEnd - 9) : 1)
                    <p>
                        <span> 全{{$jobs->perPage()}}件 {{$jobs->currentPage()}}/{{$jobs->lastPage()}} </span>　
                        @if($jobs->currentPage() < 10)
                            <span class="disable">&lt;&lt;前の10ページ</span>
                        @else
                            <span class="active"><a
                                        href="{{$jobs->url($pagStart - 10)}}">&lt;&lt;前の10ページ</a></span>
                        @endif
                        @for($page = $pagStart; $page <= $pagEnd; $page ++)
                            <span class="{{$jobs->currentPage() == $page ? 'active' : 'disable'}}">
                                <a href="{{$jobs->url($page)}}">[<span
                                            class="per-page">{{$page}}</span>]</a></span>
                        @endfor
                        @if($pagEnd > ($jobs->lastPage() - 10))
                            <span class="disable">次の10ページ&gt;&gt;</span>
                        @else
                            <span class="active"><a
                                        href="{{$jobs->url($pagEnd + 1)}}">次の10ページ&gt;&gt;</a></span>
                        @endif
                    </p>
                    <div class="choose-page-item">
                        <div id="select-item">
                            <label for="item_page" class="label-item-page">表示件数</label>
                            <select name="item_page" class="select-item-page" v-model="limit">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="filters">
                    <p class="row">
                        <span class="text">検索結果を並び替える&nbsp;≫&nbsp;</span>
                        <span class="btn-filters">
                            @php($baseUrlSort = preg_replace('/[?&]sort=[^&]+(&|$)/','', Request::fullUrl()))
                            @php($baseUrlSort .= (strpos($baseUrlSort, '?') !== false) ? "&" : "?")
                            <a href="{{$baseUrlSort . "sort=default"}}">▼初期順</a>&nbsp;
                            <a href="{{$baseUrlSort . "sort=new"}}">▼新着順</a>&nbsp;
                            <a href="{{$baseUrlSort . "sort=end"}}">▼もうすぐ終了順</a>
                        </span>
                    </p>
                </div>
            </div>
        @endif
        <div class="list-job">
            @foreach($jobs as $job)
                @php ($mark = rand(1, 3))
                <div class="job-view">
                    <div class="list_title">
                        <h2><a href="/job/{{$job->id}}">{{$job->description}}</a></h2>
                        <div class="detail_item"><a href="/job/{{$job->id}}">詳細</a></div>
                    </div>
                    <div class="__description">
                        <div class="salary">{{$job->salary}}</div>
                        <div class="company">&nbsp;</div>
                    </div>
                    <div class="copy">
                        <h3>{{$job->company_name}}</h3>
                    </div>
                    @if(auth::check())
                        <div class="main-photo">
                            <a href="{{route("job_detail", ["id" => $job->id])}}">
                                <img src="{{$job->main_image}}" alt="{{$job->main_caption}}"/>
                            </a>
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
                                    <a href="{{route("job_detail", ["id" => $job->id])}}"><img
                                                src="{{$job->sub_image1}}"
                                                alt="{{$job->sub_caption1}}"></a>
                                @endif
                                @if(isset($job->sub_image2))
                                    <a href="{{route("job_detail", ["id" => $job->id])}}"><img
                                                src="{{$job->sub_image2}}"
                                                alt="{{$job->sub_caption2}}"></a>
                                @endif
                                @if(isset($job->sub_image3))
                                    <a href="{{route("job_detail", ["id" => $job->id])}}"><img
                                                src="{{$job->sub_image3}}"
                                                alt="{{$job->sub_caption3}}"></a>
                                @endif
                            </div>
                        </div>
                        <div class="relation">
                            <div>関連の求人</div>
                            <ul>
                                @foreach($job->prefectures as $prefecture)
                                    <li class="item"><a
                                                href="{{route('search', $region->key)}}?prefecture_id={{$prefecture->id}}">{{ $prefecture->name }}
                                            の求人</a></li>
                                @endforeach
                                @foreach($job->stations as $station)
                                    <li class="item"><a
                                                href="{{route('search', $region->key)}}?station_id={{$station->id}}">{{ $station->name }}
                                            の求人</a></li>
                                @endforeach
                                @foreach($job->categories as $category)
                                    <li class="item"><a
                                                href="{{route('search', $region->key)}}?category_id={{$category->id}}">{{ $category->name }}
                                            の求人</a></li>
                                @endforeach
                                @foreach($job->salaries as $salary)
                                    <li class="item"><a
                                                href="{{route('search', $region->key)}}?salary_id={{$salary->id}}">{{ $salary->description }}
                                            の求人</a></li>
                                @endforeach
                                @foreach($job->merits as $merit)
                                    <li class="item"><a
                                                href="{{route('search', $region->key)}}?merits={{$merit->id}}">{{ $merit->name }}
                                            の求人</a></li>
                                @endforeach
                            </ul>
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
                </div>
            @endforeach
        </div>
        @if($jobs->total() > 0)
            <div class="control">
                <div class="pagination">
                    <p>
                        <span> 全{{$jobs->perPage()}}件 {{$jobs->currentPage()}}/{{$jobs->lastPage()}} </span>　
                        @if($jobs->currentPage() < 10)
                            <span class="disable">&lt;&lt;前の10ページ</span>
                        @else
                            <span class="active"><a
                                        href="{{$jobs->url($pagStart - 10)}}">&lt;&lt;前の10ページ</a></span>
                        @endif
                        @for($page = $pagStart; $page <= $pagEnd; $page ++)
                            <span class="{{$jobs->currentPage() == $page ? 'active' : 'disable'}}">
                                <a href="{{$jobs->url($page)}}">[<span
                                            class="per-page">{{$page}}</span>]</a></span>
                        @endfor
                        @if($pagEnd > ($jobs->lastPage() - 10))
                            <span class="disable">次の10ページ&gt;&gt;</span>
                        @else
                            <span class="active"><a
                                        href="{{$jobs->url($pagEnd + 1)}}">次の10ページ&gt;&gt;</a></span>
                        @endif
                    </p>
                </div>
            </div>
        @endif

        @if(isset($stations))
            <input hidden value="{{ $stations }}" name="allStation">
        @endif

        @if(isset($lines))
            <input hidden value="{{ $lines, 9 }}" name="allLine">
        @endif

        @include('app.common.breadcrumbs', ['crumbs' => collect([
            ['url' => route("home.index"), 'name' => $configs["site_name"]],
            ['url' => route("home", $region->key), 'name' => $region->name],
            ['url' => '#', 'name' => $prefecture->name . 'の求人']
        ])])
    </div>
@endsection
