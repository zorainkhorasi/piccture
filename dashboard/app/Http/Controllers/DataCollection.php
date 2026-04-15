<?php

namespace App\Http\Controllers;

use App\Models\Custom_Model;
use App\Models\Form_Model;
use App\Models\Datacollection_model;
use App\Models\Settings_Model;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DataCollection extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = array();
        //over allCounts
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', 'datacollection');


        if ($data['permission'][0]->CanView == 1) {
            $searchdata = array();
            $searchdata = array();
            $searchdata['district'] = '';
            if (
                isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail = 1
                    && isset(Auth::user()->district) && Auth::user()->district != '0'
            ) {
                $searchdata['district'] = Auth::user()->district;
            }

            $getClustersProvince = Datacollection_model::getClustersProvince();
             //echo '<pre>';print_r( $getClustersProvince);die;
            $overall_dist_array = array();
            $totalcluster = 0;
            foreach ($getClustersProvince as $k => $v) {

                $dist_id = $v->district_code;
                $overall_dist_array[$dist_id]['district_code'] = $v->district_code;
                $overall_dist_array[$dist_id]['district_name'] = $v->district_name;
                $overall_dist_array[$dist_id]['count'] = $v->totalDistrict;
                $totalcluster += $overall_dist_array[$dist_id]['count'];
            }

            $data['total'] = $overall_dist_array;
            $data['totalcluster'] = $totalcluster;

            foreach ($overall_dist_array as $dist_id => $dist_name) {
                $dist = $dist_name['district_name'];
                $data['combine_ip_comp'][$dist_id]['district_code'] = $dist_id;
                $data['combine_ip_comp'][$dist_id]['district_name'] = $dist;
                $data['combine_ip_comp'][$dist_id]['count'] = 0;

                $data['completed'][$dist_id]['district_code'] = $dist_id;
                $data['completed'][$dist_id]['district_name'] = $dist;
                $data['completed'][$dist_id]['count'] = 0;
                $data['ip'][$dist_id]['district_code'] = $dist_id;
                $data['ip'][$dist_id]['district_name'] = $dist;
                $data['ip'][$dist_id]['count'] = 0;
                $data['r'][$dist_id]['district_code'] = $dist_id;
                $data['r'][$dist_id]['district_name'] = $dist;
                $data['r'][$dist_id]['count'] = 0;
            }
            $completedClusters_district = Datacollection_model::completedClusters_district($searchdata);

            $combine_ip_comp = 0;
            $completed = 0;
            $ip = 0;
            foreach ($completedClusters_district as $row) {
                $ke = $row->dist_code;
                foreach ($overall_dist_array as $dist_id => $dist_name) {
                    if ($ke == $dist_id && $row->hh_randomized != '0' && $row->completed_tabs != 0) {
                        $combine_ip_comp++;
                        $data['combine_ip_comp'][$dist_id]['count']++;
                        if ( $row->completed_tabs >=$row->hh_randomized) {
                            $data['completed'][$dist_id]['count']++;
                            $completed++;
                        } else {
                            $data['ip'][$dist_id]['count']++;
                            $ip++;
                        }
                    }
                }
            }
            $data['total_completed'] = $completed;
            $data['total_ip'] = $ip;

            $r = 0;
            foreach ($getClustersProvince as $row2) {
                $ke = $row2->district_code;
                foreach ($overall_dist_array as $dist_id => $dist_name) {
                    $dist = $dist_name['district_name'];
                    if ($ke == $dist_id) {
                        $data['r'][$dist_id]['count'] = $row2->totalDistrict - $data['combine_ip_comp'][$dist_id]['count'];
                        $r += $data['r'][$dist_id]['count'];
                    }
                }
            }
            $data['total_r'] = $r;
            return view('datacollection.index', ['data' => $data]);

        } else {
            return view('errors/403');
        }
    }


    public function datacollection_detail(Request $request)
    {
        $data = array();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', '');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Rs_linelisting",
            "action" => "View Rs_linelisting Detail -> Function: datacollection/datacollection()",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        /*==========Log=============*/

        if ($data['permission'][0]->CanView == 1) {
            $trackarray["mainResult"] = "Success";
            $trackarray["result"] = "View Success";
            Custom_Model::trackLogs($trackarray, "all_logs");

            $searchFilter = array();
            if (
                isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset(Auth::user()->district) && Auth::user()->district != 0
            ) {
                $searchFilter['district'] = Auth::user()->district;
            }
            if (isset(request()->id) && request()->id != '' && !empty(request()->id)) {
                $searchFilter['district'] = request()->id;
            }
            if (isset(request()->id) && request()->id != '' && !empty(request()->id)) {
                $searchFilter['type'] = request()->type;
            }
            $data['details'] = Datacollection_model::get_datacollection_table($searchFilter);

            return view('datacollection.details', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }
    }



}
