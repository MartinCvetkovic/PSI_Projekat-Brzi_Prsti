<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
    Aleksa Savic, 19/0595
    Savic Ivan, 19/0389
    Martin Cvetkovic 19/0284
*/

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\CategoryModel;
use App\Models\DailyChallengeModel;
use App\Models\DailyLeaderboardModel;
use App\Models\TextModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

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
    /** Funkcija koja prikazuje formu za pretragu korisnika
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function searchUsers()
    {
        return view("pretragaProfila");
    }
    /** Funkcija koja prikazuje listu korisnika koji zadovoljavaju filter pretrage
     * @param Request $request Http zahtev
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function searchUsersSubmit(Request $request)
    {
        $this->validate($request,[
            'filter'=> "required"
        ],[
            "required" => "Morate uneti filter pretrage"
        ]);
        
        $korisnici = UserModel::dohvatiKorisnike($request["filter"]);
        return view("pretragaProfila",["profili"=>$korisnici]);

    }
    /** Funkcija koja prikazuje profil zadatog korisnika
     * @param String $username korisnicki ime korisnika 
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function visitUser($username)
    {

        $korisnik = UserModel::dohvatiKorisnika($username);
        $prijatelji = DB::table('korisnik')
            ->join('jeprijatelj','jeprijatelj.idKor2','=','korisnik.id')
            ->where(['jeprijatelj.idKor1' => $korisnik->id])
            ->get();
        $currentUser = auth()->user()->id;
         
        $mojPrijatelj = DB::table("jePrijatelj")
                           ->where("idKor1",$currentUser)
                           ->where("idKor2", $korisnik->id)
                           ->get();
       
        // dd($mojPrijatelj);

        $profile = UserModel::dohvatiKorisnika($username);
        return view("profile",["profile"=>$profile, "prijatelji"=>$prijatelji,"prijatelj"=>$mojPrijatelj]);
    }

    /** Funkcija koja dodaj profil zadatog korisnika kao prijatelja trenutnog korisnika
     * @param  String $username korisnicki ime korisnika 
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function dodajPrijatelja($username)
    {
        // ubaci u tabelu "jePrijatelj
        $korisnik = UserModel::dohvatiKorisnika($username);

        $currentUser = auth()->user();
        $mojPrijatelj = DB::table("jePrijatelj")
                           ->where("idKor1",$currentUser->id)
                           ->where("idKor2", $korisnik->id)
                           ->get();

        // Ako nismo prijatelji dodaj me, u suprotnom izbrisi nas
        if($mojPrijatelj->isEmpty()){

            $id = DB::table('jeprijatelj')->insertGetId(
                ['idKor1' => $currentUser->id, "idKor2" => $korisnik->id]
            );
            $currentUser->brojPrijatelja +=1;
            $currentUser->save();
        }else{
            $deleted = DB::table('jeprijatelj')->where('idKor1', $currentUser->id)
                                            ->where('idKor2', $korisnik->id)
                                            ->delete();
            $currentUser->brojPrijatelja -=1;
            $currentUser->save();
        }
        $prijatelji = DB::table('korisnik')
        ->join('jeprijatelj','jeprijatelj.idKor2','=','korisnik.id')
        ->where(['jeprijatelj.idKor1' => $korisnik->id])
        ->get();

        
        $prijatelj = !$mojPrijatelj->isEmpty();
        return back()->withInput(array('username' => $korisnik->username,
                        "prijatelji"=>$prijatelji,
                        "prijatelj"=>$prijatelj
        ));
    }
    /** Funkcija koja blokira profil zadatog korisnika
     * @param String $username korisnicki ime korisnika 
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function blokirajKorisnika($username)
    {
        $korisnik = UserModel::dohvatiKorisnika($username);
        $deleted = DB::table('jeprijatelj')->where('idKor1', $korisnik->id)
                                            ->orWhere('idKor2', $korisnik->id)
                                            ->delete();

        $korisnik = UserModel::dohvatiKorisnika($username);
        $korisnik->aktivan = 1 - $korisnik->aktivan;
        $korisnik->save();


        $prijatelji = DB::table('korisnik')
        ->join('jeprijatelj','jeprijatelj.idKor2','=','korisnik.id')
        ->where(['jeprijatelj.idKor1' => $korisnik->id])
        ->get();
        $prijatelj = [];
        return back()->withInput(array('username' => $korisnik->username,
                        "prijatelji"=>$prijatelji,
                        "prijatelj"=>$prijatelj
        ));
    }
    /** Funkcija koja daje moderatora zadatkom korisniku
     * @param $username korisnicki ime korisnika 
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function dodajModeratora($username)
    {

        $korisnik = UserModel::dohvatiKorisnika($username);
        $korisnik->tip = 1 - $korisnik->tip;
        $korisnik->save();

        $prijatelji = DB::table('korisnik')
        ->join('jeprijatelj','jeprijatelj.idKor2','=','korisnik.id')
        ->where(['jeprijatelj.idKor1' => $korisnik->id])
        ->get();

        return back()->withInput(array('username' => $korisnik->username,"prijatelji"=>$prijatelji));
;
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
