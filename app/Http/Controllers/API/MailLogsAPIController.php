<?php

namespace App\Http\Controllers\API;

use App\Consts;
use App\Http\Requests\API\CreateCampaignAPIRequest;
use App\Http\Requests\API\UpdateCampaignAPIRequest;
use App\Models\MailLogs;
use App\Repositories\MailLogsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Log;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Repositories\Criteria\BaseCriteria;
use Response;

class MailLogsAPIController extends AppBaseController
{
    private $mailLogsRepository;

    public function __construct(MailLogsRepository $mailLogsRepo)
    {
        $this->mailLogsRepository = $mailLogsRepo;
    }

    public function index(Request $request)
    {
      
        $this->mailLogsRepository->pushCriteria(new BaseCriteria($request));
        $this->mailLogsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $mailLogs = $this->mailLogsRepository->paginate($request->input('limit'));

        return $this->sendResponse($mailLogs->toArray(), trans('message.retrieve'));
    }

    public function store(CreateMailLogsAPIRequest $request)
    {
        $input = $request->all();

        $mailLogs = $this->mailLogsRepository->create($input);

        return $this->sendResponse($mailLogs->toArray(), trans('message.save'));
    }


    public function showmail($id)
    {
        $mailLogs = $this->mailLogsRepository->findWithoutFail($id);
        if (empty($mailLogs)) {
            return $this->sendError(trans('message.unfound'));
        }

        return $this->sendResponse($mailLogs->toArray(), trans('message.retrieve'));
    }


    public function update($id, UpdateMailLogsAPIRequest $request)
    {
        $input = $request->all();

        $mailLogs = $this->mailLogsRepository->findWithoutFail($id);

        if (empty($mailLogs)) {
            return $this->sendError(trans('message.unfound'));
        }

        $mailLogs = $this->mailLogsRepository->update($input, $id);

        return $this->sendResponse($mailLogs->toArray(), trans('message.update'));
    }

    public function destroy($id)
    {
        $mailLogs = $this->mailLogsRepository->findWithoutFail($id);

        if (empty($mailLogs)) {
            return $this->sendError(trans('message.unfound'));
        }

        $mailLogs->delete();

        return $this->sendResponse($id, trans('message.deletable'));
    }

    public function downloadCsv(Request $request)
    {
        $this->mailLogsRepository->pushCriteria(new BaseCriteria($request));
        $this->mailLogsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $mailLogs = $this->mailLogsRepository->all();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $headers = \Schema::getColumnListing('mail_logs');
        $csv->insertOne($headers);

        foreach ($mailLogs as $log) {
            $row = $log->toArray();
            $csv->insertOne($row);
        }

        $csv->output('mail_logs.csv');
    }
}
