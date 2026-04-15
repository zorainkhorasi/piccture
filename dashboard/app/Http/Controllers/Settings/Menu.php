<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Menu extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public  function dynamicMenu(){

        $myresult = array();
        if (Auth::check() && isset(Auth::user()->idGroup) && Auth::user()->idGroup!='') {
            $pages = Settings_Model::getUserRights(Auth::user()->idGroup, 1, '');

            foreach ($pages as $key => $value) {
                if (isset($value->idParent) && $value->idParent != '' && array_key_exists(strtolower($value->idParent), $myresult)) {
                    $mykey = strtolower($value->idParent);
                    $myresult[strtolower($mykey)]->myrow_options[] = $value;
                } else {
                    $mykey = strtolower($value->idPages);
                    $myresult[strtolower($mykey)] = $value;
                }
            }
        }
        return $myresult;
    }

    

}
