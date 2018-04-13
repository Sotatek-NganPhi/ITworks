<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Expo;
use App\Models\Config;
use App\Models\CurrentSituation;
use Illuminate\Support\Facades\Validator;

class ExpoController extends Controller
{
    public function getLayout(Request $request)
    {
        $expoId = $request->route('id');
        $expo = Expo::findOrFail($expoId);
        $currentSitation = CurrentSituation::all();
        return view('app.register_expo', [
            'expo' => $expo,
            'currentSitation' => $currentSitation
            ]);
    }

    public function veryRegister(Request $request) {
        $this->validator($request->all())->validate();
        $expoId = $request->route('id');
        $expo = Expo::findOrFail($expoId);
        $fullName = $request['surname'] . ' ' . $request['name'];
        $fullNamePhonetic = $request['surname_phonetic'] . ' ' . $request['name_phonetic'];
        $currentSitation = CurrentSituation::findOneById($request['current_situation_id']);
        return response()->view('app.register_expo_very', [
            'expo' => $expo,
            'result' => [
                'surname'              => $request['surname'],
                'name'                 => $request['name'],
                'full_name'            => $fullName,
                'surname_phonetic'     => $request['surname_phonetic'],
                'name_phonetic'        => $request['name_phonetic'],
                'full_name_phonetic'   => $fullNamePhonetic,
                'gender'               => $request['gender'],
                'email'                => $request['email'],
                'current_situation_id' => $currentSitation->name,
                'phone_number'         => $request['phone_number'],
                'agreed_to_policy'     => $request['privacy']
            ]
        ]);
    }
    public function register(Request $request)
    {
        DB::table('expo_reservations')->insert([
            'expo_id'              => $request['expo_id'],
            'surname'              => $request['surname'],
            'name'                 => $request['name'],
            'full_name'            => $request['surname'],
            'surname_phonetic'     => $request['surname_phonetic'],
            'name_phonetic'        => $request['name_phonetic'],
            'full_name_phonetic'   => $request['full_name_phonetic'],
            'gender'               => $request['gender'],
            'email'                => $request['email'],
            'current_situation_id' => $request['current_situation_id'],
            'phone_number'         => $request['phone_number'],
            'agreed_to_policy'     => $request['agreed_to_policy']
        ]);
        Session::put('msg', 'Reservation information success!');
        return response()->view('app.register_expo_ok');
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'surname'               => 'required|string',
            'name'                  => 'required|string',
            'surname_phonetic'      => 'required|string',
            'name_phonetic'         => 'required|string',
            'gender'                => 'required|integer',
            'email'                 => 'required|string|email|unique:expo_reservations,email',
            'current_situation_id'  => 'required|integer',
            'phone_number'          => 'required|regex:/([0-9]{3}-[0-9]{4}-[0-9]{4})/u',
            'privacy'               => 'required|integer|accepted'
        ]);
    }
}
