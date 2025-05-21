<?php

namespace App\Services\Interfaces;

use App\Models\Video;

interface VideoServiceInterface
{
    public function getVideos();
    public function getVideo($id);
    public function create(array $data);
    public function update(Video $video,array $data);
    public function destroy(Video $video);
    public function storeVideosFromZip(array $data, string $path, string $model_type);
}