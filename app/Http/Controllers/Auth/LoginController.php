<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        DB::getQueryLog();
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function action_login(Request $request)
    {
        $rule = [
            'user_username' => 'required|exists:users,user_username',
            'password' => 'required'
        ];
        $message = [
            'required' => 'The :attribute is required',
            'exists'    => 'Username not found',
        ];
        $validator = Validator::make($request->input(), $rule, $message);

        if ($validator->passes()) {
            $auth = Auth::attempt($request->only('user_username', 'password'));

            if ($auth) {
                $request->session()->put('credential', Auth::user());
                return redirect(route('admin.dashboard'));
            } else {

                return redirect(route('auth.index'))->with('message', Helper::failed_alert('Password Salah'))->withInput();
            }
        } else {
            return redirect(route('auth.index'))->with('message', Helper::failed_alert($validator->errors()->all()))->withInput();;
        }
    }
}
