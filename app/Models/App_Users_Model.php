<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class App_Users_Model extends Model
{
    use HasFactory;

    protected $table = 'AppUser';


    public static function getAllData()
    {
        $sql = DB::table('AppUser')->select(db::raw(" distinct AppUser.id ,AppUser.username,
            AppUser.passwordEnc as password,
            AppUser.full_name,
            AppUser.auth_level,
            AppUser.enabled,
            AppUser.designation,
            AppUser.dist_id,
            AppUser.attempt,
            AppUser.attemptDateTime,
            AppUser.isNewUser,
            AppUser.lastPwdChangeBy,
            AppUser.lastPwd_dt,
            districts.district_name "))
            ->join('districts', 'AppUser.dist_id', '=', 'districts.dist_id', 'INNER')
            ->orderBy('AppUser.id', 'desc');

        $sql->where('AppUser.enabled', '=', '1');
        $sql->where(function ($query) {
            $query->whereNull('AppUser.colflag')
                ->orWhere('AppUser.colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }

    public static function checkName($userName)
    {
        $data = DB::table('AppUser')
            ->where('AppUser.enabled', '=', '1')
            ->where('username', $userName)
            ->get();
        return $data;
    }

    public static function getUserDetails($id)
    {
        $data = DB::table('AppUser')
            ->where('id', $id)
            ->get();
        return $data;
    }

}
