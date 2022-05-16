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

    protected $fillable = [
        "username",
        "password",
        "zlato",
        "srebro",
        "bronza",
        "tip",
        "aktivan",
        "brojPrijatelja"
    ];

    

}
