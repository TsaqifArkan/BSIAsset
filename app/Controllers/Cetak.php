<?php

namespace App\Controllers;

use App\Models\BrgCetakModel;
use App\Models\CetakModel;

define('ERR_TITLE', 'Whoops!');
define('ERR_404', 'templates/404');

class Cetak extends BaseController
{
    protected $cetakModel, $db, $builder;

    public function __construct()
    {
        $this->cetakModel   = new CetakModel();
        $this->db           = \Config\Database::connect();
        $this->builder      = $this->db->table('cetak');
    }

    public function index()
    {
        $data['title'] = 'Transaksi Barang Cetakan';
        return $this->showPages('cetak/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            // Query
            $resultBrgCetak = $this->builder->join('brgcetak', 'brgcetak.id = cetak.id_brgcetak')->select('brgcetak.id AS idBrgCtk, cetak.id AS id, brgcetak.nama, brgcetak.tanggal AS tglkode, cetak.tanggal AS tgl, jumlah, harga, d_k, keterangan')->get()->getResultArray();

            $results = $resultBrgCetak;
            // $results = $this->cetakModel->findAll();

            $saldo = 0;
            // Penambahan data pada array results utama
            foreach ($results as $i => $result) {
                // Change Date Format Tanggal Cetak
                $results[$i]['datefmtrcetak'] = date_format(date_create($result['tgl']), "d/m/Y");
                // Change Number Formatter
                $results[$i]['numfmtr'] = numfmt_format($this->numfmt, $result['harga']);
                // Pembuatan Kode Barang
                $results[$i]['code'] = str_pad($result['idBrgCtk'], 5, '0', STR_PAD_LEFT) . '-' . date_format(date_create($result['tglkode']), 'd/m/y');
                // Hitung Nominal
                $nominal = $result['jumlah'] * $result['harga'] * ($result['d_k'] == 'K' ? 1 : -1);
                $results[$i]['nominal'] = numfmt_format($this->numfmt, $nominal);
                // Coba implement saldo - DEPRECATED - Re Summoned
                $saldo += $nominal;
                $results[$i]['saldo'] = numfmt_format($this->numfmt, $saldo);
            }

            $data['cetaks'] = $results;
            $msg = [
                'data' => $this->showPages('cetak/tablecetakdata', $data)
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
            // Fetch Barang Cetak Data
            $brgCetakModel = new BrgCetakModel();
            $hasilBrgCetak = $brgCetakModel->findAll();
            $data['brgcetakdata'] = $hasilBrgCetak;

            $msg = [
                'data' => $this->showPages('cetak/modaltambah', $data)
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
            // Fetch Inputted Data
            $opsiDK = $this->request->getVar('dkOption');

            // Fetch BarangCetakModel
            $brgCetakModel = new BrgCetakModel();

            $rule_jml = '';
            $dataBrgCtkfromDB = 0;
            if ($this->request->getVar('nama') != '') {
                $idBrgCetak = $this->request->getVar('nama');
                $dataBrgCtkfromDB = $brgCetakModel->find($idBrgCetak)['stok'];
                if ($opsiDK == 'D') {
                    $rule_jml .= "|less_than_equal_to[$dataBrgCtkfromDB]";
                }
            }

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih salah satu {field}!'
                    ]
                ],
                'jmlCetak' => [
                    'label' => 'Barang',
                    'rules' => 'required|is_natural_no_zero' . $rule_jml,
                    'errors' => [
                        'required' => 'Jumlah {field} tidak boleh kosong!',
                        'is_natural_no_zero' => '{field} minimal berjumlah 1!',
                        'less_than_equal_to' => 'Jumlah {field} tidak boleh melebihi stok! (Stok = ' . $dataBrgCtkfromDB . ')'
                    ]
                ],
                'hargaSatuan' => [
                    'label' => 'Harga Satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'dkOption' => [
                    'label' => 'Jenis Mutasi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih salah satu {field}!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'jmlCetak' => $validation->getError('jmlCetak'),
                        'hargaSatuan' => $validation->getError('hargaSatuan'),
                        'jenisMutasi' => $validation->getError('dkOption')
                    ]
                ];
            } else {
                // insert ke DB
                $inputData = [
                    // 'nama' => $this->request->getVar('nama'),
                    'id_brgcetak' => $this->request->getVar('nama'),
                    'jumlah' => $this->request->getVar('jmlCetak'),
                    'harga' => $this->request->getVar('hargaSatuan'),
                    'd_k' => $this->request->getVar('dkOption'),
                    'keterangan' => $this->request->getVar('keterangan')
                ];

                $this->cetakModel->save($inputData);

                // Update Stok Barang Cetak
                $updateBrgCetak = [
                    'stok' => $dataBrgCtkfromDB + $this->request->getVar('jmlCetak') * ($opsiDK == 'D' ? -1 : 1)
                ];

                $brgCetakModel->update($idBrgCetak, $updateBrgCetak);

                // Creating Flash Data - Deprecated
                // $dataFlash = [
                //     'alert' => 'SUCCESS ! ',
                //     'msg' => 'Data berhasil ditambahkan.'
                // ];
                // session()->setFlashdata($dataFlash);

                $msg = [
                    'flashData' => 'Data transaksi barang cetakan berhasil ditambahkan.'
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
            // Fetch Cetak ID
            $id = $this->request->getVar('id');
            $dataCM = $this->cetakModel->find($id);

            // Fetch BarangCetakModel
            $brgCetakModel = new BrgCetakModel();

            // Update BarangCetakModel
            $dataUpdate = [
                'stok' => $brgCetakModel->find($dataCM['id_brgcetak'])['stok'] - $dataCM['jumlah'] * ($dataCM['d_k'] == 'D' ? -1 : 1)
            ];

            $brgCetakModel->update($dataCM['id_brgcetak'], $dataUpdate);

            // Delete 1 row Cetak
            $this->cetakModel->delete($id);

            $msg = [
                'flashData' => 'Data transaksi barang cetakan berhasil dihapus.'
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

    public function printCSV()
    {
        // This method was deprecated
        $results = $this->cetakModel->findAll();
        $saldo = 0;
        // Penambahan data pada array results utama
        foreach ($results as $i => $result) {
            // Pembuatan Kode Barang
            $results[$i]['code'] = str_pad($result['id'], 5, '0', STR_PAD_LEFT) . '-' . date_format(date_create($result['tanggal']), 'd/m/y');
            // Coba implement saldo
            $saldo += $result['masuk'] - $result['keluar'];
            $results[$i]['saldo'] = $saldo;
            $results[$i]['tanggal'] = date_format(date_create($result['tanggal']), 'd-M-Y');
        }
        $data['cetaks'] = $results;
        $filename = 'print_' . date('YmdHis') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv;");

        // file creation
        $file = fopen('php://output', 'w');
        fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
        // $header = array_keys($results[0]);
        $header = ['id', 'tanggal', 'nama', 'harga', 'keluar', 'masuk', 'keterangan', 'code', 'saldo'];
        fputcsv($file, $header);
        foreach ($results as $result) {
            fputcsv($file, $result);
        }
        fclose($file);
        exit;
    }

    public function print()
    {
        $filename = 'print_' . date('YmdHis') . '.xlsx';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;");

        // Query
        $resultBrgCetak = $this->builder->join('brgcetak', 'brgcetak.id = cetak.id_brgcetak')->select('brgcetak.id, brgcetak.nama, brgcetak.tanggal AS tglkode, cetak.tanggal AS tgl, jumlah, harga, d_k, keterangan')->get()->getResultArray();

        $results = $resultBrgCetak;

        $newArray1 = [];

        // dd($results);

        // Fetch Data
        // $results = $this->cetakModel->findAll();
        // $saldo = 0;
        // Penambahan data pada array results utama
        foreach ($results as $i => $result) {
            // Nomor Data Transaksi
            $results[$i]['no'] = $i + 1;
            // Pembuatan Kode Barang
            $results[$i]['code'] = str_pad($result['id'], 5, '0', STR_PAD_LEFT) . '-' . date_format(date_create($result['tglkode']), 'd/m/y');
            // Coba implement saldo - DEPRECATED
            // $saldo += $result['masuk'] - $result['keluar'];
            // $results[$i]['saldo'] = $saldo;
            $results[$i]['tanggal'] = date_format(date_create($result['tgl']), 'd-M-Y');
            // Hitung Nominal
            $nominal = $result['jumlah'] * $result['harga'] * ($result['d_k'] == 'K' ? 1 : -1);
            $results[$i]['nominal'] = $nominal;
            // $results[$i]['nominal'] = numfmt_format($this->numfmt, $nominal);
            $newArray2 = [];
            array_push($newArray2, $results[$i]['no']);
            array_push($newArray2, $results[$i]['tgl']);
            array_push($newArray2, $results[$i]['nama']);
            array_push($newArray2, $results[$i]['code']);
            array_push($newArray2, $results[$i]['jumlah']);
            array_push($newArray2, $results[$i]['harga']);
            array_push($newArray2, $results[$i]['d_k']);
            array_push($newArray2, $results[$i]['nominal']);
            array_push($newArray2, $results[$i]['keterangan']);
            array_push($newArray1, $newArray2);
        }
        $data['cetaks'] = $results;
        $AllArray = [];
        $header = ['No', 'Tanggal Mutasi', 'Nama Barang', 'Kode Barang', 'Jumlah', 'Harga Satuan', 'D/K', 'Nominal', 'Keterangan'];
        array_push($AllArray, $header);
        array_merge($AllArray, $newArray1);

        // foreach ($results as $result) {
        //     array_push($AllArray, $result);
        // }
        foreach ($newArray1 as $arr1) {
            array_push($AllArray, $arr1);
        }

        // dd($AllArray, $newArray1);

        $xlsx = \Shuchkin\SimpleXLSXGen::fromArray($AllArray);
        $xlsx->saveAs('php://output'); // or downloadAs('books.xlsx') or $xlsx_content = (string) $xlsx 
        exit;
    }
}
