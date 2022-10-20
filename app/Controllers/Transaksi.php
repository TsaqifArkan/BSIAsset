<?php

namespace App\Controllers;

use App\Models\BrgCetakModel;
use App\Models\TransaksiModel;

define('ERR_TITLE', 'Whoops!');
define('ERR_404', 'templates/404');

class Transaksi extends BaseController
{
    protected $transModel, $db, $builder;

    public function __construct()
    {
        $this->transModel   = new TransaksiModel();
        $this->db           = \Config\Database::connect();
        $this->builder      = $this->db->table('transaksi');
    }

    public function index()
    {
        $data['title'] = 'Transaksi';

        // Query
        $brgCetakModel = new BrgCetakModel();
        $hasil = $brgCetakModel->builder()->select('id, nama, kode')->get()->getResultArray();
        $data['hasil'] = $hasil;

        return $this->showPages('transaksi/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            // Get Nama and Kode Barang from BarangCetakModel
            $brgCetakModel = new BrgCetakModel();
            $namaKode = $brgCetakModel->builder()->select('nama, kode')->where('id', $id)->get()->getResultArray()[0];
            // dd($namaKode);
            // dd($id);
            // Query - Get Data
            $dataTransaksi = $this->builder->join('brgcetak', 'brgcetak.id = transaksi.id_brgcetak')->select('transaksi.tanggal AS tgl, jumlah, harga, d_k, keterangan')->where('transaksi.id_brgcetak', $id)->get()->getResultArray();

            $results = $dataTransaksi;

            $saldo = 0;
            // Penambahan data pada array results utama
            foreach ($results as $i => $result) {
                // Change Date Format Tanggal Cetak
                $results[$i]['datefmtrcetak'] = date_format(date_create($result['tgl']), "d/m/Y");
                // Change Number Formatter
                $results[$i]['numfmtr'] = numfmt_format($this->numfmt, $result['harga']);
                // Pembuatan Kode Barang - Deprecated 02/10/22
                // $results[$i]['code'] = str_pad($result['idBrgCtk'], 5, '0', STR_PAD_LEFT) . '-' . date_format(date_create($result['tglkode']), 'd/m/y');
                // Hitung Nominal
                $nominal = $result['jumlah'] * $result['harga'] * ($result['d_k'] == 'K' ? 1 : -1);
                $results[$i]['nominal'] = numfmt_format($this->numfmt, $nominal);
                // Coba implement saldo - DEPRECATED - Re Summoned
                $saldo += $nominal;
                $results[$i]['saldo'] = numfmt_format($this->numfmt, $saldo);
            }

            // Send Data via JSON
            $data = [
                'idBrgCtk' => $id,
                'namaKode' => $namaKode,
                'transactions' => $results
            ];
            // $data['transactions'] = $results;
            $msg = [
                'data' => $this->showPages('transaksi/tabletransaksi', $data)
            ];

            // dd($data['transactions']);
            // dd($results);
            echo json_encode($msg);
        } else {
            $data['title'] = ERR_TITLE;
            return $this->showPages(ERR_404, $data);
        }
    }

    public function formTambah()
    {
        if ($this->request->isAJAX()) {
            // Fetch id Barang Cetak from JQuery-Ajax
            $idBrgCtk = $this->request->getVar('id');
            // dd($idBrgCtk);
            // Fetch Barang Cetak Data
            $brgCetakModel = new BrgCetakModel();
            $hasilBrgCetak = $brgCetakModel->find($idBrgCtk);
            $data['brgcetakdata'] = $hasilBrgCetak;

            $msg = [
                'data' => $this->showPages('transaksi/modaltambah', $data)
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
            // dd($_POST);
            // Fetch Inputted Data
            $idBrgCtk = $this->request->getVar('id');
            $jmlTrans = $this->request->getVar('jmlTrans');
            $opsiDK = $this->request->getVar('dkOption');

            // Fetch BarangCetakModel
            $brgCetakModel = new BrgCetakModel();

            // Deprecated 04/10/22
            // $rule_jml = '';
            // $dataBrgCtkfromDB = 0;
            // if ($this->request->getVar('nama') != '') {
            //     $idBrgCetak = $this->request->getVar('nama');
            //     $dataBrgCtkfromDB = $brgCetakModel->find($idBrgCetak)['stok'];
            //     if ($opsiDK == 'D') {
            //         $rule_jml .= "|less_than_equal_to[$dataBrgCtkfromDB]";
            //     }
            // }

            // Checking Stok BarangCetak before Debit action
            $rule_jml = '';
            $stokBrgCtk = 0;
            $stokBrgCtk = $brgCetakModel->find($idBrgCtk)['stok'];
            if ($opsiDK == 'D') {
                $rule_jml .= "|less_than_equal_to[$stokBrgCtk]";
            }

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                // 'nama' => [
                //     'label' => 'Nama Barang',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => 'Pilih salah satu {field}!'
                //     ]
                // ],
                'jmlTrans' => [
                    'label' => 'Barang',
                    'rules' => 'required|is_natural_no_zero' . $rule_jml,
                    'errors' => [
                        'required' => 'Jumlah {field} tidak boleh kosong!',
                        'is_natural_no_zero' => '{field} minimal berjumlah 1!',
                        'less_than_equal_to' => 'Jumlah {field} tidak boleh melebihi stok! (Stok = ' . $stokBrgCtk . ')'
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
                        // 'nama' => $validation->getError('nama'),
                        'jmlTrans' => $validation->getError('jmlTrans'),
                        'hargaSatuan' => $validation->getError('hargaSatuan'),
                        'jenisMutasi' => $validation->getError('dkOption')
                    ]
                ];
            } else {
                // insert ke DB
                $inputData = [
                    // 'nama' => $this->request->getVar('nama'),
                    'id_brgcetak' => $idBrgCtk,
                    'jumlah' => $jmlTrans,
                    'harga' => $this->request->getVar('hargaSatuan'),
                    'd_k' => $opsiDK,
                    'keterangan' => $this->request->getVar('keterangan')
                ];

                $this->transModel->save($inputData);

                // Update Stok Barang Cetak
                $updateBrgCetak = [
                    'stok' => $stokBrgCtk + $jmlTrans * ($opsiDK == 'D' ? -1 : 1)
                ];

                $brgCetakModel->update($idBrgCtk, $updateBrgCetak);

                // Creating Flash Data - Deprecated
                // $dataFlash = [
                //     'alert' => 'SUCCESS ! ',
                //     'msg' => 'Data berhasil ditambahkan.'
                // ];
                // session()->setFlashdata($dataFlash);

                $msg = [
                    'flashData' => 'Data transaksi barang cetakan berhasil ditambahkan.',
                    'idBrgCtk' => $idBrgCtk
                ];
            }
            echo json_encode($msg);
        } else {
            $data['title'] = ERR_TITLE;
            return $this->showPages(ERR_404, $data);
        }
    }

