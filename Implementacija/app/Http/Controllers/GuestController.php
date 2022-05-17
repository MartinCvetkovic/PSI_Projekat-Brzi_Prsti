<?php
/**
 * Autor:
 * Martin Cvetkovic 19/0284
 */

namespace App\Http\Controllers;

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
     * @var Request
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function register(Request $request)
    {

        dd($request);
    }

    /**
     * Funkcija za logovanje korisnika
     * 
     * @var Request
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function login(Request $request)
    {

        dd($request);
    }



}
