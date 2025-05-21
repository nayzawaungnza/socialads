<?php

namespace App\Services\Interfaces;

use App\Models\ProjectCategory;

interface ProjectCategoryServiceInterface
{
    public function getProjectCategories($status = null);
    public function getProjectCategoriesHasProject();
    public function getProjectCategory($slug);
    public function create(array $request);
    public function update(ProjectCategory $projectCategory, array $request);
    public function destroy(ProjectCategory $projectCategory);
    public function changeStatus(ProjectCategory $projectCategory);
    public function getProjectCategoryEloquent();
}