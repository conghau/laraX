<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        for($i=0; $i<50;$i++){
            $this->call(UserTableSeeder::class);
        }

=======
         $this->call(UserSeeder::class);
>>>>>>> 48ac3372410bffe21b248fdec3cab20391e85550
    }
}
