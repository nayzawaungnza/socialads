<?php

namespace App\Services\Interfaces;

use App\Models\FileManager;

interface FileManagerServiceInterface
{
    public function getFiles();
    public function getFile($id);
    public function create(array $data);
    public function update(FileManager $file,array $data);
    public function destroy(FileManager $file);
    public function storeFilesFromZip(array $data, string $path, string $model_type);
}