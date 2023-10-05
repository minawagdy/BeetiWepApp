<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\advertisingRequest;
use App\Interfaces\Admin\AdvertisingRepositoryInterface;
use Illuminate\Http\Request;

class AdvertisingController extends Controller
{
    private AdvertisingRepositoryInterface $advertisingRepository;

    public function __construct(AdvertisingRepositoryInterface $advertisingRepository)
    {
        $this->advertisingRepository = $advertisingRepository;

    }

    public function index()
    {

        return $this->advertisingRepository->getAllAdvertising();
    }
    public function create(){

        return $this->advertisingRepository->createAdvertising();
    }
    public function store(advertisingRequest $request){

        return $this->advertisingRepository->storeAdvertising($request);

    }
    public function edit($id){
        return $this->advertisingRepository->editAdvertising($id);
    }
    public function update($id, advertisingRequest $request){
        return $this->advertisingRepository->updateAdvertising($id,$request);
    }
    public function destroy($id){
        return $this->advertisingRepository->deleteAdvertising($id);
    }
    public function updateAdsCheckbox(Request $request)
    {
        $checkboxValue = $request->input('checkboxValue');
        $adsId = $request->input('adsId');

        // Update the database based on the checkbox value
        $this->advertisingRepository->updateCheckboxAds($adsId, $checkboxValue);

        return response()->json(['success' => true]);
    }

}
