<?php

namespace Tests\Unit;

use App\Models\LeaderboardModel;
use App\Models\TextModel;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaderboardModelTest extends TestCase
{
    use DatabaseTransactions;

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

        $user = UserModel::where("tip",2)->first();
        $this->be($user);
        $text = TextModel::first();

        $lbm = LeaderboardModel::newFactory()->make();
        $lbm->create($text->id,1);

        $this->assertDatabaseHas("ranglista", ["idKor"=>$user->id,"vreme"=>"1","idTekst"=>$text->id]);
    }

    public function test_getRankAttribute()
    {
        
        $lbm = LeaderboardModel::newFactory()->make();
        $ret = $lbm->getRankAttribute();
        $prava = LeaderboardModel::where('idTekst', $lbm->idTekst)->where('vreme', '<=', $lbm->vreme - 0.01)->distinct()->count("idKor") + 1;
        
        $this->assertTrue($ret == $prava);
    }

    // moraju podaci iz rankList
    public function test_bestForUser()
    {
        $red = LeaderboardModel::first();
        $lbm = LeaderboardModel::newFactory()->make();
        $ret = $lbm->bestForUser($red->idTekst,$red->idKor);

        $tacno = LeaderboardModel::where('idKor', 2)->where('idTekst', 12)->orderBy('vreme', 'asc')->first()->vreme;
        $this->assertTrue($tacno == $ret->vreme);

    }

}
