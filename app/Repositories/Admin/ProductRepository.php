<?php

namespace App\Repositories\Admin;

use App\Http\Requests\admin\productRequest;
use App\Interfaces\Admin\productRepositoryInterface;
use App\Models\Product;
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

    public function create(){
        return view('admin.category.create');
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

    public function deleteCategory($ctegoryId)
    {
         $deleteCat=Category::destroy($ctegoryId);
            return  redirect()->route('categories');
        
    }

    public function createCategory(categoryRequest $request)
    {
        $validatedData = $request->validated();

        $validator = Validator::make($request->all(), $validatedData);
        if ($row = Category::create($request->except(["logo", "country"]))) {
            if ($request->file('logo')) {
                $imageName = time() . '.' . $request->file('logo')->extension();
                $request->file('logo')->move(public_path('/storage/categories_images'), $imageName);
                $row->logo = $imageName;
                $row->published =1;
                $row->save();
                $country = $request->country;
                for ($i=0;$i<sizeof($country);$i++)
                {
                    CategoryCountries::create(['category_id'=>$row->id,'country_id'=>$country[$i]]);

                }

            }
        }
    }



    public function editCategory($ctegoryId)
    {
        $category= Category::find($ctegoryId);
        if (!$category) {

            // Handle the case when the item is not found
            return redirect()->back()->with('error', 'Item not found.');
        }
        return view('admin.category.edit', compact('category'));
    }

    public function updateCategory($ctegoryId, categoryRequest $request)
    {
       
        $row = Category::find($ctegoryId);


        $validatedData = $request->validated();

        $validator = Validator::make($request->all(),  $validatedData);

        if ($row->update($request->except(["logo","country"]))) {

            $input = $request->file('logo');

            if ($image = $request->file('logo')) {
                $destinationPath = public_path('/storage/categories_images');
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $row->logo = "$profileImage";
                $row->save();
            }else{
                unset($input);
            }
            // if($request->has('country')){
            //     $row->countries()->sync($request->country);
            //         }


            return  redirect()->route('categories');
        }

    }


}
