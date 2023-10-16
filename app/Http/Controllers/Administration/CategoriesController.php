<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Category;
use App\Models\Countries;
use App\Http\Controllers\Administrator;
use App\Traits\imagesTrait;
use Illuminate\Support\Facades\DB;
class CategoriesController extends Controller
{
    use imagesTrait;

public function index(){
    $rows = Category::whereHas('countries', function ($q) {
    $q->where('country_id', '=', session()->get('country')->id);
    })
    ->paginate(10);


return view('admin.categories.index',compact('rows'));
}
public function create(){

    $countries = Countries::where('is_active','1')->get();
    return view('admin.categories.create',compact('countries'));
}

public function store(Request $request){
    // dd($request->country);
        $data = $request->validate([
            'title'=>'required|max:200',
            'title_ar'=>'required|max:200',
            'description'=>'required',
            'description_ar'=>'required',
            'logo'=>'required',
            'country'=>'required',
        ]);
        $request->merge(['published' => 1 ]);
$data = $request->except(['country','logo']);
if ($request -> has('logo')) {
    // dd('here');
    $m_image = $this -> saveImages($request -> logo, public_path('/storage/categories_images'));
    $data['logo'] = $m_image;
}
DB::beginTransaction();
if($category=Category::create($data)){
    if($request->has('country')){
        $category = $category->countries()->sync($request->country);
            }

        DB::commit();
        session() -> flash('success', trans('added successfully'));

            } else{
            DB::rollback();

            session() -> flash('Error', trans('Error'));
            }
        return redirect()->back();


}

public function edit($id){
    $category = Category::findOrFail($id);
    $countries = Countries::where('is_active','1')->get();
    return view('admin.categories.edit',compact('category','countries'));
}

public function update(Request $request , $id){
    $data = $request->validate([
        'title'=>'required|max:200',
        'title_ar'=>'required|max:200',
        'description'=>'required',
        'description_ar'=>'required',
        'country'=>'required',
    ]);
    $category= Category::findOrFail($id);
    $request->merge(['published' => 1 ]);
$data = $request->except(['country','logo']);
if ($request -> has('logo')) {
// dd('here');
$m_image = $this -> saveImages($request -> logo, public_path('/storage/categories_images'));
$data['logo'] = $m_image;
}
DB::beginTransaction();
if($category->update($data)){
if($request->has('country')){
    $category = $category->countries()->sync($request->country);
        }

    DB::commit();
    session() -> flash('success', trans('updated successfully'));

        } else{
        DB::rollback();

        session() -> flash('Error', trans('Error'));
        }
    return redirect()->back();

}
public function destroy($id){
    $category=Category::findOrFail($id);
  if($category->delete($id)){
    session() -> flash('success', trans('Deleted successfully'));
  }else{
    session() -> flash('Error', trans('Error'));
  }
  return redirect()->back();
}
}
