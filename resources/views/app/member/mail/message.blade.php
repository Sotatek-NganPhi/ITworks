@extends('app.member.mail.mail')

@section('vue-js')
    <script>
      function favorite() {
        var applicantId = $("input[name='applicant_id']").val();

        if (!applicantId) {
          return;
        }
        $.ajax({
          url: "/member/conversation/favorite/" + applicantId,
          method: 'POST',
          data: {
            _token: $("input[name='_token']").val(),
          },
          success: function () {
            if ($('#star-favorite').hasClass("favorite")) {
              $('#star-favorite').removeClass('favorite');
              $('#star-favorite').addClass('un-favorite');
            } else {
              $('#star-favorite').removeClass('un-favorite');
              $('#star-favorite').addClass('favorite');
            }
          }
        });
      }
    </script>
@endsection

@section('mail_content')
    <div class="msg-a-t">
        <input name="_token" hidden value="{{ csrf_token() }}">
        <input name="applicant_id" hidden value="{{ $messages->first()->applicant_id }}">
        <strong>{{ $messages->first()->title }}</strong>
        <span id="star-favorite"
              class="star {{$messages->first()->is_favorite == \App\Consts::IS_FAVORITE ? 'favorite' : 'un-favorite'}}"
              onclick="favorite()">★</span>
    </div>
    @foreach($messages as $message)
        <div class="message">
            <div class="msg-header">
                <div class="msg-author">
                    <div class="name">
                        @if($message->from === 'user')
                            {{ $message->user->name }}
                        @else
                            {{ $message->applicant->jobs->company->name }}
                        @endif
                    </div>
                    <div class="time">
                        @php($createdAt = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $message->created_at))
                            @php(\Carbon\Carbon::setLocale('ja'))
                                <span>{{\Carbon\Carbon::now()->diffForHumans($createdAt)}}</span>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="msg-content">
                {!!  $message->content !!}
            </div>
        </div>
    @endforeach
    <div class="quick-reply">
        <form action="{{ route('reply_message') }}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="applicantId" value="{{ $messages->first()->applicant_id }}">
            <div class="form-group">
                <label for="content">Message</label>
                <textarea class="form-control" name="content" id="content" rows="5"></textarea>
            </div>
            <div class="form-group gr-btn">
                <button type="submit" class="btn">Reply</button>
            </div>
        </form>
    </div>
@endsection