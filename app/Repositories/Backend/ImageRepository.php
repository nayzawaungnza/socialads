<?php

namespace App\Repositories\Backend;

use App\Models\Image;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InvertImage;
use Illuminate\Support\Str;
use Intervention\Image\Exception\NotReadableException;
use Log;

class ImageRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Image::class;
    }

    public function getImages()
    {
        $images = Image::orderBy('id', 'desc');
        if (request()->has('paginate')) {
            $images = $images->paginate(request()->get('paginate'));
        } else {
            $images = $images->get();
        }
        return $images;
    }

    public function getImage($field, $value)
    {
        return Image::where($field, $value)->get();
    }

    /**
     * @param array $data
     *
     * @return Image
     */
    public function create(array $data): Image
    {
        $image = Image::create($data);
        return $image;
    }

    public function create_file($file, $path, $model_type)
    {
        $file_name = null;
        if ($file) {
            if (gettype($file) == 'string') {
                $image_data = base64_decode($file);
                // if ($image_data === false) {
                //     throw new \Exception('Invalid Base64 data.');
                // }
                Log::info('Image data: ' . $image_data);
                $file_open = finfo_open();
                $extension = finfo_buffer($file_open, $image_data, FILEINFO_MIME_TYPE);
                
                $img = InvertImage::make($image_data);
                
                if ($model_type == config('constants.LABEL_NAME.TRANSACTION')) {
                    $file_name = uniqid() . time() . config('constants.IMAGE_FILE_NAME.MEDIUM') . str_replace("image/", "", $extension);
                    Storage::disk('public')->put($path . '/' . $file_name, $image_data);
                }

                Log::info('Extension: ' . $extension);
                Log::info('File name: ' . $file_name);
                Log::info('File path: ' . $path);
                Log::info('File img: ' . $img);
            } else {
                
                $file_name = $file->getClientOriginalName();
                $img = InvertImage::make(file_get_contents($file->path()));

                Storage::disk('public')->put($path . '/' . $file_name, file_get_contents($file->path()));
                
                if ($model_type == config('constants.LABEL_NAME.POST')) {
                    $img->resize(config('constants.IMAGE_SIZE.INSIGHTWIDTH'), config('constants.IMAGE_SIZE.INSIGHTHEIGHT'))->response();
                    Storage::disk('public')->put($path . '/' . Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $file_name), $img);
                    $img->resize(config('constants.IMAGE_SIZE.INSIGHTBANNERWIDTH'), config('constants.IMAGE_SIZE.INSIGHTBANNERHEIGHT'))->response();
                    Storage::disk('public')->put($path . '/' . Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.BANNER'), $file_name), $img);
                } 
                if ($model_type == config('constants.LABEL_NAME.POSTCATEGORY')) {
                    $img->resize(config('constants.IMAGE_SIZE.TOPICWIDTH'), config('constants.IMAGE_SIZE.TOPICHEIGHT'))->response();
                    Storage::disk('public')->put($path . '/' . Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $file_name), $img);
                } 
                
                elseif ($model_type == config('constants.LABEL_NAME.PAGE')) {
                    $img->resize(config('constants.IMAGE_SIZE.XLARGE'), config('constants.IMAGE_SIZE.MEDIUM'))->response();
                    Storage::disk('public')->put($path . '/' . Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $file_name), $img);
                } 
                elseif ($model_type == config('constants.LABEL_NAME.SERVICE')) {
                    $img->resize(config('constants.IMAGE_SIZE.XLARGE'), config('constants.IMAGE_SIZE.MEDIUM'))->response();
                    Storage::disk('public')->put($path . '/' . Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $file_name), $img);
                } 
                elseif ($model_type == config('constants.LABEL_NAME.SERVICEBANNER')) {
                    $img->resize(config('constants.IMAGE_SIZE.SERVICEBANNERWIDTH'), config('constants.IMAGE_SIZE.SERVICEBANNERHEIGHT'))->response();
                    Storage::disk('public')->put($path . '/' . Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.BANNER'), $file_name), $img);
                }
                elseif ($model_type == config('constants.LABEL_NAME.PROJECT')) {
                    $img->resize(config('constants.IMAGE_SIZE.PROJECTWIDTH'), config('constants.IMAGE_SIZE.PROJECTHEIGHT'))->response();
                    Storage::disk('public')->put($path . '/' . Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $file_name), $img);
                } 
                elseif ($model_type == config('constants.LABEL_NAME.SLIDER')) {
                    $img->resize(config('constants.IMAGE_SIZE.SLIDERWIDTH'), config('constants.IMAGE_SIZE.SLIDERHEIGHT'))->response();
                    Storage::disk('public')->put($path . '/' . Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $file_name), $img);
                } 
                elseif ($model_type == config('constants.LABEL_NAME.PARTNER')) {
                    $img->resize(config('constants.IMAGE_SIZE.PARTNER'), config('constants.IMAGE_SIZE.PARTNER'))->response();
                    Storage::disk('public')->put($path . '/' . Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $file_name), $img);
                } 
            }
        }
        //dd($file_name);
        return $file_name;
    }

    /**
     * @param Image $image
     */
    public function destroy(Image $image)
    {
        $deleted = $this->deleteById($image->id);

        if ($deleted) {
            // $image->deleted_by = auth()->user()->id;
            $image->save();
        }
    }
}