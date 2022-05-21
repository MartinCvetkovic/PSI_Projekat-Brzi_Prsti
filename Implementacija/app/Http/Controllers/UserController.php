<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
    Aleksa Savic, 19/0595,
    Martin Cvetkovic 19/0284
*/

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\DailyChallengeModel;
use App\Models\DailyLeaderboardModel;
use App\Models\TextModel;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    
    /**
     * Konstruktor sa podesavanjem middleware-a
     */
    function __construct() {
        $this->middleware('auth');
    }

    /**
     * Funkcija za odjavljivanje
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function logout()
    {
        auth()->logout();
        return redirect()->route('homePage');
    }
    

    /** Funkcija koja prikazuje listu svih tekstova
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showTexts()
    {
        $texts = TextModel::paginate(5);
        $categories = CategoryModel::all();

        return view('texts', [
            'texts' => $texts,
            'categories' => $categories,
            'kategorija' => '',
            'tezina' => '',
            'duzina' => ''
        ]);
    }


    /** Funkcija koja prikazuje listu tekstova koji zadovoljavaju kriterijume pretrage
     * @param Request $request Http zahtev
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function searchTexts(Request $request)
    {
        $texts = TextModel::search($request->kategorija, $request->tezina, $request->duzina, $request->page);
        $categories = CategoryModel::all();

        return view('texts', [
            'texts' => $texts,
            'categories' => $categories,
            'kategorija' => $request->kategorija,
            'tezina' => $request->tezina,
            'duzina' => $request->duzina
        ]);
    }


    /** Funkcija koja zapocinje kucanje dnevnog izazova
     *  Ako daily nije postavljen, salje korisnika na 404 Not Found
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function dailyKucanje() {
        $daily = DailyChallengeModel::getDailyOrFail();

        return view('daily', ['daily' => $daily]);
    }


    /** Funkcija koja zavrsava sesiju daily kucanja, 
     * ubacuje rezultat pokusaja u bazu ako se daily nije promenio
     * , i redirectuje na prikaz rezultata
     * 
     * @param Request $request Http zahtev (POST!)
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * 
     * */
    public function dailyKucanjeKraj(Request $request) {
        //Dohvatanje podataka iz $request
        $text = TextModel::where('id', $request->idTekst)->firstOrFail();
        $time = $request->time;

        //Obrada podataka i ubacivanje pokusaja u bazu (ako je korisnik ulogovan)
        $result = DailyLeaderboardModel::create($text->id, $time);
        $speed = $result->wpm;

        //Dohvatanje najboljeg pokusaja za korisnika
        $best = DailyLeaderboardModel::bestForUser() ?? $result; //Ako se daily promenio u medjuvremenu, prva vrednost ce biti null
        $best_speed = $best->wpm;
        $best_position = $best->rank;
        
        //Redirect na GET zahtev za prikaz rezultata
        return redirect()->route('daily_kucanje_rezultati', [
            'idTekst' => $text->id,
            'speed' => $speed,
            'best_speed' => $best_speed,
            'best_position' => $best_position,
            'saved' => ($request->idTekst == DailyChallengeModel::getDaily()->idTekst),
            'reward' => $best->reward()
        ]);
    }

    
    /** Funkcija koja prikazuje rezultate kucanja
     * 
     * @param Request $request Http zahtev
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * 
     * */
    public function dailyKucanjePrikazRezultata(Request $request) {

        return view('dailyResults', [
            'text' => TextModel::where('id', $request->idTekst)->first(),
            'speed' => $request->speed,
            'best_speed' => $request->best_speed,
            'best_position' => $request->best_position,
            'saved' => $request->saved,
            'reward' => $request->reward
        ]);
    }


     /** Funkcija koja menja daily challenge na drugi nasumican tekst
     *  Izvrsavanje zahteva da je ulogovan korisnik admin (tip korisnika == 2) 
     * Vraca 403 ako user nije admin
     * Vraca 404 ako ne postoji nijedan drugi tekst u bazi
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * 
     * */
    public function promeniDaily() {
        if (auth()->user()->tip == 2)
            DailyChallengeModel::changeDaily();
        else 
            abort(403);

        return redirect()->route('homePage');
    }
}
