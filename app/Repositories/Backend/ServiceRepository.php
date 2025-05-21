<?php

namespace App\Repositories\Backend;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Backend\ImageRepository;

class ServiceRepository extends BaseRepository
{
    public function model()
    {
        return Service::class;
    }

    public function getServices($status = null)
    {
        return $this->model->where('status', $status)
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
    }
    public function getService($slug)
    {
        return $this->model
            ->where('slug', $slug)->with('faqs')
            ->first();
    }
    public function create(array $data)
    {
        $path_name = "services";
        $service = Service::create([
        'name' => $data['name'],
        'description' => $data['description'],
        'extra_focus' => $data['extra_focus'] ?? null,
        'excerpt' => $data['excerpt'] ?? null,
        'sub_title'  => $data['sub_title'] ?? null,
        'sub_description' => $data['sub_description'] ?? null,
        'brand_title' => $data['brand_title'] ?? null,
        'brand_description' => $data['brand_description'] ?? null,
        'business_title' => $data['business_title'] ?? null,
        'personalization_title' => $data['personalization_title'] ?? null,
        'personalization_description' => $data['personalization_description'] ?? null,
                
        'status' => isset($data['status']) ? $data['status'] : 1,
        'created_by' => auth()->user()->id,
        ]);

        if(isset($data['default_image']))
        {
            $imageRepository = new ImageRepository();
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.SERVICE'));
            $image_data['resourceable_type'] = 'Service';
            $image_data['resourceable_id'] = $service->id;
            $image_data['image_url'] = $path_name . '/' .$image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }
        if(isset($data['banner_image']))
        {
            $imageRepository = new ImageRepository();
            $image_path = $imageRepository->create_file($data['banner_image'], $path_name, config('constants.LABEL_NAME.SERVICEBANNER'));
            $image_data['resourceable_type'] = 'Service';
            $image_data['resourceable_id'] = $service->id;
            $image_data['image_url'] = $path_name . '/' .$image_path;
            $image_data['is_default'] = config('constants.STATUS_FALSE');
            $image = $imageRepository->create($image_data);
        }
        

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.SERVICE'));
                $image_data['resourceable_type'] = 'Service';
                $image_data['resourceable_id'] = $service->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }

        
        // save activity in activitylog
        $activity_data['subject'] = $service;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.CREATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) create service (%s).', $model_type, auth()->user()->name, $service->name);
        saveActivityLog($activity_data);

        return $service;
    }
    public function update(Service $service, array $data)
    {
        $path_name = 'services';
        $imageRepository = new ImageRepository();

        
       $service->update([
                'name' => $data['name'] ?? $service->name,
                'description' => $data['description'] ?? $service->description,
                'extra_focus' => $data['extra_focus'] ?? $service->extra_focus,
                'excerpt' => $data['excerpt'] ?? $service->excerpt,
                'status' => isset($data['status']) ? $data['status'] : $service->status,
                'sub_title'  => $data['sub_title'] ?? $service->sub_title,
                'sub_description' => $data['sub_description'] ?? $service->sub_description,
                'brand_title' => $data['brand_title'] ?? $service->brand_title,
                'brand_description' => $data['brand_description'] ?? $service->brand_description,
                'business_title' => $data['business_title'] ?? $service->business_title,
                'personalization_title' => $data['personalization_title'] ?? $service->personalization_title,
                'personalization_description' => $data['personalization_description'] ?? $service->personalization_description,
                'updated_by' => auth()->user()->id
        ]);


        if(isset($data['default_image']) && $data['default_image'])
        {       //logger($service->default_image);
                if($service->default_image){
                $previous_default_image = $service->default_image;
                logger($previous_default_image);
                $medium_img = Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $previous_default_image->image_url);
                Storage::disk('public')->delete($path_name . '/' . $medium_img);
                Storage::disk('public')->delete($path_name . '/' . $previous_default_image->image_url);
                $imageRepository->destroy($previous_default_image);
                }
        }
        
         if(isset($data['banner_image']) && $data['banner_image'])
        {       //logger($service->default_image);
                if($service->default_banner){
                $previous_default_banner = $service->default_banner;
                logger($previous_default_image);
                $medium_img = Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.BANNER'), $previous_default_banner->image_url);
                Storage::disk('public')->delete($path_name . '/' . $medium_img);
                Storage::disk('public')->delete($path_name . '/' . $previous_default_banner->image_url);
                $imageRepository->destroy($previous_default_banner);
                }
        }

        if (isset($data['default_image'])) {
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.SERVICE'));
            logger($image_path);
            $image_data['resourceable_type'] = 'Service';
            $image_data['resourceable_id'] = $service->id;
            $image_data['image_url'] = $path_name . '/' . $image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }
        
        if(isset($data['banner_image']))
        {
            $imageRepository = new ImageRepository();
            $image_path = $imageRepository->create_file($data['banner_image'], $path_name, config('constants.LABEL_NAME.SERVICEBANNER'));
            $image_data['resourceable_type'] = 'Service';
            $image_data['resourceable_id'] = $service->id;
            $image_data['image_url'] = $path_name . '/' .$image_path;
            $image_data['is_default'] = config('constants.STATUS_FALSE');
            $image = $imageRepository->create($image_data);
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.SERVICE'));
                $image_data['resourceable_type'] = 'Service';
                $image_data['resourceable_id'] = $service->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }
        
        // save activity in activitylog
        $activity_data['subject'] = $service;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update service (%s).', $model_type, auth()->user()->name, $service->name);
        saveActivityLog($activity_data);

        return $service;

    }
    public function destroy(Service $service)
    {
        $deleted = $this->deleteById($service->id);
        if ($deleted) {
            $service->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $service;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.DELETED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) delete service(%s).', $model_type, auth()->user()->name, $service->name);
        saveActivityLog($activity_data);
    }
    public function changeStatus(Service $service)
    {
        if ($service->status == 0) {
            $service->status = 1;
        } else {
            $service->status = 0;
        }
        if ($service->isDirty()) {
            $service->updated_by = auth()->user()->id;
            $service->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $service->refresh();
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update service(%s) status.', $model_type, auth()->user()->name, $service->name);
        saveActivityLog($activity_data);
        return $service;
    }
    public function getServiceEloquent()
    {
        return Service::query()
            ->with('updatedBy')
            ->with('createdBy')
            ->with('default_image');
    }
}