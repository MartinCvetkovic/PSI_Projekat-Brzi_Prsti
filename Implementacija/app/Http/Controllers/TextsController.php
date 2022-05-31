<?php
/*
    Autor(i):
    Petar Tirnanic, 19/0039
    Aleksa Savic, 19/0595
*/

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\DailyChallengeModel;
use App\Models\JePrijateljModel;
use App\Models\LeaderboardModel;
use App\Models\LeaderboardRowModel;
use App\Models\TextModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Klasa za upravljanje tekstovima
 *
 * @version 1.0
 */
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

    /**
     * Prikazuje globalnu rang listu za dati tekst.
     *
     * @return \Illuminate\Http\Response
     */
    public function rankList(Request $request, $id)
    {
        $rankList = $this->getRankList($id);

        // Sortiranje po vremenu i wpm
        usort($rankList, function ($a, $b) {
            $time_diff = $a->time - $b->time;
            if ($time_diff) return $time_diff;
            return $a->wpm - $b->wpm;
        });

        $text = TextModel::find($id);
        $tipRangListe = 0;
        $i = 0;

        return view('texts\text_rank_list', compact('rankList', 'tipRangListe', 'text', 'i'));
    }

    /**
     * Prikazuje prijateljsku rang listu za dati tekst.
     *
     * @return \Illuminate\Http\Response
     */
    public function friendlyRankList(Request $request, $id)
    {
        $rankList = $this->getRankList($id);

        $currentUserId = Auth::user()->id;
        $userFriends = JePrijateljModel::where('idKor1', $currentUserId)->pluck('idKor2')->toArray();
        $userFriends[] = $currentUserId; // Na prijateljsku listu dodajemo i sami sebe

        $filteredRankList = array();
        foreach ($rankList as $rankListRow) {
            if (in_array($rankListRow->userModel->id, $userFriends))
                $filteredRankList[] = $rankListRow;
        }

        $rankList = $filteredRankList;

        // Sortiranje po vremenu i WPM
        usort($rankList, function ($a, $b) {
            $time_diff = $a->time - $b->time;
            if ($time_diff) return $time_diff;
            return $a->wpm - $b->wpm;
        });

        $text = TextModel::find($id);
        $tipRangListe = 1;
        $i = 0;

        return view('texts\text_rank_list', compact('rankList', 'tipRangListe', 'text', 'i'));
    }

    /**
     * Prikazuje globalnu rang listu najbržih korisnika.
     *
     * @return \Illuminate\Http\Response
     */
    public function globalRankList(Request $request)
    {
        $resultsForAllTexts = LeaderboardModel::all();
        $userDict = array();
        $rankList = $this->getGlobalRankList($resultsForAllTexts, $userDict, null);

        // Sortiranje po vremenu i WPM
        usort($rankList, function ($a, $b) {
            $time_diff = $a->time - $b->time;
            if ($time_diff) return $time_diff;
            return $a->wpm - $b->wpm;
        });

        $i = 0;
        $type = 0;

        return view('rank_list', compact('rankList', 'i', 'type'));
    }

    /**
     * Prikazuje globalnu rang listu najbržih korisnika koji su prijatelji trenutnog korisnika.
     *
     * @return \Illuminate\Http\Response
     */
    public function friendlyGlobalRankList(Request $request)
    {
        $resultsForAllTexts = LeaderboardModel::all();
        $userDict = array();

        $currentUserId = Auth::user()->id;
        $userFriends = JePrijateljModel::where('idKor1', $currentUserId)->pluck('idKor2')->toArray();
        $userFriends[] = $currentUserId; // Na prijateljsku listu dodajemo i sami sebe
        $rankList = $this->getGlobalRankList($resultsForAllTexts, $userDict, $userFriends);

        // Sortiranje po vremenu i WPM
        usort($rankList, function ($a, $b) {
            $time_diff = $a->time - $b->time;
            if ($time_diff) return $time_diff;
            return $a->wpm - $b->wpm;
        });

        $i = 0;
        $type = 1; // Friendly rank list

        return view('rank_list', compact('rankList', 'i', 'type'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Provera da sadrzaj/tezina nisu prazni i da je tezina broj iz [0, 10]
        $this->validate($request, [
            'sadrzaj' => "required",
            'tezina' => "required|min:0|max:10|numeric"
        ], [
            'required' => "Polje je obavezno",
            'min' => "Tezina mora biti u opsegu 0-10",
            'max' => "Tezina mora biti u opsegu 0-10",
            'numeric' => "Tezina mora biti broj"
        ]);

        $tekst = TextModel::create($request->all());

        return redirect()->route('texts')->with('success', 'Tekst uspešno napravljen.');
    }

    /**
     * Prikazuje atribute datog teksta.
     *
     * @param int $id
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tekst = TextModel::findOrFail($id);
        //Zabrana izmene dnevnog izazova
        if ($id == DailyChallengeModel::getIdTekst()) return redirect()->route('texts')->with('danger', 'Tekst je trenutno dnevni izazov, ne moze biti izmenjen');

        $kategorije = CategoryModel::pluck('naziv', 'id')->toArray();

        return view('texts\edit', compact('tekst', 'kategorije'));
    }

    /**
     * Ažurira tekst u bazi.
     *
     * @param \Illuminate\Http\Request $request
     * @param TextModel $tekst
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TextModel $tekst)
    {
        //Provera da sadrzaj/tezina nisu prazni i da je tezina broj iz [0, 10]
        $this->validate($request, [
            'sadrzaj' => "required",
            'tezina' => "required|min:0|max:10|numeric"
        ], [
            'required' => "Polje je obavezno",
            'min' => "Tezina mora biti u opsegu 0-10",
            'max' => "Tezina mora biti u opsegu 0-10",
            'numeric' => "Tezina mora biti broj"
        ]);

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
        //Provera da li se brise dnevni izazov
        if ($id == DailyChallengeModel::getIdTekst()) {
            //Ako korisnik nije admin, zabraniti
            if (auth()->user()->tip != 2){
                return redirect()->route('texts')->with('danger', 'Tekst je trenutno dnevni izazov, brisanje je dozvoljeno samo adminima');
            }
            //U suprotnom obavestiti ga da je izbrisao dnevni izazov
            else {
                TextModel::find($id)->delete();
                return redirect()->route('texts')->with('success', 'Tekst uspešno obrisan.')->with('dailyDeleted', 1);
            }
        }

        TextModel::find($id)->delete();

        return redirect()->route('texts')->with('success', 'Tekst uspešno obrisan.');
    }
    

    /**
     * Izračunava rang listu za dati tekst.
     *
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
            $currentUser = UserModel::find($result->idKor);
            if (!array_key_exists($currentUser->id, $userDict)) {
                $userDict[$currentUser->id] = array();
                $userDict[$currentUser->id]["time"] = array();
                $userDict[$currentUser->id]["wpm"] = array();
            }

            // Dodaju se vreme i wpm
            $userDict[$currentUser->id]["time"][] = $result->vreme;

            $userDict[$currentUser->id]["wpm"][] = $text->word_count / ($result->vreme / 60.0);
        }

        // Nalazenje proseka od time i wpm za svakog korisnika
        $rankList = array();
        foreach ($userDict as $currentUser => $values) {
            $newRankListRow = new LeaderboardRowModel;
            $newRankListRow->userModel = UserModel::find($currentUser);
            $newRankListRow->time = array_sum($values["time"]) / count($values["time"]);
            $newRankListRow->wpm = array_sum($values["wpm"]) / count($values["wpm"]);
            $rankList[] = $newRankListRow;
        }

        return $rankList;
    }

    /**
     * @param $resultsForAllTexts
     * @param array $userDict
     * @return array
     */
    public function getGlobalRankList($resultsForAllTexts, array $userDict, $allowedUserIds): array
    {
        // Za svaki upisani rezultat po korisniku, dodati vreme i wpm
        foreach ($resultsForAllTexts as $result) {

            if ($allowedUserIds != null && !in_array($result->idKor, $allowedUserIds))
                continue; // Nije nam prijatelj

            $currentUser = UserModel::find($result->idKor);
            $text = TextModel::find($result->idTekst);

            if (!array_key_exists($currentUser->id, $userDict)) {
                $userDict[$currentUser->id] = array();
                $userDict[$currentUser->id]["time"] = array();
                $userDict[$currentUser->id]["wpm"] = array();
            }

            // Dodaju se vreme i wpm
            $userDict[$currentUser->id]["time"][] = $result->vreme;
            $userDict[$currentUser->id]["wpm"][] = ($text->word_count * 60.0) / $result->vreme;
        }

        // Nalaženje proseka od time i wpm za svakog korisnika
        $rankList = array();
        foreach ($userDict as $currentUser => $values) {
            $newRankListRow = new LeaderboardRowModel;
            $newRankListRow->userModel = UserModel::find($currentUser);
            $newRankListRow->time = array_sum($values["time"]) / count($values["time"]);
            $newRankListRow->wpm = array_sum($values["wpm"]) / count($values["wpm"]);
            $rankList[] = $newRankListRow;
        }
        return $rankList;
    }
}
