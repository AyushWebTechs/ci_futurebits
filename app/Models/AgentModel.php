<?php namespace App\Models;

use CodeIgniter\Model;

class AgentModel extends Model
{
    protected $table = 'agents';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name','email','current_level_id','points','last_unlocked_at','level_expires_at','created_at','updated_at'
    ];
    protected $useTimestamps = true;
}
