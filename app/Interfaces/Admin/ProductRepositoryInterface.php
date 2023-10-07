<?php

namespace App\Interfaces\Admin;

use App\Http\Requests\admin\produRequest;

interface ProductRepositoryInterface
{
    public function getAllProducts();
    // public function updateCheckboxProduct($productId, $checkboxValue);
    // public function deleteProduct($productId);
    public function createProduct();
    // public function storeProduct(productRequest $request);
    // public function editProduct($productId);
    // public function updateProduct($productId, prductRequest $request);
}
