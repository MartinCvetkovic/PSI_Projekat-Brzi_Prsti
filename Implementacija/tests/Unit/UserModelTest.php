<?php

namespace Tests\Unit;

use App\Models\LeaderboardModel;
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
}
