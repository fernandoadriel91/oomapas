<?php

use Illuminate\Database\Seeder;

class PermissionRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permission__roles')->delete();
        
        \DB::table('permission__roles')->insert(array (
            
            array (
                'permission_id' => '1',
                'role_id' => '1',
                'c' => '1',
                'r' => '1',
                'u' => '1',
                'd' => '1',
                'admin' => '1',
                'created_at' => '2018-12-26 22:33:21.670',
                'updated_at' => '2018-12-26 22:33:21.670',
            ),
            
            array (
                'permission_id' => '3',
                'role_id' => '1',
                'c' => '0',
                'r' => '0',
                'u' => '0',
                'd' => '0',
                'admin' => '0',
                'created_at' => '2018-12-26 22:33:21.677',
                'updated_at' => '2018-12-26 22:33:21.677',
            ),
            
            array (
                'permission_id' => '2',
                'role_id' => '1',
                'c' => '1',
                'r' => '1',
                'u' => '1',
                'd' => '1',
                'admin' => '1',
                'created_at' => '2018-12-26 22:33:21.680',
                'updated_at' => '2018-12-26 22:33:21.680',
            ),
            
            array (
                'permission_id' => '4',
                'role_id' => '1',
                'c' => '0',
                'r' => '0',
                'u' => '0',
                'd' => '0',
                'admin' => '0',
                'created_at' => '2018-12-26 22:33:21.683',
                'updated_at' => '2018-12-26 22:33:21.683',
            ),
            
            array (
                'permission_id' => '5',
                'role_id' => '1',
                'c' => '1',
                'r' => '1',
                'u' => '1',
                'd' => '1',
                'admin' => '1',
                'created_at' => '2018-12-26 22:33:21.687',
                'updated_at' => '2018-12-26 22:33:21.687',
            ),
        ));
        
        
    }
}