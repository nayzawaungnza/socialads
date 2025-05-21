<?php

namespace App\Http\Controllers\Frontend;

use App\Services\ProjectService;
use App\Services\ProjectCategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;
    protected $projectCategoryService;
    public function __construct(ProjectService $projectService, ProjectCategoryService $projectCategoryService)
    {
      
        $this->projectService = $projectService;
        $this->projectCategoryService = $projectCategoryService;
    }
    
    public function projectDetail($slug)
    {
        $project = $this->projectService->getProject($slug);
        $projects = $this->projectService->getProjects();
        if (!$project) {
            return redirect()->route('website.notfound');
        }
        
        return view('frontend.project-detail', compact('project','projects'));
    }
    
    public function categoryProject($slug){
        $category = $this->projectCategoryService->getProjectCategory($slug);
        return view('frontend.category-project', compact('category'));
    }
    
}