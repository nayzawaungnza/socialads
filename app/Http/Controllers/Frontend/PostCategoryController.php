<?php

namespace App\Http\Controllers\Frontend;

use App\Services\PostService;
use App\Services\PostCategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    
     protected $postService;
    protected $postCategoryService;
    public function __construct(PostService $postService, PostCategoryService $postCategoryService)
    {
      
        $this->postService = $postService;
        $this->postCategoryService = $postCategoryService;
    }
    public function categoryDetail($slug){
        return view('frontend.category-detail');
    }
    
    public function categoryPost($slug) 
    {
        $categories = $this->postCategoryService->getPostCategoriesHasPost();
        $category = $this->postCategoryService->getPostCategory($slug);
        return view('frontend.category-post', compact('category','categories'));
    }
}