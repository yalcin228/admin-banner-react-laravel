<?php

namespace Database\Factories;

use App\Models\BannerAds;
use App\Models\Site;
use App\Models\SiteCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BannerAds>
 */
class BannerAdsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = BannerAds::class;

    public function definition()
    {
        return [
            'ads' => $this->faker->imageUrl,
            'site_id' => Site::inRandomOrder()->value('id'),
            'category_id' => SiteCategory::inRandomOrder()->value('id'),
            'sort' => rand(1, 100),
            'datetime' => $this->faker->dateTime
        ];
    }
}
