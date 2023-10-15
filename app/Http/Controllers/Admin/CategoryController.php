<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\categoryRequest;
use App\Interfaces\Admin\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stevebauman\Location\Facades\Location;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $CategoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;

    }

    public function index()
    {
       return $this->categoryRepository->getAllCategories();
    }

    public function updateCheckbox(Request $request)
    {
        $checkboxValue = $request->input('checkboxValue');
        $ctegoryId = $request->input('ctegoryId');

        // Update the database based on the checkbox value
        $this->categoryRepository->updateCheckboxState($ctegoryId, $checkboxValue);

        return response()->json(['success' => true]);
    }
    public function create()
    {
        [$countries]=$this->categoryRepository->create();

        return view('admin.category.create',compact('countries'));
    }

    public function store(categoryRequest $request)
    {

        $this->categoryRepository->createCategory($request);

        return redirect()->route('categories');

    }


    public function show(Request $request): JsonResponse
    {
        $categoryId = $request->route('id');

        return response()->json([
            'data' => $this->categoryRepository->getAllCategoryById($ctegoryId)
        ]);
    }
    public function edit($ctegoryId)
    {
      return  $category = $this->categoryRepository->editCategory($ctegoryId);

    }
    public function update(categoryRequest $request)
    {
        dd(1);
        $ctegoryId = $request->route('id');
        return $this->categoryRepository->updateCategory($ctegoryId, $request);

    }

    public function destroy(Request $request): JsonResponse
    {
        $ctegoryId = $request->route('id');
        $this->categoryRepository->deleteOrder($ctegoryId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
