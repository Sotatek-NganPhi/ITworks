@if(count($specialPromotions))
    <div id="special">
        <div class="__selection_area">
            <div class="kakko">
                <h3>特集</h3>
            </div>
            <p class="title"><span>Special</span></p>
        </div>
        @foreach ($specialPromotions as $spec)
            <h4 class="show-img-spec">
                <a href="{{ url('/about/special/' . $spec['id']) }}">
                    <img src="{{$spec['image']}}" alt="{{$spec['name']}}" height="167" width="750">
                    <div class="special_wrap">
                        <h4>{{$spec['name']}}</h4>
                    </div>
                </a>
            </h4>
        @endforeach
    </div>
@endif