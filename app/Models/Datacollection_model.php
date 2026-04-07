<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Datacollection_model extends Model
{
    use HasFactory;

    public static function getClustersProvince()
    {
        $sql = DB::table('clusters');
        $sql->select(DB::raw('distinct dist_code as district_code,district as district_name,COUNT (dist_code) AS totalDistrict'));

        $sql->groupBy('dist_code', 'district');

        $sql->where(function ($query) {
            $query->where('colflag')
                ->orWhere('colflag', '=', '')
                ->orWhere('colflag', '=', '0');
        });
        $sql->where('cluster_no', 'NOT LIKE', '999%');
        $sql->orderBy('dist_code', 'ASC');
        $data = $sql->get();

//echo '<pre>';
      //  print_r($data);die;
        return $data;
    }

    public static function completedClusters_district()
    {


        return DB::table('clusters as c')
            ->select([
                'c.dist_code','c.district','c.cluster_no',
                DB::raw("(SELECT COUNT(DISTINCT hhid)
                    FROM bl_randomised r
                    WHERE c.cluster_no = r.clustercode
                    AND (colflag IS NULL OR colflag = 0)) AS hh_randomized"),
                DB::raw("(SELECT COUNT(DISTINCT hhid)
                    FROM form f
                    WHERE c.cluster_no = f.clustercode AND (f.colflag='' or f.colflag IS NULL OR f.colflag = 0) ) AS completed_tabs"),

            ])
            ->where(function ($query) {
                $query->whereNull('c.colflag')
                    ->orWhere('c.colflag', '=', 0);
            })
            ->where('c.cluster_no', 'NOT LIKE', '999%')
            ->groupBy('c.dist_code','c.district','c.cluster_no')
            ->orderBy('c.dist_code', 'asc')
            ->get();
    }

    public static function get_datacollection_table($searchdata)
    {
            //        (select DISTINCT COUNT (hltab) FROM listings where structure_no in (1,2) and hhid = l.hhid AND (colflag is null or colflag=0)) as structures,
        $sql = DB::table('clusters as c');
        $select = " c.district,c.dist_code,c.cluster_no,c.tehsil,c.village,c.village_code,
           (SELECT COUNT(DISTINCT hhid) FROM bl_randomised r WHERE c.cluster_no = r.clustercode  AND (colflag IS NULL OR colflag = 0)) AS hh_randomized,
           (SELECT COUNT(DISTINCT hhid)  FROM form f WHERE c.cluster_no = f.clustercode AND (f.colflag='' or f.colflag IS NULL OR f.colflag = 0) ) AS hh_collected
         ";
        $sql->select(DB::raw($select))->leftJoin('listings as l', 'c.cluster_no', '=', 'l.cluster_no');

        if (isset($searchdata['type']) && $searchdata['type'] == 'c') {

            $sql->whereRaw("c.randomized=1 AND (SELECT COUNT(DISTINCT hhid)  FROM form f WHERE c.cluster_no = f.clustercode AND (f.colflag='' or f.colflag IS NULL OR f.colflag = 0) ) >=
	            (SELECT COUNT(DISTINCT hhid) FROM bl_randomised r WHERE c.cluster_no = r.clustercode  AND (colflag IS NULL OR colflag = 0))");
        } elseif (isset($searchdata['type']) && $searchdata['type'] == 'i') {

            $sql->whereRaw("(SELECT COUNT(DISTINCT hhid)  FROM form f WHERE c.cluster_no = f.clustercode )!=0 AND   (SELECT COUNT(DISTINCT hhid)  FROM form f WHERE c.cluster_no = f.clustercode AND (f.colflag='' or f.colflag IS NULL OR f.colflag = 0) ) !=
	            (SELECT COUNT(DISTINCT hhid) FROM bl_randomised r WHERE c.cluster_no = r.clustercode  AND (colflag IS NULL OR colflag = 0))");;
        } elseif (isset($searchdata['type']) && $searchdata['type'] == 'r') {
            $sql->whereRaw("(SELECT COUNT(DISTINCT hhid)  FROM form f WHERE c.cluster_no = f.clustercode AND (f.colflag='' or f.colflag IS NULL OR f.colflag = 0) )=0");
        } else {
            $cluster_type_where = '';
        }
        if (isset($searchdata['district']) && $searchdata['district'] != '') {
            $dist = $searchdata['district'];
            $sql->where(function ($query) use ($dist) {
                $exp_dist = explode(',', $dist);
                foreach ($exp_dist as $d) {
                    $query->orWhere('c.dist_code', '=', trim($d));
                   // $query->orWhere('c.dist_code', '=', '901');
                }
            });
        }

        $sql->where(function ($query) {
            $query->where('c.colflag')
                ->orWhere('c.colflag', '=', '')
                ->orWhere('c.colflag', '=', '0');
        });

        $sql->where('c.cluster_no', 'NOT LIKE', '999%');
        $sql->groupBy('c.district','c.dist_code','c.cluster_no',  'c.tehsil','c.village','c.village_code');
        $sql->orderBy('c.cluster_no', 'ASC');
        $data = $sql->get();

        return $data;
    }




}
