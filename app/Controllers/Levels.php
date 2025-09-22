<?php namespace App\Controllers;

use App\Models\LevelModel;

class Levels extends BaseController
{
    public function index()
    {
        $model = new LevelModel();
        $data['levels'] = $model->findAll();
        return view('levels/index', $data);
    }

    public function store()
    {
        // Cast inputs to integers
        $input = $this->request->getPost();
        $input['min_points'] = isset($input['min_points']) ? (int)$input['min_points'] : 0;
        $input['max_points'] = ($input['max_points'] === '' || $input['max_points'] === null) ? null : (int)$input['max_points'];

        $rules = [
            'level_name' => 'required|min_length[3]',
            'min_points' => 'required|integer',
            'max_points' => 'permit_empty|integer|greater_than[' . $input['min_points'] . ']',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $model = new LevelModel();
        $model->save([
            'level_name' => $input['level_name'],
            'min_points' => $input['min_points'],
            'max_points' => $input['max_points'],
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function update($id)
    {
        $model = new LevelModel();
        $level = $model->find($id);

        if (!$level) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Level not found']);
        }

        // Cast inputs to integers
        $input = $this->request->getPost();
        $input['min_points'] = isset($input['min_points']) ? (int)$input['min_points'] : 0;
        $input['max_points'] = ($input['max_points'] === '' || $input['max_points'] === null) ? null : (int)$input['max_points'];

        $rules = [
            'level_name' => 'required|min_length[3]',
            'min_points' => 'required|integer',
            'max_points' => 'permit_empty|integer|greater_than[' . $input['min_points'] . ']',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $model->update($id, [
            'level_name' => $input['level_name'],
            'min_points' => $input['min_points'],
            'max_points' => $input['max_points'],
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete($id)
    {
        $model = new LevelModel();
        $level = $model->find($id);

        if (!$level) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Level not found']);
        }

        $model->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }
}
