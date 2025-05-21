<?php

namespace App\Repositories\Backend;

use App\Models\PostCategory;
use App\Repositories\BaseRepository;
use App\Repositories\Backend\ImageRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PostCategoryRepository extends BaseRepository
{
    public function model()
    {
        return PostCategory::class;
    }

    public function getPostCategories($request, $status)
    {
       return $this->model->where('status', $status)
                    ->whereNull('parent_id')
                    ->with('children')->get();
    }
    public function getPostCategoriesHasPost($status = 1)
    {
        return $this->model
                    ->where('status', $status)
                    ->whereHas('posts', function ($query) {
                        $query->where('status', 1);
                    })
                    ->withCount(['posts' => function ($query) {
                        $query->where('status', 1);
                    }])
                    ->get();
    }
    public function getTopicPostCategories($topics)
    {
        return $this->model->where('topics', $topics)->get();
                    
    }
    
    public function getPostCategory($slug)
    {
       return $this->model
            ->with('posts') // Eager load posts relationship
            ->where('slug', $slug)
            ->first();
    }
    public function create(array $data)
    {
         $path_name = "postcategory";
         
        $postCategory = PostCategory::create([
        'parent_id'=> isset($data['parent_category']) ? $data['parent_category'] : null,
        'name' => $data['name'],
        'description' => isset($data['description']) ? $data['description'] : null,
        'status' => isset($data['status']) ? $data['status'] : 1,
        'topics' => isset($data['topics']) ? (bool) $data['topics'] : false,
        'created_by' => auth()->user()->id,
        ]);
        
        if(isset($data['default_image']))
        {
            $imageRepository = new ImageRepository();
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.POSTCATEGORY'));
            $image_data['resourceable_type'] = 'PostCategory';
            $image_data['resourceable_id'] = $postCategory->id;
            $image_data['image_url'] = $path_name . '/' .$image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }
        

        // save activity in activitylog
        $activity_data['subject'] = $postCategory;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.CREATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) create post category (%s).', $model_type, auth()->user()->name, $postCategory->name);
        saveActivityLog($activity_data);

        return $postCategory;
    }
    public function update(PostCategory $postCategory, array $data)
    {
        $path_name = 'postcategory';
        $imageRepository = new ImageRepository();
        
        $postCategory->update([
            'parent_id'=> isset($data['parent_category']) ? $data['parent_category'] : $postCategory->parent_id,
            'name' => $data['name'] ?? $postCategory->name,
            'description' => isset($data['description']) ? $data['description'] : $postCategory->description,
            'status' => isset($data['status']) ? $data['status'] : $postCategory->status,
            'topics' => isset($data['topics']) ? (bool) $data['topics'] : $postCategory->topics,
            'updated_by' => auth()->user()->id
        ]);
        
        if(isset($data['default_image']) && $data['default_image'])
        {       logger($postCategory->default_image);
                if($postCategory->default_image){
                $previous_default_image = $post->default_image;
                logger($previous_default_image);
                $medium_img = Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $previous_default_image->image_url);
                Storage::disk('public')->delete($path_name . '/' . $medium_img);
                Storage::disk('public')->delete($path_name . '/' . $previous_default_image->image_url);
                $imageRepository->destroy($previous_default_image);
                }
        }

        if (isset($data['default_image'])) {
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.POSTCATEGORY'));
            logger($image_path);
            $image_data['resourceable_type'] = 'PostCategory';
            $image_data['resourceable_id'] = $postCategory->id;
            $image_data['image_url'] = $path_name . '/' . $image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }
        

        // save activity in activitylog
        $activity_data['subject'] = $postCategory;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update Post category (%s).', $model_type, auth()->user()->name, $postCategory->name);
        saveActivityLog($activity_data);

        return $postCategory;
    }
    public function destroy(PostCategory $postCategory)
    {
        $deleted = $this->deleteById($postCategory->id);
        if ($deleted) {
            $postCategory->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $postCategory;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.DELETED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) delete user(%s).', $model_type, auth()->user()->name, $postCategory->name);
        saveActivityLog($activity_data);
    }
    public function changeStatus(PostCategory $postCategory)
    {
        if ($postCategory->status == 0) {
            $postCategory->status = 1;
        } else {
            $postCategory->status = 0;
        }
        if ($postCategory->isDirty()) {
            $postCategory->updated_by = auth()->user()->id;
            $postCategory->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $postCategory->refresh();
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update Post(%s) status.', $model_type, auth()->user()->name, $postCategory->name);
        saveActivityLog($activity_data);
        return $postCategory;
    }
    public function getPostCategoryEloquent()
    {
        return PostCategory::query()
                ->with('children');
    }
}