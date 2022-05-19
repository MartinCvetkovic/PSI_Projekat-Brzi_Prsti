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

/**
 * Klasa koja omogucava rad sa korisnikom u bazi podataka
 * 
 * @version 1.0
 */
class UserModel extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    /**
     * Naziv tabele.
     *
     * @var String Tabela
     */
    protected $table = "korisnik";

    /**
     * Primarni kljuc.
     *
     * @var Integer Primarni kljuc
     */
    protected $primaryKey = "id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
    
    /**
     * Funkcija za dodavanje korisnika
     * 
     * @param String $username
     * @param String $password
     * @param Integer $zlato
     * @param Integer $srebro
     * @param Integer $bronza
     * @param Integer $tip
     * @param Integer $aktivan
     * @param Integer $brojPrijatelja
     * 
     * @return void
     */
    public static function addUser($username, $password, $zlato, $srebro, $bronza, $tip, $aktivan, $brojPrijatelja){
        $user = new UserModel();
        $user->username = $username;
        $user->password = $password;
        $user->zlato = $zlato;
        $user->srebro = $srebro;
        $user->bronza = $bronza;
        $user->tip = $tip;
        $user->aktivan = $aktivan;
        $user->brojPrijatelja = $brojPrijatelja;
        $user->save();
    }

    /**
     * Vraca lozinku
     * 
     * @return String $password
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

}
