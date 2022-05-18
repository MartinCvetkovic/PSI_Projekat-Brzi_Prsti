<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
    Aleksa Savic, 19/0595,
    Martin Cvetkovic 19/0284
*/

namespace App\Http\Controllers;

use App\Models\CategoryModel;
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
        return redirect()->route('index');
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

    
}
