<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

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
        'idKat',
        'sadrzaj',
        'tezina'
    ];  // Dostupno i word_count, average_time (van Query-a)

    /**
     * Dozvoljava pristup novom "atributu" word_count (broj reči u sadrzaju teksta)
     * Koristiti kao $this->word_count
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getWordCountAttribute()
    {
        return count(preg_split("/\s+/", $this->sadrzaj));
    }

    /**
     * Dozvoljava pristup novom "atributu" average_time (prosečno vreme za kucanje teksta)
     * Koristiti kao $this->average_time
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getAverageTimeAttribute()
    {
        return round(LeaderboardModel::where('idTekst', $this->id)->avg('vreme'), 2);
    }

    /**
    * Funkcija koja vraća kategoriju teksta
    *
    * @return CategoryModel
    *
    */
    public function category() {
        return CategoryModel::where('id', $this->idKat)->first();
    }

    /**
    * Funkcija koja vraća paginator sa tekstovima koji se poklapaju sa kriterijumima pretrage
    *
    * @var integer $idKat Id Kategorije (0 za sve)
    * @var integer $tezina Opcija težine (0 za sve)
    * @var integer $duzina Opcija dužine (0 za sve)
    * @var integer $page Broj stranice rezultata
    *
    * @return Illuminate\Pagination\LengthAwarePaginator
    *
    */
    public static function search($idKat, $tezina, $duzina, $page) {
        $ret = TextModel::select();

        // Provera parametara
        if (CategoryModel::where('id', $idKat)->doesntExist()) $idKat = 0;
        if ($tezina < 0 || $tezina > 3) $tezina = 0;
        if ($duzina < 0 || $duzina > 3) $duzina = 0;

        // Filtriranje po kategoriji
        if ($idKat) $ret = $ret->where('idKat', $idKat);

        // Filtriranje po težini
        if ($tezina) {
            switch($tezina){
                case 1: $ret = $ret->where('tezina', '<=', 4);
                    break;
                case 2: $ret = $ret->where('tezina', '>', 4)->where('tezina', '<=', 7);
                    break;
                case 3: $ret = $ret->where('tezina', '>', 7);
                    break;
            }
        }

        // Filtriranje po dužini teksta
        // Kako word_count ne postoji u bazi, samo u modelu, ovde se nad rezultatom Query-a vrši filtriranje
        if ($duzina) {
            $ret = $ret->get()->filter(function($text) use($duzina) {
                return $text->duzinaCategory() == $duzina;
            });

            // Filter se može zvati samo nad Collection, a paginate ne može nad Collection, tako da se ovde ručno pravi Paginator
            return new LengthAwarePaginator($ret->forPage($page, 5), $ret->count(), 5, $page, ['path' => route('search_texts')]);
        }

        return $ret->paginate(5);
    }

    /**
    * Funkcija koja vraća kategoriju dužine teksta
    *
    * @return integer
    * Jedno od {1, 2, 3}
    * 1 - Kratak tekst (<20 reči)
    * 2 - Srednji tekst (21 - 50 reči)
    * 3 - Dug tekst (>50 reči)
    */
    function duzinaCategory() {
        $words = $this->word_count;
        if ($words <= 20) return 1;
        elseif ($words <= 50) return 2;
        else return 3;
    }

    /**
    * Funkcija koja vraća kategoriju težine teksta
    *
    * @return integer
    * Jedno od {1, 2, 3}
    * 1 - Lak tekst (težina 0-4)
    * 2 - Srednji tekst (težina 4-7)
    * 3 - Tezak tekst (težina 7-10)
    */
    function tezinaCategory() {
        if ($this->tezina <= 4) return 1;
        else if ($this->tezina <= 7) return 2;
        else return 3;
    }

    /**
    * Funkcija koja vraća tekst skraćen na prvih $count reci
    *
    * @var integer $count Broj reči na koji treba skratiti tekst
    *
    * @return string
    *
    */
    public function firstWords($count) {
        if ($this->word_count > $count){
            $words = explode(" ", $this->sadrzaj, $count + 1);
            unset($words[$count]);
            return implode(" ", $words)."...";
        }
            else return $this->sadrzaj;
    }

    /**
    * Funkcija koja vraća sadržaj teksta bez novih redova, tabulacije,
    * duplih razmaka, i bez belina na početku i kraju
    *
    * @return string
    *
    */
    public function cleanText() {
        $text = $this->sadrzaj;
        $text = preg_replace("/\s+/", " ", $text);
        $text = trim($text);

        return $text;
    }
}
