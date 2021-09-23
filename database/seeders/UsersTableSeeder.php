<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(50)
                    ->has(
                        Event::factory(5)
                        ->hasPhotos(4)
                        ->hasCategories(4)
                    )
                    ->hasProfile()
                    ->create();
    }
}
