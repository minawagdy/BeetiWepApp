<?php

namespace App\Http\Controllers\Administration;
use App\Models\Contact;
use App\Http\Controllers\Controller;
class ContactsController extends Controller
{


public function index(){
    $rows = Contact::paginate(10);
return view('admin.Contacts.index',compact('rows'));
}
public function show($id){
    $message= Contact::findOrFail($id);
    return view('admin.Contacts.details',compact('message'));

}
public function destroy($id){
    // dd($id);

    if($row = Contact::findOrFail($id)){
    $row->delete();
    session() -> flash('success', trans('Deleted successfully'));
    }else{
        session() -> flash('Error', trans('Error In Delete Try again later'));
    }
    return redirect()->back();
}
}
