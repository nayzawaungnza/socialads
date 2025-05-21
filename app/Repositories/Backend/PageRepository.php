<?php

namespace App\Repositories\Backend;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Backend\ImageRepository;

class PageRepository extends BaseRepository
{
    public function model()
    {
        return Page::class;
    }

     public function getPages($status = 1)
    {
        return $this->model->where('status', $status)
                            ->orderBy('created_at', 'desc')
                            ->get();
    }
    public function getPage($slug)
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }
    public function create(array $data)
    {
        $path_name = "pages";
        $page = Page::create([
        'name' => $data['name'],
        'description' => $data['description'],
        'excerpt' => $data['excerpt'],
        'status' => isset($data['status']) ? $data['status'] : 1,
        'created_by' => auth()->user()->id,
        ]);

        if(isset($data['default_image']))
        {
            $imageRepository = new ImageRepository();
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.PAGE'));
            $image_data['resourceable_type'] = 'Page';
            $image_data['resourceable_id'] = $page->id;
            $image_data['image_url'] = $path_name . '/' .$image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.PAGE'));
                $image_data['resourceable_type'] = 'Page';
                $image_data['resourceable_id'] = $page->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }

        
        // save activity in activitylog
        $activity_data['subject'] = $page;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.CREATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) create page (%s).', $model_type, auth()->user()->name, $page->name);
        saveActivityLog($activity_data);

        return $page;
    }
    public function update(Page $page, array $data)
    {
        $path_name = 'pages';
        $imageRepository = new ImageRepository();

        
       $page->update([
                'name' => $data['name'] ?? $page->name,
                'description' => $data['description'] ?? $page->description,
                'excerpt' => $data['excerpt'] ?? $page->excerpt,
                'status' => isset($data['status']) ? $data['status'] : $page->status,
                'updated_by' => auth()->user()->id
        ]);


        if(isset($data['default_image']) && $data['default_image'])
        {       logger($page->default_image);
                if($page->default_image){
                $previous_default_image = $page->default_image;
                logger($previous_default_image);
                $medium_img = Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $previous_default_image->image_url);
                Storage::disk('public')->delete($path_name . '/' . $medium_img);
                Storage::disk('public')->delete($path_name . '/' . $previous_default_image->image_url);
                $imageRepository->destroy($previous_default_image);
                }
        }

        if (isset($data['default_image'])) {
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.PAGE'));
            logger($image_path);
            $image_data['resourceable_type'] = 'Page';
            $image_data['resourceable_id'] = $page->id;
            $image_data['image_url'] = $path_name . '/' . $image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.PAGE'));
                $image_data['resourceable_type'] = 'Page';
                $image_data['resourceable_id'] = $page->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }
        
        // save activity in activitylog
        $activity_data['subject'] = $page;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update page (%s).', $model_type, auth()->user()->name, $page->name);
        saveActivityLog($activity_data);

        return $page;

    }
    public function destroy(Page $page)
    {
        $deleted = $this->deleteById($page->id);
        if ($deleted) {
            $page->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $page;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.DELETED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) delete page(%s).', $model_type, auth()->user()->name, $page->name);
        saveActivityLog($activity_data);
    }
    public function changeStatus(Page $page)
    {
        if ($page->status == 0) {
            $page->status = 1;
        } else {
            $page->status = 0;
        }
        if ($page->isDirty()) {
            $page->updated_by = auth()->user()->id;
            $page->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $page->refresh();
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update page(%s) status.', $model_type, auth()->user()->name, $page->name);
        saveActivityLog($activity_data);
        return $page;
    }
    public function getPageEloquent()
    {
        return Page::query()
            ->with('updatedBy')
            ->with('createdBy')
            ->with('default_image');
    }
}