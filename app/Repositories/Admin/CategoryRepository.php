<?php

namespace App\Repositories\Admin;

use App\Http\Requests\admin\categoryRequest;
use App\Interfaces\Admin\CategoryRepositoryInterface;
use App\Models\Category;
use App\Models\CategoryCountries;
use App\Models\Countries;
use Validator;
use Session;
class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories()
    {
        $categories      = Category::whereHas('countries', function ($query) {
            $query->where('country_id', Session::get('country'));
        })->get();
        $categoryCount = Category::whereHas('countries', function ($query) {
            $query->where('country_id', Session::get('country'));
        })->withCount('countries')->count();
        $categorytNotApprovedCount =Category::whereHas('countries', function ($query) {
            $query->where('country_id', Session::get('country'));
        })->withCount('countries')->where('published',0)->count();
        return view('admin.category.index',compact('categories','categoryCount','categorytNotApprovedCount'));

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
        Category::destroy($ctegoryId);
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
        $countries = $this->countries;
        if (!$category) {

            // Handle the case when the item is not found
            return redirect()->back()->with('error', 'Item not found.');
        }
        return view('admin.category.edit', compact('category','countries'));
    }

    public function updateCategory($ctegoryId, categoryRequest $request)
    {
        dd(1);
        $validatedData = $request->validated();

        $validator = Validator::make($request->all(),  $validatedData);

        if ($row->update($request->except(["logo"]))) {

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


            return response()->json(['isSuccessed' => true, "data" => $row, 'error' => null], 200);
        }

        return Order::whereId($ctegoryId)->update($newDetails);
    }


}
