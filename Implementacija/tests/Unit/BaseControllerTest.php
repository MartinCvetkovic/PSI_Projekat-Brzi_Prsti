<?php

namespace Tests\Unit;

use Tests\TestCase;

class BaseControllerTest extends TestCase
{
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
        /*$response = $this->post('/soloEnd', [
            'id' => 13,
            'speed' => 15,
            'best_speed' => 13,
            'best_position' => 2
        ]);

        $response->assertRedirect(route('solo_kucanje_rezultati'));*/
        //$this->assertDatabaseHas('korisnik', ['username' => 'testuserreg1']);
    }

    public function test_soloEndGet()
    {
        $this->get('/soloEnd')->assertRedirect('/');
    }

    public function test_soloKucanjePrikazRezultata()
    {
        //$this->get('/soloResults')->assertViewIs('solo_kucanje_rezultati');
    }
}
