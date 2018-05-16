<?php

namespace App\Http\Controllers\Auth;

use App\Utils;
use DB;
use Flash;
use Redirect;
use Exception;

use Carbon\Carbon;

use App\User;
use App\Consts;
use App\Mail\Verify;
use App\Models\Config;
use App\Http\Controllers\Controller;
use App\Exceptions\InvalidConfirmationCodeException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = User::$rules;

        $rules['email']    .= '|required';
        $rules['password'] .= '|required';
        $rules['birthday'] .= '|before:' . date('Y-m-d');
        // $rules['referral_code'] = 'numeric|nullable|exists:referral_agencies,code';

        return Validator::make($data, $rules);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $email       = $request->get('email');
        $provider    = $request->get('provider') ? : 'email';
        $provider_id = $request->get('provider_id') ? : $email;

        $extraValidator = Validator::make($request->all(), $this->getExtraRules($email, $provider, $provider_id));
        $extraValidator->validate();

        User::where('email', $email)->delete();
        User::getBySocialProvider($provider, $provider_id)->delete();

        DB::beginTransaction();
        try {
            $user = $this->create($request);
            $user->socialProviders()->create([
                'provider'    => $provider,
                'provider_id' => $provider_id,
            ]);
            if (isset($request->referral_sources) || isset($request->referral_code)) {
                $this->createUserReferenceRecord($user->id, $request->get('referral_sources'), $request->get('referral_code'));
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        // event(new Registered($user));
        // $this->sendVerificationMail($user);

        return Redirect::route('login')->with('messages', trans('auth.register.complete'));
    }

    private function createUserReferenceRecord($userId, $referralSources, $referralCode)
    {
        $data = [];
        $data['user_id'] = $userId;
        if (isset($referralSources)) {
            foreach ($referralSources as $source) {
                $data[$source] = 1;
            }
        }
        if (isset($referralCode)) {
            $data['from_friends_companies'] = 1;
            $data['referral_code'] = $referralCode;
        }
        DB::table('user_references')->insert($data);
    }

    protected function create(Request $request)
    {
        $data = $request->intersect((new User)->getFillable());

        $data['confirmation_code'] = str_random(30);
        $data['password']          = bcrypt($data['password']);
        $data['name']              = join(' ', [$data['first_name'], $data['last_name']]);

        return User::create($data);
    }

    public function sendVerificationMail(User $user)
    {
        Mail::to($user)->queue(new Verify($user));
    }

    public function resendVerification(User $user)
    {
        $this->sendVerificationMail($user);
        return Redirect::route('login')->with('messages', trans('auth.register.complete'));
    }

    public function getExtraRules($email, $provider, $provider_id)
    {
        $rules = [];

        $authUser = User::where('email', $email)->first();
        $providerUser = User::getBySocialProvider($provider, $provider_id)->first();

        if ($authUser && $authUser->confirmed) {
            $rules['email'] = 'unique:users';
        }

        if ($providerUser && $providerUser->confirmed) {
            $rules['provider_id']  = 'unique:social_providers';
        }
        return $rules;
    }
 
    public function confirm($confirmation_code)
    {
        $user = User::where('confirmation_code', '=', $confirmation_code)
            ->whereDate('updated_at', '>', Carbon::today()->subHours(config('app.confirmation_time'))->toDateString())
            ->first();

        if (!$user) {
            throw new InvalidConfirmationCodeException;
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        return Redirect::route('login')->with('messages', trans('auth.register.verified'));
    }

    public function showRegistrationForm()
    {
        $referralSources = Utils::getReferralSource();
        $configs = Config::getConfigByKey();
        return view('auth.register', ['configs' => $configs, 'referralSources' => $referralSources, 'formAction' => 'register']);
    }
}
