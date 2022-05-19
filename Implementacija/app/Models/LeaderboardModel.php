<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaderboardModel extends Model
{
    use HasFactory;

    /**
     * @var string $table Ime tabele modela u bazi podataka
     */
    protected $table = 'ranglista';
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
    ];


    /** Funkcija koja dodaje novi red u tabelu ranglista
     *
     * @param integer $idKor Id korisnika
     * @param integer $idTekst Id teksta
     * @param double $vreme Vreme za koje je otkucan tekst
     *
     * */
    public static function insert($idKor, $idTekst, $vreme) {
        $entry = new LeaderboardModel();
        $entry->idKor = $idKor;
        $entry->idTekst = $idTekst;
        $entry->vreme = $vreme;

        $entry->save();
    }

    /** Funkcija koja vraca poziciju reda u tabeli ranglista sortiranoj po vremenu rastuce
     *
     * @return integer
     *
     * */
    public function getLeaderboardPosition() {
        return LeaderboardModel::where('idTekst', $this->idTekst)->where('vreme', '<=', $this->vreme - 0.000001)->count() + 1;
    }

}
