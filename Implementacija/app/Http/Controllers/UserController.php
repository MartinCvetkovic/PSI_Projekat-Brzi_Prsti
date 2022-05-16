<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\TextModel;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /** Funkcija koja prikazuje listu tekstova sa pretragom
     * @param Request $request Http zahtev
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function showTexts(Request $request) {

        $texts = TextModel::paginate(5);
        $categories = CategoryModel::all();




        return view('texts', ['texts' => $texts, 'categories' => $categories]);
    }
}
