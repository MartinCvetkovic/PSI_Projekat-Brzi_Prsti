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


    /**
     * Funkcija koja vraca preporucenu tezinu tekstova za korisnika
     * na osnovu njegove prosecne brzine kucanja
     * 
     * @return integer
     * Vraca jedno od {0, 1, 2, 3}
     * 0 - ako korisnik nije kucao nijedan tekst,
     * 1 - prosecna brzina ispod 30,
     * 2 - prosecna brzina 30-70,
     * 3 - prosecna brzina iznad 70
     */
    function getRecommendedDifficulty() {
        $avgsPerText = LeaderboardModel::where('idKor', $this->id)->groupBy('idTekst')->selectRaw('idTekst, avg(vreme) as vreme')->get();

        $count = 0;
        $averageWpm = 0;

        foreach ($avgsPerText as $row) {
            $averageWpm += $row->wpm;
            $count++;
        }

        if ($count == 0) return 0;
        $averageWpm /= $count;

        if ($averageWpm < 30) return 1;
        else if ($averageWpm <= 70) return 2;
        else return 3;
    }


    /**
     * Funkcija koja vraca preporucenu duzinu tekstova za korisnika
     * na osnovu duzine tekstova koje je ranije kucao
     * 
     * @return integer
     * Vraca jedno od {0, 1, 2, 3}
     * 0 - ako je korisnik jednako kucao sve duzine tekstova,
     * 1 - ako je kucao najvise kratkih tekstova,
     * 2 - ako je kucao najvise srednjih tekstova,
     * 3 - ako je kucao najvise dugih tekstova
     */
    function getRecommendedLength() {
        $short = 0;
        $medium = 0;
        $long = 0;

        foreach (LeaderboardModel::where('idKor', $this->id)->distinct()->get(['idTekst']) as $row) {
            $length = $row->text()->duzinaCategory();

            switch($length) {
                case 1: $short++; break;
                case 2: $medium++; break;
                case 3: $long++; break;
            }
        }
        
        if ($short > ($medium + $long)) return 1;
        if ($medium > ($short + $long)) return 2;
        if ($long > ($short + $medium)) return 3;
        return 0;
    }
}
