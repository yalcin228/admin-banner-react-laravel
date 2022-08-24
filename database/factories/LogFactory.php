<?php

namespace Database\Factories;

use App\Models\Log;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Log::class;

    public function definition()
    {
        return [
            'admin_id' => User::all()->random()->id,
            'info' => rand(1,250),
            'action' => $this->faker->text(100),
            'ip' => $this->faker->ipv4
        ];
    }
}
