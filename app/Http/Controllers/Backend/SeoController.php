<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeoMeta;
use App\Services\PageService;
use App\Services\ClientService;
use App\Services\PostService;
use App\Services\PartnerService;
use App\Services\ProjectService;
use App\Services\PostCategoryService;
use App\Services\ProjectCategoryService;
use App\Services\ServiceService;
use App\Services\FaqService;
use App\Services\SeoService;
use App\Http\Requests\Seo\SeoMetaRequest;

class SeoController extends Controller
{
    protected $seoService;
    protected $serviceService;
    protected $pageService;
    protected $clientService;
    protected $postService;
    protected $partnerService;
    protected $projectService;
    protected $postCategoryService;
    protected $projectCategoryService;
    protected $faqService;

    public function __construct(
        SeoService $seoService,
        ServiceService $serviceService,
        PageService $pageService,
        ClientService $clientService,
        PostService $postService,
        PartnerService $partnerService,
        ProjectService $projectService,
        PostCategoryService $postCategoryService,
        ProjectCategoryService $projectCategoryService,
        FaqService $faqService
    ) {
        $this->seoService = $seoService;
        $this->serviceService = $serviceService;
        $this->pageService = $pageService;
        $this->clientService = $clientService;
        $this->postService = $postService;
        $this->partnerService = $partnerService;
        $this->projectService = $projectService;
        $this->postCategoryService = $postCategoryService;
        $this->projectCategoryService = $projectCategoryService;
        $this->faqService = $faqService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $seoMetas = SeoMeta::paginate(10);
        return view('backend.seo.index', compact('seoMetas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pages = $this->pageService->getPages(1);
    $clients = $this->clientService->getClients(1);
    $posts = $this->postService->getPosts(1);
    $partners = $this->partnerService->getPartners(1);
    $projects = $this->projectService->getProjects(1);
    $postCategories = $this->postCategoryService->getPostCategories(1);
    $projectCategories = $this->projectCategoryService->getProjectCategories(1);
    $services = $this->serviceService->getServices(1);
    $faqs = $this->faqService->getFaqs(1);

    return view('backend.seo.create', compact(
        'pages', 
        'clients',
        'posts',
        'partners', 
        'projects', 
        'postCategories', 
        'projectCategories', 
        'services', 'faqs'
    ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SeoMetaRequest $request)
    {
        try {
            //dd($request->validated());
            $seoMeta = $this->seoService->createSeoMeta($request->validated());
            return redirect()->route('seo.index')->with('status', 'SEO metadata created successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating SEO metadata: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SeoMeta $seo)
    {
        return view('backend.seo.show', compact('seo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeoMeta $seo)
    {
         $pages = $this->pageService->getPages(1);
    $clients = $this->clientService->getClients(1);
    $posts = $this->postService->getPosts(1);
    $partners = $this->partnerService->getPartners(1);
    $projects = $this->projectService->getProjects(1);
    $postCategories = $this->postCategoryService->getPostCategories(1);
    $projectCategories = $this->projectCategoryService->getProjectCategories(1);
    $services = $this->serviceService->getServices(1);
    $faqs = $this->faqService->getFaqs(1);
    
        return view('backend.seo.edit', compact('seo', 'pages', 
        'clients',
        'posts',
        'partners', 
        'projects', 
        'postCategories', 
        'projectCategories', 
        'services', 'faqs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SeoMetaRequest $request, SeoMeta $seo)
    {
        try {
            $this->seoService->updateSeoMeta($seo, $request->validated());
            return redirect()->route('seo.index')->with('status', 'SEO metadata updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating SEO metadata: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeoMeta $seo)
    {
        try {
            $this->seoService->deleteSeoMeta($seo);
            return redirect()->route('seo.index')->with('status', 'SEO metadata deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting SEO metadata: ' . $e->getMessage());
        }
    }
}
