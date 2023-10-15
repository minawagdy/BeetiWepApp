<?php

namespace App\Repositories\Admin;

use App\Http\Requests\admin\advertisingRequest;
use App\Interfaces\Admin\AdvertisingRepositoryInterface;
use App\Models\ProviderAd;
use App\Models\Provider;
use Validator;
use Illuminate\Support\Facades\Session;

class AdvertisingRepository implements AdvertisingRepositoryInterface
{

    public function getAllAdvertising()
    {
        //  dd(Session::get('country'));

        $ads  = ProviderAd::whereHas('provider', function ($query)  {
                $query->where('country', '=', Session::get('country')->id);
            })->paginate(20);
           $approved_ads = ProviderAd::whereHas('provider', function ($query)  {
            $query->where('country', '=', Session::get('country')->id);
        })->where('is_active','1')->count();
        return view('admin.advertising.index',compact('ads','approved_ads'));
    }
    public function  createAdvertising(){
    $providers = Provider::where('status',1)->where('country', '=', session::get('country')->id)->get();
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


            }
                session() -> flash('Success', __('Added Successfully'));
        }
        return redirect()->route('advertising');
    }
    public function editAdvertising($id){

        $row = ProviderAd::findOrFail($id);
        $providers = Provider::where('status',1)->where('country', '=', Session::get('country')->id)->get();

        return view('admin.advertising.edit',compact('row','id','providers'));
    }
    public function updateAdvertising($id, advertisingRequest $request)
    {
        // dd($request->all());
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
            session() -> flash('Success', __('Updated Successfully'));
        }

        return redirect()->route('advertising');
    }

    public function deleteAdvertising($id) {

        $row = ProviderAd::findOrFail($id);
        $row->delete();
        session() -> flash('Success', __('Deleted Successfully'));
        return redirect()->route('advertising');

    }
    public function changeStatus($id) {

        $row = ProviderAd::findOrFail($id);

            if($row->is_active == 0){
                $row->is_active = 1;
            }else{
                $row->is_active = 0;


            }

        $row->save();
        session() -> flash('Success', __('Updated Successfully'));
        return redirect()->route('advertising');

    }





}
