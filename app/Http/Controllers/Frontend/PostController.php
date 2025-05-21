<?php

namespace App\Http\Controllers\Frontend;

use App\Services\PostService;
use App\Services\PostCategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;
    protected $postCategoryService;
    public function __construct(PostService $postService, PostCategoryService $postCategoryService)
    {
      
        $this->postService = $postService;
        $this->postCategoryService = $postCategoryService;
    }
    
    public function blogDetail($slug)
    {
        $categories = $this->postCategoryService->getPostCategoriesHasPost();
        $post = $this->postService->getPost($slug);
       $relatedPosts = $this->postService->getRelatedPosts($post->id, 3);
        
        return view('frontend.post-detail', compact('post', 'categories', 'relatedPosts'));
    }
    
    
}