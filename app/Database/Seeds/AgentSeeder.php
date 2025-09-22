<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AgentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'current_level_id' => null,
                'points' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'current_level_id' => null,
                'points' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Mark Lee',
                'email' => 'mark@example.com',
                'current_level_id' => null,
                'points' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('agents')->insertBatch($data);
    }
}
