<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\RegisterRequest;

class RegisterController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    
    public function getRegister(Request $request){
        return view('frontend.register',['url'=> route('frontend.postregister'), 'title'=>'Register']);
    }

    public function postRegister(RegisterRequest $request){
      
        $plainPassword = $request->input('password');
        
        $admin = $this->userService->register($request->all());
        $email = $admin->email;
        $password = $plainPassword;

        //dd($email, $password);
        return redirect()->route('frontend.login')->with('status', 'Account has been created successfully.')->with('email', $email)->with('password', $password);
    }
}