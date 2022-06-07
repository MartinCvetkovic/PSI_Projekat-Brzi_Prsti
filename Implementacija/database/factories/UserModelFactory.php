<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->asciify('********************'),
            'password' => '$2y$10$QS31ukwN4E3ViIk2Iz5/j.2.Q.iHDuYQ7YOKPo/iSwLLT2Yzlp4/e', // password
            'zlato' => 0,
            'srebro' => 0,
            'bronza' => 0,
            'tip' => 0,
            'aktivan' => 1,
            'brojPrijatelja' => 0
        ];
    }
}
