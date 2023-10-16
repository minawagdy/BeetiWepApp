<?php

namespace App\Libs;

use App\Libs\Adminauth;
use App\Models\Role;
use App\Models\RolePermission;
use Request;
class ACL {

    private static $allowed = ["dashboard"];

    static function can($action, $userId = NULL) {
        if (in_array($action, self::$allowed)) {
            return true;
        }

        //$hash = trim(Request::header("token"));
        //$user = \App\Models\AdminToken::whereToken($hash)->first()->customer;

        $user = Adminauth::user();

        if ($user==false){
            $msgs = new \stdClass;
            if(Request::header("lang")=="en"){
                $msgs->en = "You have to login first";
            }else{

                $msgs->ar = "يجب تسجيل دخول اولا";
            }
            return false;

        }

        if (@$user->super_admin) return true;
        $permissions = RolePermission::where('role_id',$user->role_id)->get()->pluck('permission_id')->toArray();

      $permissions =  \App\Models\Permission::whereIn('id',$permissions)->get()->pluck('slug')->toArray();
        if ($permissions) {
            if (in_array($action, $permissions)) {
                return true;
            }
        }
        return false;
    }

    static function cant($action, $user_id = NULL) {
        return !(self::can($action));
    }
}
?>
