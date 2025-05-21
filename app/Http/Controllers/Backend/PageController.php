<?php

namespace App\Http\Controllers\Backend;

use DataTables;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Enums\PostStatusEnum;
use App\Services\PageService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Page\CreatePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;

class PageController extends Controller
{
    protected $pageService;
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;

        $this->middleware('permission:page-list|page-create|page-edit|page-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:page-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:page-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:page-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $eloquent = $this->pageService->getPageEloquent();
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
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" class="button-size btn btn-sm ' . $button_color . '" href="' . url('admin/pages/' . $row->id . '/change_status') . '"
                        onclick="' . $confirm . '" title="' . $button_tooltip . '">
                       ' . $status . '
                       </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="View" class="button-size btn btn-sm btn-success" href="' . url('admin/pages/' . $row->id . '/') . '"
                       style="color:#FFF">
                      <i class="fas fa-eye"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="Edit" class="button-size btn btn-sm btn-success" href="' . url('admin/pages/' . $row->id . '/edit') . '">
                      <i class="fas fa-edit"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><form action="' . route('pages.destroy', $row->id) . '" method="POST" id="del-role-' . $row->id . '" class="d-inline">
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
        return view('backend.page.index');
    }

    public function create()
    {
        $url = route('pages.store');
        return view('backend.page.create', compact('url'));
    }
    public function store(CreatePageRequest $request)
    {
        $this->pageService->create($request->all());
        return redirect('admin/pages')->with('status', 'Page has been added successfully.');
    }

    public function show(Page $page)
    {
        return view('backend.page.show', compact('page'));
    }

    public function edit(Page $page)
    {
        $url = route('pages.update', $page->id);
        return view('backend.page.edit', compact('page', 'url'));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $this->pageService->update($page, $request->all());
        return redirect('admin/pages')->with('status', 'Page has been updated successfully.');
    }

    public function destroy(Page $page)
    {
        $this->pageService->destroy($page);
        return redirect()->route('pages.index')->with('status', 'Page has been deleted successfully.');
    }

    public function changeStatus(Page $page)
    {
        $this->pageService->changeStatus($page);
        return redirect('admin/pages')->with('status', 'Page status has been changed successfully.');
    }
}