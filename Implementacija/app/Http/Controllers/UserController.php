<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
*/

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\TextModel;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /** Funkcija koja prikazuje listu svih tekstova
     * @param Request $request Http zahtev
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function showTexts() {

        $texts = TextModel::paginate(5);
        $categories = CategoryModel::all();

        return view('texts', ['texts' => $texts, 'categories' => $categories]);
    }

    /** Funkcija koja prikazuje listu tekstova koji zadovoljavaju kriterijume pretrage
     * @param Request $request Http zahtev
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function searchTexts(Request $request) {

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
