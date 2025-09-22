<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAgents extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'current_level_id' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'points' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'last_unlocked_at' => ['type' => 'DATETIME', 'null' => true],
            'level_expires_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
    }

    public function down()
    {
        //
    }
}
