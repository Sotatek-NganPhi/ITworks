<div id="mypage">
    <ul>
        <li><a href="{{route('member_home')}}">MY PAGE TOP</a></li>
        <li><a href="{{route('profile.edit')}}">Thông tin cá nhân</a></li>
        <li><a href="{{route('candidate.edit')}}">Hồ sơ cá nhân</a></li>
        <li><a href="{{route('member_clip_list')}}">Công việc đã lưu</a></li>
    </ul>
    <div class="logout"><a href="{{route('logout')}}" title="Đăng xuất">≫Đăng xuất</a></div>
</div>