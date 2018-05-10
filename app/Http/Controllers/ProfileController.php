<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileController extends AppBaseController
{
    public function edit(Request $request)
    {
        $user = Auth::user();
        $request->merge($user->toArray());
        $request->flash();

        return view('profile.form')->with(['formAction' => 'profile.update']);
    }

    public function update(UpdateUserRequest $request)
    {
        DB::beginTransaction();
        try{
            $inputs = $request->all();
            $user = $request->user();
            $user->name = join(' ', [$inputs['first_name'], $inputs['last_name']]);
            if(!is_null($inputs["password"])) {
                $user->password = bcrypt($inputs["password"]);
            }
            $user->first_name = $inputs["first_name"];
            $user->last_name = $inputs["last_name"];
            $user->address = $inputs["address"];
            $user->phone_number = $inputs["phone_number"];
            $user->gender = $inputs["gender"];
            $user->birthday =  $inputs["birthday"];
            $user->mail_receivable = $inputs["mail_receivable"];
            $user->save();
            DB::commit();
            $request->session()->flash('messages', trans('message.update_success'));
        }catch (Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
        }
        return redirect(route('profile.edit'));
    }
}
