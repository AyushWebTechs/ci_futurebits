<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LevelsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['level_name'=>'Level 1','min_points'=>0,'max_points'=>99],
            ['level_name'=>'Level 2','min_points'=>100,'max_points'=>199],
            ['level_name'=>'Level 3','min_points'=>200,'max_points'=>499],
            ['level_name'=>'Level 4','min_points'=>500,'max_points'=>null],
        ];

        $this->db->table('levels')->insertBatch($data);
    }
}
