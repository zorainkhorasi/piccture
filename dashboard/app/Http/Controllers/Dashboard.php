<?php

namespace App\Http\Controllers;

use App\Models\Custom_Model;
use App\Models\Form_Model;
use App\Models\linelisting_model;
use App\Models\Settings_Model;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Dashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = array();
        //over allCounts
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', '');


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

            $getClustersProvince = linelisting_model::getClustersProvince();
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
            $completedClusters_district = linelisting_model::completedClusters_district($searchdata);

            $combine_ip_comp = 0;
            $completed = 0;
            $ip = 0;
            foreach ($completedClusters_district as $row) {
                $ke = $row->dist_code;
                foreach ($overall_dist_array as $dist_id => $dist_name) {
                    if ($ke == $dist_id && $row->collecting_tabs != '' && $row->collecting_tabs != 0) {
                        $combine_ip_comp++;
                        $data['combine_ip_comp'][$dist_id]['count']++;
                        if ($row->collecting_tabs == $row->completed_tabs) {
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

            // echo '<pre>';print_r( $data);die;

            /*==============Remaining Clusters List==============*/
            /*==============Remaining Clusters List==============*/
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

            return view('listing.linelisting', ['data' => $data]);

        } else {
            return view('errors/403');
        }
    }


    public function linelisting_detail(Request $request)
    {
        $data = array();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', '');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Rs_linelisting",
            "action" => "View Rs_linelisting Detail -> Function: Rs_linelisting/linelisting_detail()",
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
            $data['linelisting_details'] = linelisting_model::get_linelisting_table($searchFilter);
            //echo '<pre>';print_r(  $data['linelisting_details'] );die;

            return view('listing.linelisting_details', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }
    }

    public function systematic_randomizer(Request $request)
    {
       // $sample = 30;
        if (isset($_POST['cluster_no']) && $request->input('cluster_no') != '') {
            $cluster = $request->input('cluster_no');
            $get_rand_cluster = linelisting_model::get_rand_cluster($cluster);
            $randomization_status = $get_rand_cluster[0]->randomized;

            $settings = linelisting_model::get_cluster_settings($cluster);
            if (!$settings || $settings->randomize === null || $settings->randomize === '') {
                return json_encode(['Error', 'Randomize value is missing for this district', 'danger']);
            }
            $sample = (int) $settings->randomize;
            // ✅ Backup sample size (optional)
            $backupSample = (int) $settings->rand_backup;


            if ($randomization_status == 1) {
                $result = array('Error', 'Cluster No ' . $cluster . ' already randomized', 'danger');
            } else {
                $chked = 0;
                $chkDuplicateTabs = linelisting_model::chkDuplicateTabs($cluster);
                if (isset($chkDuplicateTabs) && count($chkDuplicateTabs) >= 1) {
                    $chked = 1;
                }
                if ($chked == 0) {

                    $get_systematic_rand = linelisting_model::get_systematic_rand($cluster);
                    $cnt = count($get_systematic_rand);
                    if ($cnt >= 1) {
                        $cntData = count($get_systematic_rand);
                        $quotient = $this->_get_quotient($cntData, $sample);
                        $random_start = $this->_get_random_start($quotient);
                        $random_point = $random_start;
                        $index = floor($random_start);
                        if ($cntData > $sample) {
                            $ll = $sample;
                        } else {
                            $ll = $cntData;
                        }
                        $counter = 0;
                        $form_data = [];
                        for ($i = 0; $i < $ll; $i++) {


                            $form_data[] = array(
                                'sno' => $i + 1,
                                'randDT' => date('Y-m-d h:i:s'),
                                'luid' => $get_systematic_rand[$index - 1]->_uid,
                                'hltab' => $get_systematic_rand[$index - 1]->hltab,
                                'clustercode' => $get_systematic_rand[$index - 1]->cluster_no,
                                'hhid' => $get_systematic_rand[$index - 1]->hhid,
                                'compid' => $get_systematic_rand[$index - 1]->cluster_no . '-' . $get_systematic_rand[$index - 1]->hhid,
                                'user_id' => Auth::user()->id,
                                'dist_id' => $get_systematic_rand[$index - 1]->dist_code,
                                'area' => $get_systematic_rand[$index - 1]->hl08,//village_name
                                'head' => $get_systematic_rand[$index - 1]->hl14,//head
                                'total' => $cntData,
                                'randno' => $random_start,
                                'randomPick' => $index - 1,
                                'quot' =>substr($quotient, 0, 5),
                                'user_name' => Auth::user()->username,
                            );
                            //DB::table('bl_randomised')->insert($form_data);
                            $random_point = $random_point + $quotient;
                            $index = floor($random_point);
                            $counter = $counter + 1;
                        }

                        //echo '<pre>';print_r($form_data);die;
                        DB::table('bl_randomised')->insert($form_data);

                        if (!empty($backupSample) && $backupSample > 0){

                            //--For backup 10
                            $sample = $backupSample;
                            $get_systematic_rand = linelisting_model::get_systematic_rand($cluster);
                            $cnt = count($get_systematic_rand);
                            $cntData = count($get_systematic_rand);
                            $quotient = $this->_get_quotient($cntData, $sample);
                            $random_start = $this->_get_random_start($quotient);
                            $random_point = $random_start;
                            $index = floor($random_start);
                            if ($cntData > $sample) {
                                $ll = $sample;
                            } else {
                                $ll = $cntData;
                            }
                            $counter = 0;
                            $form_data = [];
                            for ($i = 0; $i < $ll; $i++) {


                                $form_data[] = array(
                                    'sno' => $i + 1,
                                    'randDT' => date('Y-m-d h:i:s'),
                                    'luid' => $get_systematic_rand[$index - 1]->_uid,
                                    'hltab' => $get_systematic_rand[$index - 1]->hltab,
                                    'clustercode' => $get_systematic_rand[$index - 1]->cluster_no,
                                    'hhid' => $get_systematic_rand[$index - 1]->hhid,
                                    'compid' => $get_systematic_rand[$index - 1]->cluster_no . '-' . $get_systematic_rand[$index - 1]->hhid,
                                    'user_id' => Auth::user()->id,
                                    'dist_id' => $get_systematic_rand[$index - 1]->dist_code,
                                    'area' => $get_systematic_rand[$index - 1]->hl08,//village_name
                                    'head' => $get_systematic_rand[$index - 1]->hl14,//head
                                    'total' => $cntData,
                                    'randno' => $random_start,
                                    'randomPick' => $index - 1,
                                    'quot' =>substr($quotient, 0, 5),
                                    'user_name' => Auth::user()->username,
                                    'isBackup' => 1,
                                );
                                //DB::table('bl_randomised')->insert($form_data);
                                $random_point = $random_point + $quotient;
                                $index = floor($random_point);
                                $counter = $counter + 1;
                            }

                            //echo '<pre>';print_r($form_data);die;
                            DB::table('bl_randomised')->insert($form_data);
                        }
                        $updateCluster = array();
                        $updateCluster['randomized'] = 1;
                        $editData = DB::table('clusters')
                            ->where('cluster_no', $cluster)
                            ->update($updateCluster);
                        if ($editData) {
                            $result = array('Success', 'Successfully Randomized', 'success');
                        } else {
                            $result = array('Error', 'Randomized added, but error in updating cluster', 'danger');
                        }
                    } else {
                        $result = array('Error', 'Cluster No ' . $cluster . ' has Zero Households', 'danger');
                    }
                } else {
                    $result = array('Error', 'Duplicate Household Found in Cluster No ' . $cluster . ', Please coordinate with DMU', 'danger');
                }
            }
        } else {
            $result = array('Error', 'Cluster not found', 'danger');
        }
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Rs_linelisting Randomization",
            "action" => "Add Rs_linelisting Randomization -> Function: Rs_linelisting/systematic_randomizer()",
            "mainResult" => $result[0],
            "result" => $result[1],
            "PostData" => array(),
            "affectedKey" => 'id',
            "idUser" => Auth::user()->id,
            "username" => Auth::user()->username,
        );
        Custom_Model::trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
        return json_encode($result);
    }

    private function _get_quotient($dataset, $sample)
    {
        if ($dataset > $sample) {
            $quotient = $dataset / $sample;
        } else {
            $quotient = 1;
        }
        return $quotient;
    }

    private function _get_random_start($quotient)
    {
        $random_start = rand(1, $quotient);
        return $random_start;
    }

    public function randomized_detail(Request $request)
    {
        // echo request()->id;die;
        $data = array();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', '');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Rs_linelisting Randomization Detail",
            "action" => "View Rs_linelisting Randomization Detail -> Function: Rs_linelisting/randomized_detail()",
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
            $cluster = '0';
            if (isset(request()->id) && request()->id != '' && !empty(request()->id)) {
                $cluster = request()->id;
            }
            $get_randomized_table = linelisting_model::get_randomized_table($cluster);
            //echo '<pre>';print_r($get_randomized_table);die;
            $data['get_randomized_table'] = $get_randomized_table;
            return view('listing.linelisting_randomized_detail', ['data' => $data]);
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }
    }

    public function make_pdf(Request $request)
    {
        $data = array();
        $data['permission'] = Settings_Model::getUserRights(Auth::user()->idGroup, '', '');
        /*==========Log=============*/
        $trackarray = array(
            "activityName" => "Rs_linelisting Randomization PDF",
            "action" => "View Rs_linelisting Randomization PDF -> Function: Rs_linelisting/make_pdf()",
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
            $cluster = '0';
            if (isset(request()->id) && request()->id != '' && !empty(request()->id)) {
                $cluster = request()->id;
            }

            ///.echo request()->r_type;die;
            ///
            $r_type=request()->r_type;
            if($r_type==1){
                $get_randomized_table = linelisting_model::get_randomized_table($cluster,$r_type);
            }else{
                $get_randomized_table = linelisting_model::get_randomized_table($cluster,$r_type);
            }

            $data['get_randomized_table'] = $get_randomized_table;
            //            return view('rapid_survey.make_pdf', ['data' => $data]);
            $pdf = PDF::loadView('listing.make_pdf', ['data' => $data]);
            return $pdf->download($cluster . '_randomization_piccture.pdf');
        } else {
            $trackarray["mainResult"] = "Error";
            $trackarray["result"] = "View Error - Access denied";
            Custom_Model::trackLogs($trackarray, "all_logs");
            return view('errors/403');
        }
    }


}
