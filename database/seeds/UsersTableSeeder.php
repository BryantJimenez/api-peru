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
        App\User::create([
        	'name' => 'Super',
            'lastname' => 'Admin',
            'phone' => '12345678',
        	'photo' => 'usuario.png',
        	'slug' => 'super-admin',
        	'email' => 'admin@gmail.com',
        	'password' => bcrypt('12345678'),
        	'state' => '1'
        ]);

        App\Code::create([
            'name' => 'Prueba',
            'code' => '000000',
            'limit' => 1000,
            'state' => '1',
            'user_id' => 1
        ]);

        App\Query::create([
            'queries' => 0,
            'type' => '1',
            'code_id' => 1
        ]);

        App\Query::create([
            'queries' => 0,
            'type' => '2',
            'code_id' => 1
        ]);
    }
}
