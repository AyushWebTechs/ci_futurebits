<?php namespace App\Models;

use CodeIgniter\Model;

class AgentLevelModel extends Model
{
    protected $table = 'agent_levels';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'agent_id','level_id','unlocked_at','expiry_at'
    ];
}
