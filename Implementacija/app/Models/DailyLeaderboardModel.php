<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Klasa za model rang liste za dnevni izazov
 *
 * @version 1.0
 */
class DailyLeaderboardModel extends Model
{
    use HasFactory;

    /**
     * @var string $table Ime tabele modela u bazi podataka
     */
    protected $table = 'dnevnaranglista';
    /**
     * @var string $primaryKey Ime primarnog ključa tabele modela
     */
    protected $primaryKey = 'id';

    /**
     * @var bool $timestamps Da li se pamti created/last updated u tabeli modela
     */
    public $timestamps = false;

    /**
     * @var array $fillable Niz imena ostalih ključeva tabele modela
     */
    protected $fillable = [
        'idKor',
        'idTekst',
        'vreme'
    ]; // Dostupno i wpm, rank (van Query-a)

    /**
     * Dozvoljava pristup novom "atributu" wpm (brzina kucanja u rečima po minuti za $this pokušaj)
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

    /** Funkcija koja vraća novi DailyLeaderboardModel
     * i čuva ga u bazi ako je korisnik ulogovan
     * iako se dnevni izazov nije promenio u međuvremenu
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

    /** Funkcija koja vraća najbolje pokušaje svih korisnika
     *  Koristiti kao DailyLeaderboardModel::asLeaderboard() ili dodati na vec postojeći query ...->asLeaderboard()->...
     *  (!!) Vraćeni redovi više nemaju id polje (primarni kljuc)
     *  Dodatno pozvati get() za niz DailyLeaderboard modela (bez id) ili dalje nizati ->where()...
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     *
     * @return Illuminate\Database\Eloquent\Builder
     * */
    public function scopeAsLeaderboard($query) {
        return $query->groupBy("idKor", "idTekst")->selectRaw("idKor, idTekst, min(vreme) as vreme");
    }

    /** Funkcija koja vraća najbolji pokušaj datog korisnika na dnevnom izazovu
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


    /** Funkcija koja vraća naziv nagrade koju korisnik može da dobije
     * na osnovu ovog pokušaja
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

    /** Funkcija koja premešta $this red u tabelu ranglista
     * */
    public function moveToLeaderboard () {
        $entry = new LeaderboardModel();
        $entry->vreme = $this->vreme;
        $entry->idTekst = $this->idTekst;
        $entry->idKor = $this->idKor;

        $entry->save();
        $this->delete();
    }

    /** Funkcija koja vraća UserModel pokušaja
     *
     * @return UserModel
     * */
    public function user() {
        return UserModel::where('id', $this->idKor)->first();
    }
}
