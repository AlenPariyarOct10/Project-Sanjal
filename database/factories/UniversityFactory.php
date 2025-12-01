<?php

namespace Database\Factories;

use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class UniversityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    protected static $slugTracker = [];

    public function definition(): array
    {
        $name = $this->faker->company . ' University';
        $baseSlug = Str::slug($name);

        // Track slugs already used in this seeding run
        if (!isset(self::$slugTracker[$baseSlug])) {
            self::$slugTracker[$baseSlug] = 0;
        }

        self::$slugTracker[$baseSlug]++;
        $slug = $baseSlug . (self::$slugTracker[$baseSlug] > 1 ? '-' . self::$slugTracker[$baseSlug] : '');

        return [
            'name' => $name,
            'key' => uniqid('uni_'),
            'slug' => $slug,
            'address' => $this->faker->city,
            'description' => $this->faker->text(50),
            'website' => $this->faker->url,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'facebook' => $this->faker->url,
            'twitter' => $this->faker->url,
            'instagram' => $this->faker->url,
            'youtube' => $this->faker->url,
            'linkedin' => $this->faker->url,
        ];
    }

}
