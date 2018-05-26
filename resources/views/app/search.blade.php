@extends('app.layout')

@section('title', 'Search')

@section('script')
    <script type="text/javascript">
      $(document).ready(function () {
        $('form').submit(function () {
          $('form *').filter(':input').each(function () {
            if ($(this).val() == '')
              $(this).prop('disabled', true)
          })
        })
        $('#formRegisterBtn').click(function () {
          var form = document.getElementById('form-search-panel');
          form.action = '/login-condition';
          form.method = 'post';
          form._token.value = $('meta[name="csrf-token"]').attr('content');
          form.key_region.value = $('input[name="key_region"]').val();
          form.submit();
        });
        $("#formRegisterUnspecifiedBtn").click(function () {
          var form = document.getElementById('form-search-panel');
          form.action = '/login-condition';
          form.method = 'post';
          form._token.value = $('meta[name="csrf-token"]').attr('content');
          form.key_region.value = $('input[name="key_region"]').val();
          form.submit();
        });
      })
    </script>
@endsection

@section('vue-js')
    <script src="/js/app/home/search.js"></script>
@endsection

@section('page_content')
    <input hidden name="key_region" value="{{$region->key}}">
    <div id="navi_search">
        <div class="menu_home_page">
            <div class="area">
                <ol>
                    @foreach($regions as $region)
                        <li class="{{ preg_match('/' . $region->key .'/i', Request::url()) ? 'active' : '' }}"
                            style="width: {{ 100/count($regions) }}%;">
                            <a href="{{ route('home', $region->key) }}"
                               title="{{$region->key}}">{{$region->name}}</a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
    <div id="search">
        @if(preg_match("/" . $region->key .'\/job(\?)?\z$/', Request::fullUrl()))
            @include('app.common.breadcrumbs', ['crumbs' => collect([
                ['url' => route("home", $region->key), 'name' => $configs["site_name"]],
                ['url' => 'javascript:void(0)', 'name' => $region->name . 'Danh sách công việc']
            ])])
        @endif

        <div id="custom_field"></div>

        <form name="form2">
            <div class="form_result_search">
                <table>
                    <tbody>
                    <tr>
                        <td colspan="4" class="header">Kết quả tìm kiếm</td>
                    </tr>
                    @if(count($conditions) > 0)
                        @if(count($conditions) < 2)
                            @if(array_key_exists('merits', $conditions))
                                @foreach($conditions as $condition)
                                    <tr>
                                        <th>{{ $condition["display"]}}</th>
                                        <td>
                                            @foreach($condition['text'] as $item)
                                                @if(!$loop->first && ($condition['key'] == 'municipality'))
                                                    <span style="padding-left: 8px">L</span>
                                                @endif
                                                {{$item}}<br>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    @foreach($conditions as $condition)
                                        <th>{{ $condition["display"]}}</th>
                                        <td>
                                            @foreach($condition['text'] as $item)
                                                @if(!$loop->first && ($condition['key'] == 'municipality'))
                                                    <span style="padding-left: 8px">L</span>
                                                @endif
                                                {{$item}}<br>
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            @endif
                        @elseif(count($conditions) == 6)
                            @foreach(array_chunk($conditions, 2) as $arrays)
                                @if($loop->last)
                                    @foreach($arrays as $e)
                                        <tr>
                                            <th>{{ $e["display"]}}</th>
                                            <td colspan="3">
                                                @foreach($e['text'] as $item)
                                                    @if(!$loop->first && ($e['key'] == 'category' || $e['key'] == 'municipality'))
                                                        <span style="padding-left: 8px">L</span>
                                                    @endif
                                                    {{$item}}<br>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        @foreach($arrays as $e)
                                            <th>{{ $e["display"] }}</th>
                                            <td>
                                                @foreach($e['text'] as $item)
                                                    @if(!$loop->first && ($e['key'] == 'category' || $e['key'] == 'municipality'))
                                                        <span style="padding-left: 8px">L</span>
                                                    @endif
                                                    {{$item}}<br>
                                                @endforeach
                                            </td>
                                        @endforeach
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                @foreach($conditions as $condition)
                                    @if($loop->index < 2)
                                        <th>{{ $condition["display"] }}</th>
                                        <td>
                                            @foreach($condition['text'] as $item)
                                                @if(!$loop->first && ($condition['key'] == 'municipality'))
                                                    <span style="padding-left: 8px">L</span>
                                                @endif
                                                {{$item}}<br>
                                            @endforeach
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                            @foreach($conditions as $condition)
                                @if($loop->index > 1)
                                    <tr>
                                        <th>{{ $condition["display"]}}</th>
                                        <td colspan="3">
                                            @foreach($condition['text'] as $item)
                                                @if(!$loop->first && ($condition['key'] == 'municipality'))
                                                    <span style="padding-left: 8px">L</span>
                                                @endif
                                                {{$item}}<br>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                    @endif
                    @if(count($conditions) == 0)
                        <tbody v-if="isUnspecified">
                        <tr>
                            <td colspan="4" style="text-align:center;">
                                <div style="padding:10px"><b>Không xác định</b></div>
                            </td>
                        </tr>
                        </tbody>
                    @endif
                </table>
            </div>

        </form>
        <div class="condition-data">
            @foreach($params as $key => $param)
                <input hidden name="{{$key}}" id="{{$key}}" value="{{$param}}">
            @endforeach
        </div>
        <template v-cloak>
            <search-panel enable-advanced="true" :unspecified="unspecified" :hide-btn-expand="hideBtnExpand"
                          v-show="isFindMore"></search-panel>
        </template>

        <div class="count-result">
            <p class="text">Số công việc là<span class="count">{{$results["total"]}}</span> công việc</p>
        </div>
        @if($results["total"] > 0)
            @if(preg_match("/job\z$/", $results["path"]))
                <div class="control">
                    <div class="pagination">
                        <p>
                            @if($results["floor"] < 2)
                                <span class="disable">&lt;&lt;10 trang trước</span>
                            @else
                                <span class="active"><a
                                            href="{{$results["path"] . "?page=" . $results["current_page"] . "&floor=on"}}">&lt;&lt;10 trang trước</a></span>
                            @endif
                            @for($i = $results["floor"]; $i <= $results["ceil"]; $i++)
                                <span class="{{$results["current_page"] == $i ? 'active' : 'disable'}}"><a
                                            href="{{$results["path"] ."?page=" . $i}}">[<span
                                                class="per-page">{{$i}}</span>]</a></span>
                            @endfor
                            @if($results["last_page"] == $results["ceil"])
                                <span class="disable">10 trang sau&gt;&gt;</span>
                            @else
                                <span class="active"><a
                                            href="{{$results["path"] ."?page=" . $results["current_page"] . "&ceil=on"}}">10 trang sau&gt;&gt;</a></span>
                            @endif
                        </p>
                        <div class="choose-page-item">
                            <div id="select-item">
                                <label for="item_page" class="label-item-page">Số lượng hiển thị</label>
                                <select name="item_page" id="item_page" class="select-item-page" v-model="limit">
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
                            <span class="text">Sắp xếp kết quả tìm kiếm&nbsp;≫&nbsp;</span>
                            <span class="btn-filters">
                                <a href="{{preg_replace('/&sort=[^&]+(&|$)/','', $results["path"]) . "?sort=default"}}">▼Thứ tự ngẫu nhiên</a>&nbsp;
                                <a href="{{preg_replace('/&sort=[^&]+(&|$)/','', $results["path"]) . "?sort=new"}}">▼Từ công việc mới nhất</a>&nbsp;
                                <a href="{{preg_replace('/sort=[^&]+(&|$)/','', $results["path"]) . "&sort=end"}}">▼Theo thời gian kết thúc</a>
                            </span>
                        </p>
                    </div>
                </div>
            @else
                <div class="control">
                    <div class="pagination">
                        <p>
                            @if($results["floor"] < 2)
                                <span class="disable">&lt;&lt;10 trang trước</span>
                            @else
                                <span class="active"><a
                                            href="{{$results["path"] . "&page=" . $results["current_page"] . "&floor=on"}}">&lt;&lt;10 trang trước</a></span>
                            @endif
                            @for($i = $results["floor"]; $i <= $results["ceil"]; $i++)
                                <span class="{{$results["current_page"] == $i ? 'active' : 'disable'}}"><a
                                            href="{{$results["path"] ."&page=" . $i}}">[<span
                                                class="per-page">{{$i}}</span>]</a></span>
                            @endfor
                            @if($results["last_page"] == $results["ceil"])
                                <span class="disable">10 trang sau&gt;&gt;</span>
                            @else
                                <span class="active"><a
                                            href="{{$results["path"] ."&page=" . $results["current_page"] . "&ceil=on"}}">10 trang sau&gt;&gt;</a></span>
                            @endif
                        </p>
                        <div class="choose-page-item">
                            <div id="select-item">
                                <label for="item_page" class="label-item-page">Số lượng hiển thị</label>
                                <select name="item_page" id="item_page" class="select-item-page" v-model="limit">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="filters">
                        <p class="row">Sắp xếp kết quả tìm kiếm&nbsp;≫&nbsp;

                            <a href="{{preg_replace('/sort=[^&]+(&|$)/','', $results["path"]) . "&sort=default"}}">▼Thứ tự ngẫu nhiên</a>&nbsp;
                            <a href="{{preg_replace('/sort=[^&]+(&|$)/','', $results["path"]) . "&sort=new"}}">▼Từ công việc mới nhất</a>&nbsp;
                            <a href="{{preg_replace('/sort=[^&]+(&|$)/','', $results["path"]) . "&sort=end"}}">▼Theo thời gian kết thúc</a>

                        </p>
                    </div>
                </div>
            @endif
        @endif
        <div class="list-job">
            @foreach($results["data"] as $job)
                @php ($mark = rand(1, 3))
                <div class="job-view">
                    <div class="list_title">
                        <h2><a href="/job/{{$job->id}}">{{$job->description}}</a></h2>
                        <div class="detail_item"><a href="/job/{{$job->id}}">Chi tiết</a></div>
                    </div>
                    <div class="__description">
                        <div class="salary">{{$job->salary}}</div>
                        <div class="company">&nbsp;</div>
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
                                    <th>Điều kiện ứng tuyển</th>
                                    <td>{{$job->application_condition}}</td>
                                </tr>
                                <tr>
                                    <th>Thời gian ứng tuyển</th>
                                    <td>{{$job->post_start_date}} - {{$job->post_end_date}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="relation">
                            <div>Các công việc liên quan</div>
                            <ul>
                                @foreach($job->prefectures as $prefecture)
                                    <li class="item"><a
                                                href="{{route('search', $region->key)}}?prefecture_id={{$prefecture->id}}">{{ $prefecture->name }}
                                            Việc làm</a></li>
                                @endforeach
                                @foreach($job->salaries as $salary)
                                    <li class="item"><a
                                                href="{{route('search', $region->key)}}?salary_id={{$salary->id}}">{{ $salary->description }}
                                            Việc làm</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="clear"></div>
                        <div class="blur-mask mark-{{$mark}}">
                            <a class="button-outer" href="{{ url('login') }}">
                                <div class="signup-button">
                                    Hãy đăng nhập để xem chi tiết công việc
                                </div>
                              </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        @if($results["total"] > 0)
            @if(preg_match("/job\z$/", $results["path"]))
                <div class="control">
                    <div class="pagination">
                        <p>
                            @if($results["floor"] < 2)
                                <span class="disable">&lt;&lt;10 trang trước</span>
                            @else
                                <span class="active"><a
                                            href="{{$results["path"] . "?page=" . $results["current_page"] . "&floor=on"}}">&lt;&lt;10 trang trước</a></span>
                            @endif
                            @for($i = $results["floor"]; $i <= $results["ceil"]; $i++)
                                <span class="{{$results["current_page"] == $i ? 'active' : 'disable'}}"><a
                                            href="{{$results["path"] ."?page=" . $i}}">[<span
                                                class="per-page">{{$i}}</span>]</a></span>
                            @endfor
                            @if($results["last_page"] == $results["ceil"])
                                <span class="disable">10 trang sau&gt;&gt;</span>
                            @else
                                <span class="active"><a
                                            href="{{$results["path"] ."?page=" . $results["current_page"] . "&ceil=on"}}">10 trang sau&gt;&gt;</a></span>
                            @endif
                        </p>
                        <div class="choose-page-item">
                            <div id="select-item">
                                <label for="item_page" class="label-item-page">Số lượng hiển thị</label>
                                <select name="item_page" id="item_page" class="select-item-page" v-model="limit">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="control">
                    <div class="pagination">
                        <p>
                            @if($results["floor"] < 2)
                                <span class="disable">&lt;&lt;10 trang trước</span>
                            @else
                                <span class="active"><a
                                            href="{{$results["path"] . "&page=" . $results["current_page"] . "&floor=on"}}">&lt;&lt;10 trang trước</a></span>
                            @endif
                            @for($i = $results["floor"]; $i <= $results["ceil"]; $i++)
                                <span class="{{$results["current_page"] == $i ? 'active' : 'disable'}}"><a
                                            href="{{$results["path"] ."&page=" . $i}}">[<span
                                                class="per-page">{{$i}}</span>]</a></span>
                            @endfor
                            @if($results["last_page"] == $results["ceil"])
                                <span class="disable">10 trang sau&gt;&gt;</span>
                            @else
                                <span class="active"><a
                                            href="{{$results["path"] ."&page=" . $results["current_page"] . "&ceil=on"}}">10 trang sau&gt;&gt;</a></span>
                            @endif
                        </p>
                        <div class="choose-page-item">
                            <div id="select-item">
                                <label for="item_page" class="label-item-page">Số lượng hiển thị</label>
                                <select name="item_page" id="item_page" class="select-item-page" v-model="limit">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        @if(preg_match("/" . $region->key .'\/job(\?)?\z$/', Request::fullUrl()))
            @include('app.common.breadcrumbs', ['crumbs' => collect([
                ['url' => route("home", $region->key), 'name' => $configs["site_name"]],
                ['url' => 'javascript:void(0)', 'name' => $region->name . 'Danh sách công việc']
            ])])
        @endif
    </div>
@endsection
