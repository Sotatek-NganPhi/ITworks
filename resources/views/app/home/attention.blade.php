@if(count($attentionJobs))
    <div class="__selection_area">
        <div class="kakko">
            <h3>Các công việc được gợi ý</h3>
        </div>
        <p class="title"><span>RECOMMENDATION</span></p>
    </div>
    @foreach($attentionJobs as $job)
        <div class="recommendation_item height_min">
            <a href="/job/{{$job->id}}">
                <img src="{{$job->main_image}}" height="195" width="330">
                <p class="description text-left">
                    <span>{{ mb_strlen($job->description, 'UTF-8') > 74 ?
                    mb_strcut($job->description, 0, 71, 'UTF-8') . '...' : $job->description }}</span>
                </p>
            </a>
        </div>
    @endforeach
    <div class="button_wrap">
        <a href="job?sort=hot" class="button"><p>Xem thêm</p></a>
    </div>
@endif