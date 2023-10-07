<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\productRequest;
use App\Interfaces\Admin\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;

    }

    public function index()
    {
       return $this->productRepository->getAllProducts();
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
        return $this->productRepository->createProduct();

    }

    public function store(productRequest $request)
    {

        $this->productRepository->storeProduct($request);

        return redirect()->route('products');

    }


    public function show(Request $request): JsonResponse
    {
        $categoryId = $request->route('id');

        return response()->json([
            'data' => $this->categoryRepository->getAllCategoryById($ctegoryId)
        ]);
    }
    public function edit($productId)
    {
      return  $this->productRepository->editProduct($productId);

    }
    public function update(productRequest $request)
    {
    
        $productId = $request->route('id');
        return $this->productRepository->updateProduct($productId, $request);

    }

    public function destroy($id)
    {
        return $this->productRepository->deleteProduct($id);

    }
}
