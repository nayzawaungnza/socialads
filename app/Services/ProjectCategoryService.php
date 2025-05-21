<?php

namespace App\Services;

use Exception;
use App\Models\ProjectCategory;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Backend\ProjectCategoryRepository;
use App\Services\Interfaces\ProjectCategoryServiceInterface;

class ProjectCategoryService implements ProjectCategoryServiceInterface
{
    protected $projectCategoryRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(ProjectCategoryRepository $projectCategoryRepository)
    {
        $this->projectCategoryRepository = $projectCategoryRepository;
    }

    public function getProjectCategories($status = 1)
    {
        return $this->projectCategoryRepository->getProjectCategories($status);
    }
    public function getProjectCategoriesHasProject()
    {
        return $this->projectCategoryRepository->getProjectCategoriesHasProject();
    }
    
    public function getProjectCategory($slug)
    {
        return $this->projectCategoryRepository->getProjectCategory($slug);
    }
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $projectCategory = $this->projectCategoryRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Project Creation Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to create Project'); 
        }
        DB::commit();
        return $projectCategory;
    }
    public function update(ProjectCategory $projectCategory, array $data)
    {
        DB::beginTransaction();
        try {
            $projectCategory = $this->projectCategoryRepository->update($projectCategory,$data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Project category Update Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to Project category update'); 
        }
        DB::commit();
        return $projectCategory;
    }
    public function destroy(ProjectCategory $projectCategory)
    {
        DB::beginTransaction();
        try {
            $projectCategory = $this->projectCategoryRepository->destroy($projectCategory);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Project category deletion Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to delete Project category'); 
        }
        DB::commit();
        return $projectCategory;
    }
    public function changeStatus(ProjectCategory $projectCategory)
    {
        DB::beginTransaction();
        try {
            $projectCategory = $this->projectCategoryRepository->changeStatus($projectCategory);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Project Status Change Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to change Project status'); 
        }
        DB::commit();
        return $projectCategory;
    }
    public function getProjectCategoryEloquent()
    {
        return $this->projectCategoryRepository->getProjectCategoryEloquent();
    }
}