<?php

use Illuminate\Database\Seeder;
use App\User;
use App\posts;
use App\Coments;

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
        Coments::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        factory(User::class,10)->create();
        factory(Posts::class,50)->create();
        factory(Coments::class,100)->create();

        $arrays = range(0,60);
        foreach ($arrays as $array) {
            DB::table('followers')->insert([
                'id_follower'=>random_int(1,10),
                'id_followed'=>random_int(1,10)
            ]);
        }
    }
}
