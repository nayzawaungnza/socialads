<?php

namespace App\Services;

use Exception;
use App\Models\PostCategory;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Backend\PostCategoryRepository;
use App\Services\Interfaces\PostCategoryServiceInterface;

class PostCategoryService implements PostCategoryServiceInterface
{
    protected $postCategoryRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(PostCategoryRepository $postCategoryRepository)
    {
        $this->postCategoryRepository = $postCategoryRepository;
    }

    public function getPostCategories($request, $status = 1)
    {
        return $this->postCategoryRepository->getPostCategories($request, $status);
    }
    public function getPostCategoriesHasPost($status = 1)
    {
        return $this->postCategoryRepository->getPostCategoriesHasPost();
    }
    public function getTopicPostCategories($topics = 1)
    {
        return $this->postCategoryRepository->getTopicPostCategories($topics);
    }
    public function getPostCategory($slug)
    {
        return $this->postCategoryRepository->getPostCategory($slug);
    }
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $postCategory = $this->postCategoryRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Post Creation Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to create post'); 
        }
        DB::commit();
        return $postCategory;
    }
    public function update(PostCategory $postCategory, array $data)
    {
        DB::beginTransaction();
        try {
            $postCategory = $this->postCategoryRepository->update($postCategory,$data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Post category Update Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to post category update'); 
        }
        DB::commit();
        return $postCategory;
    }
    public function destroy(PostCategory $postCategory)
    {
        DB::beginTransaction();
        try {
            $postCategory = $this->postCategoryRepository->destroy($postCategory);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Post category deletion Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to delete post category'); 
        }
        DB::commit();
        return $postCategory;
    }
    public function changeStatus(PostCategory $postCategory)
    {
        DB::beginTransaction();
        try {
            $postCategory = $this->postCategoryRepository->changeStatus($postCategory);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Post Status Change Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to change post status'); 
        }
        DB::commit();
        return $postCategory;
    }
    public function getPostCategoryEloquent()
    {
        return $this->postCategoryRepository->getPostCategoryEloquent();
    }
}