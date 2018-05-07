@if(count($urgentJobs))
    <div class="__selection_area">
        <div class="kakko">
            <h3>Thông tin việc làm nổi bật</h3>
        </div>
        <p class="title"><span>CONSCRIPTION</span></p>
    </div>
    <ul>
        @forelse ($urgentJobs as $job)
            <li>
                <span class="time">{{ date_format(new DateTime($job->created_at), 'Y/m/d') }}</span>
                <a href="/job/{{$job->id}}" class="title">
                    <span>{{ mb_strlen($job->description, 'UTF-8') > 60
                    ? mb_strcut($job->description, 0, 56, 'UTF-8') . '...' : $job->description }}</span>
                </a>
            </li>
        @empty
        @endforelse
    </ul>
@endif