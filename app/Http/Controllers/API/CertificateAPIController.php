<?php

namespace App\Http\Controllers\API;

use App\Models\Certificate;
use App\Models\CertificateGroup;
use App\Models\CandidateCertificate;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CertificateRepository;
use App\Repositories\CertificateAPIRepository;
use App\Http\Services\MasterdataService;
use App\Http\Requests\API\CreateCertificateAPIRequest;
use App\Http\Requests\API\UpdateCertificateAPIRequest;
use Illuminate\Http\Request;
use App\Consts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CertificateAPIController extends AppBaseController
{
    /** @var  CertificateRepository */
    private $certificateRepository;

    public function __construct(CertificateRepository $certificateRepo)
    {
        $this->certificateRepository = $certificateRepo;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $certificate = $this->certificateRepository->findWithoutFail($id);

        if (empty($certificate)) {
            return $this->sendError(trans('message.unfound'));
        }

        return $this->sendResponse($certificate->toArray(), trans('message.retrieve'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateCertificateAPIRequest $request)
    {
        $input = $request->all();
        
        /** @var Certificate $certificate */
        $certificate = $this->certificateRepository->findWithoutFail($id);

        if (empty($certificate)) {
            return $this->sendError(trans('message.unfound'));
        }

        $certificate = $this->certificateRepository->update($input, $id);

        $result = $certificate->toArray();

        return $this->sendResponse($result, trans('message.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidateCertificate = CandidateCertificate::where('certificate_id', $id)->first();
        if(!isset($candidateCertificate)) {
            $certificate = $this->certificateRepository->findWithoutFail($id);

            if (empty($certificate)) {
                return $this->sendError(trans('message.unfound'));
            }

            $certificate->delete();

            return $this->sendResponse($id, trans('message.deletable'));
        } else {
            return $this->sendError(trans('message.in_use'));
        }
    }

    public function searchCertificate (Request $request)
    {
        $params = $request->all();
        $certificateGroups = CertificateGroup::select('*');
        $certificates = Certificate::select('*');

        if ($request->has('group_id')) {
            $certificateGroups = $certificateGroups->where('id', $request->input('group_id'));
            $certificates = $certificates->where('certificate_group_id', $request->input('group_id'));
        }

        if ($request->has('certificate_name')) {
            $certificates = $certificates->where('name', 'like', '%' . $request->input('certificate_name') . '%')->get();
            $certificateGroups = $certificateGroups->whereIn('id', $certificates->pluck('certificate_group_id'))->paginate($request->input('limit'));
        } else {
            $certificateGroups = $certificateGroups->paginate($request->input('limit'));
            $certificates = $certificates->whereIn('certificate_group_id', $certificateGroups->pluck('id'))->get();
        }
        return $this->sendResponse(['certificates' => $certificates, 'certificate_groups' => $certificateGroups], 'Get certificate successfully');
    }
}
