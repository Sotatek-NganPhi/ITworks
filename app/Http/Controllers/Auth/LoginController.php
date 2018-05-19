<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        return [
            'email'  => $request->get('email'),
            'password'  => $request->get('password'),
            'confirmed' => 1,
        ];
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider, Request $request)
    {
        if($request->input('error')){
            return redirect()->route('index');
        }

        $user = Socialite::driver($provider)->stateless()->user();
        $authUser = User::getBySocialProvider($provider, $user->id)->first();

        if ($authUser && $authUser->confirmed) {
            Auth::login($authUser, true);
            return redirect($this->redirectTo);
        }
        return Redirect::route('register')->withInput($this->parseProviderUser($user, $provider));
    }

    private function parseProviderUser($user, $provider)
    {
        return [
            'provider'    => $provider,
            'provider_id' => $user->id,
            'first_name'  => $user->first_name,
            'last_name'   => $user->last_name,
            'email'       => $user->email,
            'birthday'    => $user->birthday,
        ];
    }

    public function logout()
    {
        $this->guard()->logout();

        return redirect()->to('/');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        if ($request->session()->has('url._intended')) {
            return redirect()->to($request->session()->get('url._intended'));
        }
        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }
}
