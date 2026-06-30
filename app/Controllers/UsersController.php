<?php

namespace App\Controllers;

use App\Models\UsersModel;

class UsersController extends BaseController
{
    public function validateAjax()
    {
        $model = new UsersModel();

        $data = $this->request->getPost();

        if (!$model->validate($data)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $model->errors()
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'errors' => []
        ]);
    }

    public function inscription()
    {
        return view('inscrir');
    }
}