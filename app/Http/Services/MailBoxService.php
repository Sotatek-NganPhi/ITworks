<?php

namespace App\Http\Services;

use App\Consts;
use App\Models\Applicant;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MailBoxService
{
    public function getAllMailInbox()
    {
        $userId = Auth::user()->id;
        $mailInbox = Message::where('messages.user_id', $userId)
            ->select('*')
            ->whereRaw('id = (SELECT MAX(id) from `messages` m2 where messages.`applicant_id` = m2.`applicant_id`)')
            ->orderBy('messages.id', 'desc')->paginate(Consts::LIMIT_PER_PAGE);
        return $mailInbox;
    }

    public function getAllMessage($applicantId)
    {
        $userId = Auth::user()->id;
        Message::where('user_id', Auth::id())
            ->where('applicant_id', $applicantId)
            ->where('is_read', Consts::UN_READ)->update([
                'is_read' => Consts::IS_READ
            ]);
        $messages = Message::where('user_id', $userId)->where('applicant_id', $applicantId)->orderBy('messages.id')->get();
        return $messages;
    }

    public function getMailInboxUnread()
    {
        $userId = Auth::user()->id;
        $mailInbox = Message::join(DB::raw('(select distinct applicant_id from messages where is_read =' . Consts::UN_READ . ' and user_id =' . $userId . ') as topics'),
            function ($join) {
                $join->on('messages.applicant_id', '=', 'topics.applicant_id');
            })
            ->select('*')
            ->whereRaw('id = (SELECT MAX(id) from `messages` m2 where messages.`applicant_id` = m2.`applicant_id`)')
            ->orderBy('messages.id', 'desc')->paginate(Consts::LIMIT_PER_PAGE);
        return $mailInbox;
    }

    public function getMailInboxFavorite()
    {
        $userId = Auth::user()->id;
        $mailInbox = Message::join(DB::raw('(select distinct applicant_id from messages where is_favorite =' . Consts::IS_FAVORITE . ' and user_id =' . $userId . ') as topics'),
            function ($join) {
                $join->on('messages.applicant_id', '=', 'topics.applicant_id');
            })
            ->select('*')
            ->whereRaw('id = (SELECT MAX(id) from `messages` m2 where messages.`applicant_id` = m2.`applicant_id`)')
            ->orderBy('messages.id', 'desc')->paginate(Consts::LIMIT_PER_PAGE);
        return $mailInbox;
    }

    public function getMailOtboxFavorite()
    {
        $userId = Auth::user()->id;
        $mailInbox = Message::join(DB::raw('(select distinct applicant_id from messages where is_favorite =' . Consts::IS_FAVORITE . ' and `from` = "user" and user_id =' . $userId . ') as topics'),
            function ($join) {
                $join->on('messages.applicant_id', '=', 'topics.applicant_id');
            })
            ->select('*')
            ->whereRaw('id = (SELECT MAX(id) from `messages` m2 where messages.`applicant_id` = m2.`applicant_id`)')
            ->orderBy('messages.id', 'desc')->paginate(Consts::LIMIT_PER_PAGE);
        return $mailInbox;
    }

    public function getAllMailOutbox()
    {
        $userId = Auth::user()->id;
        $mailInbox = Message::join(DB::raw('(select distinct applicant_id from messages where `from` = "user" and user_id =' . $userId . ') as topics'),
            function ($join) {
                $join->on('messages.applicant_id', '=', 'topics.applicant_id');
            })
            ->select('*')
            ->whereRaw('id = (SELECT MAX(id) from `messages` m2 where messages.`applicant_id` = m2.`applicant_id`)')
            ->orderBy('messages.id', 'desc')->paginate(Consts::LIMIT_PER_PAGE);
        return $mailInbox;
    }

    public function replyMessage($params)
    {
        $userId = Auth::user()->id;
        $applicantId = $params['applicantId'];
        $content = $params['content'];
        $message = Message::where('user_id', $userId)->where('applicant_id', $applicantId)->orderBy('messages.id', 'desc')->first();
        Message::create([
            'applicant_id' => $applicantId,
            'title' => $message->title,
            'manager_id' => $message->manager_id,
            'user_id' => $userId,
            'is_favorite' => $message->is_favorite,
            'is_read' => Consts::IS_READ,
            'content' => $content,
            'from' => 'user'
        ]);
    }

    public function favoriteConversation($applicantId)
    {
        $applicant = Applicant::find($applicantId);
        if (is_null($applicant)) {
            return;
        }
        $isFavorite = Message::where('user_id', Auth::id())
            ->where('applicant_id', $applicantId)->value('is_favorite');

        Message::where('user_id', Auth::id())
            ->where('applicant_id', $applicantId)
            ->update([
                'is_favorite' => $isFavorite == Consts::IS_FAVORITE ? Consts::UN_FAVORITE : Consts::IS_FAVORITE
            ]);
    }
}
