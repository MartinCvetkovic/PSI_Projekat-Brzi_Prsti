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
use App\Models\TextModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
            'kategorija' => 0,
            'tezina' => 0,
            'duzina' => 0
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
        
        // dohvatanje informacije da li je on moj prijatelj
        // $mojPrijatelj = DB::table("jePrijatelj")
        //                     ->where("idKor1",ja)
        //                     ->where("idKor2", $korisnik->id)

        $profile = UserModel::dohvatiKorisnika($username);
        return view("profile",["profile"=>$profile, "prijatelji"=>$prijatelji]);
    }
    public function dodajPrijatelja($username)
    {
        // uvaci u tabelu "jePrijatelj
        $korisnik = UserModel::dohvatiKorisnika($username);
        return redirect()->route('visit_user', ["username"=>$korisnik->username]);
    }
    public function blokirajKorisnika($username)
    {
        $korisnik = UserModel::dohvatiKorisnika($username);
        $korisnik->aktivan = 1 - $korisnik->aktivan;
        $korisnik->save();
        return redirect()->route('visit_user', ["username"=>$korisnik->username]);
    }
    public function dodajModeratora($username)
    {
        $korisnik = UserModel::dohvatiKorisnika($username);
        $korisnik->tip = 1 - $korisnik->tip;
        $korisnik->save();
        return redirect()->route('visit_user', ["username"=>$korisnik->username]);
    }
}
