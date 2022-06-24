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
        return (view('cetak/index', $data));
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {

            $results = $this->cetakModel->findAll();

            $saldo = 0;
            // Penambahan data pada array results utama
            foreach ($results as $i => $result) {
                // Change Date Format Tanggal Cetak
                $results[$i]['datefmtrcetak'] = date_format(date_create($result['tanggal']), "d/m/Y");
                // Change Number Formatter
                $results[$i]['numfmtr'] = numfmt_format($this->numfmt, $result['harga']);
                // Pembuatan Kode Barang
                $results[$i]['code'] = str_pad($result['id'], 5, '0', STR_PAD_LEFT) . '-' . date_format(date_create($result['tanggal']), 'd/m/y');
                // Coba implement saldo
                $saldo += $result['masuk'] - $result['keluar'];
                $results[$i]['saldo'] = $saldo;
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
                ],
                'keluar' => [
                    'label' => 'Jumlah Keluar',
                    'rules' => 'is_natural',
                    'errors' => [
                        'is_natural' => '{field} harus positif!'
                    ]
                ],
                'masuk' => [
                    'label' => 'Jumlah Masuk',
                    'rules' => 'is_natural',
                    'errors' => [
                        'is_natural' => '{field} harus positif!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'hargaSatuan' => $validation->getError('hargaSatuan'),
                        'keluar' => $validation->getError('keluar'),
                        'masuk' => $validation->getError('masuk')
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

    public function print()
    {
        $results = $this->cetakModel->findAll();
        $saldo = 0;
        // Penambahan data pada array results utama
        foreach ($results as $i => $result) {
            // Pembuatan Kode Barang
            $results[$i]['code'] = str_pad($result['id'], 5, '0', STR_PAD_LEFT) . '-' . date_format(date_create($result['tanggal']), 'd/m/y');
            // Coba implement saldo
            $saldo += $result['masuk'] - $result['keluar'];
            $results[$i]['saldo'] = $saldo;
        }
        $data['cetaks'] = $results;
        $filename = 'print_' . date('YmdHis') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv;");

        // file creation
        $file = fopen('php://output', 'w');
        // $header = array_keys($results[0]);
        $header = ['id', 'tanggal', 'nama', 'harga', 'keluar', 'masuk', 'keterangan', 'code', 'saldo'];
        fputcsv($file, $header);
        foreach ($results as $result) {
            fputcsv($file, $result);
        }
        fclose($file);
        exit;
    }
}