    public function print($id)
    {
        // Get Nama and Kode Barang from BarangCetakModel
        $brgCetakModel = new BrgCetakModel();
        $namaKode = $brgCetakModel->builder()->select('nama, kode')->where('id', $id)->get()->getResultArray()[0];
        $nama = str_replace(' ', '', strtolower($namaKode['nama']));

        $filename = date('YmdHis') . '_' . $nama . '_' . $namaKode['kode'] . '.xlsx';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;");

        // Query - Get Data
        $dataTransaksi = $this->builder->join('brgcetak', 'brgcetak.id = transaksi.id_brgcetak')->select('transaksi.tanggal AS tgl, nama, kode, jumlah, harga, d_k, keterangan')->where('transaksi.id_brgcetak', $id)->get()->getResultArray();

        $results = $dataTransaksi;
        $newArray1 = [];

        // dd($results);

        // Fetch Data
        // $results = $this->cetakModel->findAll();
        $saldo = 0;
        // Penambahan data pada array results utama
        foreach ($results as $i => $result) {
            // 1. Nomor Data
            $results[$i]['no'] = $i + 1;
            // Pembuatan Kode Barang - Deprecated 05/10/22
            // $results[$i]['code'] = str_pad($result['id'], 5, '0', STR_PAD_LEFT) . '-' . date_format(date_create($result['tglkode']), 'd/m/y');
            // 2. Tanggal Mutasi Deprecated 05/10/22 - Instead, use default format
            $results[$i]['tanggal'] = date_format(date_create($result['tgl']), 'd-M-Y');
            // 2. Tanggal Mutasi, 3. Nama, 4. Kode, 5. Jumlah, 6. Harga, 7. D_K <default>
            // 8. Hitung Nominal
            $nominal = $result['jumlah'] * $result['harga'] * (($result['d_k'] == 'K' ? 1 : -1));
            $results[$i]['nominal'] = $nominal;
            // Coba implement saldo - DEPRECATED - This version no longer used
            // $saldo += $result['masuk'] - $result['keluar'];
            // $results[$i]['saldo'] = $saldo;
            // 9. Saldo
            $saldo += $nominal;
            $results[$i]['saldo'] = $saldo;

            $newArray2 = [];
            array_push($newArray2, $results[$i]['no']);
            array_push($newArray2, $results[$i]['tanggal']);
            array_push($newArray2, $results[$i]['nama']);
            array_push($newArray2, $results[$i]['kode']);
            array_push($newArray2, $results[$i]['jumlah']);
            array_push($newArray2, $results[$i]['harga']);
            array_push($newArray2, $results[$i]['d_k']);
            array_push($newArray2, $results[$i]['nominal']);
            array_push($newArray2, $results[$i]['saldo']);
            array_push($newArray2, $results[$i]['keterangan']);
            array_push($newArray1, $newArray2);
        }
        // $data['transactions'] = $results;
        $AllArray = [];
        $header = ['No', 'Tanggal Mutasi', 'Nama Barang', 'Kode Barang', 'Jumlah', 'Harga Satuan', 'D/K', 'Nominal', 'Saldo', 'Keterangan'];
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
