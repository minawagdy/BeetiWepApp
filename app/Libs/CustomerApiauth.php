<?php

namespace App\Libs;

use App\Models\Customer;
use Session;
use Hash;
use Config;

class CustomerApiauth {

    public static function attempt($credentials, $remember = 0) {
        extract($credentials);
        $row = Customer::where('country_code', "=", $country_code)->where('mobile', "=", $mobile)->first();
        if ($row) {
            if (Hash::check($password, $row->password)) {
                return $row;
            }
            else return false;
        }
        else return false;
    }
    public static function attempt2($credentials, $remember = 0) {
        extract($credentials);
        $row = Customer::where('country_code', "=", $country_code)->where('mobile', "=", $mobile)->first();
        if ($row) {

                return $row;


        }
        else return false;
    }

}
