<?php

namespace App\Libs;

use App\Models\Provider;
use Session;
use Hash;
use Config;

class ProviderApiauth {

    public static function attempt($credentials, $remember = 0) {
        extract($credentials);
        $row = Provider::where('country_code', "=", $country_code)->where('mobile', "=", $mobile)->first();
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
        $row = Provider::where('country_code', "=", $country_code)->where('mobile', "=", $mobile)->first();
        if ($row) {

                return $row;


        }
        else return false;
    }

}
