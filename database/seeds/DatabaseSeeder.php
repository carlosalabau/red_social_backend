<?php

use Illuminate\Database\Seeder;
use App\User;
use App\posts;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Posts::truncate();

        factory(User::class,10)->create();
        factory(Posts::class,20)->create();


        $arrays = range(0,50);
        foreach ($arrays as $array) {
            DB::table('likes')->insert([
                'id_user'=>random_int(0,10),
                'id_post'=>random_int(0,10)
            ]);
        }
    }
}
