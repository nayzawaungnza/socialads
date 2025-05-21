<?php

namespace App\Http\Controllers\Backend;

use DataTables;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use App\Enums\PostStatusEnum;
use App\Http\Controllers\Controller;
use App\Services\PostCategoryService;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdatePostCategoryRequest;

class PostCategoryController extends Controller
{
    protected $postCategoryService;
    public function __construct(PostCategoryService $postCategoryService)
    {
        $this->postCategoryService = $postCategoryService;

        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
    if ($request->ajax()) {
        $eloquent = $this->postCategoryService->getPostCategoryEloquent();
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
                $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" class="button-size btn btn-sm ' . $button_color . '" href="' . url('admin/post_categories/' . $row->id . '/change_status') . '"
                    onclick="' . $confirm . '" title="' . $button_tooltip . '">
                   ' . $status . '
                   </a></div>';
                $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="View" class="button-size btn btn-sm btn-success" href="' . url('admin/post_categories/' . $row->id . '/') . '"
                   style="color:#FFF">
                  <i class="fas fa-eye"></i>
                  </a></div>';
                $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="Edit" class="button-size btn btn-sm btn-success" href="' . url('admin/post_categories/' . $row->id . '/edit') . '">
                  <i class="fas fa-edit"></i>
                  </a></div>';
                $btn = $btn . '<div class="my-1 button-box text-center"><form action="' . route('post_categories.destroy', $row->id) . '" method="POST" id="del-role-' . $row->id . '" class="d-inline">
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

    $categories = $this->postCategoryService->getPostCategories($request);
    $url = route('post_categories.store');

    return view('backend.post_category.index', compact('url', 'categories'));
    }

    public function create()
    {
        dd('post category create');
        $url = route('post_categories.store');
        return view('backend.post_category.index', compact('url'));
    }
    public function store(CreateCategoryRequest $request)
    {
        $this->postCategoryService->create($request->all());
        return redirect('admin/post_categories')->with('status', 'Post Category has been added successfully.');
    }

    public function show(PostCategory $postCategory)
    {
        return view('backend.post_category.show', compact('postCategory'));
    }

    public function edit(PostCategory $postCategory)
    {
        $url = route('post_categories.update', $postCategory->id);
        $categories = $this->postCategoryService->getPostCategories($request = null);
        return view('backend.post_category.edit', compact('postCategory', 'url', 'categories'));
    }

    public function update(UpdatePostCategoryRequest $request, PostCategory $postCategory)
    {
        $this->postCategoryService->update($postCategory, $request->all());
        return redirect('admin/post_categories')->with('status', 'Post Category has been updated successfully.');
    }

    public function destroy(PostCategory $postCategory)
    {
        $this->postCategoryService->destroy($postCategory);
        return redirect('admin/post_categories')->with('status', 'Post Category has been deleted successfully.');
    }

    public function changeStatus(PostCategory $postCategory)
    {
        $this->postCategoryService->changeStatus($postCategory);
        return redirect('admin/post_categories')->with('status', 'Post Category has been updated successfully.');
    }
}