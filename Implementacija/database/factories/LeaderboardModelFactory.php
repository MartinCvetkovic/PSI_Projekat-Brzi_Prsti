<?php

namespace Database\Factories;

use App\Models\LeaderboardModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LeaderboardModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LeaderboardModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idKor' => 2,
            'vreme' => 12345,
            'idTekst' => 12
        ];
    }
}
