<?php

namespace App\Services;

use Exception;
use App\Models\Project;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Backend\ProjectRepository;
use App\Services\Interfaces\ProjectServiceInterface;

class ProjectService implements ProjectServiceInterface
{
    protected $projectRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getProjects($status = 1)
    {
        return $this->projectRepository->getProjects($status);
    }
    public function getProject($slug)
    {
         return $this->projectRepository->getProject($slug);
    }
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Project Creation Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to create page'); 
        }
        DB::commit();
        return $project;
    }
    public function update(Project $project, array $data)
    {
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->update($project,$data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Project Update Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to Project update'); 
        }
        DB::commit();
        return $project;
    }
    public function destroy(Project $project)
    {
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->destroy($project);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Project deletion Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to delete Project'); 
        }
        DB::commit();
        return $project;
    }
    public function changeStatus(Project $project)
    {
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->changeStatus($project);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Project Status Change Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to change Project status'); 
        }
        DB::commit();
        return $project;
    }
    public function getProjectEloquent()
    {
        return $this->projectRepository->getProjectEloquent();
    }
}