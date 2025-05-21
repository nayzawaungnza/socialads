<?php

namespace App\Services\Interfaces;

use App\Models\Post;

interface PostServiceInterface
{
    public function getPosts( $status = 1);
    public function getRecentPosts($limit = 5);
    public function getPost($slug);
    public function create(array $request);
    public function update(Post $post, array $request);
    public function destroy(Post $post);
    public function changeStatus(Post $post);
    public function getPostEloquent();
    public function getFeaturePosts($is_featured = 1);
    public function getRelatedPosts($currentPostId, $limit = 3);
}