<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Friend;
use App\Models\User;
use Faker\Generator as Faker;

class FriendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users= collect(User::all()->modelKeys());
        $data = [];

        for ($i = 0; $i < 30; $i++) {
            $data[] = [
                'status' => 'Pending',
                'user_id_1' => $users->random(),
                'user_id_2' => $users->random()
            ];
        }

        $chunks = array_chunk($data, 30);

        foreach ($chunks as $chunk) {
            Friend::insert($chunk);
        }
    }
}
