<?php

namespace App\Repositories\Backend;

use App\Models\Video;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InvertImage;
use Illuminate\Support\Str;

class VideoRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Video::class;
    }

    public function getVideos()
    {
        $videos = Video::orderBy('id', 'desc');
        if (request()->has('paginate')) {
            $videos = $videos->paginate(request()->get('paginate'));
        } else {
            $videos = $videos->get();
        }
        return $videos;
    }

    public function getVideo($field, $value)
    {
        return Video::where($field, $value)->get();
    }

    /**
     * @param array $data
     *
     * @return Video
     */
    public function create(array $data): Video
    {
        $video = Video::create($data);
        return $video;
    }

    public function create_file($file, $path, $model_type)
    {
        $file_name = null;
        
        if ($file) {
            if (is_string($file)) {
                // Handle base64 string
                $image_data = base64_decode($file);
                $finfo = finfo_open();
                $mime_type = finfo_buffer($finfo, $image_data, FILEINFO_MIME_TYPE);
                finfo_close($finfo);

                $extension = Str::after($mime_type, '/');
                $file_name = uniqid() . '_' . time() . '.' . $extension;

                // Save to S3
                Storage::disk('public')->put($path . '/' . $file_name, $image_data);

            } elseif ($file instanceof UploadedFile) {
                // Handle uploaded file
                $file_name = $file->getClientOriginalName();
                $file_content = file_get_contents($file->path());

                // Save original file to public disk
                Storage::disk('public')->put($path . '/' . $file_name, $file_content);
            }
        }
        return $file_name;

        
    }

    /**
     * @param Video $image
     */
    public function destroy(Video $video)
    {
        $deleted = $this->deleteById($video->id);

        if ($deleted) {
            // $image->deleted_by = auth()->user()->id;
            $video->save();
        }
    }
}