<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel   = new UserModel();
        $this->db           = \Config\Database::connect();
        $this->builder      = $this->db->table('users');
    }

    public function index()
    {
        $hour = date('H');
        $dayTerm = ($hour > 17) ? "Evening" : (($hour > 12) ? "Afternoon" : "Morning");
        $data = [
            'title' => 'My Profile',
            'userdata' => user(),
            'greet' => $dayTerm
        ];
        return view('user/index', $data);
    }

    public function formEdit()
    {
        if ($this->request->isAJAX()) {
            // $id = $this->request->getVar('id');
            $result = user();

            $data = [
                // 'id' => $result->id,
                'email' => $result->email,
                'username' => $result->username,
                'fullname' => $result->fullname
            ];

            $msg = [
                'data' => view('user/modaledit', $data)
            ];
            echo json_encode($msg);
        } else {
            $data['title'] = 'Woops!';
            return view('templates/404', $data);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            // Cek email dan username sebelumnya
            $result = user();
            $rule_username = ($result->username == $this->request->getVar('username')) ? 'required' : 'required|is_unique[users.username]';
            $rule_email = ($result->email == $this->request->getVar('email')) ? 'required' : 'required|is_unique[users.email]';

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'username' => [
                    'label' => 'Username',
                    'rules' => $rule_username,
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} sudah terdaftar! {field} tidak boleh sama dengan yang sudah terdaftar'
                    ]
                ],
                'email' => [
                    'label' => 'Email Address',
                    'rules' => $rule_email,
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} sudah terdaftar! {field} tidak boleh sama dengan yang sudah terdaftar'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'username' => $validation->getError('username'),
                        'email' => $validation->getError('email')
                    ]
                ];
            } else {
                // update ke DB
                $updatedData = [
                    'username' => $this->request->getVar('username'),
                    'fullname' => $this->request->getVar('fullname'),
                    'email' => $this->request->getVar('email')
                ];

                $id = $result->id;

                $this->userModel->builder()->update($updatedData, "id = $id");

                // Flash Data
                // $dataFlash = [
                //     'alert' => 'SUCCESS ! ',
                //     'msg' => 'Data berhasil diubah.'
                // ];
                // session()->setFlashdata($dataFlash);
                $msg = [
                    'flashData' => 'Data user berhasil diupdate.'
                ];
            }
            echo json_encode($msg);
        } else {
            $data['title'] = 'Woops!';
            return view('templates/404', $data);
        }
    }
}
