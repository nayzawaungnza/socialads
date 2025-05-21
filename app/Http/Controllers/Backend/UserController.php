<?php

namespace App\Http\Controllers\Backend;

use DataTables;
use Carbon\Carbon;
use App\Models\User as Account;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Enums\ActiveStatusEnum;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    protected $userService;
    protected $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $eloquent = $this->userService->getUserEloquent();
            if ($request->input('order.0.column') === null) {
                $eloquent->orderBy('created_at', 'desc');
            }
            return DataTables::eloquent($eloquent)
                ->addIndexColumn()
                ->editColumn('is_active', function ($account) {
                    return ActiveStatusEnum::getLabel($account->is_active);
                })
                ->addColumn('role', function ($account) {
                    return $account->roles->pluck('name')->first();
                })
                ->addColumn('email', function ($account) {
                    return $account->email;
                })
                ->addColumn('default_image', function ($account) {
                    $image = '<img src="' . e($account->default_image?->image_url) . '" alt="Default" class="img-fluid img-thumbnail rounded" width="50px">';
                    return $image;
                    
                })
                ->filterColumn('role', function ($query, $keyword) {
                    $query->whereHas('roles', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('is_active', function ($query, $keyword) {
                    $sql = "(CASE WHEN users.is_active = 1 THEN 'Active' ELSE 'Inactive' END)  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('is_active', function ($query, $keyword) {
                    $sql = "(CASE WHEN users.is_active = 1 THEN 'Active' ELSE 'Inactive' END)  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->editColumn('created_at', function ($account) {
                    return Carbon::parse($account->created_at)->format(config('constants.DATE_FORMAT.DATAIL_DATE_FORMAT'));
                })
                ->orderColumn('role', function ($query, $order) {
                    $query->join('model_has_roles', 'model_has_roles.model_id', 'users.id')
                        ->join('roles', 'roles.id', 'model_has_roles.role_id')
                        ->orderBy('roles.name', $order);
                })
                ->addColumn('action', function ($row) {
                    if ($row->is_active == ActiveStatusEnum::Inactive) {
                        $status = '<i class="fas fa-check"></i>';
                        $button_color = 'btn-success';
                        $button_tooltip = 'Active';
                        $confirm = '';
                    } else {
                        $status = '<i class="fas fa-ban"></i>';
                        $button_color = 'btn-danger';
                        $button_tooltip = 'Inactive';
                        $confirm = 'return confirmInactive(this)';
                    }
                    $btn = '<div class="row m-sm-n1">';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" class="button-size btn btn-sm ' . $button_color . '" href="' . url('admin/accounts/' . $row->id . '/change_status') . '"
                        onclick="' . $confirm . '" title="' . $button_tooltip . '">
                       ' . $status . '
                       </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="View" class="button-size btn btn-sm btn-success" href="' . url('admin/accounts/' . $row->id . '/') . '"
                       style="color:#FFF">
                      <i class="fas fa-eye"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="Edit" class="button-size btn btn-sm btn-success" href="' . url('admin/accounts/' . $row->id . '/edit') . '">
                      <i class="fas fa-edit"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><form action="' . route('accounts.destroy', $row->id) . '" method="POST" id="del-role-' . $row->id . '" class="d-inline">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="button-size btn btn-sm btn-danger destroy_btn" data-original-title="" data-origin="del-role-' . $row->id . '" title="Delete">
                        <i class="fas fa-trash"></i>
                        </button>                                                    
                        </form></div>';
                    $btn = $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['action','default_image'])
                ->make(true);
        }
        return view('main_admin.index');
        
    }

    public function create()
    {
        $url = route('accounts.store');
        return view('.main_admin.create', compact('url'));
    }

    public function store(CreateUserRequest $request)
    {
        $this->userService->create($request->all());
        return redirect('admin/accounts')->with('status', 'User has been added successfully.');
    }

    public function edit(Account $account)
    {
       
        //dd($account->toArray());
        $roles = $this->roleService->getRolesPluckName();
        $userRole = $this->userService->getUserRolesPluckName($account);
        $url = route('accounts.update', $account->id);
        return view('.main_admin.edit', compact('account', 'roles', 'userRole', 'url'));
    }


    public function update(UpdateUserRequest $request, Account $account)
    {
        //dd($request->all());
        $this->userService->update($account, $request->all());
        return redirect('admin/accounts')->with('status', 'Admin Account has been updated successfully.');
    }

    public function changeStatus(Account $account)
    {
            $result = $this->userService->changeStatus($account);
            return redirect('admin/accounts')->with('status', 'Admin Account status has been updated successfully.');
        
    }
    public function destroy(Account $account)
    {
        $this->userService->destroy($account);
        return redirect()->route('accounts.index')->with('status', 'Admin Account has been deleted successfully.');
    }
    
}