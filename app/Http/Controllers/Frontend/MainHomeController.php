<?php
namespace App\Http\Controllers\Frontend;

use App\Services\ClientService;
use App\Services\PostService;
use App\Services\PageService;
use App\Services\PostCategoryService;
use App\Services\ProjectService;
use App\Services\ProjectCategoryService;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use App\Enums\PostStatusEnum;
use App\Services\SliderService;
use App\Http\Controllers\Controller;
use App\Models\SeoMeta;
use App\Models\Page;

class MainHomeController extends Controller
{
    protected $pageService;
    protected $sliderService;
    protected $serviceService;
    protected $clientService;
    protected $postService;
    protected $projectService;
    protected $postCategoryService;
    protected $projectCategoryService;

    public function __construct(
        PageService $pageService, 
        SliderService $sliderService, 
        ServiceService $serviceService, 
        ClientService $clientService, 
        PostService $postService, 
        ProjectService $projectService, 
        PostCategoryService $postCategoryService, 
        ProjectCategoryService $projectCategoryService
    ) {
        $this->pageService = $pageService;
        $this->sliderService = $sliderService;
        $this->serviceService = $serviceService;
        $this->clientService = $clientService;
        $this->postService = $postService;
        $this->projectService = $projectService;
        $this->postCategoryService = $postCategoryService;
        $this->projectCategoryService = $projectCategoryService;
    }

    // private function setSeo($pageType, $pageId = null)
    // {
    //     $seoMeta = SeoMeta::where('page_type', $pageType)
    //                       ->where('page_id', $pageId)
    //                       ->first();

    //     if ($seoMeta) {
    //         $seoMeta->setSeoMeta();
    //     }
    // }

    public function index(Request $request)
    {
       $page = $this->pageService->getPage('home');
        SeoMeta::setSeoForPage('page', $page->id);



        $sliders = $this->sliderService->getSliders($request, PostStatusEnum::Publish);
        $services = $this->serviceService->getServices(PostStatusEnum::Publish);
        $clients = $this->clientService->getClients();
        $posts = $this->postService->getPosts();
        $projects = $this->projectService->getProjects();

        return view('frontend.home', compact('sliders', 'services', 'clients', 'posts', 'projects'));
    }

    public function services()
    {
        $page = $this->pageService->getPage('services');
        SeoMeta::setSeoForPage('page', $page->id);
        
        $services = $this->serviceService->getServices(PostStatusEnum::Publish);
        return view('frontend.service', compact('page', 'services'));
    }

    public function aboutUs()
    {
         $page = $this->pageService->getPage('about-us');
        SeoMeta::setSeoForPage('page', $page->id);
        return view('frontend.about', compact('page'));
    }

    public function contactUs()
    {
         $page = $this->pageService->getPage('contact-us');
         
         
        SeoMeta::setSeoForPage('page', $page->id);
        $services = $this->serviceService->getServices(PostStatusEnum::Publish);
        $posts = $this->postService->getRecentPosts();
        return view('frontend.contact', compact('page','services','posts'));
    }

    public function portfolio()
    {
        $page = $this->pageService->getPage('portfolio');
        SeoMeta::setSeoForPage('page', $page->id);

        $categories = $this->projectCategoryService->getProjectCategoriesHasProject();
        $projects = $this->projectService->getProjects();
        $services = $this->serviceService->getServices(PostStatusEnum::Publish);

        return view('frontend.portfolio', compact('page', 'projects', 'categories', 'services'));
    }

    public function serviceDetail($slug)
    {
        $service = $this->serviceService->getServiceBySlug($slug);
       
        
        return view('frontend.service-detail', compact('service'));
    }

    public function insights()
    {
        $page = $this->pageService->getPage('insights');
        SeoMeta::setSeoForPage('page', $page->id);

        $posts = $this->postService->getPosts();
        $recent_posts = $this->postService->getRecentPosts(3);
        $features = $this->postService->getFeaturePosts();
        $categories = $this->postCategoryService->getPostCategoriesHasPost();
        $topics = $this->postCategoryService->getTopicPostCategories();
        
        return view('frontend.insights', compact('page','posts', 'categories', 'recent_posts','features','topics'));
    }

    public function privacy()
    {
        $page = $this->pageService->getPage('privacy-policy');
        SeoMeta::setSeoForPage('page', $page->id);
        
        return view('frontend.privacy-policy', compact('page'));
    }

    public function notfound()
    {
        
        return view('frontend.404');
    }
}
