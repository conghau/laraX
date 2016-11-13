<?php

use Illuminate\Database\Seeder;

class categoryTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            DB::table('categories')->insert([
                'group' => str_random(10),
                'name' => str_random(10) . '@gmail.com',
                'status' => 1,
                'slug' => str_slug(str_random(10)),
                'position' => str_random(10),
                'template' => str_random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
