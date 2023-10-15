<?php

namespace App\Http\Controllers\Administration;
use Mail;
use Config;
use Session;
use App\Libs\ACL;
use App\Models\Order;
use App\Libs\Adminauth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Merchant;
use App\Models\Countries;
// use Validator;
use App\Models\ProviderAd;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Administrator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App as FacadesApp;
use Str;

class CountriesController extends Administrator
{
    public $model;
    public $module;
    public $rules;

    public function __construct(\App\Models\Countries $model)
    {

        // parent::__construct();
        $this->module = 'countries';
        $this->model = $model;
        $this->rules = [
            'iso' => 'required|unique:countries,iso|max:2',
            'name' => 'required|unique:countries,name',
            'nicename' => 'required|unique:countries,nicename',
            'iso3' => 'required|unique:countries,iso3|max:3',
            'phonecode' => 'required|unique:countries,phonecode',
            'offset' => 'required',
            //'bank_account' => 'required',
            'fees_percentage' => 'required',
          //  'lowest_value' => 'required',
            'wallet_limit' => 'required',
           // 'iban' => 'required',
           // 'bank_name' => 'required',
           // 'bank_name_ar' => 'required',
        ];
        $this->middleware('Lang');
    }

    public function getBankAccounts(Request $request,$id) {
        $row = Countries::where('id',$id)->first();
        $accounts = \App\Models\BankAccount::where("country_id",$id)->latest()->paginate();
        return response()->json(['isSuccessed' =>true,"data"=>$accounts,'error'=>null], 200);
    }
    public  function getActiveBankAccount($value,$id)
    {
        authorize('active-'.$this->module);
        $row = \App\Models\BankAccount::where('id',$id)->first();
        if ($value == 0) {
            $row->is_active = 0;
        } else {
            $row->is_active = 1;
        }
        $row->save();
        return response()->json(['isSuccessed' =>true,"data"=>true,'error'=>null], 200);
    }

    public function getDeleteBankAccount(Request $request,$id) {
        $accounts = \App\Models\BankAccount::where("id",$id)->first();
        $accounts->delete();
        return response()->json(['isSuccessed' =>true,"data"=>true,'error'=>null], 200);
    }
    public function postCreateBankAccount(Request $request) {

        authorize('edit-'.$this->module);
        $rules = [
            'bank_name' => 'required|min:2',
            'iban' => 'required|alpha_num|min:15|max:32',
            'account_number' => 'required|numeric',
            'country_id' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif',
        ];
        $msgs = new \stdClass;

        $validator = Validator::make($request->all(),  $rules);
        if ($validator->fails()) {
            $msgs = Lang::get( $validator->errors()->first());
            return response()->json(['isSuccessed' => false,"data"=>null,'error'=>$msgs], 200);
        }

        if ($row = \App\Models\BankAccount::create($request->except(["logo"]))) {
            if($request->file("logo")){
                $uploadPath = public_path().'/storage/bank_logo/';
                $file = $request->file("logo");
                $fileName = Str::random(10) . time() . '.' . $file->getClientOriginalExtension();
                $request->file("logo")->move($uploadPath, $fileName);
                $filePath = $uploadPath . $fileName;
                $row->logo = $fileName;
                $row->save();
            }
            return response()->json(['isSuccessed' =>true,"data"=>$row,'error'=>null], 200);
        }
    }

    public function postEditBankAccount($id, Request $request) {

        authorize('edit-'.$this->module);
        $row = \App\Models\BankAccount::findOrFail($id);
        $rules = [
            'bank_name' => 'required',
            'iban' => 'required',
            'account_number' => 'required',
        ];
        $msgs = new \stdClass;

        $validator = Validator::make($request->all(),  $rules);
        if ($validator->fails()) {
            $msgs = Lang::get( $validator->errors()->first());
            return response()->json(['isSuccessed' => false,"data"=>null,'error'=>$msgs], 200);
        }

        if ($row->update($request->except(["logo"]))) {
            if($request->file("logo")){
                $uploadPath = public_path().'/storage/bank_logo/';
                $file = $request->file("logo");
                $fileName = Str::random(10) . time() . '.' . $file->getClientOriginalExtension();
                $request->file("logo")->move($uploadPath, $fileName);
                $filePath = $uploadPath . $fileName;
                $row->logo = $fileName;
                $row->save();
            }
            return response()->json(['isSuccessed' =>true,"data"=>$row,'error'=>null], 200);
        }
    }


