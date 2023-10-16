<?php

namespace App\Libs;

use App\Models\Bank;
use Session;
use Hash;
use Config;

class Bankauth {

    public static function attempt($credentials, $remember = 0) {
        if (Session::get('bank_user')) return true;
        $bank = new Bank();
        extract($credentials);
        $row = $bank->where('email', "=", $email)->wherePublished(1)->first();
        if ($row) {
            if (Hash::check($password, $row->password)) {
                Session::put('bank_user', $row);
                return $row;
            }
            else return false;
        }
        else return false;
    }

    public static function user() {
        $key = Config::get('application.key');
        if (Session::has('bank_user')) {
            $user = Session::get('bank_user');
            return $user;
        }
        else return false;
    }

    public static function id() {
        if (Session::has('bank_user')) {
            $user = Session::get('bank_user');
            return @$user->id;
        }
    }

    public static function guest() {
        if (!Session::has('bank_user')) return true;
        else return false;
    }

    public static function logout() {
        Session::forget('bank_user');
        return true;
    }
}
