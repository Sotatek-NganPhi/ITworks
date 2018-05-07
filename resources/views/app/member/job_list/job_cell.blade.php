<div class="list_title">
    <h2><a href="/job/{{$job->id}}">{{$job->description}}</a></h2>
    <div class="detail"><a href="/job/{{$job->id}}">Chi tiết</a></div>
</div>
<div class="__description">
    <div class="salary">{{$job->salary}}</div>
    <div class="company">&nbsp;</div>
</div>
<div class="copy">
    <h3>{{$job->company_name}}</h3>
</div>
<div class="spec">
    <table border="0" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <th>Điều kiện ứng tuyển</th>
            <td>{{$job->application_condition}}</td>
        </tr>
        <tr>
            <th>Thời gian nhận hồ sơ</th>
            <td>{{$job->post_start_date}} - {{$job->post_end_date}}</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="clear-both"></div>