    public function getIndex(Request $request) {
        // authorize('view-' . $this->module);

        $rows = Countries::with(['currency'])->paginate();
        $govs =\App\Models\Gov::where('country_id', $request->session()->get('country')->id)->get();
        $zones =\App\Models\Zones::where('country_id', $request->session()->get('country')->id)->get();
        if($request->name){
          $rows = $rows->where('name', 'like', '%' . $request->name . '%');
        }

        return view('admin.countries.index',compact('rows','govs','zones'));

    }
    public function getAllCountries(Request $request) {
        authorize('view-' . $this->module);
        $rows = Countries::paginate();
        if($request->name){
          $rows = $rows->where('name', 'like', '%' . $request->name . '%');
        }


        return response()->json(['isSuccessed' =>true,"data"=>$rows,'error'=>null], 200);
    }

    public function getView($id) {
        authorize('view-'.$this->module);
        $row = $this->model->findOrFail($id);
        return response()->json(['isSuccessed' =>true,"data"=>$row,'error'=>null], 200);
    }


    public function postCreate(Request $request) {
        $msgs = new \stdClass;

        $validator = Validator::make($request->all(),  $this->rules);
        if ($validator->fails()) {
            $msgs = Lang::get( $validator->errors()->first());
            return response()->json(['isSuccessed' => false,"data"=>null,'error'=>$msgs], 200);
       }

        if ($row = Countries::create($request->except([]))) {
            $row->save();
            return response()->json(['isSuccessed' =>true,"data"=>$row,'error'=>null], 200);
        }

        //$msgs = new \stdClass;
        $msgs = Lang::get( $validator->errors()->first());
        return response()->json(['isSuccessed' => false,"data"=>null,'error'=>$msgs], 200);
    }


    public function postEdit($id, Request $request) {

        // authorize('edit-'.$this->module);
        $row = $this->model->findOrFail($id);
        $rules = [
            'iso' => 'required|unique:countries,iso,'.$id,
            'name' => 'required|unique:countries,name,'.$id,
            'nicename' => 'required|unique:countries,nicename,'.$id,
            'iso3' => 'required|max:3|unique:countries,iso3,'.$id,
            'phonecode' => 'required|unique:countries,phonecode,'.$id,
            'offset' => 'required',
            'bank_account' => 'required',
            'fees_percentage' => 'required',
            //'lowest_value' => 'required',
            'wallet_limit' => 'required',
            'iban' => 'required',
            'bank_name' => 'required',
            'bank_name_ar' => 'required',
        ];
        //Validate parameters and dispaly validation errors
        //  $validator = Validator::make($request->all(), $rules);
        $msgs = new \stdClass;

        $validator = Validator::make($request->all(),  $rules);
        if ($validator->fails()) {

              $msgs = Lang::get( $validator->errors()->first());

            return response()->json(['isSuccessed' => false,"data"=>null,'error'=>$msgs], 200);
        }

        if ($row->update($request->except([]))) {
            return response()->json(['isSuccessed' =>true,"data"=>$row,'error'=>null], 200);
        }
        $msgs = new \stdClass;
        $msgs = Lang::get( $validator->errors()->first());

        return response()->json(['isSuccessed' => false,"data"=>null,'error'=>$msgs], 200);
    }

    public function getDelete($id) {
        authorize('delete-'.$this->module);
        $row = $this->model->findOrFail($id);
        $row->delete();
        return response()->json(['isSuccessed' =>true,"data"=>true,'error'=>null], 200);

    }

    public function getActive($id) {
        // authorize('active-'.$this->module);

        $row = $this->model->find($id);
        if ($row->is_active == 0) {
            $row->is_active = 1;
        } else {
            $row->is_active = 0;
        }
        $row->save();

        session() -> flash('success', trans('status updated successfully'));
        return redirect()->back();
    }


    public function postDelete(Request $request) {
        authorize('delete-'.$this->module);
        $ids = $request->input("ids");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        $object = $this->model->whereIn("id", $ids)->delete();
        return response()->json(['isSuccessed' =>true,"data"=>true,'error'=>null], 200);
    }

