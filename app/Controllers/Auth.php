<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $rules = [
            'email' => 'required',
            'password' => ['required'],
        ];

        if (!$this->validate($rules)) {
            $errors = [
                'email' => $this->validation->getError('email'),
                'password' => $this->validation->getError('password'),
            ];

            $output = [
                'status' => FALSE,
                'errors' => $errors
            ];

            echo json_encode($output);
        } else {
            $token = $this->setUserSession($this->request->getPost('email'));

            echo json_encode(['status' => TRUE, 'token' => $token]);
        }
    }

    private function setUserSession($email)
    {
        $data = [
            'id' => 1,
            'username' => $email,
            'isLoggedIn' => true
        ];

        session()->set($data);

        $token = '123123';

        return $token;
    }
}
