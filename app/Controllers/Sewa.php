<?php

namespace App\Controllers;

use App\Models\SewaModel;
use DateTime;

class Sewa extends BaseController
{
    protected $sewaModel, $db, $builder;

    public function __construct()
    {
        $this->sewaModel    = new SewaModel();
        $this->db           = \Config\Database::connect();
        $this->builder      = $this->db->table('sewa');
    }

    public function index()
    {
        $data['title'] = 'Sewa Barang';
        return view('sewa/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {

            $results = $this->sewaModel->findAll();

            // Specify a Generality
            $datefmtrsewa = [];
            $datefmtrtempo = [];
            $numfmtr = [];
            $timeleft = [];
            $now = strtotime(date('Y-m-d'));
            foreach ($results as $result) {
                // Change Date Format Tanggal Sewa
                array_push($datefmtrsewa, date_format(date_create($result['tgl_sewa']), "d/m/Y"));
                // Change Date Format Jatuh Tempo
                array_push($datefmtrtempo, date_format(date_create($result['jatuh_tempo']), "d/m/Y"));
                // Change Number Formatter
                array_push($numfmtr, numfmt_format($this->numfmt, $result['harga']));
                // Count sisa hari
                $sisaWaktu = (strtotime($result['jatuh_tempo']) - $now) / 86400;
                array_push($timeleft, $sisaWaktu > 0 ? $sisaWaktu : 0);
            }

            $data = [
                'rents' => [
                    'majority' => $results,
                    'dateFmtrSewa' => $datefmtrsewa,
                    'dateFmtrTempo' => $datefmtrtempo,
                    'numFmtr' => $numfmtr,
                    'timeLeft' => $timeleft
                ]
                // 'numFmt' => $this->numfmt
                // 'dateFmt' => $datefmt
            ];

            $msg = [
                'data' => view('sewa/tablesewadata', $data)
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
                'data' => view('sewa/modaltambah')
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
                'tglSewa' => [
                    'label' => 'Tanggal Sewa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'periodeSewa' => [
                    'label' => 'Periode Sewa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'hargaSewa' => [
                    'label' => 'Harga Sewa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ]
            ]);
            $msg = [];
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'tglSewa' => $validation->getError('tglSewa'),
                        'periodeSewa' => $validation->getError('periodeSewa'),
                        'hargaSewa' => $validation->getError('hargaSewa')
                    ]
                ];
            } else {
                // insert ke DB
                $inputData = [
                    'nama' => $this->request->getVar('nama'),
                    'tgl_sewa' => $this->request->getVar('tglSewa'),
                    'periode_sewa' => $this->request->getVar('periodeSewa'),
                    'harga' => $this->request->getVar('hargaSewa')
                ];

                $this->sewaModel->save($inputData);

                // Flash Data
                // $dataFlash = [
                //     'alert' => 'SUCCESS ! ',
                //     'msg' => 'Data berhasil ditambahkan.'
                // ];

                $msg = [
                    'flashData' => 'Data sewa berhasil ditambahkan.'
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
}
