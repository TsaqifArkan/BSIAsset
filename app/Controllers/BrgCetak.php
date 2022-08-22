<?php

namespace App\Controllers;

use App\Models\BrgCetakModel;

define('ERR_TITLE', 'Whoops!');
define('ERR_404', 'templates/404');

class BrgCetak extends BaseController
{
    protected $brgCetakModel, $db, $builder;

    public function __construct()
    {
        $this->brgCetakModel = new BrgCetakModel();
        $this->db           = \Config\Database::connect();
        $this->builder      = $this->db->table('brgcetak');
    }

    public function index()
    {
        $data['title'] = 'Barang Cetak';
        return $this->showPages('brgcetak/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            // Fetch data from Database
            $results = $this->brgCetakModel->findAll();

            // Penambahan data pada array results utama
            foreach ($results as $i => $result) {
                // Change Date Format Tanggal Cetak
                $results[$i]['datefmtrbrgcetak'] = date_format(date_create($result['tanggal']), "d/m/Y");
                // Pembuatan Kode Barang
                $results[$i]['code'] = str_pad($result['id'], 5, '0', STR_PAD_LEFT) . '-' . date_format(date_create($result['tanggal']), 'd/m/y');
            }

            $data['brgcetaks'] = $results;
            $msg = [
                'data' => $this->showPages('brgcetak/tablebrgcetakdata', $data)
            ];
            echo json_encode($msg);
        } else {
            $data['title'] = ERR_TITLE;
            return $this->showPages(ERR_404, $data);
        }
    }

    public function formTambah()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => $this->showPages('brgcetak/modaltambah')
            ];
            echo json_encode($msg);
        } else {
            $data['title'] = ERR_TITLE;
            return $this->showPages(ERR_404, $data);
        }
    }

    public function tambah()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama')
                    ]
                ];
            } else {
                // insert ke DB
                $inputData = [
                    'nama' => $this->request->getVar('nama')
                ];

                $this->brgCetakModel->save($inputData);

                // Creating Flash Data - Deprecated
                // $dataFlash = [
                //     'alert' => 'SUCCESS ! ',
                //     'msg' => 'Data berhasil ditambahkan.'
                // ];
                // session()->setFlashdata($dataFlash);

                $msg = [
                    'flashData' => 'Data barang cetak berhasil ditambahkan.'
                ];
            }
            echo json_encode($msg);
        } else {
            $data['title'] = ERR_TITLE;
            return $this->showPages(ERR_404, $data);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $this->brgCetakModel->delete($id);

            $msg = [
                'flashData' => 'Data barang cetak berhasil dihapus.'
            ];
            // Creating Flash Data - Deprecated
            // $dataFlash = [
            //     'alert' => 'SUCCESS ! ',
            //     'msg' => 'Data berhasil dihapus.'
            // ];
            // session()->setFlashdata($dataFlash);
        }
        echo json_encode($msg);
    }
}
