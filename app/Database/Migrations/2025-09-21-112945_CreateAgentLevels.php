<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAgentLevels extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'agent_id'    => ['type'=>'INT','constraint'=>11],
            'level_id'    => ['type'=>'INT','constraint'=>11],
            'unlocked_at' => ['type'=>'DATETIME','null'=>true],
            'expiry_at'   => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('agent_levels');
    }

    public function down()
    {
        $this->forge->dropTable('agent_levels');
    }
}
