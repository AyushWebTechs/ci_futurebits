<?php namespace App\Models;

use CodeIgniter\Model;

class LevelModel extends Model
{
    protected $table = 'levels';
    protected $primaryKey = 'id';
    protected $allowedFields = ['level_name', 'min_points', 'max_points', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
