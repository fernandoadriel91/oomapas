<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            
            array (
                'route' => 'user',
                'title' => 'Usuarios',
                'icon' => NULL,
                'menu' => '1',
                'priority' => '1',
                'parent' => '3',
                'created_at' => '2018-12-26 13:50:29.803',
                'updated_at' => '2018-12-26 13:50:29.803',
            ),
            
            array (
                'route' => 'permission',
                'title' => 'Permisos',
                'icon' => NULL,
                'menu' => '1',
                'priority' => '1',
                'parent' => '4',
                'created_at' => '2018-12-26 13:50:29.807',
                'updated_at' => '2018-12-26 13:50:29.807',
            ),
            
            array (
                'route' => NULL,
                'title' => 'Usuarios y Dependencias',
                'icon' => 'flaticon-users',
                'menu' => '1',
                'priority' => '5',
                'parent' => '-1',
                'created_at' => '2018-12-26 13:50:29.807',
                'updated_at' => '2018-12-26 13:50:29.807',
            ),
            
            array (
                'route' => NULL,
                'title' => 'Developers',
                'icon' => 'la la-code',
                'menu' => '1',
                'priority' => '7',
                'parent' => '-1',
                'created_at' => '2018-12-26 13:50:29.807',
                'updated_at' => '2018-12-26 13:50:29.807',
            ),
            
            array (
                'route' => 'role',
                'title' => 'Roles',
                'icon' => NULL,
                'menu' => '1',
                'priority' => '2',
                'parent' => '4',
                'created_at' => '2018-12-26 13:50:29.810',
                'updated_at' => '2018-12-26 13:50:29.810',
            ),
            
            array (
                'route' => NULL,
                'title' => 'Admin',
                'icon' => NULL,
                'menu' => '0',
                'priority' => '4',
                'parent' => '-1',
                'created_at' => '2018-12-26 13:50:29.810',
                'updated_at' => '2018-12-26 13:50:29.810',
            ),
            
            array (
                'route' => 'developer',
                'title' => 'Developer',
                'icon' => NULL,
                'menu' => '0',
                'priority' => '6',
                'parent' => '-11',
                'created_at' => '2018-12-26 13:50:29.813',
                'updated_at' => '2018-12-26 13:50:29.813',
            ),
        ));
        
        
    }
}