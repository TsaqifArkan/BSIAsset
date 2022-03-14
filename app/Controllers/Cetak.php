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

    public function getData()
    {
        if ($this->request->isAJAX()) {

            $results = $this->cetakModel->findAll();

            // Penambahan data pada array results utama
            foreach ($results as $i => $result) {
                // Change Date Format Tanggal Cetak
                $results[$i]['datefmtrcetak'] = date_format(date_create($result['tanggal']), "d/m/Y H:i:s");
                // Change Number Formatter
                $results[$i]['numfmtr'] = numfmt_format($this->numfmt, $result['harga']);
                // Pembuatan Kode Barang
                $results[$i]['code'] = str_pad($result['id'], 5, '0', STR_PAD_LEFT) . '-' . date_format(date_create($result['tanggal']), 'd/m/y');
            }

            $data['cetaks'] = $results;
            $msg = [
                'data' => view('cetak/tablecetakdata', $data)
            ];
            echo json_encode($msg);
        } else {
            $data['title'] = 'Woops!';
            return view('templates/404', $data);
        }
    }

    public function formTambah()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('cetak/modaltambah')
            ];
            echo json_encode($msg);
        } else {
            $data['title'] = 'Woops!';
            return view('templates/404', $data);
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
                ],
                'hargaSatuan' => [
                    'label' => 'Harga Satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'hargaSatuan' => $validation->getError('hargaSatuan')
                    ]
                ];
            } else {
                // insert ke DB
                $inputData = [
                    'nama' => $this->request->getVar('nama'),
                    'harga' => $this->request->getVar('hargaSatuan'),
                    'keluar' => $this->request->getVar('keluar'),
                    'masuk' => $this->request->getVar('masuk'),
                    'keterangan' => $this->request->getVar('keterangan')
                ];

                $this->cetakModel->save($inputData);

                // Flash Data
                // $dataFlash = [
                //     'alert' => 'SUCCESS ! ',
                //     'msg' => 'Data berhasil ditambahkan.'
                // ];

                $msg = [
                    'flashData' => 'Data barang cetak berhasil ditambahkan.'
                ];

                // session()->setFlashdata($dataFlash);
            }
            echo json_encode($msg);
        } else {
            // exit("Woops! seems you're quite curious..");
            $data['title'] = 'Woops!';
            return view('templates/404', $data);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $this->cetakModel->delete($id);

            $msg = [
                'flashData' => 'Data barang cetak berhasil dihapus.'
            ];
            // Flash Data
            // $dataFlash = [
            //     'alert' => 'SUCCESS ! ',
            //     'msg' => 'Data berhasil dihapus.'
            // ];
            // session()->setFlashdata($dataFlash);
        }
        echo json_encode($msg);
    }
}
