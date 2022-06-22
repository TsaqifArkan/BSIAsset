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

    public function editprofile()
    {
        $result = user();
        $data = [
            'title' => 'Edit Profile',
            'email' => $result->email,
            'username' => $result->username,
            'fullname' => $result->fullname,
            'profilePict' => $result->user_image,
            'validation' => \Config\Services::validation()
        ];

        return view('user/formedit', $data);
    }

    public function edit()
    {
        // Cek email dan username sebelumnya
        $result = user();
        $rule_username = ($result->username == $this->request->getVar('username')) ? 'required' : 'required|is_unique[users.username]';
        $rule_email = ($result->email == $this->request->getVar('email')) ? 'required' : 'required|is_unique[users.email]';

        // $validation = \Config\Services::validation();
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
            ],
            'profilePict' => [
                'label' => 'Profile Picture',
                'rules' => 'max_size[profilePict,1024]|is_image[profilePict]|mime_in[profilePict,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar! (max size: 1 MB)',
                    'is_image' => 'File yang Anda upload bukan gambar!',
                    'mime_in' => 'File yang Anda upload bukan gambar!'
                ]
            ]
        ]);

        if (!$valid) {
            return redirect()->to('user/editprofile')->withInput();
        }

        // kelola gambar - pindahkan gambar - insert ke dalam database
        $fileUserImage = $this->request->getFile('profilePict');
        // cek gambar, apakah tetap menggunakan gambar lama. If user tdk mengupload foto baru, berarti error == 4 (tidak ada file yg diupload)
        if ($fileUserImage->getError() == 4) $namaUserImage = $this->request->getVar('oldUserImage');
        else { // jika ada file baru yg diupload
            // generate nama file random
            $namaUserImage = $fileUserImage->getRandomName();
            // pindahkan gambar
            $fileUserImage->move('img', $namaUserImage);
            // hapus file yang lama (bila sampul tidak default.png)
            if ($this->request->getVar('oldUserImage') != 'default.png') {
                unlink('img/' . $this->request->getVar('oldUserImage'));
            }
        }

        // update ke DB
        $updatedData = [
            'username' => $this->request->getVar('username'),
            'fullname' => $this->request->getVar('fullname'),
            'email' => $this->request->getVar('email'),
            'user_image' => $namaUserImage
        ];

        $id = $result->id;

        $this->userModel->builder()->update($updatedData, "id = $id");

        // pembuatan flashdata data diubah
        session()->setFlashdata('pesan', 'Data user berhasil diupdate.');

        return redirect()->to('user');
    }
}
