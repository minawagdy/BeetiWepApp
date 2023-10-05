<?php

namespace App\Repositories\Admin;

use App\Http\Requests\admin\advertisingRequest;
use App\Interfaces\Admin\AdvertisingRepositoryInterface;
use App\Models\ProviderAd;
use App\Models\Provider;
use Validator;
use Session;
class AdvertisingRepository implements AdvertisingRepositoryInterface
{

    public function getAllAdvertising()
    {
        $all_ads = \App\Models\ProviderAd::with([])->whereHas('provider', function ($q) {
            $q->where('country', '=', Session::get('country'));
        })->get()->count();

        $active_ads = \App\Models\ProviderAd::with([])->whereHas('provider', function ($q) {
            $q->where('country', '=', Session::get('country'));
        })->where('is_active',1)->get()->count();
        $deactive_ads = \App\Models\ProviderAd::with([])->whereHas('provider', function ($q) {
            $q->where('country', '=', Session::get('country'));
        })->where('is_active',0)->get()->count();


    
        $ads  =  \App\Models\ProviderAd::with([])->whereHas('provider', function ($q) {
                $q->where('country', '=', Session::get('country'));
            })->get();

        return view('admin.advertising.index',compact('ads','all_ads','active_ads','deactive_ads'));

    }
    public function  createAdvertising(){
        $providers = Provider::where('country', Session::get('country'))->where('published',1)->orderby('name')->get();
        return view('admin.advertising.create',compact('providers'));

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
                return  redirect()->route('advertising');

            }

        }
    }
    public function editAdvertising($id){

        $row = ProviderAd::findOrFail($id);
        $providers = Provider::where('country', Session::get('country'))->where('published',1)->orderby('name')->get();

        return view('admin.advertising.edit',compact('row','providers'));
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
        return  redirect()->route('advertising');
 
    }

    public function deleteAdvertising($id) {

        $row = ProviderAd::findOrFail($id);
        $row->delete();
        return  redirect()->route('advertising');

    }

    public function updateCheckboxAds($adsId, $checkboxValue)
    {
        $ads = ProviderAd::find($adsId);
        $ads->is_active = $checkboxValue;
        $ads->save();

        return $ads;
    }




}
