<?php

namespace App\Repositories\Admin;

use App\Http\Requests\admin\productiveFamilyRequest;
use App\Interfaces\Admin\ProductiveFamilyRepositoryInterface;
use App\Models\Provider;
use Validator;

class ProductiveFamilyRepository implements ProductiveFamilyRepositoryInterface
{

    public function getAllProducttiveFamily()
    {
        $country=63;

        $rows=Provider::with(['images','categories','statusObj'])->whereHas('country', function ($query) use ($country) {
                $query->where('country', $country);
            })->get();

        return view('admin.productive-families.index',compact('rows'));

    }
    public function  createProductiveFamily(){
        return view('admin.productive-families.create');

    }
    public function storeProductiveFamily(productiveFamilyRequest $request)
    {

        $validatedData = $request->validated();

        Validator::make($request->all(), $validatedData);

        if ($row = Provider::create($request->except([]))) {
            if ($request->profile_img) {

                $imageName = time() . '.' . $request->profile_img->extension();
                $request->profile_img->move(public_path('/storage/profile_images'), $imageName);
                $row->profile_img = $imageName;
                $row->save();
            }
            if ($request->categories) {
                foreach ($request->categories as $category) {
                    \App\Models\ProviderCategory::firstOrCreate(["provider_id" => $row->id, 'category_id' => $category]);
                }
            }
            $row->status = 1;
            $zone = Zone($request->lat, $request->lng);
            $country = Country($request->lat, $request->lng);
            $countryObject = \App\Models\Countries::where("iso3", $country)->first();
            $gov = \App\Models\Gov::where("id", $zone->gov_id)->first();
            $row->zone = $zone->id;
            $row->gov = $gov->id;
            $row->country = $countryObject->id;
            $row->save();
        }
    }

    public function editProductiveFamily($id){
        $row = Provider::with("images","categories","statusObj")->where('id',$id)->first();
        return view('admin.productive-families.edit',compact('row'));

    }
    public function updateProductiveFamily(productiveFamilyRequest $request,$id){
        $row = Provider::with("images","categories","statusObj")->where('id',$id)->first();
        $validatedData = $request->validated();

        Validator::make($request->all(), $validatedData);
        if ($row->update($request->except([]))) {
            if($request->file('profile_img')){

                $destinationPath = public_path() . '/storage/profile_images';
                $profileImage = Str::random(10) . time() . '.' . $request->file('profile_img')->getClientOriginalExtension();
                $request->file("profile_img")->move($destinationPath, $profileImage);
                $row->profile_img = "$profileImage";

            }
            if ($request->categories) {

                \App\Models\ProviderCategory::where("provider_id", $row->id)->whereNotIn("category_id", $request->categories)->delete();;
                foreach ($request->categories as $category) {
                    \App\Models\ProviderCategory::firstOrCreate(["provider_id" => $row->id, 'category_id' => $category])->whereIn($category, $request->categories);
                    $row->save();
                }


            }
            if($row->lowKMPrice!= null && $row->highKMPrice!= null)
            {
                $row->status = 6 ;
                $row->save();
            }
            if($row->iban!= null && $row->bank_name!= null && $row->account_number != null)
            {
                $row->status = 6 ;
                $row->save();
            }

        }


    }

    public function deleteProductiveFamily($id){
        $row = Provider::findOrFail($id);
        $row->delete();
        return back();
    }


}
