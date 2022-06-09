<?php

namespace Tests\Unit;

use App\Models\LeaderboardModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class UserModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_addGold()
    {
        $user = UserModel::newFactory()->make();
        $user->addGold();
        $this->assertTrue($user->zlato == 1);
    }

    public function test_addSilver()
    {
        $user = UserModel::newFactory()->make();
        $user->addSilver();
        $this->assertTrue($user->srebro == 1);
    }

    public function test_addBronze()
    {
        $user = UserModel::newFactory()->make();
        $user->addBronze();
        $this->assertTrue($user->bronza == 1);
    }

    public function test_getRecommendedDifficulty()
    {
        $user = UserModel::newFactory()->make();
        // Ako nije kucao
        $this->assertTrue($user->getRecommendedDifficulty() == 0);
        $user = UserModel::where('id', 6)->first();
        $this->assertTrue($user->getRecommendedDifficulty() == 1);
        $user = UserModel::where('id', 3)->first();
        $this->assertTrue($user->getRecommendedDifficulty() == 2);
        $user = UserModel::where('id', 2)->first();
        $this->assertTrue($user->getRecommendedDifficulty() == 3);
    }

    public function test_getRecommendedLength()
    {
        $user = UserModel::newFactory()->make();
        $this->assertTrue($user->getRecommendedLength() == 0);
        $user = UserModel::where('id', 2)->first();
        $this->assertTrue($user->getRecommendedLength() == 1);
    }

    public function test_dohvatiKorisnika() {
        $this->assertEquals(UserModel::where('username', 'korisnik1')->first(), UserModel::dohvatiKorisnika("korisnik1"));

        $this->expectException(ModelNotFoundException::class);
        UserModel::dohvatiKorisnika("23thgf2rjtg");
    }

    public function test_add_user() {
        UserModel::addUser("sdfrgt2", "brziprsti123", 1, 2, 3, 0, 1, 7);
        $this->assertDatabaseHas('korisnik', [
            'username' => "sdfrgt2",
            'password' => "brziprsti123",
            'zlato' => 1,
            'srebro' => 2,
            'bronza' => 3,
            'tip' => 0,
            'aktivan' => 1,
            'brojPrijatelja' => 7
        ]);

        //Dodavanje postojeceg korisnika
        $count = UserModel::count();
        UserModel::addUser("korisnik1", "brziprsti123", 99, 99, 99, 0, 1, 0);
        $countAfter = UserModel::count();
        $this->assertEquals($count, $countAfter);
    }

    public function test_getAuthPassword() {
        $user = UserModel::first();

        $this->assertEquals($user->password, $user->getAuthPassword());
    }

    public function test_isBlocked() {
        $notBlocked = UserModel::where('aktivan', 1)->first();
        $this->assertFalse(UserModel::isBlocked($notBlocked->username));

        $blocked = UserModel::where('aktivan', 0)->first();
        $this->assertTrue(UserModel::isBlocked($blocked->username));
    }
}
