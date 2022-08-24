<?php

namespace Database\Factories;

use App\Enum\StatusEnum;
use App\Enum\TypeEnum;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SiteCategory>
 */
class SiteCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'site_id' => Site::inRandomOrder()->value('id'),
            'image'   => '18.jpg',
            'place'   => $this->faker->text(),
            'status'  => StatusEnum::ACTIVE,
            'type'    => TypeEnum::WEB,
        ];
    }
}
