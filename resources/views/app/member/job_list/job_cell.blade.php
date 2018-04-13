<div class="list_title">
    <h2><a href="/job/{{$job->id}}">{{$job->description}}</a></h2>
    <div class="detail"><a href="/job/{{$job->id}}">詳細</a></div>
</div>
<div class="__description">
    <div class="salary">{{$job->salary}}</div>
    <div class="company">&nbsp;</div>
</div>
<div class="copy">
    <h3>{{$job->company_name}}</h3>
</div>
<div class="main-photo">
    <a href="{{route("job_detail", ["id" => $job->id])}}"><img src="{{$job->main_image}}"
                                                               alt="{{$job->main_caption}}"></a>
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
            <a href="{{route("job_detail", ["id" => $job->id])}}"><img src="{{$job->sub_image1}}"
                                                                       alt="{{$job->sub_caption1}}"></a>
        @endif
        @if(isset($job->sub_image2))
            <a href="{{route("job_detail", ["id" => $job->id])}}"><img src="{{$job->sub_image2}}"
                                                                       alt="{{$job->sub_caption2}}"></a>
        @endif
        @if(isset($job->sub_image3))
            <a href="{{route("job_detail", ["id" => $job->id])}}"><img src="{{$job->sub_image3}}"
                                                                       alt="{{$job->sub_caption3}}"></a>
        @endif
    </div>
</div>
<div class="clear-both"></div>