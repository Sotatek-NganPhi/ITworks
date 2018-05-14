<?php

namespace App\Http\Controllers\Manage;

use App\Consts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    protected $guard = "manager";

    public function index(Request $request)
    {
        $typeManager = $request->user($this->guard)->type;
        switch ($typeManager) {
            case Consts::TYPE_SYS_ADMIN:
                $view = 'manage/admin/index';
                break;
            case Consts::TYPE_COMPANY_ADMIN:
                $view = 'manage/company/index';
                break;
            default:
                Auth::guard($this->guard)->logout();
                return redirect()->to('manage/login');
        }
        return view($view);
    }
}
