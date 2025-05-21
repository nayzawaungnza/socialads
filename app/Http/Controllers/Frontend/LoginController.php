<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getLogin(Request $request)
    {
        return view('frontend.login', ['url' => route('frontend.postlogin'), 'title' => 'Login']);
    }

    public function postLogin(LoginRequest $request)
    {
        $check_student = $this->userService->checkActiveStudent($request->all())->first();

        if ($check_student && $check_student->is_active == 1) {
            if (auth()->guard('student')->attempt($request->only(['email', 'password']), $request->get('remember'))) {
                event(new \Illuminate\Auth\Events\Login(auth()->guard('student')->user(), $request->get('remember'), 'student'));

                return redirect('/dashboard');
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

        return $request->expectsJson()
            ? response()->json($errors, 422)
            : redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors($errors);
    }

    public function logout(Request $request)
    {
        $activeGuard = null;
        $guards = ['student', 'admin', 'teacher', 'web'];

        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                $activeGuard = $guard;
                break;
            }
        }

        if ($activeGuard) {
            auth()->guard($activeGuard)->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}