<?php

namespace Tests\Unit;

use App\Models\LeaderboardModel;
use App\Models\TextModel;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaderboardModelTest extends TestCase
{
    // use RefreshDatabase;

    public function test_user()
    {
        $lbm = LeaderboardModel::newFactory()->make();
        $korisnik = $lbm->user();

        $this->assertTrue($korisnik->id == 2);
    }

    public function test_text()
    {
        $lbm = LeaderboardModel::newFactory()->make();

        $text = $lbm->text();
        //  dd($text);

        $this->assertTrue($text->id == $lbm->idTekst);
    }

    public function test_getWpmAttribute()
    {

        $lbm = LeaderboardModel::newFactory()->make();
        $broj = $lbm->getWpmAttribute();
        $tacno = round(TextModel::where("id", $lbm->idTekst)->first()->word_count / $lbm->vreme * 60, 2);

        $this->assertTrue($broj == $tacno);
    }
    public function test_create()
    {
        //Los pristup

        $lbm = LeaderboardModel::newFactory()->make();
        $lbm->create(12,99990099);

        $this->assertDatabaseMissing("ranglista", ["vreme"=>"99990099"]);
        // $zaBrisanje = LeaderboardModel::where("idKor")
    }
    public function test_getRankAttribute()
    {
        // return LeaderboardModel::where('idTekst', $this->idTekst)->where('vreme', '<=', $this->vreme - 0.01)->distinct()->count("idKor") + 1;

        $lbm = LeaderboardModel::newFactory()->make();
        $ret = $lbm->getRankAttribute();
        $prava = LeaderboardModel::where('idTekst', $lbm->idTekst)->where('vreme', '<=', $lbm->vreme - 0.01)->distinct()->count("idKor") + 1;
        
        $this->assertTrue($ret == $prava);
    }
    public function test_bestForUser()
    {
        $lbm = LeaderboardModel::newFactory()->make();
        $ret = $lbm->bestForUser(12,2);
        // dd($ret);
        $tacno = LeaderboardModel::where('idKor', 2)->where('idTekst', 12)->orderBy('vreme', 'asc')->first()->vreme;
        $this->assertTrue($tacno == $ret->vreme);

    }

}
