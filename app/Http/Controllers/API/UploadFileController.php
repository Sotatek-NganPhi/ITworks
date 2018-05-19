<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends AppBaseController
{
    public function uploadFile(Request $request)
    {
        $file = $request->file;
        if (is_file($file)) {
            $res = [];
            $fileName = str_replace(".", "", microtime(true)) . '.' . $file->getClientOriginalExtension();
            if (isset($request->type) && $request->type == 'temporary') {
                Storage::disk('temporary')->put($fileName, File::get($file));
                $res["path"] = Storage::disk('temporary')->url($fileName);
            } else {
                Storage::disk('public')->put($fileName, File::get($file));
                $res["path"] = Storage::disk('public')->url($fileName);
            }
            return $this->sendResponse($res,  trans('message.upload_file'));
        }
        return $this->sendError( trans('message.params_not_file'));
    }
}
