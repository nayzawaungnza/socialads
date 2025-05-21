<?php

namespace App\Repositories\Backend;

use App\Models\ProjectCategory;
use App\Repositories\BaseRepository;
use App\Repositories\Backend\ImageRepository;

class ProjectCategoryRepository extends BaseRepository
{
    
    
    public function model()
    {
        return ProjectCategory::class;
    }

    public function getProjectCategories($status)
    {
       return $this->model->where('status', $status)
                    ->whereNull('parent_id')
                    ->with('children')->get();
    }
    
    public function getProjectCategoriesHasProject()
    {
        return $this->model
                    ->where('status', 1)
                    ->whereHas('projects', function ($query) {
                        $query->where('status', 1);
                    })
                    ->withCount(['projects' => function ($query) {
                        $query->where('status', 1);
                    }])
                    ->get();
    }
    
    public function getProjectCategory($slug)
    {
         return $this->model
            ->with('projects') // Eager load posts relationship
            ->where('slug', $slug)
            ->first();
    }
    public function create(array $data)
    {
        $projectCategory = ProjectCategory::create([
        'parent_id'=> isset($data['parent_category']) ? $data['parent_category'] : null,
        'name' => $data['name'],
        'description' => isset($data['description']) ? $data['description'] : null,
        'status' => isset($data['status']) ? $data['status'] : 1,
        'created_by' => auth()->user()->id,
        ]);

        // save activity in activitylog
        $activity_data['subject'] = $projectCategory;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.CREATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) create Project category (%s).', $model_type, auth()->user()->name, $projectCategory->name);
        saveActivityLog($activity_data);

        return $projectCategory;
    }
    public function update(ProjectCategory $projectCategory, array $data)
    {
        $projectCategory->update([
            'parent_id'=> isset($data['parent_category']) ? $data['parent_category'] : $projectCategory->parent_id,
            'name' => $data['name'] ?? $projectCategory->name,
            'description' => isset($data['description']) ? $data['description'] : $projectCategory->description,
            'status' => isset($data['status']) ? $data['status'] : $projectCategory->status,
            'updated_by' => auth()->user()->id
        ]);

        // save activity in activitylog
        $activity_data['subject'] = $projectCategory;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update Project category (%s).', $model_type, auth()->user()->name, $projectCategory->name);
        saveActivityLog($activity_data);

        return $projectCategory;
    }
    public function destroy(ProjectCategory $projectCategory)
    {
        $deleted = $this->deleteById($projectCategory->id);
        if ($deleted) {
            $projectCategory->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $projectCategory;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.DELETED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) delete user(%s).', $model_type, auth()->user()->name, $projectCategory->name);
        saveActivityLog($activity_data);
    }
    public function changeStatus(ProjectCategory $projectCategory)
    {
        if ($projectCategory->status == 0) {
            $projectCategory->status = 1;
        } else {
            $projectCategory->status = 0;
        }
        if ($projectCategory->isDirty()) {
            $projectCategory->updated_by = auth()->user()->id;
            $projectCategory->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $projectCategory->refresh();
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update Project(%s) status.', $model_type, auth()->user()->name, $projectCategory->name);
        saveActivityLog($activity_data);
        return $projectCategory;
    }
    public function getProjectCategoryEloquent()
    {
        return ProjectCategory::query()
                ->with('children');
    }
}