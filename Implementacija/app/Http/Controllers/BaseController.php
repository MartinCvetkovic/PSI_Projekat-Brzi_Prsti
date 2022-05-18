<?php

/**
 * Autor:
 * Martin Cvetkovic 19/0284
 */

namespace App\Http\Controllers;

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
    
}
