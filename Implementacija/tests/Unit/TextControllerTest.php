<?php

namespace Tests\Unit;
// use PHPUnit\Framework\TestCase;

use App\Models\User;
use App\Models\LeaderboardModel;
use App\Models\UserModel;
use Tests\TestCase;

class TextControllerTest extends TestCase
    
{
    /*
        Provera redirektovanja do globalne rang liste
    */
    public function test_global_rankList_view()
    {
        $response = $this->get('/rankList');

        $response->assertViewIs("rank_list");
    }

    /*
        Provera ubacivanja u bazu podataka
    */
    public function test_insert_to_rangList(){

        $rank1 = LeaderboardModel::make([
            'idKor' => "3",
            'idTekst' => "12",
            'vreme' => "12345"
        ]);
        $rank1->save();

        // $this->assertTrue($rank1->idKor != $rank2->idKor);
        $this->assertDatabaseHas("ranglista", [
            "idKor"=>"3",
            "idTekst"=>"12",
            'vreme' => "12345"
        ]);
    }
    /*
        Provera zahteva neprijavljenih za promenu teksta
    */
    public function test_neprijavljeni_menja_tekst()
    {
        $response = $this->get('/texts/update');    

        $response->assertRedirect("/");
    }
    // ne vracamo ga na "/", pocetnu stranicu
    // public function test_neprijavljeni_prijateljskaGlobalnaRank()
    // {
    //     $response = $this->get("/friendlyRankList");
    //     $response->assertRedirect("/");
    // }

    /*
        Provera pristupa neprijavljenih stranici za kreiranje tekstova
    */
    public function test_neprijavljeni_kreira_tekst()
    {
        $response = $this->get("/texts/create");
        $response->assertRedirect("/");
    }

    /*
        Provera pristupa neprijavljenih stranici za izmenu  tekstova
    */
    public function test_izmena_teksta_neprijavljeni()
    {
        // /texts/edit/{id}
        $response = $this->get("/texts/edit/{id}",["id"=>1]);
        // $response = $this->get("/texts/edit/1");
        $response->assertRedirect("/");

    }
    public function test_prisup_stvaranju()
    {
        $user = UserModel::where("tip",2)->first();
 
        $response = $this->actingAs($user)->get("/texts/create");
        $response->assertStatus(200);
        $response->assertViewIs("texts\create");
    }
}
