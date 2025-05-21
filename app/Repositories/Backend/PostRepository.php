<?php

namespace App\Repositories\Backend;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Backend\ImageRepository;
use App\Events\PostPublishedEvent;

class PostRepository extends BaseRepository
{
    public function model()
    {
        return Post::class;
    }

    public function getPosts($status = 1)
    {
        return $this->model->where('status', $status)
                        ->with('postCategories')
                          ->orderBy('created_at', 'desc')
                          ->paginate(4);
    }
    public function getRecentPosts($limit = 5)
    {
        return $this->model->where('status', 1)
                ->with('postCategories')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
    }
    public function getFeaturePosts($is_featured)
    {
        return $this->model->where('is_featured', $is_featured)->get();
    }
    public function getPost($slug)
    {
        return $this->model
            ->with('postCategories') // Eager load posts relationship
            ->where('slug', $slug)
            ->first();
    }
    public function getRelatedPosts($currentPostId, $limit)
    {
        $currentPost = $this->model->with('postCategories')->findOrFail($currentPostId);
        $categoryIds = $currentPost->postCategories->pluck('id')->toArray();
        
        if (empty($categoryIds)) {
            return collect();
        }
        
        return $this->model->withCount(['postCategories as shared_categories' => function($query) use ($categoryIds) {
                $query->whereIn('post_categories.id', $categoryIds);
            }])
            ->whereHas('postCategories', function($query) use ($categoryIds) {
                $query->whereIn('post_categories.id', $categoryIds);
            })
            ->where('id', '!=', $currentPostId)
            ->with('postCategories')
            ->orderBy('shared_categories', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function create(array $data)
    {
        $path_name = "posts";
        $post = Post::create([
        //'post_category_id'=> isset($data['post_category']) ? $data['post_category'] : null,
        'name' => $data['name'],
        'description' => $data['description'],
        'excerpt' => $data['excerpt'],
        'status' => isset($data['status']) ? $data['status'] : 1,
        'is_featured' => isset($data['is_featured']) ? (bool) $data['is_featured'] : false,
        'created_by' => auth()->user()->id,
        ]);

        if (!empty($data['post_category'])) {
            $post->postCategories()->sync($data['post_category']);
        }

        if(isset($data['default_image']))
        {
            $imageRepository = new ImageRepository();
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.POST'));
            $image_data['resourceable_type'] = 'Post';
            $image_data['resourceable_id'] = $post->id;
            $image_data['image_url'] = $path_name . '/' .$image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.POST'));
                $image_data['resourceable_type'] = 'Post';
                $image_data['resourceable_id'] = $post->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }

        event(new PostPublishedEvent($post));
        
        // save activity in activitylog
        $activity_data['subject'] = $post;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.CREATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) create User (%s).', $model_type, auth()->user()->name, $post->name);
        saveActivityLog($activity_data);

        return $post;
    }
    public function update(Post $post, array $data)
    {
        $path_name = 'posts';
        $imageRepository = new ImageRepository();

        
       $post->update([
                //'post_category_id'=> isset($data['post_category']) ? $data['post_category'] : $post->post_category_id,
                'name' => $data['name'] ?? $post->name,
                'description' => $data['description'] ?? $post->description,
                'excerpt' => $data['excerpt'] ?? $post->excerpt,
                'status' => isset($data['status']) ? $data['status'] : $post->status,
                'is_featured' => isset($data['is_featured']) ? (bool) $data['is_featured'] : $post->is_featured,
                'updated_by' => auth()->user()->id
        ]);

        if (!empty($data['post_category'])) {
            $post->postCategories()->sync($data['post_category']);
        }

        if(isset($data['default_image']) && $data['default_image'])
        {       logger($post->default_image);
                if($post->default_image){
                $previous_default_image = $post->default_image;
                logger($previous_default_image);
                $medium_img = Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $previous_default_image->image_url);
                $banner_img = Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.BANNER'), $previous_default_image->image_url);
                Storage::disk('public')->delete($path_name . '/' . $medium_img);
                Storage::disk('public')->delete($path_name . '/' . $banner_img);
                Storage::disk('public')->delete($path_name . '/' . $previous_default_image->image_url);
                $imageRepository->destroy($previous_default_image);
                }
        }

        if (isset($data['default_image'])) {
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.POST'));
            logger($image_path);
            $image_data['resourceable_type'] = 'Post';
            $image_data['resourceable_id'] = $post->id;
            $image_data['image_url'] = $path_name . '/' . $image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.POST'));
                $image_data['resourceable_type'] = 'Post';
                $image_data['resourceable_id'] = $post->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }
        
        // save activity in activitylog
        $activity_data['subject'] = $post;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) create User (%s).', $model_type, auth()->user()->name, $post->name);
        saveActivityLog($activity_data);

        return $post;

    }
    public function destroy(Post $post)
    {
        $post->postCategories()->detach();
        $deleted = $this->deleteById($post->id);
        if ($deleted) {
            $post->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $post;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.DELETED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) delete user(%s).', $model_type, auth()->user()->name, $post->name);
        saveActivityLog($activity_data);
    }
    public function changeStatus(Post $post)
    {
        if ($post->status == 0) {
            $post->status = 1;
        } else {
            $post->status = 0;
        }
        if ($post->isDirty()) {
            $post->updated_by = auth()->user()->id;
            $post->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $post->refresh();
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update Post(%s) status.', $model_type, auth()->user()->name, $post->name);
        saveActivityLog($activity_data);
        return $post;
    }
    public function getPostEloquent()
    {
        return Post::query()
            ->with('postCategories')
            ->with('updatedBy')
            ->with('createdBy')
            ->with('default_image');
    }
}