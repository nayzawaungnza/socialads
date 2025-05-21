<?php

namespace App\Http\Controllers\Backend;

use DataTables;
use App\Models\Partner;
use Illuminate\Http\Request;
use App\Enums\PostStatusEnum;
use App\Services\PartnerService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Partner\CreatePartnerRequest;
use App\Http\Requests\Partner\UpdatePartnerRequest;

class PartnerController extends Controller
{
    protected $partnerService;
    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;

        $this->middleware('permission:partner-list|partner-create|partner-edit|partner-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:partner-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:partner-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:partner-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $eloquent = $this->partnerService->getPartnerEloquent();
            return DataTables::of($eloquent)
                ->addIndexColumn()
                ->addColumn('name', fn($row) => $row->name)
                ->addColumn('slug', fn($row) => $row->slug)   
                ->addColumn('status', function ($row) {
                    return '<span class="badge ' . ($row->status ? 'bg-success' : 'bg-warning') . '">' 
                        . ($row->status ? 'Publish' : 'Draft') . '</span>';
                })
                ->addColumn('created_at', fn($row) => $row->created_at->diffForHumans())
                ->addColumn('created_by', fn($row) => optional($row->createdBy)->name ?? 'N/A')
                ->addColumn('default_image', function ($row) {
                    $image = '<img src="' . Storage::disk('public')->url($row->default_image?->image_url ?? '') . '" alt="Default" class="img-fluid img-thumbnail rounded" width="50px">';
                    return $image;
                })
                ->addColumn('action', function ($row) {
                    if ($row->status == PostStatusEnum::Draft) {
                        $status = '<i class="fas fa-check"></i>';
                        $button_color = 'btn-success';
                        $button_tooltip = 'Publish';
                        $confirm = '';
                    } else {
                        $status = '<i class="fas fa-ban"></i>';
                        $button_color = 'btn-danger';
                        $button_tooltip = 'Draft';
                        $confirm = 'return confirmInactive(this)';
                    }
                    $btn = '<div class="row m-sm-n1">';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" class="button-size btn btn-sm ' . $button_color . '" href="' . url('admin/partners/' . $row->id . '/change_status') . '"
                        onclick="' . $confirm . '" title="' . $button_tooltip . '">
                       ' . $status . '
                       </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="View" class="button-size btn btn-sm btn-success" href="' . url('admin/partners/' . $row->id . '/') . '"
                       style="color:#FFF">
                      <i class="fas fa-eye"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="Edit" class="button-size btn btn-sm btn-success" href="' . url('admin/partners/' . $row->id . '/edit') . '">
                      <i class="fas fa-edit"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><form action="' . route('partners.destroy', $row->id) . '" method="POST" id="del-role-' . $row->id . '" class="d-inline">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="button-size btn btn-sm btn-danger destroy_btn" data-original-title="" data-origin="del-role-' . $row->id . '" title="Delete">
                        <i class="fas fa-trash"></i>
                        </button>                                                    
                        </form></div>';
                    $btn = $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['name', 'status', 'created_at', 'created_by', 'default_image', 'action'])
                ->make(true);
            }
        return view('backend.partner.index');
    }

    public function create()
    {
        $url = route('partners.store');
        return view('backend.partner.create', compact('url'));
    }
    public function store(CreatePartnerRequest $request)
    {
        $this->partnerService->create($request->all());
        return redirect('admin/partners')->with('status', 'Partner has been added successfully.');
    }

    public function show(Partner $partner)
    {
        return view('backend.partner.show', compact('partner'));
    }

    public function edit(Partner $partner)
    {
        $url = route('partners.update', $partner->id);
        return view('backend.partner.edit', compact('partner', 'url'));
    }

    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $this->partnerService->update($partner, $request->all());
        return redirect('admin/partners')->with('status', 'Partner has been updated successfully.');
    }

    public function destroy(Partner $partner)
    {
        $this->partnerService->destroy($partner);
        return redirect()->route('partners.index')->with('status', 'Partner has been deleted successfully.');
    }

    public function changeStatus(Partner $partner)
    {
        $this->partnerService->changeStatus($partner);
        return redirect('admin/partners')->with('status', 'Partner status has been changed successfully.');
    }
}