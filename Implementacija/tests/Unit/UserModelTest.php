<?php

namespace Tests\Unit;

use App\Models\UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

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
}
