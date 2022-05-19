<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
    Aleksa Savic, 19/0595
    Savic Ivan, 19/0389
*/

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\CategoryModel;
use App\Models\LeaderboardModel;
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

    public function searchUsers()
    {
        return view("pretragaProfila");
    }
    public function searchUsersSubmit(Request $request)
    {
        // kada budes imao auth nemoj sebe da uzimas iz baze
        $this->validate($request,[
            'filter'=> "required"
        ],[
            "required" => "Morate uneti filter pretrage"
        ]);
        
        $korisnici = UserModel::dohvatiKorisnike($request["filter"]);
        return view("pretragaProfila",["profili"=>$korisnici]);

    }
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
    public function dodajPrijatelja($username)
    {
        // uvaci u tabelu "jePrijatelj
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
        }else{
            $deleted = DB::table('jeprijatelj')->where('idKor1', $currentUser->id)
                                            ->where('idKor2', $korisnik->id)
                                            ->delete();
        }
        return $this->visitUser($username);
    }
    public function blokirajKorisnika($username)
    {
        $korisnik = UserModel::dohvatiKorisnika($username);
        $korisnik->aktivan = 1 - $korisnik->aktivan;
        $korisnik->save();

        return $this->visitUser($username);
    }
    public function dodajModeratora($username)
    {

        $korisnik = UserModel::dohvatiKorisnika($username);
        $korisnik->tip = 1 - $korisnik->tip;
        $korisnik->save();

        $prijatelji = DB::table('korisnik')
        ->join('jeprijatelj','jeprijatelj.idKor2','=','korisnik.id')
        ->where(['jeprijatelj.idKor1' => $korisnik->id])
        ->get();

        return $this->visitUser($username);
        // return redirect()->back()->withInput(array("profile"=>$korisnik,"prijatelji"=>$prijatelji));
        // return view("profile",["profile"=>$korisnik,"prijatelji"=>$prijatelji]);
        //  return back()->withInput(array('username' => $korisnik->username,"prijatelji"=>$prijatelji));
        // return redirect()->route('visit_user', ["username"=>$korisnik->username]);
    }
}
