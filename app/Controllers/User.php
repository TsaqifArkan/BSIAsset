<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel, $db, $builder;

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->db           = \Config\Database::connect();
        $this->builder      = $this->db->table('user');
    }

    public function index()
    {
        // Panggil Notif
        if (!session()->get('notif')) {
            $this->updateNotification();
        }

        // Fetch data from session and database
        $userid = session('user_session.id');
        $datadb = $this->userModel->find($userid);

        $hour = date('H');
        $dayTerm = ($hour > 17) ? "Evening" : (($hour > 12) ? "Afternoon" : "Morning");
        $data = [
            'title' => 'My Profile',
            'userdata' => $datadb,
            'greet' => $dayTerm
        ];
        return $this->showPages('user/index', $data);
    }

    public function editprofile()
    {
        // Fetch data from session and database
        $userid = session('user_session.id');
        $datadb = $this->userModel->find($userid);

        $data = [
            'title' => 'Edit Profile',
            'username' => $datadb['username'],
            'email' => $datadb['email'],
            'fullname' => $datadb['full_name'],
            'profilePict' => $datadb['user_image'],
            'validation' => \Config\Services::validation()
        ];
        return $this->showPages('user/formedit', $data);
    }

    public function edit()
    {
        // Fetch data from session and database
        $userid = session('user_session.id');
        $result = $this->userModel->find($userid);

        // Cek username sebelumnya
        $rule_username = ($result['username'] == $this->request->getVar('username')) ? 'required' : 'required|is_unique[user.username]';

        $valid = $this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => $rule_username,
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
            return redirect()->to(base_url('user/editprofile'))->withInput();
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
            // hapus file yang lama (bila sampul tidak default_profile.png)
            if ($this->request->getVar('oldUserImage') != 'default_profile.png') {
                unlink('img/' . $this->request->getVar('oldUserImage'));
            }
        }

        // update ke DB
        $updatedData = [
            'username' => $this->request->getVar('username'),
            'full_name' => $this->request->getVar('fullname'),
            'email' => $this->request->getVar('email'),
            'user_image' => $namaUserImage
        ];

        $this->userModel->update($userid, $updatedData);

        // Update session
        session()->set('sess_user', [
            'username' => $updatedData['username'],
            'user_image' => $updatedData['user_image']
        ]);

        // pembuatan flashdata data diubah
        session()->setFlashdata('pesan', 'Data user berhasil diupdate.');

        return redirect()->to(base_url('user'));
    }

    public function password()
    {
        $data = [
            'title' => 'Ubah Password',
            'validation' => \Config\Services::validation()
        ];
        return $this->showPages('user/ubahpassword', $data);
    }

    public function changePassword()
    {
        // Fetch data from session and database
        $userid = session('user_session.id');
        $result = $this->userModel->find($userid);
        $userpass = $result['password'];

        // Fetch data from POST
        $oldPass = $this->request->getPost('oldPassword');

        if (!password_verify($oldPass, $userpass)) {
            $err['oldpass'] = 'Password salah!';
            return redirect()->to(base_url('user/password'))->withInput()->with('errors', $err);
        }

        $valid = $this->validate([
            'newPassword' => [
                'label' => 'Password Baru',
                'rules' => 'min_length[5]',
                'errors' => [
                    'matches' => '{field} minimal 5 karakter!'
                ]
            ],
            'konfNewPassword' => [
                'label' => 'Konfirmasi Password Baru',
                'rules' => 'matches[newPassword]',
                'errors' => [
                    'matches' => '{field} tidak sesuai dengan Password Baru!'
                ]
            ]
        ]);

        if (!$valid) {
            return redirect()->to(base_url('user/password'))->withInput();
        }

        // Update ke DB
        $newPass = $this->request->getPost('newPassword');
        $this->userModel->update($userid, ['password' => password_hash($newPass, PASSWORD_DEFAULT)]);

        // pembuatan flashdata data diubah
        session()->setFlashdata('pesan', 'Password user berhasil diupdate.');

        return redirect()->to(base_url('/'));
    }
}
