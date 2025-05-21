<?php

namespace App\Services\Interfaces;

use App\Models\PostCategory;

interface PostCategoryServiceInterface
{
    public function getPostCategories($request, $status = null);
    public function getPostCategoriesHasPost($status = null);
    public function getPostCategory($slug);
    public function create(array $request);
    public function update(PostCategory $postCategory, array $request);
    public function destroy(PostCategory $postCategory);
    public function changeStatus(PostCategory $postCategory);
    public function getPostCategoryEloquent();
    public function getTopicPostCategories($topics = 1);
}