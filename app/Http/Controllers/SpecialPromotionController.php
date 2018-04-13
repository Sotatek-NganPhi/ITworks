<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Services\SpecialJobService;

class SpecialPromotionController extends AppBaseController
{
    protected $specialService;

    public function __construct(SpecialJobService $specialService)
    {
        $this->specialService = $specialService;
    }

    public function show($id)
    {
        try {
            $results = $this->specialService->getElementSpecial($id);
            return view('app.about_special', ["results" => $results, "special_promotion_id" => $id]);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
