<?php namespace App\Models;

use CodeIgniter\Model;

class AgentPointsTransactionModel extends Model
{
    protected $table = 'agent_points_transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'agent_id','points','comment','admin_user_id','created_at'
    ];
    protected $useTimestamps = false;
}
