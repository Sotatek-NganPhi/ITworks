<div id="mypage">
    <ul>
        <li><a href="{{route('member_home')}}">MY PAGE TOP</a></li>
        <li><a href="{{route('profile.edit')}}">基本情報の確認・修正</a></li>
        <li><a href="{{route('candidate.edit')}}">詳細情報の確認・修正</a></li>
        <li><a href="{{route('member_clip_list')}}">クリップ情報</a></li>
        <li><a href="{{route('resume_register')}}">WEB履歴書の確認</a></li>
        <li><a href="{{route('member_application_list')}}">応募履歴管理</a></li>
        <li><a href="{{route('mail_inbox')}}">メールボックス</a></li>
        <li><a href="{{route('member_leave_confirm')}}">退会する</a></li>
    </ul>
    <div class="logout"><a href="{{route('logout')}}" title="ログアウト">≫ログアウト</a></div>
</div>