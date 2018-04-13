<div class="__selection_area">
    <div class="kakko">
        <h3>簡単検索</h3>
    </div>
    <p class="title"><span></span></p>
</div>
<h4>こだわりのメリットでカンタン検索。希望の条件をクリックして下さい。</h4>
<div class="search_new">
    <ul>
        <li>
            <a href="javascript:void(0)">
                <span>new | </span>
                <span class="num_new num_new_y">{{$today->year}}</span>年<span class="num_new num_new_m">{{$today->month}}</span>月<span
                        class="num_new num_new_d">{{$today->day}}</span>日更新
                <span style="width:1em; display:inline" class="search_new_space">新着情報</span><span
                        class="num_new num_new_n">{{$totalJobNew}}</span>件
            </a>
        </li>
    </ul>
</div>

@foreach($jobCounts as $key => $criterias)
<div class="search-body">
    <h5>{{ $key }}</h5>
    @foreach($criterias as $criteria)
    <ul>
        <li><a href="{{$criteria['link']}}">{{$criteria['name']}}({{$criteria['jobCount']}})</a></li>
    </ul>
    @endforeach
</div>
@endforeach
