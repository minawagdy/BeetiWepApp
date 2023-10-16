<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Countries;
use App\Models\Provider;
use App\Models\Version;
use App\Models\PaymentMethod;
use App\Models\CountriesPaymentMethods;
use App\Http\Controllers\Administrator;

use Illuminate\Support\Facades\DB;
class SettingsController extends Controller
{

    public $rules;
    public function getSettings(){
        $countries = Countries::all();
        $providers = Provider::where([['status','1'],['country', '=', session()->get('country')->id]])->get();
        $provider_with_special_fees = Provider::where([['status','1'],['country', '=', session()->get('country')->id]])->whereNotNull('fees_percentage')->get();

        // dd($provider_with_special_fees);
        return view('admin.settings.wallet',compact('countries','providers','provider_with_special_fees'));
    }
    public function updateFeesSettings(Request $request){
        if($request->has('country_id')){
                $row= Countries::findOrFail($request->country_id);
        }else if($request->has('provider_id')){
            $row= Provider::findOrFail($request->provider_id);
        }
                if($row->update($request->all())){
                    session() -> flash('success', trans('percentage Updated successfully'));
                }else{
                    session() -> flash('Error', trans('Error, try again later'));
                }
                return redirect()->back();
            }
    public function updateLimitSettings(Request $request){
        if($request->has('country_id')){
                $row= Countries::findOrFail($request->country_id);
        }
                if($row->update($request->all())){
                    session() -> flash('success', trans('Limit Updated successfully'));
                }else{
                    session() -> flash('Error', trans('Error, try again later'));
                }
                return redirect()->back();
            }





            public function getPaymnetSettings(){
                $countries = Countries::all();
                $rows = PaymentMethod::paginate(20);
                // dd($provider_with_special_fees);
                return view('admin.settings.payment',compact('countries','rows'));
            }



            public function storePaymentMethod(Request $request)
            {
                $request->validate([
                    'title' => 'required|unique:payment_methods,title',
                    'title_ar' => 'required|unique:payment_methods,title_ar',
                    'country'=>'required|array|min:1',
                    'country.*'=>'required|exists:countries,id',
                ]);



                DB::beginTransaction();
               if ($row = PaymentMethod::create($request->except(['country']))) {
                   if($request->file('icon')){
                        $uploadPath = public_path().'/storage/icons/';
                        $file = $request->file("icon");
                        $fileName = Str::random(10) . time() . '.' . $file->getClientOriginalExtension();
                        $request->file("icon")->move($uploadPath, $fileName);
                        $filePath = $uploadPath . $fileName;
                        $row->icon = $fileName;
                        $row->save();
                    }
                   for ($i=0;$i<sizeof($request->country);$i++)
                   {
                       $row2 = CountriesPaymentMethods::create(['country_id'=>$request->country[$i],'payment_method_id'=>$row->id]);
                       $row2->save();
                   }
                   DB::commit();
                   session() -> flash('success', trans('Added successfully'));

            }else{
                DB::rollback();

                session() -> flash('Error', trans('Error, try again later'));
            }
            return redirect()->back();

}


            public function ActivePayment($id) {
                // authorize('active-'.$this->module);

                $row = PaymentMethod ::findOrFail($id);
                if ($row->is_active == 0) {
                    $row->is_active = 1;
                } else {
                    $row->is_active = 0;
                }
                $row->save();

                session() -> flash('success', trans('status updated successfully'));
                return redirect()->back();
            }

            public function deletePayment($id){
                $row = PaymentMethod ::findOrFail($id);
                $row->delete();
                session() -> flash('success', trans('Deleted successfully'));
                return redirect()->back();

            }


            public function getVersions(){

                $rows = Version::all();
                // dd($rows);
                return view('admin.settings.versions',compact('rows'));
            }


            public function updateVersions(Request $request){
            // dd($request->all());
                        $request->validate([
                        'ids'=>'required',
                        'ids.*'=>'numeric|min:0|not_in:0',
                        'version_nums'=>'required',
                        'version_nums.*'=>'numeric|min:0|not_in:0'
                        ]);
                $ids = $request->ids;
                $version_nums = $request->version_nums;
                $is_forced = $request->is_forced;
                for($i=0;$i<sizeof($ids);$i++){
                    $row = Version::find($ids[$i]);
                    $row->update((["version_num"=>$version_nums[$i],"is_forced"=>$is_forced[$ids[$i]]?? 0]));
                }
                session() -> flash('success', trans('Updated successfully'));
                return redirect()->back();
            }

}
