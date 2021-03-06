<?php

namespace Tests\Unit;
// use PHPUnit\Framework\TestCase;

use App\Models\DailyChallengeModel;
use App\Models\User;
use App\Models\LeaderboardModel;
use App\Models\TextModel;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TextControllerTest extends TestCase
    
{
    use DatabaseTransactions;

    /*
        Provera ubacivanja u bazu podataka
    */
    public function test_insert_to_rangList(){

        $text = TextModel::first();
        $korisnik = UserModel::first();

        $rank1 = LeaderboardModel::make([
            'idKor' => $korisnik->id,
            'idTekst' => $text->id,
            'vreme' => "12345"
        ]);
        $rank1->save();

        // $this->assertTrue($rank1->idKor != $rank2->idKor);
        $this->assertDatabaseHas("ranglista", [
            'idKor' => $korisnik->id,
            'idTekst' => $text->id,
            'vreme' => "12345"
        ]);
        $rank1->delete();
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
     /*
        Provera pristupa admina stranici za izmenu  tekstova
    */
    public function test_prisup_stvaranju_admin()
    {
        $user = UserModel::where("tip",2)->first();
 
        $response = $this->actingAs($user)->get("/texts/create");
        $response->assertViewIs("texts\create");
    }
    /*
        Provera pristupa admina stranici tekstova - prikaz dugmeta izmene
    */
    public function test_prisup_tekstovima_dugmeIzmene_auth()
    {
        $user = UserModel::where("tip",1)->first();
 
        $response = $this->actingAs($user)->get("/texts");

        $response->assertViewIs("texts");
        $response->assertSee("Izmeni");
    }
    /*
        Provera pristupa admina stranici tekstova - prikaz dugmeta dodavanja
    */
    public function test_prisup_tekstovima_dugmeDodatka_auth()
    {
        $user = UserModel::where("tip",1)->first();
 
        $response = $this->actingAs($user)->get("/texts");

        $response->assertViewIs("texts");
        $response->assertSee("Dodaj");
    }
    /*
        Provera pristupa admina stranici tekstova - prikaz dugmeta dodavanja, ne treba se prikazati
    */
    public function test_prisup_tekstovima_dugmeDodatka_neAuth()
    {
        $user = UserModel::where("tip",0)->first();
 
        $response = $this->actingAs($user)->get("/texts");

        $response->assertViewIs("texts");
        $response->assertDontSee("Dodaj");
    }
    /*
        Provera pristupa, moderatora stranici za izmenu  tekstova
    */
    public function test_prisup_stvaranju_mod()
    {
        $user = UserModel::where("tip",1)->first();
 
        $response = $this->actingAs($user)->get("/texts/create");

        $response->assertViewIs("texts\create");
    }

    /*
        Provera pristupa admina stranici tekstova - prikaz dugmeta dodavanja, ne treba se prikazati
    */
    public function test_prisup_tekstovima_dugmeIzmene_neAuth()
    {
        $user = UserModel::where("tip",0)->first();
 
        $response = $this->actingAs($user)->get("/texts");

        $response->assertViewIs("texts");
        $response->assertDontSee("Izmeni");
    }

    // Ne redirektuje na pocetnu stranicu
     /*
        Provera pristupa registrovanog (tip==0) stranici za izmenu  tekstova
    */
    // public function test_prisup_stvaranju_registrovan()
    // {
    //     $user = UserModel::where("tip",0)->first();
 
    //     $response = $this->actingAs($user)->get("/texts/create");
    //     $response->assertRedirect("/");
    // }
    /*
        Kreiranje sa tezinom < 10
    */
    public function test_kreiranje_tezina_levoOd_intervala()
    {
        $user = UserModel::where("tip",2)->first();
 
        $response = $this->actingAs($user)
                    ->post("/texts/store",["sadrzaj"=>"value", "tezina"=>"-121","idKat"=>"2"])
                    ->assertSessionHasErrors("tezina")
                    ->assertStatus(302);

        $this->assertDatabaseMissing('tekst', [ 'tezina' => "-121"]);
    }
    /*
        Kreiranje sa tezinom > 10
    */
    public function test_kreiranje_tezina_desnoOd_intervala()
    {
        $user = UserModel::where("tip",2)->first();
 
        $response = $this->actingAs($user)
                    ->post("/texts/store",["sadrzaj"=>"value", "tezina"=>"121","idKat"=>"2"])
                    ->assertSessionHasErrors("tezina")
                    ->assertStatus(302);

        $this->assertDatabaseMissing('tekst', [ 'tezina' => "121"]);
    }
    /*
        Kreiranje sa tezinom koja nije broj
    */
    public function test_kreiranje_tezina_neBroj()
    {
        $user = UserModel::where("tip",2)->first();
 
        $response = $this->actingAs($user)
                    ->post("/texts/store",["sadrzaj"=>"value", "tezina"=>"tesko","idKat"=>"2"])
                    ->assertSessionHasErrors("tezina")
                    ->assertStatus(302);

        $this->assertDatabaseMissing('tekst', [ 'tezina' => "tesko"]);
    }
    /*
        Testiranje prazan sadrzaj
    */
    public function test_kreiranje_prazan_sadrzaj()
    {
        $user = UserModel::where("tip",1)->first();
 
        $response = $this->actingAs($user)
                    ->post("/texts/store",["sadrzaj"=>"", "tezina"=>"10","idKat"=>"2"])
                    ->assertSessionHasErrors("sadrzaj")
                    ->assertStatus(302);

        $this->assertDatabaseMissing('tekst', [ 'sadrzaj' => ""]);
    }
    /*
        Uspesno dodavanje teksta
    */
    public function test_kreiranje_uspeh()
    {
        $user = UserModel::where("tip",1)->first();
 
        $response = $this->actingAs($user)
                        ->post("/texts/store",["sadrzaj"=>"___test___text___", "tezina"=>"1","idKat"=>"2"])
                        ->assertStatus(302);
        $response->assertRedirect("/texts")->with("success");
        $forDelete = TextModel::where("sadrzaj","___test___text___");
        $forDelete->delete();


    }
    /*
        Kreiranje sa tezinom < 10
    */
    public function test_azuriranje_tezina_levoOd_intervala()
    {
        $user = UserModel::where("tip",1)->first();
        $tekst = TextModel::first();
 
        $response = $this->actingAs($user)
        ->post("/texts/update",["id"=>$tekst->id,"sadrzaj"=>"value", "tezina"=>"-121","idKat"=>"2"])
                    ->assertSessionHasErrors("tezina")
                    ->assertStatus(302);

        $this->assertDatabaseMissing('tekst', [ 'tezina' => "-121"]);
    }
    /*
        Kreiranje sa tezinom > 10
    */
    public function test_azuriranje_tezina_desnoOd_intervala()
    {
        $user = UserModel::where("tip",1)->first();
        $tekst = TextModel::first();
 
        $response = $this->actingAs($user)
        ->post("/texts/update",["id"=>$tekst->id,"sadrzaj"=>"value", "tezina"=>"121","idKat"=>"2"])
                    ->assertSessionHasErrors("tezina")
                    ->assertStatus(302);

        $this->assertDatabaseMissing('tekst', [ 'tezina' => "121"]);
    }
    /*
        Azuriranje sa tezinom koja nije broj
    */
    public function test_azuriranje_tezina_nijeBroj()
    {
        $user = UserModel::where("tip",1)->first();
        $tekst = TextModel::first();
 
        $response = $this->actingAs($user)
        ->post("/texts/update",["id"=>$tekst->id,"sadrzaj"=>"value", "tezina"=>"tesko","idKat"=>"2"])
                    ->assertSessionHasErrors("tezina")
                    ->assertStatus(302);

        $this->assertDatabaseMissing('tekst', [ 'tezina' => "tesko"]);
    }
    /*
        Azuriranje  prazan sadrzaj
    */
    public function test_auziranje_prazan_sadrzaj()
    {
        $user = UserModel::where("tip",1)->first();
        $tekst = TextModel::first();
        
        $response = $this->actingAs($user)
        ->post("/texts/update",["id"=>$tekst->id,"sadrzaj"=>"", "tezina"=>"1","idKat"=>"2"])
                    ->assertSessionHasErrors("sadrzaj")
                    ->assertStatus(302);

        $this->assertDatabaseMissing('tekst', [ 'sadrzaj' => ""]);
    }
    /*
        Azuriranje  uspesno
    */
    public function test_auziranje_uspeh()
    {
        $user = UserModel::where("tip",1)->first();
        $tekst = TextModel::first();
        $oldText = $tekst->sadrzaj;
  
        $response = $this->actingAs($user)
                    ->post("/texts/update",["id"=>$tekst->id,"sadrzaj"=>"novi sadrzaj", "tezina"=>"1","idKat"=>"2"])
                    ->assertStatus(302);

        $this->assertDatabaseHas('tekst', [ 'sadrzaj' => "novi sadrzaj", "tezina"=>"1"]);
        $response->assertRedirect("/texts")->with("success");
        $tekst->sadrzaj = $oldText;
    }

    /*
        Pristup editu nepostojeceg teksta
    */
    public function test_global_edit_nepostojeceg()
    {
        $user = UserModel::where("tip",2)->first();
 
        $response = $this->actingAs($user)->get('/tekst/edit/-1')->assertNotFound();
    }
    /*
        Pristup editu nepostojeceg teksta
    */
    public function test_pristup_prijateljskoj_globalnoj_rL()
    {
        $user = UserModel::first();
 
        $response = $this->actingAs($user)
                ->get('/friendlyRankList');

        $response->assertViewIs("rank_list");
        $response->assertSeeText("Prebaci na globalnu");
    }
    /*
        Provera redirektovanja do globalne rang liste
    */
    public function test_global_rankList_neprijavljeni()
    {
        $response = $this->get('/rankList');

        $response->assertViewIs("rank_list");
        $response->assertDontSee("Prebaci na globalnu");
    }
    /*
        Prikaz glovalne rang liste prijavljenogkorisnika
    */
    public function test_global_rankList_prijavljeni()
    {
        $response = $this->get('/rankList');

        $response->assertViewIs("rank_list");
        $response->assertDontSee("Prebaci na prijateljsku");
    }  

    //Uspesno brisanje teksta
    public function test_delete_text() {
        $id = TextModel::where('id', '!=', DailyChallengeModel::getIdTekst())->first()->id;

        $this->actingAs(UserModel::where('tip', 1)->first())->delete('/texts/destroy/'.$id);
        $this->assertDatabaseMissing('tekst', ['id' => $id]);
    }

    //Brisanje nepostojeceg teksta
    public function test_delete_bad_id_text() {
        $id = -1;

        $this->actingAs(UserModel::where('tip', 1)->first())->delete('/texts/destroy/'.$id)->assertNotFound();
    }

    //Brisanje teksta kao obican korisnik
    public function test_delete_as_user() {
        $id = TextModel::where('id', '!=', DailyChallengeModel::getIdTekst())->first()->id;

        $this->actingAs(UserModel::where('tip', 0)->first())->delete('/texts/destroy/'.$id)->assertForbidden();
        $this->assertDatabaseHas('tekst', ['id' => $id]);
    }

    //Brisanje daily-a kao mod
    public function test_delete_daily_as_mod() {
        $id = DailyChallengeModel::getIdTekst();

        $this->actingAs(UserModel::where('tip', 1)->first())->delete('/texts/destroy/'.$id)->assertSessionHas('danger', 'Tekst je trenutno dnevni izazov, brisanje je dozvoljeno samo adminima');
        $this->assertDatabaseHas('tekst', ['id' => $id]);
    }

    //Brisanje daily-a kao admin
    public function test_delete_daily_as_admin() {
        $id = DailyChallengeModel::getIdTekst();

        $this->actingAs(UserModel::where('tip', 2)->first())->delete('/texts/destroy/'.$id)->assertSessionHas('dailyDeleted', 1);
        $this->assertDatabaseMissing('tekst', ['id' => $id]);
        $this->assertDatabaseCount('dnevniizazov', 0);
    }
}