    public function postFeesPercentage(Request $request)
    {
        authorize('edit-'.$this->module);
        try {
            $rules = [

                'fees_percentage' => 'required',
                'country'=>'required|array|min:1',
                'country.*'=>'required|exists:countries,id',
            ];
            $msgs = new \stdClass;

            $validator = Validator::make($request->all(),  $rules);
            if ($validator->fails()) {

                $msgs = Lang::get( $validator->errors()->first());

                return response()->json(['isSuccessed' => false,"data"=>null,'error'=>$msgs], 200);
            }
            for ($i=0;$i<sizeof($request->country);$i++) {
                $row = $this->model->findOrFail($request->country[$i]);
                if ($row->update($request->all())) {

                }
            }
            return response()->json(['isSuccessed' => true, "data" => true, 'error' => null], 200);

        }
        catch (\Exception $e)
        {
            return response()->json(['isSuccessed' => false,"data"=>null,'error'=>"country not found"], 200);
        }
    }


    public function postDeliveryFees(Request $request ,$id)
    {
        authorize('edit-'.$this->module);
        $row = $this->model->find($id);
        if ($row)
        {
            $rules = [

                'offset' => 'required',
            ];
            $msgs = new \stdClass;

            $validator = Validator::make($request->all(),  $rules);
            if ($validator->fails()) {

                $msgs = Lang::get( $validator->errors()->first());

                return response()->json(['isSuccessed' => false,"data"=>null,'error'=>$msgs], 200);
            }
            if ($row->update($request->all())) {
                return response()->json(['isSuccessed' =>true,"data"=>$row,'error'=>null], 200);
            }
        }
        else
        {
            return response()->json(['isSuccessed' => false,"data"=>null,'error'=>"country not found"], 200);
        }
    }


    public function postAccountDetails(Request $request ,$id)
    {
        authorize('edit-'.$this->module);
        $row = $this->model->find($id);
        if ($row)
        {
            $rules = [

                'bank_name' => 'required|min:2',
                'iban' => 'required|alpha_num|min:15|max:32',
                'account_number' => 'required|numeric|digits_between:10,12',
                'bank_name_ar' => 'required|min:2',

            ];
            $msgs = new \stdClass;

            $validator = Validator::make($request->all(),  $rules);
            if ($validator->fails()) {

                $msgs = Lang::get( $validator->errors()->first());

                return response()->json(['isSuccessed' => false,"data"=>null,'error'=>$msgs], 200);
            }
            if ($row->update($request->all())) {
                return response()->json(['isSuccessed' =>true,"data"=>$row,'error'=>null], 200);
            }
        }
        else
        {
            return response()->json(['isSuccessed' => false,"data"=>null,'error'=>"country not found"], 200);
        }
    }


    public function postWalletLimit(Request $request)
    {
        authorize('edit-'.$this->module);

        try {

            $rules = [

                'wallet_limit' => 'required',
                'country'=>'required|array|min:1',
                'country.*'=>'required|exists:countries,id',
            ];
            $msgs = new \stdClass;

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {

                $msgs = Lang::get($validator->errors()->first());

                return response()->json(['isSuccessed' => false, "data" => null, 'error' => $msgs], 200);
            }
            for ($i=0;$i<sizeof($request->country);$i++) {
                $row = $this->model->findOrFail($request->country[$i]);
                if ($row->update($request->all())) {

                }
            }
            return response()->json(['isSuccessed' => true, "data" => true, 'error' => null], 200);

        }
        catch (\Exception $e)
        {
            return response()->json(['isSuccessed' => false,"data"=>null,'error'=>"country not found"], 200);
        }
    }

    public function getGovData($id)
    {
        $data = \App\Models\Zones::where([['gov_id', $id]])->get();
        // dd($data);

        return response()->json($data);
    }
    public function changeAnyStatus($type,$id){
        // dd($type,$id);
        if($type == 'gov'){

            $row = \App\Models\Gov::where('id',$id)->first();
            if ($row->published == 0) {
                $row->published = 1;
            } else {
                $row->published = 0;
            }
            $row->save();
        }else{
            $row = \App\Models\Zones::where('id',$id)->first();
            if ($row->status == 0) {
                $row->status = 1;
            } else {
                $row->status = 0;
            }
            $row->save();
        }
    }

}
