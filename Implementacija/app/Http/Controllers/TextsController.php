<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
    Aleksa Savic, 19/0595
*/

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\TextModel;
use Illuminate\Http\Request;

class TextsController extends Controller
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

    public function rankList(Request $request, $id)
    {


        return view('texts\rank_list');
    }

    public function friendlyRankList(Request $request, $id)
    {


        return view('texts\rank_list');
    }

    /**
     * Prikazuje formu za ubacivanje novog teksta.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tekst = new TextModel();
        $kategorije = CategoryModel::pluck('naziv', 'id')->toArray();

        return view('texts\create', compact('tekst', 'kategorije'));
    }

    /**
     * Ubacuje novi tekst u bazu.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tekst = TextModel::create($request->all());

        return redirect()->route('texts')->with('success', 'Tekst uspešno napravljen.');
    }

    /**
     * Prikazuje atribute datog teksta.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tekst = TextModel::find($id);

        return view('texts\show', compact('tekst'));
    }

    /**
     * Prikazuje formu za izmenu teksta.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tekst = TextModel::find($id);
        $kategorije = CategoryModel::pluck('naziv', 'id')->toArray();

        return view('texts\edit', compact('tekst', 'kategorije'));
    }

    /**
     * Ažurira tekst u bazi.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  TextModel $tekst
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TextModel $tekst)
    {
        $attrs = $request->only(["id", "sadrzaj", "tezina", "idKat"]);
        $attrs["id"] = intval($attrs["id"]);

        $reqTekst = TextModel::where('id', $attrs["id"])->first();
        $reqTekst->update($attrs);

        return redirect()->route('texts')->with('success', 'Tekst uspešno izmenjen.');
    }

    /**
     * Briše tekst iz baze.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tekst = TextModel::find($id)->delete();

        return redirect()->route('texts')->with('success', 'Tekst uspešno obrisan.');
    }
}
