<?php

namespace App\Repositories\Backend;

use App\Enums\StageStatusEnum;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Backend\ImageRepository;

class ProjectRepository extends BaseRepository
{
    public function model()
    {
        return Project::class;
    }

    public function getProjects( $status = 1)
    {
    return $this->model->where('status', $status)
                        ->with('categories')
                          ->orderBy('created_at', 'desc')
                          ->get();
    }
    public function getProject($slug)
    {
         return $this->model
            ->with('categories') // Eager load posts relationship
            ->where('slug', $slug)
            ->first();
    }
    public function create(array $data)
    {
        $path_name = "projects";
        $project = Project::create([
        'name' => $data['name'],
        'description' => $data['description'],
        'excerpt' => $data['excerpt'],
        'goal' => isset($data['goal']) ? $data['goal'] : null, 
        'strategy' => isset($data['strategy']) ? $data['strategy'] : null, 
        'result' => isset($data['result']) ? $data['result'] : null,
        'industry' => isset($data['industry']) ? $data['industry'] : null,
        'status' => isset($data['status']) ? $data['status'] : 1,
        'client_id' => isset($data['client_id']) ? $data['client_id'] : null,
        'stage' => isset($data['stage']) ? $data['stage'] : null,
        'date' => isset($data['date']) ? $data['date'] : null,
        'duration' => isset($data['duration']) ? $data['duration'] : null,
        'created_by' => auth()->user()->id,
        ]);
        
         if (!empty($data['project_category'])) {
            $project->categories()->sync($data['project_category']);
        }

        if(isset($data['default_image']))
        {
            $imageRepository = new ImageRepository();
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.PAGE'));
            $image_data['resourceable_type'] = 'Project';
            $image_data['resourceable_id'] = $project->id;
            $image_data['image_url'] = $path_name . '/' .$image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.PAGE'));
                $image_data['resourceable_type'] = 'Project';
                $image_data['resourceable_id'] = $project->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }

        
        // save activity in activitylog
        $activity_data['subject'] = $project;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.CREATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.PROJECT'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) create project (%s).', $model_type, auth()->user()->name, $project->name);
        saveActivityLog($activity_data);

        return $project;
    }
    public function update(Project $project, array $data)
    {
        $path_name = 'projects';
        $imageRepository = new ImageRepository();
        logger($data);
        
       $project->update([
                'name' => $data['name'] ?? $project->name,
                'description' => $data['description'] ?? $project->description,
                'excerpt' => $data['excerpt'] ?? $project->excerpt,
                'goal' => isset($data['goal']) ? $data['goal'] : $project->goal, 
                'strategy' => isset($data['strategy']) ? $data['strategy'] : $project->strategy, 
                'result' => isset($data['result']) ? $data['result'] : $project->result,
                'industry' => isset($data['industry']) ? $data['industry'] : $project->industry,
                'status' => isset($data['status']) ? $data['status'] : $project->status,
                'client_id' => isset($data['client_id']) ? $data['client_id'] : ($project->client_id ?? null),
                'stage' => isset($data['stage']) ? $data['stage'] : $project->stage,
                'date' => isset($data['date']) ? $data['date'] : $project->date,
                'duration' => isset($data['duration']) ? $data['duration'] : $project->duration,
                'updated_by' => auth()->user()->id
        ]);

         if (!empty($data['project_category'])) {
            $project->categories()->sync($data['project_category']);
        }

        if(isset($data['default_image']) && $data['default_image'])
        {       logger($project->default_image);
                if($project->default_image){
                $previous_default_image = $project->default_image;
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
            $image_data['resourceable_type'] = 'Project';
            $image_data['resourceable_id'] = $project->id;
            $image_data['image_url'] = $path_name . '/' . $image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.PAGE'));
                $image_data['resourceable_type'] = 'Project';
                $image_data['resourceable_id'] = $project->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }
        
        // save activity in activitylog
        $activity_data['subject'] = $project;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.PROJECT'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update project (%s).', $model_type, auth()->user()->name, $project->name);
        saveActivityLog($activity_data);

        return $project;
    }
    public function destroy(Project $project)
    {
        $project->categories()->detach();
        $deleted = $this->deleteById($project->id);
        if ($deleted) {
            $project->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $project;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.DELETED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.PROJECT'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) delete project (%s).', $model_type, auth()->user()->name, $project->name);
        saveActivityLog($activity_data);
    }
    public function changeStatus(Project $project)
    {
        if ($project->status == 0) {
            $project->status = 1;
        } else {
            $project->status = 0;
        }
        if ($project->isDirty()) {
            $project->updated_by = auth()->user()->id;
            $project->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $project->refresh();
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.PROJECT'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update project (%s) status.', $model_type, auth()->user()->name, $project->name);
        saveActivityLog($activity_data);
        return $project;
    }
    public function getProjectEloquent()
    {
        return Project::query()
            ->with('client')
            ->with('updatedBy')
            ->with('createdBy')
            ->with('default_image');
    }
}