<?php

use App\User;
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
        $user = User::create([
            "name"=>"thomas",
            "email"=>"thomas.ricci@cpnv.ch",
            "password"=>bcrypt("123456")
        ]);
        $user->albums()->create(["name"=>"default"]);
        $user = User::create([
            "name"=>"este",
            "email"=>"westixy@gmail.com",
            "password"=>bcrypt("123456")
        ]);
        $user->albums()->create(["name"=>"default"]);
        // $this->call(UsersTableSeeder::class);
    }
}
