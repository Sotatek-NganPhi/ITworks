<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Http\Services\MasterdataService;
use Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        $res = [
            'success'       => true,
            'message'       => $message,
            'dataVersion'   => MasterdataService::getDataVersion(),
            'data'          => $result,
        ];

        return Response::json($res);
    }

    public function sendError($error, $code = 404)
    {
        $res = [
            'success' => false,
            'message' => $error,
        ];

        return Response::json($res, $code);
    }
}
