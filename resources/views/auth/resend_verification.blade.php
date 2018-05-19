<?php
    $user = \App\User::where('email', old('email'))->first();
?>
@if ($user)
    <li>
        <a href="{{ route('resend_verification', $user->id) }}" style="color: #a94442">@lang('auth.register.resend_verification')</a>
    </li>
@endif