<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JePrijateljModel extends Model
{
    use HasFactory;

    /**
     * @var string $table Ime tabele modela u bazi podataka
     */
    protected $table = 'jeprijatelj';
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
        'idKor1',
        'idKor2'
    ];

    /** Funkcija koja dodaje novi red u tabelu jeprijatelj
     *
     * @param integer $idKor Id korisnika
     * @param integer $idTekst Id teksta
     * @param double $vreme Vreme za koje je otkucan tekst
     *
     * */
    public static function insert($idKor1, $idKor2) {
        $entry = new JePrijateljModel();
        $entry->idKor1 = $idKor1;
        $entry->idKor2 = $idKor2;
        $entry->save();
    }
}
