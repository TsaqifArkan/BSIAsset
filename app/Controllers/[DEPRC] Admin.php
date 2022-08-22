<?php

namespace App\Controllers;

class Admin extends BaseController
{
    protected $db, $builder;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
    }

    public function index()
    {
        $data['title'] = 'User List';

        // unfortunately, penggunaan model hanya akan mengambil 1 tabel saja, tidak bisa melakukan join 2 atau lebih tabel.
        // $users = new \Myth\Auth\Models\UserModel();
        // $data['users'] = $users->findAll();
        // Oleh karenanya, agar dapat dilakukan join antar beberapa tabel, gunakan query builder bawaan codeigniter. (implementasi dipindah ke dalam __construct())

        // NB. field name dibawah ini merujuk pada field di tabel auth_groups
        // sedangkan field id yg tdk disebutkan (tdk diberi alias) dibawah ini, merujuk pada id milik tabel auth_groups
        $this->builder->select('users.id as userid, username, email, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $this->builder->get();

        // perintah ini akan mengoutputkan sebuah object. Bila ingin array, ubah mjd getResultArray()
        $data['users'] = $query->getResult();

        return $this->showPages('admin/index', $data);
        // return view('admin/index', $data);
    }

    public function detail($id = 0)
    {
        $data['title'] = 'User Detail';

        // NB. field name dibawah ini merujuk pada field di tabel auth_groups
        // sedangkan field id yg tdk disebutkan (tdk diberi alias) dibawah ini, merujuk pada id milik tabel auth_groups
        $this->builder->select('users.id as userid, username, email, fullname, user_image, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.id', $id);
        $query = $this->builder->get();

        // perintah ini akan mengoutputkan satu data saja.
        $data['user'] = $query->getRow();

        // penanganan mengakses URL dg id yg tdk ada di database (tampil null)
        if (empty($data['user'])) {
            return redirect()->to('/admin');
        }

        return $this->showPages('admin/detail', $data);
        // return view('admin/detail', $data);
    }
}
