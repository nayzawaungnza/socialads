<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $permissionService;
    public function __construct(PermissionService $permissionService){
        $this->permissionService = $permissionService;
    }

    public function index(Request $request)
    {
        $id = auth()->user()->id;
        //dd($id);
        $permissions = $this->permissionService->getRolePermissions($id);
        //dd($permissions);
        return view('main_admin.home',['title'=>'Dashboard ']);
    }
}