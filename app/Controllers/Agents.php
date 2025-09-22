<?php namespace App\Controllers;

use App\Models\AgentModel;
use App\Models\LevelModel;
use App\Models\AgentPointsTransactionModel;
use App\Models\AgentLevelModel;

class Agents extends BaseController
{
    public function index()
    {
        $agentModel = new AgentModel();
        $levelModel = new LevelModel();

        $agents = $agentModel->findAll();

        foreach ($agents as &$agent) {
            $level = $levelModel->find($agent['current_level_id']);
            $agent['level_name'] = $level['level_name'] ?? 'N/A';
        }

        return view('agents/index', ['agents' => $agents]);
    }

    public function addPoints($agentId)
    {
        $points = (int) $this->request->getPost('points');
        $comment = $this->request->getPost('comment');
        $adminUserId = 1; // TODO: replace with logged-in admin ID

        $agentModel = new AgentModel();
        $transactionModel = new AgentPointsTransactionModel();

        $agent = $agentModel->find($agentId);
        $newPoints = $agent['points'] + $points;
        if ($newPoints < 0) {
            $newPoints = 0;
        }

        $transactionModel->insert([
            'agent_id' => $agentId,
            'points' => $points,
            'comment' => $comment,
            'admin_user_id' => $adminUserId,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->recalculateLevel($agentId, $newPoints);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Points updated',
        ]);
    }

    public function history($agentId)
    {
        $transactionModel = new AgentPointsTransactionModel();
        $agentLevelModel = new AgentLevelModel();

        $transactions = $transactionModel->where('agent_id', $agentId)->findAll();

        $levels = $agentLevelModel->select('level_id, unlocked_at, expiry_at, levels.level_name')->join('levels', 'levels.id = agent_levels.level_id')->where('agent_levels.agent_id', $agentId)->findAll();

        return view('agents/history', [
            'transactions' => $transactions,
            'levels' => $levels,
        ]);
    }

    private function recalculateLevel($agentId, $newPoints)
    {
        $agentModel = new AgentModel();
        $levelModel = new LevelModel();
        $agentLevelModel = new AgentLevelModel();

        $agent = $agentModel->find($agentId);
        if (!$agent) {
            return;
        }

        $newLevel = $levelModel->where('min_points <=', $newPoints)->where('max_points >=', $newPoints)->first();

        if (!$newLevel) {
            return;
        }

        $currentLevelId = $agent['current_level_id'];

        if ($currentLevelId != $newLevel['id']) {
            $agentModel->update($agentId, [
                'current_level_id' => $newLevel['id'],
                'points' => 0, 
                'last_unlocked_at' => date('Y-m-d H:i:s'),
                'level_expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            ]);

            $agentLevelModel->insert([
                'agent_id' => $agentId,
                'level_id' => $newLevel['id'],
                'unlocked_at' => date('Y-m-d H:i:s'),
                'expiry_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            ]);
        } else {
            $agentModel->update($agentId, [
                'points' => $newPoints,
            ]);
        }
    }
}
