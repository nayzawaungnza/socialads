<?php

namespace App\Http\Controllers\Backend;

use App\Enums\StageStatusEnum;
use App\Services\ClientService;
use DataTables;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Enums\PostStatusEnum;
use App\Services\ProjectService;
use App\Services\ProjectCategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;

class ProjectController extends Controller
{
    protected $projectService;
    protected $clientService;
    protected $projectCategoryService;
    public function __construct(ProjectService $projectService, ClientService $clientService, ProjectCategoryService $projectCategoryService)
    {
        $this->projectService = $projectService;
        $this->clientService = $clientService;
         $this->projectCategoryService = $projectCategoryService;

        $this->middleware('permission:project-list|project-create|project-edit|project-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:project-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:project-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:project-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $eloquent = $this->projectService->getProjectEloquent();
            return DataTables::of($eloquent)
                ->addIndexColumn()
                ->addColumn('name', fn($row) => $row->name)
                ->addColumn('slug', fn($row) => $row->slug)   
                ->addColumn('stage', function($row) {
                    return '<span class="badge ' . ($row->stage === StageStatusEnum::Completed ? 'bg-success' : 'bg-warning') . '">' 
                        . ( $row->stage === StageStatusEnum::Completed 
                            ? StageStatusEnum::getLabel(StageStatusEnum::Completed) 
                            : StageStatusEnum::getLabel(StageStatusEnum::Ongoing) ) 
                        . '</span>';
                })
                
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
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" class="button-size btn btn-sm ' . $button_color . '" href="' . url('admin/projects/' . $row->id . '/change_status') . '"
                        onclick="' . $confirm . '" title="' . $button_tooltip . '">
                       ' . $status . '
                       </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="View" class="button-size btn btn-sm btn-success" href="' . url('admin/projects/' . $row->id . '/') . '"
                       style="color:#FFF">
                      <i class="fas fa-eye"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="Edit" class="button-size btn btn-sm btn-success" href="' . url('admin/projects/' . $row->id . '/edit') . '">
                      <i class="fas fa-edit"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><form action="' . route('projects.destroy', $row->id) . '" method="POST" id="del-role-' . $row->id . '" class="d-inline">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="button-size btn btn-sm btn-danger destroy_btn" data-original-title="" data-origin="del-role-' . $row->id . '" title="Delete">
                        <i class="fas fa-trash"></i>
                        </button>                                                    
                        </form></div>';
                    $btn = $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['name', 'status', 'stage', 'created_at', 'created_by', 'default_image', 'action'])
                ->make(true);
            }
        return view('backend.project.index');
    }

    public function create()
    {
        $url = route('projects.store');
        $clients = $this->clientService->getClients();
         $categories = $this->projectCategoryService->getProjectCategories(1);
        return view('backend.project.create', compact('url','clients','categories'));
    }
    public function store(CreateProjectRequest $request)
    {
        //dd($request->all());
        $this->projectService->create($request->all());
        return redirect('admin/projects')->with('status', 'Project has been added successfully.');
    }

    public function show(Project $project)
    {
        return view('backend.project.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $url = route('projects.update', $project->id);
        $clients = $this->clientService->getClients();
        $categories = $this->projectCategoryService->getProjectCategories(1);
        return view('backend.project.edit', compact('project', 'url', 'clients', 'categories'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        //dd($request->all());
        $this->projectService->update($project, $request->all());
        return redirect('admin/projects')->with('status', 'Project has been updated successfully.');
    }

    public function destroy(Project $project)
    {
        $this->projectService->destroy($project);
        return redirect()->route('projects.index')->with('status', 'Project has been deleted successfully.');
    }

    public function changeStatus(Project $project)
    {
        $this->projectService->changeStatus($project);
        return redirect('admin/projects')->with('status', 'Project status has been changed successfully.');
    }
}