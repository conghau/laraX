<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        for ($i = 0; $i < 50; $i++) {
            DB::table('users')->insert([
                'username' => str_random(10),
                'email' => str_random(10) . '@gmail.com',
                'password' => bcrypt('secret'),
                'last_name' => str_random(10),
                'first_name' => str_random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
