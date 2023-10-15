<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Libs\ACL;
use App\Libs\Adminauth;
use Request;
use Session;
use Form;
use App;

class Administrator extends Controller {

    public function __construct() {
        //$this->middleware('HaveToken');
        $this->middleware('AclAuthenticate', ['except' => ['getDeleteImage']]);
    }
}
