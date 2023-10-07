<?php

namespace App\Repositories\Admin;

use App\Http\Requests\admin\productRequest;
use App\Interfaces\Admin\productRepositoryInterface;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Modelds\Image;
use App\Models\Category;
use App\Models\Provider;
use Validator;
use Session;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts()
    {
        $products = Product::with(['provider','images','category'])->whereHas('provider', function ($q) {
            $q->where('country', '=', session()->get('country'));
        })->get();
        $totalcount =   Product::with(['provider','images','category'])->whereHas('provider', function ($q) {
            $q->where('country', '=', session()->get('country'));
        })->count();
        $pending_product =Product::where('approved_by_admin','0')->whereHas('provider', function ($q) {
            $q->where('country', '=', session()->get('country'));
            })->count();
    
        return view('admin.product.index',compact('products','totalcount','pending_product'));

    }

    public function createProduct(){
        $categories = Category::where('published','1')->whereHas('countries', function ($q) {
            $q->where('country_id', '=', session()->get('country'));
            })->get();
        $providers = Provider::where([['status','1'],['country', '=', session()->get('country')]])->get();
        return view('admin.product.create',compact('categories','providers'));
    }

    public function updateCheckboxState($ctegoryId, $checkboxValue)
    {
        $category = Category::find($ctegoryId);
        $category->published = $checkboxValue;
        $category->save();

        return $category;
    }


    public function getAllCategoryById($ctegoryId)
    {
        return Category::findOrFail($ctegoryId);
    }

    public function deleteProduct($ctegoryId)
    {
         $deleteCat=Product::destroy($ctegoryId);
            return  redirect()->route('products');
        
    }

    public function storeProduct(productRequest $request)
    {
        $validatedData = $request->validated();

        $validator = Validator::make($request->all(), $validatedData);
        $request->merge(['is_active' => 1,
        'approved_by_admin'=>'1',
        ]);
        if ($row = Product::create($request->except(["images", "prices"]))) {
            if ($request->file('images')) {
                foreach($request->images as $i){

                    $imageName = time() . '.' . $i->extension();
                    $i->move(public_path('/storage/product_images'), $imageName);
                    //$product->images()->delete();
                    $image = $row->images()->create(['title' => $request->input('title')]);
                    $image->image_name = $imageName;
                    $image->save();
                }

            }

            if($request->has('prices')){
                // dd($request->prices);
                        foreach($request->prices as $p){
                            if($p['price']){
                            $product_price = new ProductPrice();
                            $product_price->product_id = $row->id;
                            $product_price->price = $p['price'];
                            $product_price->title = $p['title'];
                            $product_price->title_ar = $p['title_ar'];
                            $product_price->save();
                        }
                        }
        }
    }
    return  redirect()->route('products');

}



    public function editProduct($productId)
    {
        $product= Product::find($productId);
        $categories = Category::where('published','1')->whereHas('countries', function ($q) {
            $q->where('country_id', '=', session()->get('country'));
            })->get();
        $providers = Provider::where([['status','1'],['country', '=', session()->get('country')]])->get();
        if (!$productId) {

            // Handle the case when the item is not found
            return redirect()->back()->with('error', 'Item not found.');
        }
        return view('admin.product.edit', compact('product','categories','providers'));
    }

    public function updateProduct($productId, productRequest $request)
    {
       
        $product = Product::find($productId);


        $validatedData = $request->validated();

        $validator = Validator::make($request->all(),  $validatedData);

        if ($product->update($request->except(['images','prices']))) {
            
                    if ($request->images) {
                        foreach($request->images as $i){
            
                        $imageName = time() . '.' . $i->extension();
            
                        $i->move(public_path('/storage/product_images'), $imageName);
                        //$product->images()->delete();
                        $image = $product->images()->create(['title' => $request->input('title')]);
                        $image->image_name = $imageName;
                         $image->save();
                    }
                }
            
            
                if($request->has('prices')){
                    // dd($request->prices);
                     ProductPrice::where('product_id',$productId)->delete();
            
                            foreach($request->prices as $p){
                                if($p['price']){
                                $product_price = new ProductPrice();
                                $product_price->product_id = $product->id;
                                $product_price->price = $p['price'];
                                $product_price->title = $p['title'];
                                $product_price->title_ar = $p['title_ar'];
                                $product_price->save();
                            }
                            }
                        }
                    


            return  redirect()->route('products');
        }

    }


}
