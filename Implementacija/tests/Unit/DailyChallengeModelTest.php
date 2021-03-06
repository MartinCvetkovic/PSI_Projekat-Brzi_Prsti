<?php

namespace Tests\Unit;

use App\Models\DailyChallengeModel;
use App\Models\TextModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DailyChallengeModelTest extends TestCase
{
    use DatabaseTransactions;
    
    public function test_text()
    {
        $this->assertTrue(21 == DailyChallengeModel::first()->text()->id);
    }

    public function test_category()
    {
        $this->assertTrue('edukativni' == DailyChallengeModel::first()->category()->naziv);
    }

    public function test_getDaily()
    {
        $this->assertTrue(2 == DailyChallengeModel::getDaily()->id);
    }

    public function test_getDailyOrFail()
    {
        $this->assertTrue(2 == DailyChallengeModel::getDailyOrFail()->id);
    }

    public function test_changeDaily()
    {
        DailyChallengeModel::changeDaily();
        $this->assertTrue(2 != DailyChallengeModel::getDaily()->id);
        $this->assertTrue(true);
    }

    public function test_getIdTekst() {
        $this->assertTrue(21 == DailyChallengeModel::getIdTekst());
    }
}
