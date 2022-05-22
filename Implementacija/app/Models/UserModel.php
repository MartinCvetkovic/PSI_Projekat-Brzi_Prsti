<?php
/**
 * Autor:
 * Martin Cvetkovic 19/0284
 */

namespace App\Models;

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
        "username",
        "password",
        "zlato",
        "srebro",
        "bronza",
        "tip",
        "aktivan",
        "brojPrijatelja"
    ];

    /**
     * Funkcija vraca sve korisnike po imenu
     * 
     * @param String $filter filter sa kojim se uporedjuje
     * 
     * @return $users niz korisnika
     */
    public static function dohvatiKorisnike($filter)
    {
        $korisnici = UserModel::where("username","LIKE","%$filter%");
        if(auth()->user()->tip == 0){
            $korisnici = $korisnici->where("aktivan",1);
        }
        $korisnici = $korisnici->get();
                        
        return $korisnici;
    }

    /**
     * Funkcija vraca korisnika po imenu
     * 
     * @param String $username korisnicko ime
     * 
     * @return Authenticatable $user korisnik
     */
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

     /**
     * Funkcija uvecava broj zlata koje korisnik ima za 1
     * i update-uje to u bazi podataka
     * 
     */
    public function addGold() {
        $this->zlato++;
        $this->save();
    }


     /**
     * Funkcija uvecava broj zlata koje korisnik ima za 1
     * i update-uje to u bazi podataka
     * 
     */
    public function addSilver() {
        $this->srebro++;
        $this->save();
    }


     /**
     * Funkcija uvecava broj zlata koje korisnik ima za 1
     * i update-uje to u bazi podataka
     * 
     */
    public function addBronze() {
        $this->bronza++;
        $this->save();
    }

    /**
     * Proverava da li je korisnik blokiran
     * 
     * @param String $username korisnicko ime
     * 
     * @return boolean
     */
    public static function isBlocked($username){
        $user = UserModel::dohvatiKorisnika($username);
        if($user == null){
            return true;
        }
        return ($user->aktivan == 0)? true: false;
    }

}
