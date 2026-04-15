<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class App_Users_Model extends Model
{
    use HasFactory;

    protected $table = 'Users';


    public static function getAllData()
    {
        $sql = DB::table('Users')->select(db::raw(" distinct Users.id ,Users.username,
            Users.passwordEnc as password,
            Users.full_name,
            Users.auth_level,
            Users.enabled,
            Users.designation,
            Users.dist_id,
            Users.attempt,
            Users.attemptDateTime,
            Users.isNewUser,
            Users.lastPwdChangeBy,
            Users.lastPwd_dt,
            districts.district_name "))
            ->join('districts', 'Users.dist_id', '=', 'districts.dist_id', 'INNER')
            ->orderBy('Users.id', 'desc');

        $sql->where('Users.enabled', '=', '1');
        $sql->where(function ($query) {
            $query->whereNull('Users.colflag')
                ->orWhere('Users.colflag', '=', '0');
        });
        $data = $sql->get();
        return $data;
    }

    public static function checkName($userName)
    {
        $data = DB::table('Users')
            ->where('Users.enabled', '=', '1')
            ->where('username', $userName)
            ->get();
        return $data;
    }

    public static function getUserDetails($id)
    {
        $data = DB::table('Users')
            ->where('id', $id)
            ->get();
        return $data;
    }

}
