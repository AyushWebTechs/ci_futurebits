<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\AgentModel;
use App\Models\LevelModel;

class CheckLevelExpiry extends BaseCommand
{
    protected $group       = 'Maintenance';
    protected $name        = 'levels:check-expiry';
    protected $description = 'Checks agent levels and downgrades if expired';

    public function run(array $params)
    {
        $agentModel = new AgentModel();
        $levelModel = new LevelModel();

        $agents = $agentModel->findAll();
        $now = time();

        foreach ($agents as $agent) {
            if ($agent['level_expires_at'] && strtotime($agent['level_expires_at']) < $now) {
                // expired
                $prevLevel = $levelModel->where('max_points <', $agent['points'])
                                        ->orderBy('max_points', 'DESC')
                                        ->first();
                if ($prevLevel) {
                    $agentModel->update($agent['id'], [
                        'level_id' => $prevLevel['id'],
                        'points' => $prevLevel['min_points'],
                        'level_expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
                    ]);
                    CLI::write("Agent {$agent['name']} downgraded to {$prevLevel['level_name']}", 'yellow');
                }
            }
        }

        CLI::write('Level expiry check completed.', 'green');
    }
}
