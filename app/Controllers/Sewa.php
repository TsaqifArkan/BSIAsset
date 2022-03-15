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
        // $data['getSearch'] = $this->request->getGet('search');
        // dd($_GET);
        $data['title'] = 'Sewa Barang';
        $data['get']['id'] = $this->request->getGet('id');
        $data['get']['hghlt'] = $this->request->getGet('hghlt');
        return view('sewa/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            // terima data dari index.php sewa
            $notifId = $this->request->getVar('dGetId');
            $notifHg = $this->request->getVar('dGetHg');

            $results = $this->sewaModel->findAll();

            // Specify a Generality
            $datefmtrsewa = [];
            $datefmtrtempo = [];
            $numfmtr = [];
            $timeleft = [];
            $highlight = [];
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
                // Catat notif ke highlight
                if ($notifId == $result['id']) array_push($highlight, ($notifHg == 'exp') ? 'font-weight-bold table-danger' : (($notifHg == 'warn') ? 'font-weight-bold table-warning' : 'font-weight-bold table-secondary'));
                else array_push($highlight, '');
            }

            $data = [
                'rents' => [
                    'majority' => $results,
                    'dateFmtrSewa' => $datefmtrsewa,
                    'dateFmtrTempo' => $datefmtrtempo,
                    'numFmtr' => $numfmtr,
                    'timeLeft' => $timeleft,
                    'highlight' => $highlight
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

    public function formEdit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $result = $this->sewaModel->find($id);

            $now = strtotime(date('Y-m-d'));
            $sisaWaktu = (strtotime($result['jatuh_tempo']) - $now) / 86400;
            $timeleft = ($sisaWaktu > 0) ? $sisaWaktu : 0;

            $data = [
                'id' => $result['id'],
                'nama' => $result['nama'],
                'tglSewa' => $result['tgl_sewa'],
                'periodeSewa' => $result['periode_sewa'],
                'hargaSewa' => $result['harga'],
                'sisaWaktu' => $timeleft,
                'jatuhTempo' => $result['jatuh_tempo']
            ];

            $msg = [
                'data' => view('sewa/modaledit', $data)
            ];
            echo json_encode($msg);
        } else {
            $data['title'] = 'Woops!';
            return view('templates/404', $data);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
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
                // update ke DB
                $updatedData = [
                    'nama' => $this->request->getVar('nama'),
                    'tgl_sewa' => $this->request->getVar('tglSewa'),
                    'periode_sewa' => $this->request->getVar('periodeSewa'),
                    'harga' => $this->request->getVar('hargaSewa')
                ];

                $this->sewaModel->update($id, $updatedData);

                // Flash Data
                // $dataFlash = [
                //     'alert' => 'SUCCESS ! ',
                //     'msg' => 'Data berhasil diubah.'
                // ];
                // session()->setFlashdata($dataFlash);
                $msg = [
                    'flashData' => 'Data sewa berhasil diupdate.'
                ];
            }
            echo json_encode($msg);
        } else {
            $data['title'] = 'Woops!';
            return view('templates/404', $data);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $this->sewaModel->delete($id);

            $msg = [
                'flashData' => 'Data sewa berhasil dihapus.'
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
