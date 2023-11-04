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
        $data = [
            [
                'name' => "Rafael Vera",
                'username' => "rafael.vera",
                'email' => "rafael.vera@heroicanogales.gob.mx",
                'role_id' => 1,
                'dependency_id' => '3400',
                'department_id' => '3401',
                'password' => '123456',
                'active' => 0,
                'password_expires' => 1,
                'change_password' => 0,
                'last_password_changed' => \Carbon\Carbon::now()

            ],
            [
                'name' => "Fernando León",
                'username' => "fernando.leon",
                'email' => "fernando.leon@heroicanogales.gob.mx",
                'role_id' => 1,
                'dependency_id' => '3400',
                'department_id' => '3401',
                'password' => '123456',
                'active' => 1,
                'password_expires' => 0,
                'change_password' => 0,
                'last_password_changed' => \Carbon\Carbon::now()
            ],
            [
                'name' => "Ivan Zuñiga",
                'username' => "ivan.zuniga",
                'email' => "ivan.zuniga@heroicanogales.gob.mx",
                'role_id' => 1,
                'dependency_id' => '3400',
                'department_id' => '3401',
                'password' => '123456',
                'active' => 1,
                'password_expires' => 0,
                'change_password' => 0,
                'last_password_changed' => \Carbon\Carbon::now()
            ],
            [
                'name' => "Carlos Nevarez",
                'username' => "carlos.nevarez",
                'email' => "carlos.nevarez@heroicanogales.gob.mx",
                'role_id' => 1,
                'dependency_id' => '3400',
                'department_id' => '3401',
                'password' => '123456',
                'active' => 1,
                'password_expires' => 0,
                'change_password' => 0,
                'last_password_changed' => \Carbon\Carbon::now()
            ],
            [
                'name' => "Aurelio Martinez",
                'username' => "aurelio.martinez",
                'email' => "aurelio.martinez@heroicanogales.gob.mx",
                'role_id' => 1,
                'dependency_id' => '3400',
                'department_id' => '3401',
                'password' => '123456',
                'active' => 1,
                'password_expires' => 0,
                'change_password' => 0,
                'last_password_changed' => \Carbon\Carbon::now()
            ]
        ];
        
        foreach($data as $user){
            User::create($user);
        }

    }
}
