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

        $this->assertTrue($text->id == 12);
    }

    public function test_getRankAttribute()
    {

        $lbm = LeaderboardModel::newFactory()->make();
        $broj = $lbm->getWpmAttribute();
        
        $this->assertTrue($broj == 0.04);
    }
    public function test_create()
    {
        // $user = UserModel::where("tip",1)->first();
        // $response = $this->actingAs($user);

        $lbm = LeaderboardModel::newFactory()->make();
        $lbm->create(12,99990099);
        $this->assertDatabaseMissing("ranglista", ["vreme"=>"99990099"]);
        // $zaBrisanje = LeaderboardModel::where("idKor")
    }
    

}
