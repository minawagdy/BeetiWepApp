<?php

namespace App\Http\Controllers\Administration;

use App;
use App\Models\Order;
use Mail;
use Config;
use Session;
use Validator;
use App\Libs\ACL;
use App\Libs\Adminauth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Administrator;

class CustomersController extends Administrator
{


    public $model;
    public $module;
    public $rules;

    public function __construct(Customer $model) {

        $this->module = 'customers';
        $this->model = $model;
        $this->rules = [
            'name' => 'required',
            'mobile' => 'required|unique:customers,mobile',
            "password" => "required|confirmed",
            'country_iso' => 'required',
            'country_code' => 'required'
        ];
    }

    public function getIndex(Request $request) {

        $rows = Customer::with(["address"])->where('published',1);

        $rows->where('country_id', '=', session()->get('country')->id);
        if($request->title){
          $rows = $rows->where('name', 'like', '%' . $request->title . '%');
          $rows = $rows->orWhere('mobile', 'like', '%' . $request->title . '%');
        }


        $rows = $rows->latest()->paginate();
        // dd($rows);
        return view('admin.customers.index',compact('rows'));
    }

    public function getView($id) {

        $row = Customer::with(["address","orders"])->where('id',$id)->first();
        if ($row) {
            return view('admin.customers.details',compact('row'));
        }
        else
        {
            session() -> flash('Error', trans('Error'));
            return redirect()->back();
        }
    }


    public function getCustomerOrders(Request $request,$id)
    {

        $rows = Order::with()
            ->where('client_id',$id)->latest()->paginate();
        return response()->json(['isSuccessed' =>true,"data"=>$rows,'error'=>null], 200);
    }
    public function postCreate(Request $request) {
        $msgs = new \stdClass;

        $validator = Validator::make($request->all(),  $this->rules);
        if ($validator->fails()) {
            $msgs =Lang::get($validator->errors()->first());
            return response()->json(['isSuccessed' => false,"data"=>null,'error'=>$msgs], 200);
       }

        if ($row = Customer::create($request->except([]))) {
            if($request->input('profile_img')){
                $imageSizes = ['small' => 'crop,100x100', 'large' => 'crop,400x300'];
                $row->uploadAndResize('profile_img', $row, $imageSizes);
            }
            $row->save();
            return response()->json(['isSuccessed' =>true,"data"=>$row,'error'=>null], 200);
        }

        $msgs = new \stdClass;
        $msgs =Lang::get($validator->errors()->first());
        return response()->json(['isSuccessed' => false,"data"=>null,'error'=>$msgs], 200);
    }


    public function postEdit($id, Request $request)
    {
        authorize('edit-' . $this->module);
        $row = $this->model->findOrFail($id);
        $rules = [
            //   'title' => 'required|unique:categories,title,'.$id,
            //   'title_ar' => 'required|unique:categories,title_ar,'.$id,
            //   'description' => 'required',
            //   'description_ar' => 'required'
            'name' => 'required',
            'mobile' => 'required|unique:customers,mobile,' . $id,
            "password" => "required|confirmed",
            'country_iso' => 'required',
            'country_code' => 'required'
        ];
        //Validate parameters and dispaly validation errors
        //  $validator = Validator::make($request->all(), $rules);
        $msgs = new \stdClass;

      $validator = Validator::make($request->all(),  $rules);
      if ($validator->fails()) {
        $msgs =Lang::get($validator->errors()->first());
          return response()->json(['isSuccessed' => false,"data"=>null,'error'=>$msgs], 200);
     }

        if ($row->update($request->except([]))) {
            if($request->input('profile_img')){
                $imageSizes = ['small' => 'crop,100x100', 'large' => 'crop,400x300'];
                $row->uploadAndResize('profile_img', $row, $imageSizes);
                $row->save();
            }
            return response()->json(['isSuccessed' =>true,"data"=>$row,'error'=>null], 200);
        }
        $msgs = new \stdClass;
        $msgs =Lang::get($validator->errors()->first());
        return response()->json(['isSuccessed' => false,"data"=>null,'error'=>$msgs], 200);
     }


     public function getDelete($id) {
        authorize('delete-'.$this->module);
        $row = $this->model->findOrFail($id);
          SaveActionLog('admin/customers/delete');
        $row->delete();
        flash()->success(trans('admin.Delete successfull'));
        return back();
    }

    public function postDelete($id) {
// dd($id);
        $Customer=Customer::findOrFail($id);
        if($Customer->delete($id)){
          session() -> flash('success', trans('Deleted successfully'));
        }else{
          session() -> flash('Error', trans('Error'));
        }
        return redirect()->back();
    }


    public function postEditBalance(Request $request, $id)
    {

        $row = Customer::where("id", $id)->first();
        if ($row) {
            $row->update($request->all());
            session() -> flash('success', trans('Updated successfully'));

        } else {
            session() -> flash('Error', trans('Error In Update'));
        }

        return redirect()->back();
    }

    public function getPublish($value, $id) {
        authorize('publish-'.$this->module);
        $row = $this->model->findOrFail($id);
        if ($value == 0) {
            $row->published = 0;
        } else {
            $row->published = 1;
        }
        $row->save();
        return response()->json(['isSuccessed' =>true,"data"=>true,'error'=>null], 200);
    }
}
