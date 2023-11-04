<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            
            array (
                'name' => 'Developer',
                'state' => 'role',
                'description' => 'Todos los permisos',
                'active' => '1',
                'created_at' => '2018-12-26 13:50:29.787',
                'updated_at' => '2018-12-26 13:50:29.787',
            ),
        ));
        
        
    }
}