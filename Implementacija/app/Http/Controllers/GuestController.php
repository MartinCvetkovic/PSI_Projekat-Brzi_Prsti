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
class GuestController extends Controller
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
            'min' => "Polje mora imati :min karaktera",
            'max' => "Polje mora imati :max karaktera",
            'alpha_num' => "Polje mora sadrzati slova i brojeve",
            'same' => "Polje mora biti isto kao i lozinka",
        ]);

        if(UserModel::where("username", $request->username)->first() != null){
            return view("registerPage", [
                'errorUsername' => "Korisnicko ime vec postoji"
            ]);
        };
        UserModel::addUser($request->username, $request->password, 0, 0, 0, 0, 1, 0);
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
        
        if(!auth()->attempt($request->only('username', 'password'))) {
            return back()->with('status', 'Pogresno korisnicko ime ili lozinka');
        }

        //dd(session());

        return redirect()->route("homePage");
    }



}
