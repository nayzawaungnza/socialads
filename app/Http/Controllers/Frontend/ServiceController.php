<?php

namespace App\Http\Controllers\Frontend;

use App\Services\ServiceService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProjectService;

class ServiceController extends Controller
{
    protected $serviceService;
    protected $projectService;
    public function __construct(ServiceService $serviceService, ProjectService $projectService){
        $this->serviceService = $serviceService;
        $this->projectService = $projectService;
    }
    public function serviceDetail($slug)
    {
        $service = $this->serviceService->getService($slug);
         $projects = $this->projectService->getProjects();
        if (!$service) {
            return redirect()->route('website.notfound');
        }

        return view('frontend.service-detail', compact('service', 'projects'));
    }
}
