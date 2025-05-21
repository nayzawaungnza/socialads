<?php

namespace App\Http\Controllers\Backend;

use DataTables;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Enums\PostStatusEnum;
use App\Services\PostService;
use App\Http\Controllers\Controller;
use App\Services\PostCategoryService;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;

class PostController extends Controller
{
    protected $postService;
    protected $postCategoryService;
    public function __construct(PostService $postService, PostCategoryService $postCategoryService)
    {
        $this->postService = $postService;
        $this->postCategoryService = $postCategoryService;

        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:post-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $eloquent = $this->postService->getPostEloquent();
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
                    $image = '<img src="' . Storage::disk('public')->url($row->default_image?->image_url) . '" alt="Default" class="img-fluid img-thumbnail rounded" width="50px">';
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
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" class="button-size btn btn-sm ' . $button_color . '" href="' . url('admin/posts/' . $row->id . '/change_status') . '"
                        onclick="' . $confirm . '" title="' . $button_tooltip . '">
                       ' . $status . '
                       </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="View" class="button-size btn btn-sm btn-success" href="' . url('admin/posts/' . $row->id . '/') . '"
                       style="color:#FFF">
                      <i class="fas fa-eye"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="Edit" class="button-size btn btn-sm btn-success" href="' . url('admin/posts/' . $row->id . '/edit') . '">
                      <i class="fas fa-edit"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><form action="' . route('posts.destroy', $row->id) . '" method="POST" id="del-role-' . $row->id . '" class="d-inline">
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
        return view('backend.post.index');
    }

    public function create()
    {
        $url = route('posts.store');
        $categories = $this->postCategoryService->getPostCategories($request = null);
        return view('backend.post.create', compact('url', 'categories'));
    }
    public function store(CreatePostRequest $request)
    {
       // dd($request->all());
        $this->postService->create($request->all());
        return redirect('admin/posts')->with('status', 'Post has been added successfully.');
    }

    public function show(Post $post)
    {
        return view('backend.post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $url = route('posts.update', $post->id);
        $categories = $this->postCategoryService->getPostCategories($request = null);
        return view('backend.post.edit', compact('post', 'url', 'categories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->postService->update($post, $request->all());
        return redirect('admin/posts')->with('status', 'Post has been updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->postService->destroy($post);
        return redirect()->route('posts.index')->with('status', 'Post has been deleted successfully.');
    }

    public function changeStatus(Post $post)
    {
        $this->postService->changeStatus($post);
        return redirect('admin/posts')->with('status', 'Post status has been changed successfully.');
    }
}