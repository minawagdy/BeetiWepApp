<?php

namespace App\Libs;

use App\Models\Admin;
use Session;
use Hash;
use Config;
use Request;
class Adminauth {

    public static function attempt($credentials, $remember = 0) {
        $admin = new Admin();
        extract($credentials);
        $row = $admin->where('email', "=", $email)->wherePublished(1)->first();
        if ($row) {
            if (Hash::check($password, $row->password)) {
                // Session::put('admin_user', $row);
                //Session::put('admin_permissions',
                //    $row->roles->pluck('slug', 'id')->toArray());
                return $row;
            }
            else return false;
        }
        else return false;
    }

    public static function user() {
        $hash = trim(Request::header("token"));
        try {
            $admin = \App\Models\AdminToken::whereToken($hash)->first()->admin;
            if ($admin) {
                return $admin;
            }
        }
        catch (\Exception $exception)
        {
         return false;
        }


    }

    public static function id() {
        $hash = trim(Request::header("token"));
        $admin = \App\Models\AdminToken::whereToken($hash)->first()->admin;
        if ($admin) {
            return @$admin->id;
        }
    }

    public static function guest() {
        $hash = trim(Request::header("token"));
        $admin = \App\Models\AdminToken::whereToken($hash)->first()->admin;

        if (!$admin) return true;
        else return false;
    }


    public static function permissions() {
        $hash = trim(Request::header("token"));
        $admin = \App\Models\AdminToken::whereToken($hash)->first()->admin;
        if ($admin) {
            $permissions =  $admin->roles->pluck('slug', 'id')->toArray();
            return $permissions;
        }
    }
}
