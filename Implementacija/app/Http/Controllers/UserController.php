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

/**
 * Klasa za upravljanje korisnicima
 *
 * @version 1.0
 */
class UserController extends BaseController
{

    /**
     * Konstruktor sa podešavanjem middleware-a
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  Isto što i auth()->user()
     *  Funkcija koja vraća trenutno ulogovanog korisnika
     *  Zvati ovo umesto auth()->user() ako se dalje zovu metode UserModel-a (npr auth()->user()->save() postaje $this->user()->save())
     *  U suprotnom ce IDE (PHP Intelephense extension) da podvlaci kao gresku (iako kod radi ispravno)
     *
     * @return \App\Models\UserModel|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    function user()
    {
        return auth()->user();
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

    /**
     * Funkcija koja prikazuje stranu za pretragu korisnika
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function searchUsers()
    {
        return view("pretragaProfila");
    }

    /**
     * Funkcija koja pretražuje korisnike prema datim zahtevima
     *
     * @param Request $request Http zahtev
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function searchUsersSubmit(Request $request)
    {
        // Kada budes imao auth, nemoj sebe da uzimas iz baze
        $this->validate($request, [
            'filter' => "required"
        ], [
            "required" => "Morate uneti filter pretrage"
        ]);

        $korisnici = UserModel::dohvatiKorisnike($request["filter"]);
        return view("pretragaProfila", ["profili" => $korisnici]);
    }

    /**
     * Funkcija koja prikazuje profilnu stranu korisnika
     *
     * @param $username Korisničko ime
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function visitUser($username)
    {
        $korisnik = UserModel::dohvatiKorisnika($username);
        $prijatelji = DB::table('korisnik')
            ->join('jeprijatelj', 'jeprijatelj.idKor2', '=', 'korisnik.id')
            ->where(['jeprijatelj.idKor1' => $korisnik->id])
            ->get();
        $currentUser = auth()->user()->id;

        $mojPrijatelj = DB::table("jePrijatelj")
            ->where("idKor1", $currentUser)
            ->where("idKor2", $korisnik->id)
            ->get();

        $profile = UserModel::dohvatiKorisnika($username);
        return view("profile", ["profile" => $profile, "prijatelji" => $prijatelji, "prijatelj" => $mojPrijatelj]);
    }

    /**
     * Funkcija za dodavanje prijatelja
     *
     * @param $username Korisničko ime
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dodajPrijatelja($username)
    {
        // Ubaci u tabelu jePrijatelj
        $korisnik = UserModel::dohvatiKorisnika($username);

        $currentUser = $this->user();   //Isto sto i auth()->user()
        $mojPrijatelj = DB::table("jePrijatelj")
            ->where("idKor1", $currentUser->id)
            ->where("idKor2", $korisnik->id)
            ->get();

        // Ako nismo prijatelji dodaj me, u suprotnom izbrisi nas
        if ($mojPrijatelj->isEmpty()) {

            $id = DB::table('jeprijatelj')->insertGetId(
                ['idKor1' => $currentUser->id, "idKor2" => $korisnik->id]
            );
            $currentUser->brojPrijatelja += 1;
            $currentUser->save();
        } else {
            $deleted = DB::table('jeprijatelj')->where('idKor1', $currentUser->id)
                ->where('idKor2', $korisnik->id)
                ->delete();
            $currentUser->brojPrijatelja -= 1;
            $currentUser->save();
        }
        $prijatelji = DB::table('korisnik')
            ->join('jeprijatelj', 'jeprijatelj.idKor2', '=', 'korisnik.id')
            ->where(['jeprijatelj.idKor1' => $korisnik->id])
            ->get();

        $prijatelj = !$mojPrijatelj->isEmpty();
        return back()->withInput(array('username' => $korisnik->username,
            "prijatelji" => $prijatelji,
            "prijatelj" => $prijatelj
        ));
    }

    /**
     * Funkcija za blokiranje drugog korisnika
     *
     * @param $username Korisničko ime
     * @return \Illuminate\Http\RedirectResponse
     */
    public function blokirajKorisnika($username)
    {
        $korisnik = UserModel::dohvatiKorisnika($username);

        //Zabrana da korisnik rucno ode na /blokiraj/username i blokira bilo koga
        if (auth()->user()->tip <= $korisnik->tip) abort(403);

        $deleted = DB::table('jeprijatelj')->where('idKor1', $korisnik->id)
            ->orWhere('idKor2', $korisnik->id)
            ->delete();

        $korisnik = UserModel::dohvatiKorisnika($username);
        $korisnik->aktivan = 1 - $korisnik->aktivan;
        $korisnik->save();


        $prijatelji = DB::table('korisnik')
            ->join('jeprijatelj', 'jeprijatelj.idKor2', '=', 'korisnik.id')
            ->where(['jeprijatelj.idKor1' => $korisnik->id])
            ->get();
        $prijatelj = [];

        return back()->withInput(array('username' => $korisnik->username,
            "prijatelji" => $prijatelji,
            "prijatelj" => $prijatelj
        ));
    }

