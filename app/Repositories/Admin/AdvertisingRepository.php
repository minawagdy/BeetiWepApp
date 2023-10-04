<?php

namespace App\Repositories\Admin;

use App\Http\Requests\admin\advertisingRequest;
use App\Interfaces\Admin\AdvertisingRepositoryInterface;
use App\Models\ProviderAd;
use Validator;

class AdvertisingRepository implements AdvertisingRepositoryInterface
{

    public function getAllAdvertising()
    {
        $ads  = ProviderAd::whereHas('provider', function ($query)  {
                $query->where('country', '=', 63);
            })->where('is_active',1)->get();

        return view('admin.advertising.index',compact('ads'));

    }
    public function  createAdvertising(){
        return view('admin.advertising.create');

    }
    public function storeAdvertising(advertisingRequest $request)
    {
        $validatedData = $request->validated();

        Validator::make($request->all(), $validatedData);
        if ($row = ProviderAd::create($request->except([]))) {
            $row->is_active = 1;
            $row->save();
            if ($request->image) {

                $imageName = time() . '.' . $request->image->getClientOriginalName();

                $request->image->move(public_path('/storage/Ads_images'), $imageName);
                $row->image = $imageName;
                $row->save();
                return redirect('advertising');
            }

        }
    }
    public function editAdvertising($id){

        $row = ProviderAd::findOrFail(1);

        return view('admin.advertising.edit',compact('row','id'));
    }
    public function updateAdvertising($id, advertisingRequest $request)
    {
        $validatedData = $request->validated();

        $row = ProviderAd::findOrFail($id);
        Validator::make($request->all(), $validatedData);
        if ($row->update($request->except([]))) {
            if ($request->image) {
                $imageName = time() . '.' . $request->image->getClientOriginalName();
                $request->image->move(public_path('/storage/Ads_images'), $imageName);
                $row->image = $imageName;
                $row->save();
            }
        }
    }

    public function deleteAdvertising($id) {

        $row = ProviderAd::findOrFail($id);
        $row->delete();
        return response()->json(['isSuccessed' =>true,"data"=>true,'error'=>null], 200);

    }



}
