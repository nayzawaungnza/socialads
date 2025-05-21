<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $userService;

    public function __construct(UserService $userServices)
    {
        $this->userService = $userServices;
    }

    public function getLogin(Request $request){
        return view('auth.login',['url'=> route('admin.login'), 'title'=>'Admin Login']);
    }

    public function postLogin(LoginRequest $request)
    {
        $check_admin = $this->userService->checkActiveUser($request->all())->first();
        if (isset($check_admin) && $check_admin->is_active == 1 && $check_admin->is_admin == 1) {
            if (auth()->guard()->attempt($request->only(['email', 'password']), $request->get('remember'))) {
                return redirect('/admin/dashboard');
            }
        }
        return $this->sendFailedLoginResponse($request);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];
        $user = User::where('email', $request->{$this->username()})->first();
        if ($user && !Hash::check($request->password, $user->password)) {
            $errors = ['password' => trans('auth.password')];
        }
        if ($user && Hash::check($request->password, $user->password) && $user->is_active != 1) {
            $errors = [$this->username() => trans('auth.noactive')];
        }
        if ($user && Hash::check($request->password, $user->password) && $user->is_admin != 1) {
            $errors = [$this->username() => trans('auth.noadmin')];
        }
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    public function logout(Request $request)
    {
        $redirectTo = '/';
        // if(auth()->guard('admin')->check()) {
        //     $redirectTo = 'admin';
        // }

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect($redirectTo);
    }

}