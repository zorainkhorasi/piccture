<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class linelisting_model extends Model
{
    use HasFactory;

    public static function getClustersProvince()
    {
        $sql = DB::table('clusters');
        $sql->select(DB::raw('distinct dist_code as district_code,district as district_name,COUNT (dist_code) AS totalDistrict'));

        $sql->groupBy('dist_code', 'district');

        $sql->where(function ($query) {
            $query->whereNull('colflag')
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
                'l.hl05 as district_l',
                'c.district',
                'l.cluster_no',
                'c.dist_code',
                DB::raw("(SELECT COUNT(DISTINCT hltab)
                    FROM listings
                    WHERE cluster_no = l.cluster_no
                    AND (hl14 NOT LIKE 'Deleted' OR hl14 IS NULL)
                    AND (colflag IS NULL OR colflag = '' OR colflag = 0)) AS collecting_tabs"),
                DB::raw("(SELECT COUNT(DISTINCT hltab)
                    FROM listings
                    WHERE cluster_no = l.cluster_no
                    and hl10=8
                    AND (hl14 NOT LIKE 'Deleted' OR hl14 IS NULL)
                    AND (colflag IS NULL OR colflag = '' OR colflag = 0)) AS completed_tabs"),

            ])
            ->leftJoin('listings as l', 'c.cluster_no', '=', 'l.cluster_no')
            ->Where('l.username', 'NOT LIKE', '%test%')
            ->where(function ($query) {
                $query->whereNull('l.colflag')
                    ->orWhere('l.colflag', '=', '')
                    ->orWhere('l.colflag', '=', 0);
            })
            ->where(function ($query) {
                $query->whereNull('c.colflag')
                    ->orWhere('c.colflag', '=', '')
                    ->orWhere('c.colflag', '=', 0);
            })
            ->where(function ($query) {
                $query->where('hl20', '!=', '')
                    ->orWhere('hl14', 'NOT LIKE', 'Deleted');
            })
            ->where('c.cluster_no', 'NOT LIKE', '999%')
            ->groupBy('c.district', 'c.dist_code', 'l.colflag', 'l.hl05', 'l.cluster_no')
            ->orderBy('l.cluster_no', 'asc')
            ->orderBy('c.dist_code', 'asc')
            ->get();
    }


//(select DISTINCT COUNT (structure_no) FROM listings  where hl11 = '1' and	 (hl14!='Deleted' or hl14 is null) AND hh13=1 and cluster_no = l.cluster_no AND (colflag is null or colflag=0)) as eligible_households,
//(select sum(cast(hh13a as int)) from listings where hl11 = '1' and	 (hl14!='Deleted' or hl14 is null) and cluster_no = l.cluster_no AND (colflag is null or colflag=0)) as no_of_eligible_wras,
    public static function get_linelisting_table($searchdata)
    {
        $sql = DB::table('clusters as c');

        $select = "
        c.dist_code,
        c.cluster_no,
        l.hl05,
        l.cluster_no,
        c.randomized,
        c.town,
        d.randomize, d.rand_backup,

       (
            SELECT STRING_AGG(CAST(t.hl08 AS VARCHAR(MAX)), ' , ')
            FROM (
                SELECT DISTINCT hl08
                FROM listings
                WHERE cluster_no = l.cluster_no
                  AND (colflag IS NULL OR colflag = 0)
                  AND hl08 IS NOT NULL
            ) t
        ) AS hl08,

        (SELECT COUNT(*) FROM (
            SELECT DISTINCT structure_no, hltab
            FROM listings
            WHERE (colflag IS NULL OR colflag = 0)
              AND (hl14 != 'Deleted' OR hl14 IS NULL)
              AND cluster_no = l.cluster_no
        ) AS structures) AS structures,

        (SELECT COUNT(DISTINCT structure_no)
         FROM listings
         WHERE hl11 = '1'
           AND (hl14 != 'Deleted' OR hl14 IS NULL)
           AND cluster_no = l.cluster_no
           AND (colflag IS NULL OR colflag = 0)
        ) AS residential_structures,

        (SELECT COUNT(DISTINCT hhid)
         FROM listings
         WHERE hl11 = '1'
           AND (hl14 != 'Deleted' OR hl14 IS NULL)
           AND hl15 > 0 AND hl15bx > 0 AND hl15cx > 0
           AND cluster_no = l.cluster_no
           AND (colflag IS NULL OR colflag = 0)
        ) AS eligible_households,

        (SELECT COUNT(DISTINCT hltab)
         FROM listings
         WHERE cluster_no = l.cluster_no
           AND (hl14 NOT LIKE 'Deleted' OR hl14 IS NULL)
           AND (colflag IS NULL OR colflag = 0)
        ) AS collecting_tabs,

        (SELECT COUNT(DISTINCT hltab)
         FROM listings
         WHERE cluster_no = l.cluster_no
           AND hl10 = 8
           AND (hl14 NOT LIKE 'Deleted' OR hl14 IS NULL)
           AND (colflag IS NULL OR colflag = 0)
        ) AS completed_tabs
    ";

        $sql->select(DB::raw($select))
            ->join('districts as d', 'd.dist_id', '=', 'c.dist_code')
            ->leftJoin('listings as l', function ($join) {
        $join->on('c.cluster_no', '=', 'l.cluster_no')
            ->where(function ($q) {
                $q->where('l.username', 'NOT LIKE', '%test%');
            })
            ->where(function ($q) {
                $q->whereNull('l.colflag')
                    ->orWhere('l.colflag', '')
                    ->orWhere('l.colflag', '0');
            })
            ->where(function ($query) {
                $query->whereNull('l.hl20')
                    ->orWhere('l.hl20', '!=', '1');
            })
            ->where(function ($q) {
                $q->whereNull('l.colflag')
                    ->orWhere('l.colflag', '')
                    ->orWhere('l.colflag', '0');
            });
        });

        // Cluster type filters
        if (isset($searchdata['type']) && $searchdata['type'] == 'c') {

            $sql->whereRaw("
            (SELECT COUNT(DISTINCT deviceid)
             FROM listings
             WHERE hhid = l.hhid
               AND hl05 = l.hl05
               AND (colflag IS NULL OR colflag = 0)
            ) != 0

            AND

            (SELECT COUNT(DISTINCT hltab)
             FROM listings
             WHERE cluster_no = c.cluster_no
               AND (colflag = '' OR colflag = '0' OR colflag IS NULL)
            ) =

            (SELECT COUNT(DISTINCT hltab)
             FROM listings
             WHERE hl10 = '8'
               AND cluster_no = c.cluster_no
               AND (colflag = '' OR colflag = '0' OR colflag IS NULL)
            )
        ");

        }
        elseif (isset($searchdata['type']) && $searchdata['type'] == 'i') {

            $sql->whereRaw("
            (SELECT COUNT(DISTINCT hltab)
             FROM listings
             WHERE cluster_no = c.cluster_no
               AND (colflag = '' OR colflag = '0' OR colflag IS NULL)
            ) !=
            (SELECT COUNT(DISTINCT hltab)
             FROM listings
             WHERE hl10 = '8'
               AND cluster_no = c.cluster_no
               AND (colflag = '' OR colflag = '0' OR colflag IS NULL)
            )
        ");

        }
        elseif (isset($searchdata['type']) && $searchdata['type'] == 'r') {

            $sql->whereRaw("
            (SELECT COUNT(DISTINCT deviceid)
             FROM listings
             WHERE hhid = l.hhid
               AND hl05 = l.hl05
               AND (hl20 != '1' OR hl20 IS NULL)
               AND (colflag IS NULL OR colflag = 0)
            ) = 0
        ");
        }

        // District filter
        if (isset($searchdata['district']) && $searchdata['district'] != '') {
            $dist = $searchdata['district'];

            $sql->where(function ($query) use ($dist) {
                $exp_dist = explode(',', $dist);
                foreach ($exp_dist as $d) {
                    $query->orWhere('c.dist_code', '=', trim($d));
                }
            });
        }



        $sql->where(function ($query) {
            $query->whereNull('c.colflag')
                ->orWhere('c.colflag', '=', '')
                ->orWhere('c.colflag', '=', '0');
        });

        $sql->where('c.cluster_no', 'NOT LIKE', '999%');

        // ✅ IMPORTANT: hl08 removed from groupBy
        $sql->groupBy(
            'c.dist_code',
            'c.cluster_no',
            'l.hl05',
            'l.cluster_no',
            'c.randomized',
            'c.town',
            'd.randomize', 'd.rand_backup'
        );

        $sql->orderBy('c.cluster_no', 'ASC');
        $sql->orderBy('l.hl05', 'ASC');

        return $sql->get();
    }

    /*============================ Systematic Randomization ============================*/
    public static function get_rand_cluster($cluster)
    {
        $sql = DB::table('clusters as c')->select('c.randomized');
        $sql->where('cluster_no', '=', $cluster);
        $sql->where(function ($query) {
            $query->whereNull('c.colflag')
                ->orWhere('c.colflag', '=', '0')
                ->orWhere('c.colflag', '=', '');
        });

        $data = $sql->get();
        return $data;
    }

    public static function chkDuplicateTabs($cluster)
    {
        $sql = DB::table('listings');
        $select = "COUNT ((hltab + '-' + cluster_no + '-' + hhid)) AS duplicates,(hltab + '-' + cluster_no + '-' + hhid) AS hh";
        $sql->select(DB::raw($select));
        $sql->where('cluster_no', '=', $cluster);
        $sql->where(function ($query) {
            $query->whereNull('colflag')
                ->orWhere('colflag', '=', '')
                ->orWhere('colflag', '=', '0');
        });

        $sql->where(function ($query) {
            $query->where('hl20')
                ->orWhere('hl20', '!=', '1');
        });
        $sql->where(function ($query) {
            $query->where('hhid')
                ->orWhere('hhid', '!=', '');
        });

        $sql->Where('username', 'NOT LIKE', '%test%');
        $sql->groupByRaw("(hltab + '-' + cluster_no + '-' + hhid)");
        $sql->havingRaw("(COUNT (hltab + '-' + cluster_no + '-' + hhid)) > 1");
        $data = $sql->get();
       // echo '<pre>';
       // print_r($data);die;
        return $data;
    }

    public static function get_systematic_rand($cluster)
    {

        $sql = DB::table('listings as l');

        $sql->select(DB::raw("
        hhid, dist_code, col_id, hltab, hl08, cluster_no,  structure_no, hl10, hl11, hhid, hl14, hl_d, hl05, _uid"));

        $sql->where('l.cluster_no', $cluster);
        $sql->where('l.hl11', '1');
        $sql->where('l.hl15', '>', 0);
        $sql->where('l.hl15cx', '>', 0);
        $sql->where('l.hl15bx', '>', 0);

        $sql->where(function ($query) {
            $query->whereNull('l.colflag')
                ->orWhere('l.colflag', '')
                ->orWhere('l.colflag', '0');
        });

        $sql->where('l.username', 'NOT LIKE', '%test%');
        $sql->where('l.hl14', 'NOT LIKE', '%Deleted%');

        $sql->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('bl_randomised as b')
                ->whereColumn('b.clustercode', 'l.cluster_no')
                ->whereColumn('b.hhid', 'l.hhid')
                ->where(function ($q) {
                    $q->whereNull('b.colflag')
                        ->orWhere('b.colflag', '')
                        ->orWhere('b.colflag', '0');
                });
        });
        $sql->orderByRaw("hltab, deviceid, CAST(structure_no as INT)");
        return $sql->get();


    }

    public static function get_cluster_settings($cluster)
    {
        return DB::table('districts as d')
            ->join('clusters as c', 'd.dist_id', '=', 'c.dist_code')
            ->where('c.cluster_no', $cluster)
            ->where(function ($query) {
                $query->whereNull('c.colflag')
                    ->orWhere('c.colflag', '')
                    ->orWhere('c.colflag', '0');
            })
            ->select('d.randomize', 'd.rand_backup')
            ->first();
    }

    public static function get_randomized_table($cluster,$r_type)
    {
        $sql = DB::table('bl_randomised');
        $select = "Listings.hl14a,Listings.hl14c,bl_randomised.dist_id,bl_randomised.hhid,clustercode,bl_randomised.head, bl_randomised.randDT,bl_randomised.compid,bl_randomised.hltab,
        clusters.district,clusters.tehsil,clusters.uc,clusters.village";
        $sql->select(DB::raw($select))
            ->leftJoin('clusters', 'bl_randomised.clustercode', '=', 'clusters.cluster_no')
            ->leftJoin('Listings', function ($join) {
                $join->on('bl_randomised.clustercode', '=', 'Listings.cluster_no')
                    ->on('Listings.hhid', '=', 'bl_randomised.hhid')
                    ->on('Listings._uid', '=', 'bl_randomised.luid'); // Use `on()` instead of `where()`
            });

        $sql->where('bl_randomised.clustercode', '=', $cluster);

        if($r_type==1){
            $sql->where('bl_randomised.isBackup', '=', $r_type);
        }else{
            $sql->where(function ($query) {
                $query->whereNull('bl_randomised.isBackup')
                    ->orWhere('bl_randomised.isBackup', '=', '')
                    ->orWhere('bl_randomised.isBackup', '=', '0');
            });
        }

        $sql->where(function ($query) {
            $query->where('bl_randomised.colflag')
                ->orWhere('bl_randomised.colflag', '=', '')
                ->orWhere('bl_randomised.colflag', '=', '0');
        });
        $sql->orderByRaw("bl_randomised.sno,bl_randomised._id");
        $data = $sql->get();



       // echo '<pre>';print_r($data);die;
        return $data;

    }


}
