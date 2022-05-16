<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
* TextModel – klasa za upravljanje tekstovima u bazi
*
* @version 1.0
*/
class TextModel extends Model
{
    use HasFactory;

    /**
     * @var string $table Ime tabele modela u bazi podataka
     */
    protected $table = 'tekst';
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
        'idKat',
        'sadrzaj',
        'tezina'
    ];

    /**
    * Funkcija koja vraca kategoriju teksta
    *
    * @return Response
    *
    */
    public function category() {
        return CategoryModel::where('id', $this->idKat)->first();
    }    
}
