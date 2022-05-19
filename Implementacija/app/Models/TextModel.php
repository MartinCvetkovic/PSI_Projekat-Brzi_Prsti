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
    ];  //Dostupno i word_count, average_time (van Query-a)

    /**
     * Dozvoljava pristup novom "atributu" word_count (broj reci u sadrzaju teksta)
     * Koristiti kao $this->word_count
     *
     * @return integer
     */
    public function getWordCountAttribute()
    {
        return str_word_count($this->sadrzaj);
    }

    /**
     * Dozvoljava pristup novom "atributu" average_time (prosecno vreme za kucanje teksta)
     * Koristiti kao $this->average_time
     *
     * @return double
     */
    public function getAverageTimeAttribute()
    {
        return round(LeaderboardModel::where('idTekst', $this->id)->avg('vreme'), 2);
    }

    /**
    * Funkcija koja vraca kategoriju teksta
    *
    * @return CategoryModel
    *
    */
    public function category() {
        return CategoryModel::where('id', $this->idKat)->first();
    }
    
    /**
    * Funkcija koja vraca sve tekstove koji se poklapaju sa kriterijumima pretrage
    * 
    * @var integer $idKat Id Kategorije (0 za sve)
    * @var integer $tezina Opcija tezine (0 za sve)
    * @var integer $duzina Opcija duzine (0 za sve)
    * @var integer $page Broj stranice rezultata
    *
    * @return array[TextModel] 
    *
    */
    public static function search($idKat, $tezina, $duzina, $page) {
        $ret = TextModel::select();

        //Provera parametara
        if (CategoryModel::where('id', $idKat)->doesntExist()) $idKat = 0;
        if ($tezina < 0 || $tezina > 3) $tezina = 0;
        if ($duzina < 0 || $duzina > 3) $duzina = 0;
        
        //Filtriranje po kategoriji
        if ($idKat) $ret = $ret->where('idKat', $idKat);

        //Filtriranje po tezini
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

        //Filtriranje po duzini teksta
        //Kako word_count ne postoji u bazi, samo u modelu, ovde se nad rezultatom Query-a vrsi filtriranje
        if ($duzina) {
            switch($duzina){
                case 1: $ret = $ret->get()->filter(function($text) {
                    return $text->word_count <= 20;
                });
                    break;
                case 2: $ret = $ret->get()->filter(function($text) {
                    return $text->word_count > 20 && $text->word_count <= 50;
                });
                    break;
                case 3: $ret = $ret->get()->filter(function($text) {
                    return $text->word_count > 50;
                });
                    break;
            }

            //Filter se moze zvati samo nad Collection, a paginate ne moze nad Collection, tako da se ovde rucno pravi Paginator
            return new LengthAwarePaginator($ret->forPage($page, 5), $ret->count(), 5, $page, ['path' => route('search_texts')]);
        }

        return $ret->paginate(5);
    }

    /**
    * Funkcija koja vraca prvih N reci teksta
    * 
    * @var integer $count Broj stranice rezultata
    *
    * @return array[TextModel] 
    *
    */
    public function firstWords($count) {
        if ($this->word_count > 10){
            $words = explode(" ", $this->sadrzaj, $count + 1);
            unset($words[$count]);
            return implode(" ", $words)."...";
        }
            else return $this->sadrzaj;
    }
}
