<?php

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
       factory(App\User::class, 50)->create()
        ->each( function ($user) {
            factory(App\Models\Article::class, 20)->create([
                'user_id' => $user->id
            ]);
        });
        
    }
}
