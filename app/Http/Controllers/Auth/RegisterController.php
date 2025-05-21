<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;

class RegisterController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    
    public function getRegister(Request $request){
        return view('auth.register',['url'=> route('admin.register'), 'title'=>'Admin Register']);
    }

    public function postRegister(CreateUserRequest $request){
        $plainPassword = $request->input('password');
        
        $admin = $this->userService->create($request->all());
        $email = $admin->email;
        $password = $plainPassword;

        //dd($email, $password);
        return redirect()->route('admin.login')->with('status', 'User Account has been created successfully.')->with('email', $email)->with('password', $password);
    }
}