@if(Auth::check())
    <div class="logout">
        <div class="user-panel">
            <h4>Xin chào、{{Auth::user()->first_name}}！</h4>
            <p class="__btn btn_member_home"><a href="{{ route('member_home') }}">Thông tin cá nhân</a></p>
        </div>
         <p class="__btn btn_logout"><a href="{{route('logout')}}">Đăng xuất</a></p>
    </div>
@else
    <div class="user-panel">
        <h4>Nếu bạn chưa là thành viên</h4>
        <br>
        <p class="__btn"><a href="{{ route('register') }}">Đăng ký thành viên</a></p>
        <h4>Nếu bạn đã là thành viên</h4>
        <br>
        <p class="__btn"><a href="{{route('login')}}">Đăng nhập</a></p>
    </div>
@endif
