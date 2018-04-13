<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Services\MailBoxService;
use Log;
use Exception;
use DB;

class MailBoxController extends AppBaseController
{
    protected $mailBoxService;

    public function __construct(MailBoxService $mailBoxService)
    {
        $this->mailBoxService = $mailBoxService;
    }

    public function showMailInbox()
    {
        $mailInbox = $this->mailBoxService->getAllMailInbox();
        return view('app.member.mail.mail_inbox', [
            'mailInbox' => $mailInbox,
            'isInbox' => true
        ]);
    }

    public function showMailBox($applicantId)
    {
        DB::beginTransaction();
        try {
            $messages = $this->mailBoxService->getAllMessage($applicantId);
            DB::commit();
            return view('app.member.mail.message', [
                'messages' => $messages,
                'isInbox' => true
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }

    public function favoriteConversation($applicantId)
    {
        DB::beginTransaction();
        try {
            $this->mailBoxService->favoriteConversation($applicantId);
            DB::commit();
            return response()->json([
                'status' => 1,
                'message' => 'Favorite Conversation successfully',
                'data' => null
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }

    public function showMailInboxUnread()
    {
        $mailInbox = $this->mailBoxService->getMailInboxUnread();
        return view('app.member.mail.mail_inbox', [
            'mailInbox' => $mailInbox,
            'isInbox' => true
        ]);
    }

    public function showMailInboxFavorite()
    {
        $mailInbox = $this->mailBoxService->getMailInboxFavorite();
        return view('app.member.mail.mail_inbox', [
            'mailInbox' => $mailInbox,
            'isInbox' => true
        ]);
    }

    public function showMailOtboxFavorite()
    {
        $mailInbox = $this->mailBoxService->getMailOtboxFavorite();
        return view('app.member.mail.mail_inbox', [
            'mailInbox' => $mailInbox,
            'isInbox' => false
        ]);
    }

    public function showMailOutbox()
    {
        $mailInbox = $this->mailBoxService->getAllMailOutbox();
        return view('app.member.mail.mail_inbox', [
            'mailInbox' => $mailInbox,
            'isInbox' => false
        ]);
    }

    public function replyMessage(Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            $messages = $this->mailBoxService->replyMessage($params);
            DB::commit();
            return redirect()->route('mail_box', array($params['applicantId']));
        } catch (Exception $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }
}
