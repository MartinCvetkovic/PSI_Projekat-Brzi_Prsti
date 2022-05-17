<?php
/**
 * Autor:
 * Martin Cvetkovic 19/0284
 */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "korisnik";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        "id",
        "username",
        "password",
        "zlato",
        "srebro",
        "bronza",
        "tip",
        "aktivan",
        "brojPrijatelja"
    ];

    public static function dohvatiKorisnike($filter)
    {
        $korisnici = UserModel::where("username","LIKE","%$filter%")->get();
        return $korisnici;
    }
    public static function dohvatiKorisnika($username)
    {
        $ret = UserModel::where("username",$username)->first();
        return $ret;

    }
    

}
