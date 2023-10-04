<?php

namespace App\Interfaces\Admin;
use Illuminate\Http\Request;


interface DashboardRepositoryInterface
{
    public function getData();
    public function getDropdown1Data(Request $request);
    public function getDropdown2Data($id);
    public function getDropdown3Data($id);

}
