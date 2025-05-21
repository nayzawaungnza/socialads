<?php

namespace App\Repositories\Backend;

use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Backend\ImageRepository;

class SliderRepository extends BaseRepository
{
    public function model()
    {
        return Slider::class;
    }

    public function getSliders($request, $status = null)
    {
        return $this->model->where('status', $status)
                          ->orderBy('created_at', 'desc')
                          ->get();
    }
    public function getSlider($id)
    {

    }
    public function create(array $data)
    {
        $path_name = "sliders";
        $slider = Slider::create([
        'name' => $data['name'],
        'subname' => $data['subname'],
        'description' => $data['description'],
        'button_text' => $data['button_text'] ?? null,
        'button_url' => $data['button_url'] ?? null,
        'excerpt' => $data['excerpt'],
        'status' => isset($data['status']) ? $data['status'] : 1,
        'created_by' => auth()->user()->id,
        ]);

        if(isset($data['default_image']))
        {
            $imageRepository = new ImageRepository();
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.SLIDER'));
            $image_data['resourceable_type'] = 'Slider';
            $image_data['resourceable_id'] = $slider->id;
            $image_data['image_url'] = $path_name . '/' .$image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.SLIDER'));
                $image_data['resourceable_type'] = 'Slider';
                $image_data['resourceable_id'] = $slider->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }

        
        // save activity in activitylog
        $activity_data['subject'] = $slider;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.CREATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) create slider (%s).', $model_type, auth()->user()->name, $slider->name);
        saveActivityLog($activity_data);

        return $slider;
    }
    public function update(Slider $slider, array $data)
    {
        $path_name = 'sliders';
        $imageRepository = new ImageRepository();

        
       $slider->update([
                'name' => $data['name'] ?? $slider->name,
                'subname' => $data['subname'] ?? $slider->subname,
                'description' => $data['description'] ?? $slider->description,
                'excerpt' => $data['excerpt'] ?? $slider->excerpt,
                'button_text' => $data['button_text'] ?? $slider->button_text,
                'button_url' => $data['button_url'] ?? $slider->button_url,
                'status' => isset($data['status']) ? $data['status'] : $slider->status,
                'updated_by' => auth()->user()->id
        ]);


        if(isset($data['default_image']) && $data['default_image'])
        {       logger($slider->default_image);
                if($slider->default_image){
                $previous_default_image = $slider->default_image;
                logger($previous_default_image);
                $medium_img = Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $previous_default_image->image_url);
                Storage::disk('public')->delete($path_name . '/' . $medium_img);
                Storage::disk('public')->delete($path_name . '/' . $previous_default_image->image_url);
                $imageRepository->destroy($previous_default_image);
                }
        }

        if (isset($data['default_image'])) {
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.SLIDER'));
            logger($image_path);
            $image_data['resourceable_type'] = 'Slider';
            $image_data['resourceable_id'] = $slider->id;
            $image_data['image_url'] = $path_name . '/' . $image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.SLIDER'));
                $image_data['resourceable_type'] = 'Slider';
                $image_data['resourceable_id'] = $slider->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }
        
        // save activity in activitylog
        $activity_data['subject'] = $slider;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update slider (%s).', $model_type, auth()->user()->name, $slider->name);
        saveActivityLog($activity_data);

        return $slider;

    }
    public function destroy(Slider $slider)
    {
        $deleted = $this->deleteById($slider->id);
        if ($deleted) {
            $slider->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $slider;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.DELETED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) delete slider (%s).', $model_type, auth()->user()->name, $slider->name);
        saveActivityLog($activity_data);
    }
    public function changeStatus(Slider $slider)
    {
        if ($slider->status == 0) {
            $slider->status = 1;
        } else {
            $slider->status = 0;
        }
        if ($slider->isDirty()) {
            $slider->updated_by = auth()->user()->id;
            $slider->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $slider->refresh();
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update slider (%s) status.', $model_type, auth()->user()->name, $slider->name);
        saveActivityLog($activity_data);
        return $slider;
    }
    public function getSliderEloquent()
    {
        return Slider::query()
            ->with('updatedBy')
            ->with('createdBy')
            ->with('default_image');
    }
}