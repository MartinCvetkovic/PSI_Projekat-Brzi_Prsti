<?php

/**
 * Autor:
 * Martin Cvetkovic 19/0284
 * Petar Tirnanic 19/0039
 */

namespace App\Http\Controllers;

use App\Models\LeaderboardModel;
use App\Models\TextModel;
use Illuminate\Http\Request;

/**
 * Klasa koja sadrzi zajednicke funkcionalnosti za sve kontrolere
 */
class BaseController extends Controller
{
    /**
     * Funkcija za prikaz pocetne strane
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function homePage()
    {
        return view("home");
    }
    
    /** Funkcija koja zapocinje solo brzo kucanje nad tekstom datog Id-a
     *  Ako tekst ne postoji, salje korisnika na 404 Not Found
     * 
     * @param integer $id=0 Id teksta koji se kuca, 0 za random text
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function soloKucanje($id = 0) {

        if ($id == 0){
            $text = TextModel::inRandomOrder()->firstOrFail();
        }
        else 
            $text = TextModel::where('id', $id)->firstOrFail();

        return view('solo', ['text' => $text]);
    }

    /** Funkcija koja zavrsava sesiju solo kucanja, prikazuje i ubacuje rezultat pokusaja u bazu
     * 
     * @param Request $request Http zahtev
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function soloKucanjeKraj(Request $request) {

        //Funkcija nije zavrsena, ne dirati nista
        

        $text = TextModel::where('id', $request->idTekst)->first() ?? TextModel::inRandomOrder()->firstOrFail();
        $time = $request->time ?? round(random_int(500, 3000) / 100.0, 2);
        $mistakes = $request->errors ?? random_int(0, 5);

        $speed = round(($text->word_count / $time) * 60, 2);

        //if (auth()->user())
            $idKor = auth()->user()->id ?? 1;
            //Napraviti PostRedirectGet na kraju
            LeaderboardModel::insert($idKor, $text->id, $time);
            
            $best = LeaderboardModel::where('idTekst', $text->id)->where('idKor', $idKor)->orderBy('vreme', 'asc')->first();
            $best_speed = round($text->word_count / $best->vreme * 60, 2);
            $best_position = $best->getLeaderboardPosition();
        /*else {
            //$best_speed = 0;
            //$best_position = 0;
        }*/

        
        return view('soloEnd', [
            'text' => $text,
            'time' => $time,
            'mistakes' => $mistakes,
            'speed' => $speed,
            'best_speed' => $best_speed,
            'best_position' => $best_position
        ]);
    }

}
