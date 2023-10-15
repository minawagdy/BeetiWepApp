<?php

namespace App\Libs;


use App\Models\Driver;
use Session;
use Hash;
use Config;

class DriverApiauth {

    public static function attempt($credentials, $remember = 0) {
        extract($credentials);
        $row = Driver::where('country_code', "=", $country_code)->where('mobile', "=", $mobile)->first();
        if ($row) {
            if (Hash::check($password, $row->password)) {
                return $row;
            }
            else return false;
        }
        else return false;
    }

}
