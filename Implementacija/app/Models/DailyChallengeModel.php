<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyChallengeModel extends Model
{
    use HasFactory;

    /**
     * @var string $table Ime tabele modela u bazi podataka
     */
    protected $table = 'dnevniizazov';
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
        'sadrzaj',
        'tezina',
        'nazivKategorije',
        'idTekst'
    ];  //Dostupno i word_count, average_time (van Query-a)


    /**
    * Funkcija koja vraca TextModel sa id == $this->idTekst
    *
    * @return TextModel
    *
    */
    public function text() {
        return TextModel::where('id', $this->idTekst)->first();
    }


    /**
     * Dozvoljava pristup novom "atributu" average_time (prosecno vreme za kucanje teksta)
     * Koristiti kao $this->average_time
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getAverageTimeAttribute()
    {
        return round(DailyLeaderboardModel::avg('vreme'), 2);
    }


    /**
     * Dozvoljava pristup novom "atributu" word_count (broj reci u sadrzaju teksta)
     * Koristiti kao $this->word_count
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getWordCountAttribute()
    {
        return str_word_count($this->sadrzaj);
    }


    /**
    * Funkcija koja vraca kategoriju dnevnog izazova
    *
    * @return CategoryModel
    *
    */
    public function category() {
        return $this->text()->category();
    }
    
    
    /**
    * Funkcija koja vraca tekst dnevnog izazova skracen na prvih $count reci
    * 
    * @var integer $count Broj reci na koji treba skratiti tekst
    *
    * @return string
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


    /**
    * Funkcija koja vraca dnevni izazov ako je postavljen
    * U suprotnom vraca null
    *
    * @return DailyChallengeModel
    */
    public static function getDaily() {
        return DailyChallengeModel::first();
    }


    /**
    * Funkcija koja vraca dnevni izazov ako je postavljen
    * U suprotnom vraca 404
    *
    * @return DailyChallengeModel
    */
    public static function getDailyOrFail() {
        if (($t = self::getDaily()) == null) abort(404);
        return $t;
    }


    /**
    * Funkcija koja menja dnevni izazov u drugi nasumican tekst
    * Svi pokusaji iz tabele dnevnaranglista se prebacuju u tabelu ranglista
    *
    * Vraca 404 ako ne postoji nijedan drugi tekst u bazi
    */
    public static function changeDaily() {
        //Dohvatanje starog dnevnog izazova
        $daily = DailyChallengeModel::getDaily();
        $oldDailyId = $daily->idTekst ?? 0;

        //Odredjivanje novog teksta za dnevni izazov (mora da se razlikuje od trenutnog daily)
        $newText = TextModel::where('id', '!=', $oldDailyId)->inRandomOrder()->firstOrFail();
        
        //Stvaranje novog modela za novi dnevni izazov
        $newDaily = new DailyChallengeModel();

        $newDaily->idTekst = $newText->id;
        $newDaily->sadrzaj = $newText->sadrzaj;
        $newDaily->tezina = $newText->tezina;
        $newDaily->nazivKategorije = $newText->category()->naziv;

        //Brisanje starog dnevnog izazova iz baze (brisanje svih redova tabele za svaki slucaj)
        DailyChallengeModel::query()->delete();

        //Prolazak kroz najbolje rezultate na izazovu i deljenje nagrada
        $breakTwice = false;
        foreach (DailyLeaderboardModel::asLeaderboard()->orderBy('vreme', 'asc')->get() as $row) {
            $user = UserModel::where('id', $row->idKor)->first();
            if ($user == null) continue;

            switch($row->reward()) {
                case "gold":
                    $user->addGold();
                    break;
                case "silver":
                    $user->addSilver();
                    break;
                case "bronze":
                    $user->addBronze();
                    break;
                default:
                    $breakTwice = true;
                    break;
            }
            if ($breakTwice) break;
        }

        //Prebacivanje rezultata dnevnog izazova u normalnu rang listu
        foreach (DailyLeaderboardModel::all() as $row) {
            $row->moveToLeaderboard();
        }

        //Pamcenje novog dnevnog izazova u bazi podataka
        $newDaily->save();
    }
}
