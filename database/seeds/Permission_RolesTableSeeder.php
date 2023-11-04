<?php

use App\Permission_Role;
use Crockett\CsvSeeder\CsvSeeder;

class Permission_RolesTableSeeder extends CsvSeeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insert_chunk_size = 1;
        $this->insert_callback = function ($chunk) {
            foreach($chunk as $row) {
                Permission_Role::create($row->toArray());
            }
        };
        $this->seedFromCSV(base_path('/database/seeds/csvs/permission__roles.csv'));
    }
}
