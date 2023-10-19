<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Interfaces\Front\IndexRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Product;

class IndexController extends Controller
{
    private IndexRepositoryInterface $indexRepository;

    public function __construct(IndexRepositoryInterface $indexRepository)
    {
        $this->indexRepository = $indexRepository;

    }

    public function index()
    {

        return $this->indexRepository->index();
    }

    public function getCategory($category)
    {
        $category = 1;
        // $request->input('category');
        $products = Product::where('category_id', $category)->get();
        return response()->json(['products' => $products]);
    }
}
