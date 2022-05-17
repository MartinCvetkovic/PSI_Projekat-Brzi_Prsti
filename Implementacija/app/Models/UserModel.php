<?php

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
    public $timestamops = false;

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

    

}
