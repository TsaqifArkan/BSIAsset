<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session('user_session.id') && session('user_session.session_key')) {
            $model = new UserModel();
            if ($model->cek_session_key(session('user_session.id'), session('user_session.session_key'))) {
                return redirect()->to('/');
            }
        }
        return $this->showPages('auth/login');
    }

    public function attemptLogin()
    {
        // Fetch POST Form Data
        $uname = $this->request->getPost('username');
        $pass = $this->request->getPost('password');

        // Validation
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong!'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong!'
                ]
            ]
        ]);

        if (!$valid) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Fetch from Database
        $model = new UserModel();
        $result = $model->builder()->select()->where('username', $uname)->get()->getFirstRow('array');

        if ($result) {
            if (password_verify($pass, $result['password'])) {
                $key = md5(uniqid());
                $hash = password_hash($key, PASSWORD_DEFAULT);
                $model->update($result['id'], [
                    'session_key' => $hash
                ]);
                session()->setTempdata('user_session', [
                    'id' => $result['id'],
                    'session_key' => $key
                ], 1800);
                session()->set('sess_user', [
                    'username' => $result['username'],
                    'user_image' => $result['user_image']
                ]);
                return redirect()->to('/');
            }
        }

        $err['login'] = 'Username atau Password salah!';
        return redirect()->back()->withInput()->with('errors', $err);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('auth');
    }
}
