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
 * Klasa za model rang liste
 *
 * @version 1.0
 */
class LeaderboardModel extends Model
{
    use HasFactory;

    /**
     * @var string $table Ime tabele modela u bazi podataka
     */
    protected $table = 'ranglista';
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
     * Koristiti kao $this->wpm
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getWpmAttribute()
    {
        return round(TextModel::where("id", $this->idTekst)->first()->word_count / $this->vreme * 60, 2);
    }

    /**
     * Dozvoljava pristup novom "atributu" rank (rangiranje reda za dati tekst)
     * Koristiti kao $this->rank
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getRankAttribute()
    {
        return LeaderboardModel::where('idTekst', $this->idTekst)->where('vreme', '<=', $this->vreme - 0.01)->distinct()->count("idKor") + 1;
    }

    /** Funkcija koja vraća novi LeaderboardModel
     * i čuva ga u bazi ako je korisnik ulogovan
     *
     * @param integer $idTekst Id teksta
     * @param double $vreme Vreme za koje je otkucan tekst
     *
     * @return LeaderboardModel
     * */
    public static function create($idTekst, $vreme) {
        $entry = new LeaderboardModel();
        $entry->idKor = Auth::check()? auth()->user()->id : 0;
        $entry->idTekst = $idTekst;
        $entry->vreme = $vreme;

        if (Auth::check()) $entry->save();
        return $entry;
    }

    /** Funkcija koja vraća najbolje pokušaje svih korisnika za svaki tekst
     *  Koristiti kao LeaderboardModel::asLeaderboard() ili dodati na vec postojeci query ...->asLeaderboard()->...
     *  (!!) Vraćeni redovi više nemaju id polje (primarni kljuc)
     *  Dodatno pozvati get() za niz LeaderboardModel-a (bez id) ili dalje nizati ->where()...
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     *
     * @return Illuminate\Database\Eloquent\Builder
     * */
    public function scopeAsLeaderboard($query) {
        return $query->groupBy("idKor", "idTekst")->selectRaw("idKor, idTekst, min(vreme) as vreme");
    }

    /** Funkcija koja vraća najbolji pokušaj datog korisnika na datom tekstu
     *
     * @param integer $idTekst Id teksta
     * @param integer $idKor Id korisnika, ako se ne navede podrazumeva se trenutno ulogovani korisnik
     *
     * @return LeaderboardModel
     * */
    public static function bestForUser($idTekst, $idKor = 0) {
        if ($idKor == 0) {
            if (Auth::check())
                $idKor = auth()->user()->id;
                else return null;
        }

        return LeaderboardModel::where('idTekst', $idTekst)->where('idKor', $idKor)->orderBy('vreme', 'asc')->first();
    }

    /** Funkcija koja vraća TextModel pokušaja
     *
     * @return TextModel
     * */
    public function text() {
        return TextModel::where('id', $this->idTekst)->first();
    }

    /** Funkcija koja vraća UserModel pokušaja
     *
     * @return UserModel
     * */
    public function user() {
        return UserModel::where('id', $this->idKor)->first();
    }
}
