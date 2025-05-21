<?php

namespace App\Http\Controllers\Backend;

use DataTables;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use App\Enums\PostStatusEnum;
use App\Http\Controllers\Controller;
use App\Services\ProjectCategoryService;
use App\Http\Requests\ProjectCategory\CreateProjectCategoryRequest;
use App\Http\Requests\ProjectCategory\UpdateProjectCategoryRequest;

class ProjectCategoryController extends Controller
{
    protected $projectCategoryService;
    public function __construct(ProjectCategoryService $projectCategoryService)
    {
        $this->ProjectCategoryService = $projectCategoryService;

        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
    if ($request->ajax()) {
        $eloquent = $this->ProjectCategoryService->getProjectCategoryEloquent();
        return DataTables::eloquent($eloquent)
            ->addIndexColumn()
            ->addColumn('name', fn($row) => $row->name)
            //->addColumn('slug', fn($row) => $row->slug)
            ->addColumn('status', function ($row) {
                return '<span class="badge ' . ($row->status ? 'bg-success' : 'bg-warning') . '">' 
                    . ($row->status ? 'Publish' : 'Draft') . '</span>';
            })
            ->addColumn('created_at', fn($row) => $row->created_at->diffForHumans())
            ->addColumn('created_by', fn($row) => optional($row->createdBy)->name ?? 'N/A')
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
                $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" class="button-size btn btn-sm ' . $button_color . '" href="' . url('admin/project_categories/' . $row->id . '/change_status') . '"
                    onclick="' . $confirm . '" title="' . $button_tooltip . '">
                   ' . $status . '
                   </a></div>';
                $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="View" class="button-size btn btn-sm btn-success" href="' . url('admin/project_categories/' . $row->id . '/') . '"
                   style="color:#FFF">
                  <i class="fas fa-eye"></i>
                  </a></div>';
                $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="Edit" class="button-size btn btn-sm btn-success" href="' . url('admin/project_categories/' . $row->id . '/edit') . '">
                  <i class="fas fa-edit"></i>
                  </a></div>';
                $btn = $btn . '<div class="my-1 button-box text-center"><form action="' . route('project_categories.destroy', $row->id) . '" method="POST" id="del-role-' . $row->id . '" class="d-inline">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="button-size btn btn-sm btn-danger destroy_btn" data-original-title="" data-origin="del-role-' . $row->id . '" title="Delete">
                    <i class="fas fa-trash"></i>
                    </button>                                                    
                    </form></div>';
                $btn = $btn . '</div>';
                return $btn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    $categories = $this->ProjectCategoryService->getProjectCategories(1);
    $url = route('project_categories.store');

    return view('backend.project_category.index', compact('url', 'categories'));
    }

    public function create()
    {
        dd('post category create');
        $url = route('project_categories.store');
        return view('backend.project_category.index', compact('url'));
    }
    public function store(CreateProjectCategoryRequest $request)
    {
        $this->ProjectCategoryService->create($request->all());
        return redirect('admin/project_categories')->with('status', 'Post Category has been added successfully.');
    }

    public function show(ProjectCategory $projectCategory)
    {
        return view('backend.project_category.show', compact('ProjectCategory'));
    }

    public function edit(ProjectCategory $projectCategory)
    {
        $url = route('project_categories.update', $projectCategory->id);
        $categories = $this->ProjectCategoryService->getPostCategories($request = null);
        return view('backend.project_category.edit', compact('ProjectCategory', 'url', 'categories'));
    }

    public function update(UpdateProjectCategoryRequest $request, ProjectCategory $projectCategory)
    {
        $this->ProjectCategoryService->update($projectCategory, $request->all());
        return redirect('admin/project_categories')->with('status', 'Post Category has been updated successfully.');
    }

    public function destroy(ProjectCategory $projectCategory)
    {
        $this->ProjectCategoryService->destroy($projectCategory);
        return redirect('admin/project_categories')->with('status', 'Post Category has been deleted successfully.');
    }

    public function changeStatus(ProjectCategory $projectCategory)
    {
        $this->ProjectCategoryService->changeStatus($projectCategory);
        return redirect('admin/project_categories')->with('status', 'Post Category has been updated successfully.');
    }
}