<?php

namespace App\Interfaces\Admin;

use App\Http\Requests\admin\categoryRequest;

interface CategoryRepositoryInterface
{
    public function getAllCategories();
    public function create();
    public function updateCheckboxState($ctegoryId, $checkboxValue);
    public function getAllCategoryById($ctegoryId);
    public function deleteCategory($ctegoryId);
    public function createCategory(categoryRequest $request);
    public function editCategory($ctegoryId);

    public function updateCategory($ctegoryId, categoryRequest $request);
}
