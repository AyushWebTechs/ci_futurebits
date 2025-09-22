<?php namespace App\Libraries;

use App\Models\LevelModel;
use App\Models\AgentModel;
use App\Models\AgentPointsTransactionModel;

class LevelService
{
    protected $levelModel;
    protected $agentModel;
    protected $txnModel;

    public function __construct()
    {
        $this->levelModel = new LevelModel();
        $this->agentModel = new AgentModel();
        $this->txnModel   = new AgentPointsTransactionModel();
    }

    public function addPoints(int $agentId, int $delta, int $adminId, string $comment = '')
    {
        $agent = $this->agentModel->find($agentId);
        if (!$agent) return false;

        $newPoints = intval($agent['points']) + intval($delta);

        // log transaction
        $this->txnModel->insert([
            'agent_id' => $agentId,
            'points' => $delta,
            'comment' => $comment,
            'admin_user_id' => $adminId,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // get levels ordered high to low
        $levels = $this->levelModel->orderBy('min_points','DESC')->findAll();
        $target = null;
        foreach ($levels as $lvl) {
            if ($lvl['min_points'] <= $newPoints) {
                $target = $lvl;
                break;
            }
        }

        $currentLevel = $agent['current_level_id'] ? $this->levelModel->find($agent['current_level_id']) : null;

        if ($target && (!$currentLevel || $target['id'] > $currentLevel['id'])) {
            // UPGRADE
            $this->agentModel->update($agentId, [
                'current_level_id' => $target['id'],
                'points'           => 0,
                'last_unlocked_at' => date('Y-m-d H:i:s'),
                'level_expires_at' => date('Y-m-d H:i:s', strtotime('+30 days'))
            ]);
        } elseif ($target && $currentLevel && $target['id'] < $currentLevel['id']) {
            // DOWNGRADE
            $this->agentModel->update($agentId, [
                'current_level_id'=>$target['id'],
                'points'=>$newPoints
            ]);
        } else {
            // stay in same level
            $this->agentModel->update($agentId, ['points'=>$newPoints]);
        }

        return true;
    }
}
