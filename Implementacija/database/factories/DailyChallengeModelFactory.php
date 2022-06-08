<?php

namespace Database\Factories;

use App\Models\DailyChallengeModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DailyChallengeModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyChallengeModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sadrzaj' => 'Početak je najvažniji deo svakog posla. - Platon',
            'tezina' => 1,
            'nazivKategorije' => 'citat',
            'idTekst' => 13
        ];
    }
}
