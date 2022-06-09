<?php

namespace Tests\Unit;

use App\Models\UserModel;
use Tests\TestCase;

class GuestControllerTest extends TestCase
{
    //Provera prikaza register stranice
    public function test_register_page_view() {
        $this->get('/registerPage')->assertViewIs('registerPage');
    }

    //Provera registracije korisnika kroz register rutu
    public function test_register() {
        $response = $this->post('/register', [
            'username' => 'testuserreg1',
            'password' => 'brziprsti123',
            'passwordConfirm' => 'brziprsti123'
        ]);

        $response->assertRedirect(route('homePage'));
        $this->assertDatabaseHas('korisnik', ['username' => 'testuserreg1']);

        UserModel::where('username', 'testuserreg1')->delete();
    }

    //Provera registracije korisnika koji vec postoji
    public function test_register_existing_username() {
        $response = $this->post('/register', [
            'username' => 'korisnik1',
            'password' => 'brziprsti123',
            'passwordConfirm' => 'brziprsti123'
        ]);

        $response->assertViewIs('registerPage')->assertViewHas('errorUsername', 'Korisnicko ime vec postoji');
    }

    //Provera registracije sa praznim korisnickim imenom
    public function test_register_empty_username() {
        $response = $this->post('/register', [
            'username' => '',
            'password' => 'brziprsti123',
            'passwordConfirm' => 'brziprsti123'
        ]);

        $response->assertSessionHasErrors(['username' => 'Polje je obavezno']);
    }

    //Provera registracije sa praznom lozinkom
    public function test_register_empty_password() {
        $response = $this->post('/register', [
            'username' => 'testuserreg2',
            'password' => '',
            'passwordConfirm' => 'brziprsti123'
        ]);

        $response->assertSessionHasErrors(['password' => 'Polje je obavezno']);
    }

    //Provera registracije sa praznom potvrdom lozinke
    public function test_register_empty_confirm_password() {
        $response = $this->post('/register', [
            'username' => 'testuserreg3',
            'password' => 'brziprsti123',
            'passwordConfirm' => ''
        ]);

        $response->assertSessionHasErrors(['passwordConfirm' => 'Polje je obavezno']);
    }

    //Provera registracije sa prekratkim usernameom
    public function test_register_short_username() {
        $response = $this->post('/register', [
            'username' => 't4',
            'password' => 'brziprsti123',
            'passwordConfirm' => 'brziprsti123'
        ]);

        $response->assertSessionHasErrors(['username' => 'Polje mora imati bar 3 karaktera']);
    }

    //Provera registracije sa predugackim usernameom
    public function test_register_long_username() {
        $response = $this->post('/register', [
            'username' => 'testuserreg5testuserreg5testuserreg5',
            'password' => 'brziprsti123',
            'passwordConfirm' => 'brziprsti123'
        ]);

        $response->assertSessionHasErrors(['username' => 'Polje mora imati manje od 20 karaktera']);
    }

    //Provera registracije sa prekratkom lozinkom
    public function test_register_short_password() {
        $response = $this->post('/register', [
            'username' => 'testuserreg6',
            'password' => 'brzprst',
            'passwordConfirm' => 'brzprst'
        ]);

        $response->assertSessionHasErrors(['password' => 'Polje mora imati bar 8 karaktera']);
    }

    //Provera registracije sa predugackom lozinkom
    public function test_register_long_password() {
        $response = $this->post('/register', [
            'username' => 'testuserreg7',
            'password' => 'brziprsti123brziprsti123brziprsti123',
            'passwordConfirm' => 'brziprsti123brziprsti123brziprsti123'
        ]);

        $response->assertSessionHasErrors(['password' => 'Polje mora imati manje od 15 karaktera']);
    }

    //Provera registracije gde se lozinka i njena potvrda ne poklapaju
    public function test_register_password_confirm_mismatch() {
        $response = $this->post('/register', [
            'username' => 'testuserreg8',
            'password' => 'brziprsti123',
            'passwordConfirm' => 'prstibrzi132'
        ]);

        $response->assertSessionHasErrors(['passwordConfirm' => 'Polje mora biti isto kao i lozinka']);
    }

    //Provera registracije gde lozinka sadrzi specijalne znakove
    public function test_register_password_with_special_characters() {
        $response = $this->post('/register', [
            'username' => 'testuserreg9',
            'password' => 'brziprsti123*',
            'passwordConfirm' => 'brziprsti123*'
        ]);

        $response->assertSessionHasErrors(['password' => 'Polje mora sadrzati slova i brojeve']);
    }

    //Provera uspesnog logina
    public function test_login() {
        $response = $this->post('/login', [
            'username' => 'korisnik1',
            'password' => 'brziprsti123'
        ]);

        $this->assertAuthenticatedAs(UserModel::where('username', 'korisnik1')->first());
        $response->assertRedirect(route('homePage'));
    }

    //Provera logina sa praznim username-om
    public function test_login_empty_username() {
        $response = $this->post('/login', [
            'username' => '',
            'password' => 'brziprsti123'
        ]);

        $response->assertSessionHasErrors(['username' => 'Polje je obavezno']);
        $this->assertGuest();
    }

    //Provera logina sa praznom lozinkom
    public function test_login_empty_password() {
        $response = $this->post('/login', [
            'username' => 'korisnik1',
            'password' => ''
        ]);

        $response->assertSessionHasErrors(['password' => 'Polje je obavezno']);
        $this->assertGuest();
    }

    //Provera logina sa nepostojecim korisnickim imenom
    public function test_login_wrong_username() {
        $response = $this->post('/login', [
            'username' => 'egtjydt4r',
            'password' => 'brziprsti123'
        ]);

        $response->assertSessionHas('status', 'Nepostojeće korisničko ime');
        $this->assertGuest();
    }

    //Provera logina sa pogresnom lozinkom
    public function test_login_wrong_password() {
        $response = $this->post('/login', [
            'username' => 'korisnik1',
            'password' => 'wdfry4t3ef'
        ]);

        $response->assertSessionHas('status', 'Pogrešna šifra');
        $this->assertGuest();
    }

    public function test_login_blocked() {
        $response = $this->post('/login', [
            'username' => 'blokirani',
            'password' => 'brziprsti123'
        ]);

        $response->assertSessionHas('status', 'Korisnik je blokiran');
        $this->assertGuest();
    }
}
