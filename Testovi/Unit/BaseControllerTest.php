<?php

namespace Tests\Unit;

use App\Models\UserModel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BaseControllerTest extends TestCase
{
    use DatabaseTransactions;
    //Test rute za homepage
    public function test_home_page() {
        $this->get('/')->assertViewIs('home');
    }

    public function test_soloKucanjeRandom()
    {
        $this->get('/solo')->assertViewIs('solo');
    }

    public function test_soloKucanjeId()
    {
        $this->get('/solo/13')->assertViewIs('solo');
    }

    public function test_soloEndPost()
    {
        $mod = UserModel::where('tip', 1)->first();
        $response = $this->actingAs($mod)->post('/soloEnd', [
            'idTekst' => 13,
            'time' => 1
        ]);

        $response->assertRedirect('http://localhost/soloResults?id=13&speed=480&best_speed=480&best_position=1');
    }

    public function test_soloEndGet()
    {
        $this->get('/soloEnd')->assertRedirect('/');
    }

    public function test_soloKucanjePrikazRezultata()
    {
        $mod = UserModel::where('tip', 1)->first();
        $response = $this->actingAs($mod)->get('/soloResults', [
            'id' => 13,
            'speed' => 480,
            'best_speed' => 480,
            'best_position' => 1
        ]);
        $response->assertNotFound();
    }
}
