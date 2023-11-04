<?php

use Crockett\CsvSeeder\CsvSeeder;
use App\Dependency;

class DependenciesTableSeeder extends CsvSeeder
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
                Dependency::create($row->toArray());
            }
        };
        $this->seedFromCSV(base_path('/database/seeds/csvs/dependencies.csv'));
    }
}
