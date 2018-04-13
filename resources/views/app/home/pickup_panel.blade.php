@if(count($pickups))
    <div class="__selection_area">
        <div class="kakko bolder">
            <h3>注目のお仕事特集</h3>
        </div>
        <p class="title"><span>PICK UP</span></p>
    </div>
    @foreach($pickups as $pick)
        <div class="recommendation_item">
            <a href="{{$pick['link']}}">
                <img src="{{$pick['image']}}" height="195" width="330">
                <h4>{{$pick['title']}}</h4>
                <p class="description">
                    <span>{{ $pick['description'] }}</span>
                </p>
            </a>
        </div>
    @endforeach
@endif
