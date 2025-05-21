<?php

namespace App\Repositories\Backend;

use App\Models\Partner;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Backend\ImageRepository;

class PartnerRepository extends BaseRepository
{
    public function model()
    {
        return Partner::class;
    }

   
     public function getPartners($status = 1)
    {
        return $this->model->where('status', $status)
                            ->orderBy('created_at', 'desc')
                            ->get();
    }
    public function getPartner($id)
    {

    }
    public function create(array $data)
    {
        $path_name = "partners";
        $partner = Partner::create([
        'name' => $data['name'],
        'description' => $data['description'],
        'url' => $data['url'] ?? null,
        //'excerpt' => $data['excerpt'],
        'status' => isset($data['status']) ? $data['status'] : 1,
        'created_by' => auth()->user()->id,
        ]);

        if(isset($data['default_image']))
        {
            $imageRepository = new ImageRepository();
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.PARTNER'));
            $image_data['resourceable_type'] = 'Partner';
            $image_data['resourceable_id'] = $partner->id;
            $image_data['image_url'] = $path_name . '/' .$image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.PARTNER'));
                $image_data['resourceable_type'] = 'Partner';
                $image_data['resourceable_id'] = $partner->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }

        
        // save activity in activitylog
        $activity_data['subject'] = $partner;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.CREATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.PARTNER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) create Partner (%s).', $model_type, auth()->user()->name, $partner->name);
        saveActivityLog($activity_data);

        return $partner;
    }
    public function update(Partner $partner, array $data)
    {
        $path_name = 'partners';
        $imageRepository = new ImageRepository();

        
       $partner->update([
                'name' => $data['name'] ?? $partner->name,
                'description' => $data['description'] ?? $partner->description,
                //'excerpt' => $data['excerpt'] ?? $partner->excerpt,
                'url' => $data['url'] ?? $partner->url,
                'status' => isset($data['status']) ? $data['status'] : $partner->status,
                'updated_by' => auth()->user()->id
        ]);


        if(isset($data['default_image']) && $data['default_image'])
        {       logger($partner->default_image);
                if($partner->default_image){
                $previous_default_image = $partner->default_image;
                logger($previous_default_image);
                $medium_img = Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $previous_default_image->image_url);
                Storage::disk('public')->delete($path_name . '/' . $medium_img);
                Storage::disk('public')->delete($path_name . '/' . $previous_default_image->image_url);
                $imageRepository->destroy($previous_default_image);
                }
        }

        if (isset($data['default_image'])) {
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.PARTNER'));
            logger($image_path);
            $image_data['resourceable_type'] = 'Partner';
            $image_data['resourceable_id'] = $partner->id;
            $image_data['image_url'] = $path_name . '/' . $image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.PARTNER'));
                $image_data['resourceable_type'] = 'Partner';
                $image_data['resourceable_id'] = $partner->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }
        
        // save activity in activitylog
        $activity_data['subject'] = $partner;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.PARTNER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update Partner (%s).', $model_type, auth()->user()->name, $partner->name);
        saveActivityLog($activity_data);

        return $partner;

    }
    public function destroy(Partner $partner)
    {
        $deleted = $this->deleteById($partner->id);
        if ($deleted) {
            $partner->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $partner;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.DELETED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.PARTNER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) delete Partner (%s).', $model_type, auth()->user()->name, $partner->name);
        saveActivityLog($activity_data);
    }
    public function changeStatus(Partner $partner)
    {
        if ($partner->status == 0) {
            $partner->status = 1;
        } else {
            $partner->status = 0;
        }
        if ($partner->isDirty()) {
            $partner->updated_by = auth()->user()->id;
            $partner->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $partner->refresh();
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.PARTNER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update partner (%s) status.', $model_type, auth()->user()->name, $partner->name);
        saveActivityLog($activity_data);
        return $partner;
    }
    public function getPartnerEloquent()
    {
        return Partner::query()
            ->with('updatedBy')
            ->with('createdBy')
            ->with('default_image');
    }
}