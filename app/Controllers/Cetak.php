<?php

namespace App\Controllers;

use App\Models\CetakModel;

class Cetak extends BaseController
{
    protected $cetakModel, $db, $builder;

    public function __construct()
    {
        $this->cetakModel    = new CetakModel();
        $this->db           = \Config\Database::connect();
        $this->builder      = $this->db->table('cetak');
    }

    public function index()
    {
        $data['title'] = 'Barang Cetakan';
        $results = $this->cetakModel->findAll();

        foreach ($results as $i => $result) {
            $results[$i]['code'] = str_pad($result['id'], 5, '0', STR_PAD_LEFT) . '-' . date_format(date_create($result['tanggal']), 'd/m/y');
        }
        $data['datas'] = $results;

        return (view('cetak/index', $data));
    }
}
