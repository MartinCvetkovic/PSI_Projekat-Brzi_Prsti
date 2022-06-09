<?php

namespace Tests\Unit;

use Tests\TestCase;

class BaseControllerTest extends TestCase
{
    //Test rute za homepage
    public function test_home_page() {
        $this->get('/')->assertViewIs('home');
    }
}
