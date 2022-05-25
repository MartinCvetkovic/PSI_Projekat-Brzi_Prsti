<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DailyLeaderboardModel extends Model
{
    use HasFactory;

    /**
     * @var string $table Ime tabele modela u bazi podataka
     */
    protected $table = 'dnevnaranglista';
    /**
     * @var string $primaryKey Ime primarnog kljuca tabele modela
     */
    protected $primaryKey = 'id';

    /**
     * @var bool $timestamps Da li se pamti created/last updated u tabeli modela
     */
    public $timestamps = false;

    /**
     * @var array $fillable niz imena ostalih kljuceva tabele modela
     */
    protected $fillable = [
        'idKor',
        'idTekst',
        'vreme'
    ]; //Dostupno i wpm, rank (van Query-a)

    
    /**
     * Dozvoljava pristup novom "atributu" wpm (brzina kucanja u recima po minuti za $this pokusaj)
     * Koristiti kao $this->wpm
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getWpmAttribute()
    {
        return round(TextModel::where('id', $this->idTekst)->first()->word_count / $this->vreme * 60, 2);
    }


    /**
     * Dozvoljava pristup novom "atributu" rank (rangiranje reda)
     * Koristiti kao $this->rank
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getRankAttribute()
    {
        return DailyLeaderboardModel::where('vreme', '<=', $this->vreme - 0.000001)->distinct()->count("idKor") + 1;
    }


    /** Funkcija koja vraca novi DailyLeaderboardModel
     * i cuva ga u bazi ako je korisnik ulogovan
     * i ako se dnevni izazov nije promenio u medjuvremenu
     * 
     * @param integer $idTekst id Teksta koji je kucan
     * @param double $vreme Vreme za koje je otkucan tekst
     * 
     * @return DailyLeaderboardModel
     * */
    public static function create($idTekst, $vreme) {
        $entry = new DailyLeaderboardModel();
        $entry->idKor = Auth::check()? auth()->user()->id : 0;
        $entry->idTekst = $idTekst;
        $entry->vreme = $vreme;

        if (Auth::check() && $idTekst == DailyChallengeModel::getDaily()->idTekst) $entry->save();
        return $entry;
    }


    /** Funkcija koja vraca najbolje pokusaje svih korisnika
     *  Koristiti kao DailyLeaderboardModel::asLeaderboard() ili dodati na vec postojeci query ...->asLeaderboard()->...
     *  (!!) Vraceni redovi vise nemaju id polje (primarni kljuc)
     *  Dodatno pozvati get() za niz DailyLeaderboard modela (bez id) ili dalje nizati ->where()...
     * 
     * @param Illuminate\Database\Eloquent\Builder $query
     * 
     * @return Illuminate\Database\Eloquent\Builder
     * */
    public function scopeAsLeaderboard($query) {
        return $query->groupBy("idKor", "idTekst")->selectRaw("idKor, idTekst, min(vreme) as vreme");
    }


    /** Funkcija koja vraca najbolji pokusaj datog korisnika na dnevnom izazovu
     * 
     * @param integer $idKor Id korisnika, ako se ne navede podrazumeva se trenutno ulogovani korisnik
     * 
     * @return DailyLeaderboardModel
     * */
    public static function bestForUser($idKor = 0) {
        if ($idKor == 0) {
            if (Auth::check())
                $idKor = auth()->user()->id;
                else return null;
        }

        return DailyLeaderboardModel::where('idKor', $idKor)->orderBy('vreme', 'asc')->first();
    }


    /** Funkcija koja vraca naziv nagrade koju korisnik moze da dobije
     * na osnovu ovog pokusaja
     *
     * @return string Jedno od {"gold", "silver", "bronze", "none"}
     * */
    public function reward() {
        $place = $this->rank;
        if ($place == 1) return "gold";
        else if ($place <= 3) return "silver";
        else if ($place <= 10) return "bronze";
        
        return "none";
    }

    /** Funkcija koja premesta $this red u tabelu ranglista
     * 
     * */
    public function moveToLeaderboard () {
        $entry = new LeaderboardModel();
        $entry->vreme = $this->vreme;
        $entry->idTekst = $this->idTekst;
        $entry->idKor = $this->idKor;

        $entry->save();
        $this->delete();
    }

    /** Funkcija koja vraca UserModel pokusaja
     * 
     * @return UserModel
     * */
    public function user() {
        return UserModel::where('id', $this->idKor)->first();
    }
}
