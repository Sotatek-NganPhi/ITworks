<?php

namespace App\Http\Controllers\API;

use App\Consts;
use App\Http\Requests\API\CreateMessageAPIRequest;
use App\Http\Requests\API\UpdateMessageAPIRequest;
use App\Mail\ReminderMail;
use App\Manager;
use App\Models\Applicant;
use App\Models\Message;
use App\Repositories\Criteria\BaseCriteria;
use App\Repositories\MessageRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Mail;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Response;
use Auth;

/**
 * Class MessageController
 * @package App\Http\Controllers\API
 */

class MessageAPIController extends AppBaseController
{
    /** @var  MessageRepository */
    private $messageRepository;

    public function __construct(MessageRepository $messageRepo)
    {
        $this->messageRepository = $messageRepo;
    }

    /**
     * Display a listing of the Message.
     * GET|HEAD /messages
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->messageRepository->pushCriteria(new BaseCriteria($request));
        $this->messageRepository->pushCriteria(new LimitOffsetCriteria($request));
        $messages = $this->messageRepository->paginate($request->input('limit'));

        return $this->sendResponse($messages->toArray(), trans('message.retrieve'));
    }

    /**
     * Store a newly created Message in storage.
     * POST /messages
     *
     * @param CreateMessageAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMessageAPIRequest $request)
    {
        $input = $request->all();
        $input['manager_id'] = Auth::guard('manager')->id();

        $message = $this->messageRepository->create($input);

        $this->sendReminderMail($message);

        return $this->sendResponse($message->toArray(), trans('message.save'));
    }

    /**
     * Display the specified Message.
     * GET|HEAD /messages/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Message $message */
        $message = $this->messageRepository->findWithoutFail($id);

        if (empty($message)) {
            return $this->sendError(trans('message.unfound'));
        }

        return $this->sendResponse($message->toArray(), trans('message.retireve'));
    }

    /**
     * Update the specified Message in storage.
     * PUT/PATCH /messages/{id}
     *
     * @param  int $id
     * @param UpdateMessageAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMessageAPIRequest $request)
    {
        $input = $request->all();

        /** @var Message $message */
        $message = $this->messageRepository->findWithoutFail($id);

        if (empty($message)) {
            return $this->sendError(trans('message.unfound'));
        }

        $message = $this->messageRepository->update($input, $id);

        return $this->sendResponse($message->toArray(), trans('message.update'));
    }

    /**
     * Remove the specified Message from storage.
     * DELETE /messages/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Message $message */
        $message = $this->messageRepository->findWithoutFail($id);

        if (empty($message)) {
            return $this->sendError(trans('message.unfound'));
        }

        $message->delete();

        return $this->sendResponse($id, trans('message.deletable'));
    }

    public function getConversations(Request $request)
    {
        $query = Message::selectRaw('messages.id as message_id,
            messages.title, messages.content, messages.created_at, applicants.id as applicant_id,
            users.name as user_name, companies.name as company_name, messages.from')
            ->whereRaw('messages.id = (SELECT MAX(id) from `messages` m2 where messages.`applicant_id` = m2.`applicant_id`)')
            ->join('users', 'users.id', 'messages.user_id')
            ->join('applicants', 'applicants.id', 'messages.applicant_id')
            ->join('jobs', 'jobs.id', 'applicants.job_id')
            ->join('companies', 'companies.id', 'jobs.company_id')
            ->orderBy('messages.id', 'desc');
        if($request->has('search')) {
            $freeWord = explode("\\:", $request->input('search'))[1];
            $query = $query->where(function ($query) use ($freeWord) {
                $query->where('messages.title', 'like', "%{$freeWord}%")
                    ->orWhere('messages.content', 'like', "%{$freeWord}%")
                    ->orWhere('companies.name', 'like', "%{$freeWord}%")
                    ->orWhere('users.name', 'like', "%{$freeWord}%");
            });
        }
        $conversations = $query->paginate(Consts::LIMIT_PER_PAGE);
        return $this->sendResponse($conversations, 'Conversations retrieved successfully');
    }

    public function getConversation($applicantId)
    {
        Message::where('applicant_id', $applicantId)
            ->where('is_read', Consts::UN_READ)->update([
                'is_read' => Consts::IS_READ
            ]);
        $messages = Message::selectRaw('messages.id as message_id,
            messages.title, messages.content,
            messages.created_at, applicants.id as applicant_id, 
            users.name as user_name, companies.name as company_name, messages.from')
            ->where('applicant_id', $applicantId)
            ->join('users', 'users.id', 'messages.user_id')
            ->join('applicants', 'applicants.id', 'messages.applicant_id')
            ->join('jobs', 'jobs.id', 'applicants.job_id')
            ->join('companies', 'companies.id', 'jobs.company_id')
            ->orderBy('messages.id')->get();
        return $this->sendResponse($messages, trans('message.retrieve'));
    }

    public function sendMessage($applicantId, Request $request)
    {
        $applicant = Applicant::find($applicantId);

        if(is_null($applicantId)) {
            return $this->sendError(null, trans('message.unfound'));
        }
        $originMessage = Message::where('applicant_id', $applicantId)->first();
        $message = Message::create([
            'applicant_id' => $applicantId,
            'title' => $originMessage->title,
            'manager_id' => $originMessage->manager_id,
            'user_id' => $applicant->user_id,
            'is_favorite' => $originMessage->is_favorite,
            'is_read' => Consts::IS_READ,
            'content' => $request->message,
            'from' => 'user'
        ]);

        $this->sendReminderMail($message);

        return $this->getConversation($applicantId);
    }

    public function sendReminderMail(Message $message)
    {
        if ($message->from === 'user') {
            $manager = Manager::find($message->manager_id);
            if(is_null($manager)) {
                return;
            }
            Mail::to($manager)->queue(new ReminderMail($manager, $message));
        } else {
            $user = User::find($message->user_id);
            if(is_null($user)) {
                return;
            }
            Mail::to($user)->queue(new ReminderMail($user, $message));
        }
    }
}
