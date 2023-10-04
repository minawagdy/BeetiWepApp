<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\DashboardRepositoryInterface;
use Session;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private DashboardRepositoryInterface $dashboardRepository;

    public function __construct(DashboardRepositoryInterface $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
        $this->middleware('admin');
    }


    public function index()
    {
        dd( $selectedCountry);
        [$providerCount,$orderCount,$productNotApprovedCount,$providerNotApprovedCount,$countries] = $this->dashboardRepository->getData();

        return view('admin.dashboard.index',compact('providerCount','orderCount','productNotApprovedCount','providerNotApprovedCount','countries'));
    }
    public function getDropdown1(Request $request)
    {
       ;
        $parent_id = $request['parent_id'];
        $dropdown1Data = $this->dashboardRepository->getDropdown1Data($parent_id);
        Session::put('country', $parent_id);

        return response()->json($dropdown1Data);
    }

    public function getDropdown2($id)
    {
        $dropdown2Data = $this->dashboardRepository->getDropdown2Data($id);
        Session::put('gov', $id);

        return response()->json($dropdown2Data);
    }

    public function getDropdown3($id)
    {

        $dropdown3Data = $this->dashboardRepository->getDropdown3Data($id);
        return response()->json($dropdown3Data);
    }



}
