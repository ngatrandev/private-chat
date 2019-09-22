<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        factory(User::class)->create([
            'email'=> 'ngatrandev@gmail.com',
            'name' => 'Nga Tran'
        ]);

        factory(User::class)->create([
            'email'=> 'tranngocnga24@gmail.com',
            'name' => 'Gau'
        ]);

        factory(User::class)->create([
            'email'=> 'phanvan27@gmail.com',
            'name' => 'Van Phan'
        ]);

        //tạo các factory: php artisan db:seed
    }
}
