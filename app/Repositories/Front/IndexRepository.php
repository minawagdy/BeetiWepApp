<?php

namespace App\Repositories\Front;
use App\Interfaces\front\IndexRepositoryInterface;
use App\Models\Category;
use App\Models\Product;


class IndexRepository implements IndexRepositoryInterface
{

    public function index()
    {
        $allCategories    = Category::where('published',1)->get();
        $categories      = Category::whereHas('countries', function ($query) {
            $query->where('country_id', 63)->where('published',1);
        })->withCount(['products' => function ($query) {
        $query->where('is_active', 1)->whereHas('provider', function ($query) {
            $query->where('country', 63)->where('published',1)->where('status',1);
        });
    }])->get();
 $products = Product::where('is_active', 1)->whereHas('provider', function ($query) {
         $query->where('country', 63)->where('published',1)->where('status',1);
          })->get();
// dd($products);
        return view('front.index',compact('allCategories','categories','products'));

    }





}
