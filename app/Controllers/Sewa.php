<?php

namespace App\Controllers;

use App\Models\SewaModel;

define('ERR_TITLE', 'Whoops!');
define('ERR_404', 'templates/404');

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
        return $this->showPages('sewa/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            // terima data dari index.php sewa
            $notifId = $this->request->getVar('dGetId');
            $notifHg = $this->request->getVar('dGetHg');
            // Fetch data from Database
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
            ];

            $msg = [
                'data' => $this->showPages('sewa/tablesewadata', $data)
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
                'data' => $this->showPages('sewa/modaltambah')
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
                    'rules' => 'required|is_natural_no_zero',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_natural_no_zero' => '{field} harus positif!'
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

                // Panggil Notif
                $this->updateNotification();

                // Creating Flash Data - Deprecated
                // $dataFlash = [
                //     'alert' => 'SUCCESS ! ',
                //     'msg' => 'Data berhasil ditambahkan.'
                // ];
                // session()->setFlashdata($dataFlash);

                $msg = [
                    'flashData' => 'Data sewa berhasil ditambahkan.'
                ];
            }
            echo json_encode($msg);
        } else {
            $data['title'] = ERR_TITLE;
            return $this->showPages(ERR_404, $data);
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
                'data' => $this->showPages('sewa/modaledit', $data)
            ];
            echo json_encode($msg);
        } else {
            $data['title'] = ERR_TITLE;
            return $this->showPages(ERR_404, $data);
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
                    'rules' => 'required|is_natural_no_zero',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_natural_no_zero' => '{field} harus positif!'
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

                // Panggil Notif
                $this->updateNotification();

                // Creating Flash Data - Deprecated
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
            $data['title'] = ERR_TITLE;
            return $this->showPages(ERR_404, $data);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            // Fetch data on database
            $query = $this->builder->select('gambar_sewa, file_sewa')->where('id', $id);
            $result = $query->get()->getResultArray()[0];

            // kelola Gambar Sewa
            if ($result['gambar_sewa'] != 'default_img.jpg') unlink('img/' . $result['gambar_sewa']);

            // kelola PDF Sewa
            if ($result['file_sewa'] != null) unlink('pdf/' . $result['file_sewa']);

            // Delete 1 Row Sewa Data
            $this->sewaModel->delete($id);

            // Panggil Notif
            $this->updateNotification();

            $msg = [
                'flashData' => 'Data sewa berhasil dihapus.'
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

    public function upload($id = 0)
    {
        // Working with Image and/or File Upload
        $namaKolom = 'gambar_sewa, file_sewa';
        $query = $this->builder->select($namaKolom)->where('id', $id);
        $data = [
            'title' => 'Upload File Sewa',
            'id' => $id,
            'sewa' => $query->get()->getResultArray()[0],
            'validation' => \Config\Services::validation()
        ];
        return $this->showPages('sewa/formupload', $data);
    }

    public function uploadFile()
    {
        // Fetch Data
        $idSewa = $this->request->getVar('id');

        // Validasi Sewa Image dan Sewa PDF
        $valid = $this->validate([
            'sewaPict' => [
                'label' => 'Foto Barang Sewa',
                'rules' => 'max_size[sewaPict,5120]|is_image[sewaPict]|mime_in[sewaPict,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar! (max size: 5 MB)',
                    'is_image' => 'File yang Anda upload bukan gambar!',
                    'mime_in' => 'File yang Anda upload bukan gambar!'
                ]
            ],
            'sewaPDF' => [
                'label' => 'Berkas Perjanjian Sewa',
                'rules' => 'max_size[sewaPDF,10240]|ext_in[sewaPDF,pdf]',
                'errors' => [
                    'max_size' => 'Ukuran file terlalu besar! (max size: 10 MB)',
                    'ext_in' => 'File yang dapat diupload harus berupa PDF!'
                ]
            ]
        ]);

        if (!$valid) {
            return redirect()->to('sewa/upload/' . $idSewa)->withInput();
        }

        // kelola Gambar Sewa
        $fileSewaImage = $this->request->getFile('sewaPict');
        // cek gambar
        if ($fileSewaImage->getError() == 4) $namaSewaImage = $this->request->getVar('oldSewaImage');
        else {
            // generate random filename
            $namaSewaImage = $fileSewaImage->getRandomName();
            // pindah lokasi gambar
            $fileSewaImage->move('img', $namaSewaImage);
            // hapus file yg lama (bila gambar sewa tidak default_img.jpg)
            if ($this->request->getVar('oldSewaImage') != 'default_img.jpg') {
                unlink('img/' . $this->request->getVar('oldSewaImage'));
            }
        }

        // kelola Dokumen Sewa
        $fileSewaPDF = $this->request->getFile('sewaPDF');
        $namaSewaPDF = null;
        // $namaSewaPDF = $this->request->getVar('oldSewaPDF');
        // cek PDF
        if ($fileSewaPDF->getError() != 4) {
            // generate random filename
            $namaSewaPDF = $fileSewaPDF->getRandomName();
            // pindah lokasi PDF
            $fileSewaPDF->move('pdf', $namaSewaPDF);
            // hapus file lama
            if ($this->request->getVar('oldSewaPDF') != null) {
                unlink('pdf/' . $this->request->getVar('oldSewaPDF'));
            }
        }

        // update ke DB
        $updatedData['gambar_sewa'] = $namaSewaImage;
        if ($namaSewaPDF != null) $updatedData['file_sewa'] = $namaSewaPDF;

        $this->sewaModel->builder()->update($updatedData, "id = $idSewa");

        // pembuatan flashdata data diubah
        $isiPesan = ($fileSewaImage->getError() != 4 || $fileSewaPDF->getError() != 4) ?  'File barang sewa berhasil diupdate.' : 'Tidak ada perubahan data!';
        session()->setFlashdata('pesan', $isiPesan);

        return redirect()->to('sewa');
    }

    public function detail($id = 0)
    {
        // Fetch Data
        $data['title'] = 'Detail Barang Sewa';
        $data['sewa'] = $this->sewaModel->find($id);

        // Using Date Formatter and Number Formatter
        $data['tglSewa'] = date_format(date_create($data['sewa']['tgl_sewa']), "d/m/Y");
        $data['harga'] = numfmt_format($this->numfmt, $data['sewa']['harga']);

        // Count sisa hari sewa
        $now = strtotime(date('Y-m-d'));
        $sisaWaktu = (strtotime($data['sewa']['jatuh_tempo']) - $now) / 86400;
        $data['timeLeft'] = ($sisaWaktu > 0) ? $sisaWaktu : 0;

        // Count tgl jatuh tempo sewa
        $data['tglSewaJthTempo'] = date_format(date_create($data['sewa']['jatuh_tempo']), "d/m/Y");

        return $this->showPages('sewa/detail', $data);
    }

    // public function downloadPDF($id = 0)
    // {
    //     $namaKolom = 'file_sewa';
    //     $query = $this->builder->select($namaKolom)->where('id', $id);
    //     $result = $query->get()->getResultArray()[0];

    //     return $this->response->download('pdf/' . $result['file_sewa'], null);
    // }
}
