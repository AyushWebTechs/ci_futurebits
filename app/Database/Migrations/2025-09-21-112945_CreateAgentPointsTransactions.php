<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAgentPointsTransactions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'agent_id'     => ['type'=>'INT','constraint'=>11],
            'points'       => ['type'=>'INT','constraint'=>11],
            'comment'      => ['type'=>'TEXT','null'=>true],
            'admin_user_id'=> ['type'=>'INT','constraint'=>11,'null'=>true],
            'created_at'   => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('agent_points_transactions');
    }

    public function down()
    {
        $this->forge->dropTable('agent_points_transactions');
    }
}
