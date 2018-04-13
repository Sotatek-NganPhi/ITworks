@if(count($expos))
    <div class="__selection_area">
        <div class="kakko">
            <h3>説明会情報</h3>
        </div>
        <p class="title"><span>Event</span></p>
    </div>
    <div class="list-expo">
        <ul>
            @forelse ($expos as $expo)
                <li>
                    <span>{{ date_format(new DateTime($expo->date), 'Y/m/d') }}</span>
                    <a href="/expo/{{$expo->id}}/regist">
                            {{ str_limit($expo['presentation_name'], 59) }}
                    </a>
                </li>
            @empty
            @endforelse
        </ul>
    </div>
@endif
