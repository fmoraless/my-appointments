<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           'name' => 'Admin',
           'email' => 'admin@admin.com',
           'password' => bcrypt('password'),
           'dni' => 12345678,
           'address' => 'MI derexxion',
           'phone' => '1111111',
           'role' => 'admin',

        ]);

        User::create([
            'name' => 'Medico test',
            'email' => 'doctor@doctor.com',
            'password' => bcrypt('password'),
            'dni' => 12345690,
            'address' => 'Avenida lasikarias 1234',
            'phone' => '1111111',
            'role' => 'doctor',

        ]);
        factory(User::class, 50)->states('patient')->create();
    }
}
