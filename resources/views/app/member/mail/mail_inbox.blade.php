@extends('app.member.mail.mail')

@section('mail_content')
    <div class="list-msg">
        @foreach($mailInbox as $mail)
            <div class="row">
                @php(\Carbon\Carbon::setLocale('ja'))
                @php ($createdAt = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $mail->created_at))
                <div class="msg-title {{ !intval($mail->is_read) ? 'is-read' : '' }}">
                    <div class="link" title="{{ $mail->title }}">
                        <a href="{{ route('mail_box', array($mail->applicant_id)) }}">
                            @if($mail->from === 'user')
                                <div class="name">{{ $mail->user->name }}</div>
                            @else
                                <div class="name">{{ $mail->applicant->jobs->company->name }}</div>
                            @endif
                                <div class="title"> <label class="main-title">{{ $mail->title }}</label> <label class="hidden-xs">- </label> <label class="content">{{ $mail->content }}</label></div>
                        </a>
                    </div>
                </div>
                <div class="last-update">
                    <span>{{\Carbon\Carbon::now()->diffForHumans($createdAt)}}</span>
                </div>
            </div>
        @endforeach
        <div class="text-center">
            {!! $mailInbox->render() !!}
        </div>
    </div>
@endsection