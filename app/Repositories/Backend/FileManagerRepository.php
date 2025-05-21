<?php

namespace App\Repositories\Backend;

use App\Models\FileManager;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InvertImage;
use Illuminate\Support\Str;

class FileManagerRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return FileManager::class;
    }

    public function getFiles()
    {
        $files = FileManager::orderBy('id', 'desc');
        if (request()->has('paginate')) {
            $files = $files->paginate(request()->get('paginate'));
        } else {
            $files = $files->get();
        }
        return $files;
    }

    public function getImage($field, $value)
    {
        return FileManager::where($field, $value)->get();
    }

    /**
     * @param array $data
     *
     * @return FileManager
     */
    public function create(array $data): FileManager
    {
        $file = FileManager::create($data);
        return $file;
    }

    public function create_file($file, $path, $model_type)
    {
        $file_name = null;
        $allowedMimeTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

        if ($file) {
            // Case 1: If the file is base64-encoded
            if (is_string($file)) {
                $file_data = base64_decode($file);
                $file_open = finfo_open();
                $mime_type = finfo_buffer($file_open, $file_data, FILEINFO_MIME_TYPE);

                if (in_array($mime_type, $allowedMimeTypes)) {
                    $extension = pathinfo($mime_type, PATHINFO_EXTENSION) ?: '';
                    $file_name = uniqid() . time() . '.' . $extension;
                    Storage::disk('public')->put("{$path}/{$file_name}", $file_data);
                }
            } 
            // Case 2: If the file is an uploaded file
            else {
                $mime_type = $file->getMimeType();

                if (in_array($mime_type, $allowedMimeTypes)) {
                    $file_name = $file->getClientOriginalName();
                    Storage::disk('public')->put("{$path}/{$file_name}", file_get_contents($file->path()));
                }
            }
        }

        return $file_name;
    }


    /**
     * @param FileManager $file
     */
    public function destroy(FileManager $file)
    {
        $deleted = $this->deleteById($file->id);

        if ($deleted) {
            // $file->deleted_by = auth()->user()->id;
            $file->save();
        }
    }
}