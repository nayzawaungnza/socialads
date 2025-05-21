<?php

namespace App\Services;

use Exception;
use App\Models\Post;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Backend\PostRepository;
use App\Services\Interfaces\PostServiceInterface;

class PostService implements PostServiceInterface
{
    protected $postRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPosts($status = 1)
    {
        return $this->postRepository->getPosts( $status);
    }
    public function getRecentPosts($limit = 5)
    {
        return $this->postRepository->getRecentPosts($limit);
    }
    public function getFeaturePosts($is_featured = 1)
    {
         return $this->postRepository->getFeaturePosts($is_featured);
    }
    public function getPost($slug)
    {
        return $this->postRepository->getPost($slug);
    }
    public function getRelatedPosts($currentPostId, $limit = 3)
    {
        return $this->postRepository->getRelatedPosts($currentPostId, $limit);
    }
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $post = $this->postRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Post Creation Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to create post'); 
        }
        DB::commit();
        return $post;
    }
    public function update(Post $post, array $data)
    {
        DB::beginTransaction();
        try {
            $post = $this->postRepository->update($post,$data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Post Update Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to post update'); 
        }
        DB::commit();
        return $post;
    }
    public function destroy(Post $post)
    {
        DB::beginTransaction();
        try {
            $post = $this->postRepository->destroy($post);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Post deletion Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to delete post'); 
        }
        DB::commit();
        return $post;
    }
    public function changeStatus(Post $post)
    {
        DB::beginTransaction();
        try {
            $post = $this->postRepository->changeStatus($post);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Post Status Change Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to change post status'); 
        }
        DB::commit();
        return $post;
    }
    public function getPostEloquent()
    {
        return $this->postRepository->getPostEloquent();
    }
}