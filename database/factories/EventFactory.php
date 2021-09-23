<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence;

        return [
            "title" => $name,
            "description" => $this->faker->sentence(),
            "body" => $this->faker->paragraph,
            "start_event" => date("d/m/Y H:i"),
            "slug" => \Str::slug($name),
        ];
    }
}
