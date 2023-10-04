<?php

namespace App\Interfaces\Admin;


use App\Http\Requests\admin\advertisingRequest;

interface AdvertisingRepositoryInterface
{
    public function getAllAdvertising();
    public function createAdvertising();
    public function storeAdvertising(advertisingRequest $request);
    public function editAdvertising($id);
    public function updateAdvertising($id, advertisingRequest $request);
    public function deleteAdvertising($id);


}
