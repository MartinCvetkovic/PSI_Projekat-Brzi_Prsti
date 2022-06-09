<?php
/**
 * Autor:
 * Martin Cvetkovic 19/0284
 */

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

/**
 * Klasa za upravljanje funkcionalnostima gosta
 *
 * @version 1.0
 */
class GuestController extends BaseController
{
    /**
     * Konstruktor sa podešavanjem middleware-a
     */
    function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Funkcija za prikaz strane za registraciju
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function registerPage()
    {
        return view("registerPage");
    }

    /**
     * Funkcija za registraciju novog korisnika
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => "required|min:3|max:20",
            'password' => "required|min:8|max:15|alpha_num",
            'passwordConfirm' => "required|same:password"
        ], [
            'required' => "Polje je obavezno",
            'min' => "Polje mora imati bar :min karaktera",
            'max' => "Polje mora imati manje od :max karaktera",
            'alpha_num' => "Polje mora sadrzati slova i brojeve",
            'same' => "Polje mora biti isto kao i lozinka",
        ]);

        if (UserModel::where("username", $request->username)->first() != null) {
            return view("registerPage", [
                'errorUsername' => "Korisnicko ime vec postoji"
            ]);
        };
        $pass = password_hash($request->password, PASSWORD_BCRYPT);
        UserModel::addUser($request->username, $pass, 0, 0, 0, 0, 1, 0);
        return redirect()->route("homePage");
    }

    /**
     * Funkcija za logovanje korisnika
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ], [
            'required' => 'Polje je obavezno'
        ]);

        //Direktan query umesto pomocne funkcije
        $user = UserModel::where("username",$request->username)->first();

        if ($user == null) {
            return back()->with('status', 'Nepostojeće korisničko ime');
        }

        if (!password_verify($request->password, $user->password)) {
            return back()->with('status', 'Pogrešna šifra');
        }

        if (UserModel::isBlocked($request->username)) {
            return back()->with('status', 'Korisnik je blokiran');
        }

        auth()->login($user);

        return redirect()->route("homePage");
    }
}
