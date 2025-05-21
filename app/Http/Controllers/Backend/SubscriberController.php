<?php

namespace App\Http\Controllers\Backend;

use DataTables;
use Carbon\Carbon;
use App\Models\User as Subscriber;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Enums\ActiveStatusEnum;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriber\CreateSubscriberRequest;
use App\Http\Requests\Subscriber\UpdateSubscriberRequest;

class SubscriberController extends Controller
{
    protected $userService;
    protected $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;

        $this->middleware('permission:subscription-list|subscription-create|subscription-edit|subscription-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:subscription-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:subscription-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subscription-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $eloquent = $this->userService->getSubscriberEloquent();
            if ($request->input('order.0.column') === null) {
                $eloquent->orderBy('created_at', 'desc');
            }
            return DataTables::eloquent($eloquent)
                ->addIndexColumn()
                ->editColumn('is_active', function ($subscriber) {
                    $btn = '<button class="'. ($subscriber->is_active == ActiveStatusEnum::Active ? 'btn btn-sm btn-success' : 'btn btn-sm btn-danger') .'">'.ActiveStatusEnum::getLabel($subscriber->is_active).'</button>';
                    return $btn;
                })
                ->addColumn('role', function ($subscriber) {
                    return $subscriber->roles->pluck('name')->first();
                })
                ->addColumn('email', function ($subscriber) {
                    return $subscriber->email;
                })
                ->addColumn('default_image', function ($subscriber) {
                    $image = '<img src="' . e($subscriber->default_image?->image_url) . '" alt="Default" class="img-fluid img-thumbnail rounded" width="50px">';
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
                ->editColumn('created_at', function ($subscriber) {
                    return Carbon::parse($subscriber->created_at)->format(config('constants.DATE_FORMAT.DATAIL_DATE_FORMAT'));
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
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" class="button-size btn btn-sm ' . $button_color . '" href="' . url('admin/subscribers/' . $row->id . '/change_status') . '"
                        onclick="' . $confirm . '" title="' . $button_tooltip . '">
                       ' . $status . '
                       </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="View" class="button-size btn btn-sm btn-success" href="' . url('admin/subscribers/' . $row->id . '/') . '"
                       style="color:#FFF">
                      <i class="fas fa-eye"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="Edit" class="button-size btn btn-sm btn-success" href="' . url('admin/subscribers/' . $row->id . '/edit') . '">
                      <i class="fas fa-edit"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><form action="' . route('subscribers.destroy', $row->id) . '" method="POST" id="del-role-' . $row->id . '" class="d-inline">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="button-size btn btn-sm btn-danger destroy_btn" data-original-title="" data-origin="del-role-' . $row->id . '" title="Delete">
                        <i class="fas fa-trash"></i>
                        </button>                                                    
                        </form></div>';
                    $btn = $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['action','default_image','is_active'])
                ->make(true);
        }
        return view('backend.subscriber.index');
        
    }

    public function create()
    {
        $url = route('subscribers.store');
        return view('backend.subscriber.create', compact('url'));
    }

    public function store(CreateSubscriberRequest $request)
    {
        $this->userService->create($request->all());
        return redirect('admin/subscribers')->with('status', 'Subscriber has been added successfully.');
    }

    public function edit(Subscriber $subscriber)
    {
       
        //dd($subscriber->toArray());
        $roles = $this->roleService->getRolesPluckName();
        $userRole = $this->userService->getUserRolesPluckName($subscriber);
        $url = route('subscribers.update', $subscriber->id);
        return view('backend.subscriber.edit', compact('subscriber', 'roles', 'userRole', 'url'));
    }


    public function update(UpdateSubscriberRequest $request, Subscriber $subscriber)
    {
        //dd($request->all());
        $this->userService->update($subscriber, $request->all());
        return redirect('admin/subscribers')->with('status', 'Subscriber Account has been updated successfully.');
    }

    public function changeStatus(Subscriber $subscriber)
    {
            $result = $this->userService->changeStatus($subscriber);
            return redirect('admin/subscribers')->with('status', 'Subscriber Account status has been updated successfully.');
        
    }
    public function destroy(Subscriber $subscriber)
    {
        $this->userService->destroy($subscriber);
        return redirect()->route('subscribers.index')->with('status', 'Subscriber Account has been deleted successfully.');
    }
    
}