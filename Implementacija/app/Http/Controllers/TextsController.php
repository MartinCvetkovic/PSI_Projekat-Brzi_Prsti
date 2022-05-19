<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
    Aleksa Savic, 19/0595
*/

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\LeaderboardModel;
use App\Models\LeaderboardRowModel;
use App\Models\TextModel;
use App\Models\UserModel;
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
        $rankList = $this->getRankList($id);

        // Sortiranje po vremenu i wpm
        usort($rankList, function($a, $b) {
            $time_diff = $a->time - $b->time;
            if ($time_diff) return $time_diff;
            return $a->wpm - $b->wpm;
        });

        return view('texts\rank_list', compact('rankList'));
    }

    public function friendlyRankList(Request $request, $id)
    {
        // TODO: Izvaditi user id i filtrirati po prijateljima
        $rankList = $this->getRankList($id);

        $filteredRankList = array();
        foreach ($rankList as $rankListRow)
        {
            // TODO: Ako je $rankListRow->userModel u spisku prijatelja, dodaj u $filteredRankList
        }

        $rankList = $filteredRankList;

        // Sortiranje po vremenu i wpm
        usort($rankList, function($a, $b) {
            $time_diff = $a->time - $b->time;
            if ($time_diff) return $time_diff;
            return $a->wpm - $b->wpm;
        });

        return view('texts\rank_list', compact('rankList'));
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

    /**
     * @param $id
     * @return array
     */
    public function getRankList($id): array
    {
        $resultsForText = LeaderboardModel::where('idTekst', $id)->get();
        $text = TextModel::find($id);
        $userDict = array();

        // Za svaki upisani rezultat za dati tekst, po korisnicima zapisi svako vreme i wpm
        foreach ($resultsForText as $result) {
            $currentUser = UserModel::find($resultsForText->idKor);
            if (!array_key_exists($currentUser, $userDict)) {
                $userDict[$currentUser] = array();
                $userDict[$currentUser]["vreme"] = array();
                $userDict[$currentUser]["wpm"] = array();
            }

            // Dodaju se vreme i wpm
            $userDict[$currentUser]["time"][] = $resultsForText->vreme;

            // TODO: Proveriti format vremena
            $userDict[$currentUser]["wpm"][] = $resultsForText->vreme / 60.0 * $text->word_count;
        }

        // Nalazenje proseka od time i wpm za svakog korisnika
        $rankList = array();
        foreach ($userDict as $currentUser) {
            $newRankListRow = new LeaderboardRowModel;
            $newRankListRow->userModel = $currentUser;
            $newRankListRow->time = array_sum($userDict[$currentUser]["time"]) / count($userDict[$currentUser]["time"]);
            $newRankListRow->wpm = array_sum($userDict[$currentUser]["wpm"]) / count($userDict[$currentUser]["wpm"]);
            $rankList[] = $newRankListRow;
        }
        return $rankList;
    }
}