    /**
     * Funkcija za koja daje moderatorske privilegije korisniku
     *
     * @param $username Korisničko ime
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dodajModeratora($username)
    {
        $korisnik = UserModel::dohvatiKorisnika($username);

        //Zabrana da korisnik rucno ode na /mod/username i dodeli mod
        if (auth()->user()->tip != 2) abort(403);

        $korisnik->tip = 1 - $korisnik->tip;
        $korisnik->save();

        $prijatelji = DB::table('korisnik')
            ->join('jeprijatelj', 'jeprijatelj.idKor2', '=', 'korisnik.id')
            ->where(['jeprijatelj.idKor1' => $korisnik->id])
            ->get();
        return back()->withInput(array('username' => $korisnik->username, "prijatelji" => $prijatelji));

    }

    /** Funkcija koja zapo;inje kucanje dnevnog izazova
     *  Ako daily nije postavljen, [alje korisnika na 404 Not Found
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function dailyKucanje()
    {
        $daily = DailyChallengeModel::getDailyOrFail();

        return view('daily', ['daily' => $daily]);
    }

    /** Funkcija koja zavr[ava sesiju daily kucanja,
     *  ubacuje rezultat pokušaja u bazu ako se daily nije promenio
     * i redirectuje na prikaz rezultata
     *
     * @param Request $request Http zahtev (POST!)
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     *
     * */
    public function dailyKucanjeKraj(Request $request)
    {
        // Dohvatanje podataka iz $request
        $text = TextModel::where('id', $request->idTekst)->firstOrFail();
        $time = $request->time;

        // Obrada podataka i ubacivanje poku[aja u bazu (ako je korisnik ulogovan)
        $result = DailyLeaderboardModel::create($text->id, $time);
        $speed = $result->wpm;

        // Dohvatanje najboljeg poku[aja za korisnika
        $best = DailyLeaderboardModel::bestForUser() ?? $result; //Ako se daily promenio u medjuvremenu, prva vrednost ce biti null
        $best_speed = $best->wpm;
        $best_position = $best->rank;

        // Redirect na GET zahtev za prikaz rezultata
        return redirect()->route('daily_kucanje_rezultati', [
            'idTekst' => $text->id,
            'speed' => $speed,
            'best_speed' => $best_speed,
            'best_position' => $best_position,
            'saved' => ($request->idTekst == DailyChallengeModel::getDaily()->idTekst),
            'reward' => $best->reward()
        ]);
    }

    /** Funkcija koja prikazuje rezultate kucanja za dnevni izazov
     *
     * @param Request $request Http zahtev
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     *
     * */
    public function dailyKucanjePrikazRezultata(Request $request)
    {
        $leaderboard = DailyLeaderboardModel::asLeaderboard()->orderBy('vreme', 'asc')->get();

        return view('dailyResults', [
            'text' => TextModel::where('id', $request->idTekst)->first(),
            'speed' => $request->speed,
            'best_speed' => $request->best_speed,
            'best_position' => $request->best_position,
            'saved' => $request->saved,
            'reward' => $request->reward,
            'leaderboard' => $leaderboard
        ]);
    }

    /** Funkcija koja menja daily challenge na drugi nasumičan tekst
     *  Izvršavanje zahteva da je ulogovan korisnik admin (tip korisnika == 2)
     *  Vraća 403 ako user nije admin
     *  Vraća 404 ako ne postoji nijedan drugi tekst u bazi
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     *
     * */
    public function promeniDaily()
    {
        if (auth()->user()->tip == 2)
            DailyChallengeModel::changeDaily();
        else
            abort(403);

        return redirect()->route('homePage');
    }

    /** Funkcija koja korisniku prikazuje preporučene tekstove
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function recommendTexts()
    {
        $korisnik = $this->user();

        $tezina = $korisnik->getRecommendedDifficulty();
        $duzina = $korisnik->getRecommendedLength();

        return redirect()->route('search_texts', [
            'kategorija' => 0,
            'tezina' => $tezina,
            'duzina' => $duzina,
            'page' => 1
        ]);
    }
}
