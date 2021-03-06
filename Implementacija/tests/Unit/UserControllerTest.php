<?php

namespace Tests\Unit;

use App\Models\UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    //Logout test
    public function test_logout() {
        $response = $this->actingAs(UserModel::first());
        $response->assertAuthenticated();

        $response->get('/logout');
        $response->assertGuest();
    }

    //test dodavanja i oduzimanja moderatorskih privilegija korisniku
    public function test_add_and_remove_mod() {
        $admin = UserModel::where('tip', 2)->first();
        $response = $this->actingAs($admin);

        $user = UserModel::where('tip', 0)->first();

        $response->get("/mod/".$user->username);

        $this->assertDatabaseHas('korisnik', [
            'username' => $user->username,
            'tip' => 1
        ]);

        $response->get("/mod/".$user->username);

        $this->assertDatabaseHas('korisnik', [
            'username' => $user->username,
            'tip' => 0
        ]);
    }

    //test blokiranja od strane obicnog korisnika
    public function test_mod_as_user() {
        $user = UserModel::where('tip', 0)->first();
        $response = $this->actingAs($user);

        $target = UserModel::where('tip', 0)->where('id', '!=', $user->id)->first();

        $response = $response->get("/mod/".$target->username)->assertForbidden();
    }

    //test modovanja sebe
    public function test_mod_self() {
        $admin = UserModel::where('tip', 2)->first();
        $response = $this->actingAs($admin);

        $response->get("/mod/".$admin->username)->assertForbidden();
    }

    //test modovanja nepostojeceg korisnika
    public function test_mod_unregistered_username() {
        $admin = UserModel::where('tip', 2)->first();
        $response = $this->actingAs($admin);

        $response->get("/mod/r1ewgt43fr3r")->assertNotFound();
    }

    //test blokirajnja i odblokiranja korisnika
    public function test_block_and_unblock_user() {
        $mod = UserModel::where('tip', 1)->first();
        $response = $this->actingAs($mod);

        $user = UserModel::where('tip', 0)->where('aktivan', 1)->first();

        $response->get("/blokiraj/".$user->username);

        $this->assertDatabaseHas('korisnik', [
            'username' => $user->username,
            'aktivan' => 0
        ]);

        $response->get("/blokiraj/".$user->username);

        $this->assertDatabaseHas('korisnik', [
            'username' => $user->username,
            'aktivan' => 1
        ]);
    }

    //test blokiranja od strane obicnog korisnika
    public function test_block_as_user() {
        $user = UserModel::where('tip', 0)->first();
        $response = $this->actingAs($user);

        $target = UserModel::where('tip', 1)->where('aktivan', 1)->where('id', '!=', $user->id)->first();

        $response = $response->get("/blokiraj/".$target->username)->assertForbidden();
    }

    //test blokiranja sebe
    public function test_block_self() {
        $mod = UserModel::where('tip', 1)->first();
        $response = $this->actingAs($mod);

        $response->get("/blokiraj/".$mod->username)->assertForbidden();
    }

    //test blokiranja nepostojeceg korisnika
    public function test_block_unregistered_username() {
        $mod = UserModel::where('tip', 1)->first();
        $response = $this->actingAs($mod);

        $response->get("/blokiraj/r1ewgt43fr3r")->assertNotFound();
    }

    public function test_showTexts()
    {
        $user = UserModel::where('tip', 0)->first();
        $response = $this->actingAs($user);
        $response->get('texts')->assertViewIs('texts');
    }


    public function test_showTextsGuest()
    {
        $this->get('texts')->assertRedirect('/');
    }

    public function test_textSearch()
    {
        $user = UserModel::where('tip', 0)->first();
        $response = $this->actingAs($user);
        $response->get('textsearch?kategorija=2&tezina=1&duzina=2')->assertViewIs('texts');
    }


    public function test_textSearchGuest()
    {
        $this->get('textsearch')->assertRedirect('/');
    }

    public function test_recommendTexts()
    {
        $user = UserModel::where('tip', 0)->first();
        $response = $this->actingAs($user);
        $response->get('recommendTexts')->assertRedirect('textsearch?kategorija=0&tezina=3&duzina=1&page=1');
    }

    public function test_recommendTextsGuest()
    {
        $this->get('recommendTexts')->assertRedirect('/');
    }

    public function test_getDaily()
    {
        $user = UserModel::where('tip', 0)->first();
        $response = $this->actingAs($user);
        $response->get('daily')->assertViewIs('daily');
    }

    public function test_getDailyGuest()
    {
        $this->get('daily')->assertRedirect('/');
    }

    public function test_getDailyEnd()
    {
        $user = UserModel::where('tip', 0)->first();
        $response = $this->actingAs($user);
        $response->get('dailyEnd')->assertRedirect('/');
    }

    public function test_getDailyEndGuest()
    {
        $this->get('dailyEnd')->assertRedirect('/');
    }

    public function test_dailyPrikazRezultata()
    {
        $user = UserModel::where('tip', 0)->first();
        $response = $this->actingAs($user);
        $response->get('/dailyResults', [
            'idTekst' => 13,
            'speed' => 480,
            'best_speed' => 480,
            'best_position' => 1,
            'saved' => 1,
            'reward' => 'gold',
        ])->assertStatus(500);
    }

    public function test_promeniDailyAdmin()
    {
        $user = UserModel::where('tip', 2)->first();
        $response = $this->actingAs($user);
        $response->get('dailyChange')->assertRedirect('/');
    }

    public function test_promeniDailyNonAdmin()
    {
        $user = UserModel::where('tip', 0)->first();
        $response = $this->actingAs($user);
        $response->get('dailyChange')->assertForbidden();
    }

    // test prikaza sopstvenog profila
    public function test_show_own_profile() {
        $user = UserModel::where('tip', 0)->where('aktivan', 1)->first();
        $response = $this->actingAs($user);
        $response->get("/user/".$user->username)->assertSeeText($user->username);
    }

    // test dodavanja i uklanjanja korisnika kao prijatelja
    public function test_friend_and_unfriend_user() {
        $firstUser = UserModel::where('tip', 0)->first();
        $response = $this->actingAs($firstUser);

        $secondUser = UserModel::where('tip', 0)->where('aktivan', 1)->first();

        $response->get("/dodaj/".$secondUser->username);

        $this->assertDatabaseHas('jeprijatelj', [
            'idKor1' => $firstUser->id,
            'idKor2' => $secondUser->id
        ]);

        $response->get("/dodaj/".$secondUser->username);

        $this->assertDatabaseMissing('jeprijatelj', [
            'idKor1' => $firstUser->id,
            'idKor2' => $secondUser->id
        ]);
    }

    // test otvaranja stranice za pretragu korisnika
    public function test_search_users_form() {
        $mod = UserModel::where('tip', 1)->first();
        $response = $this->actingAs($mod);

        $response->get("/searchusers")->assertViewIs("pretragaProfila");
    }

    // test pretrage korisnika
    public function test_search_users() {
        $mod = UserModel::where('tip', 1)->first();
        $response = $this->actingAs($mod);

        $response->get("/submitusersearch?filter=kor")->assertSeeText("korisnik1");
    }
}
