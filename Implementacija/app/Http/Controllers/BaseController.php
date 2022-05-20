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
use Illuminate\Support\Facades\Auth;

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
     * @param integer $id Id teksta koji se kuca, ako se ne navede dohvata se random tekst
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


    /** Funkcija koja zavrsava sesiju solo kucanja, ubacuje rezultat pokusaja u bazu
     * , i redirectuje na prikaz rezultata
     * 
     * @param Request $request Http zahtev (POST!)
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * 
     * */
    public function soloKucanjeKraj(Request $request) {
        //Dohvatanje podataka iz $request
        $text = TextModel::where('id', $request->idTekst)->firstOrFail();
        $time = $request->time;

        //Obrada podataka i ubacivanje pokusaja u bazu (ako je korisnik ulogovan)
        $result = LeaderboardModel::create($text->id, $time);
        $speed = $result->wpm;

        //Dohvatanje najboljeg pokusaja za korisnika
        $best = LeaderboardModel::bestForUser($text->id) ?? $result;    //prva vrednost za goste vraca null pa se koristi trenutni pokusaj kao najbolji

        $best_speed = $best->wpm;
        $best_position = $best->rank;
        
        //Redirect na GET zahtev za prikaz rezultata
        return redirect()->route('solo_kucanje_rezultati', [
            'id' => $text->id,
            'speed' => $speed,
            'best_speed' => $best_speed,
            'best_position' => $best_position
        ]);
    }

    
    /** Funkcija koja prikazuje rezultate kucanja
     * 
     * @param Request $request Http zahtev
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * 
     * */
    public function soloKucanjePrikazRezultata(Request $request) {

        return view('soloResults', [
            'text' => TextModel::where('id', $request->id)->firstOrFail(),
            'speed' => $request->speed,
            'best_speed' => $request->best_speed,
            'best_position' => $request->best_position
        ]);
    }
}
