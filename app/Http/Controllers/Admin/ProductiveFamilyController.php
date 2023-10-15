<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\productiveFamilyRequest;
use App\Interfaces\Admin\ProductiveFamilyRepositoryInterface;

class ProductiveFamilyController extends Controller
{
    private ProductiveFamilyRepositoryInterface $productiveFamilyRepository;

    public function __construct(ProductiveFamilyRepositoryInterface $productiveFamilyRepository)
    {
        $this->productiveFamilyRepository = $productiveFamilyRepository;

    }

    public function index()
    {
        return $this->productiveFamilyRepository->getAllProducttiveFamily();
    }
    public function create(){
        return $this->productiveFamilyRepository->createProductiveFamily();
    }
//    public function store(advertisingRequest $request){
//        return $this->advertisingRepository->storeAdvertising($request);
//
//    }
//    public function edit($id){
//        return $this->advertisingRepository->editAdvertising($id);
//    }
//    public function update($id, advertisingRequest $request){
//        return $this->advertisingRepository->updateAdvertising($id,$request);
//    }
//    public function delete($id){
//        return $this->advertisingRepository->deleteAdvertising($id);
//    }


}
