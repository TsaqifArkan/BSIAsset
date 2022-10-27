<?php

namespace App\Controllers;

use App\Models\AsetModel;
use DateTime;

define('ERR_TITLE', 'Whoops!');
define('ERR_404', 'templates/404');

class Aset extends BaseController
{
    protected $asetModel, $db, $builder;

    public function __construct()
    {
        $this->asetModel    = new AsetModel();
        $this->db           = \Config\Database::connect();
        $this->builder      = $this->db->table('aset');
    }

    public function index()
    {
        $data['title'] = 'Kelola Aset';
        return $this->showPages('aset/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            // Fetch data from Database
            $results = $this->asetModel->findAll();
            // Specify a Generality
            $datefmtr = [];
            $numfmtr = [];
            foreach ($results as $result) {
                // Change Date Format
                array_push($datefmtr, date_format(date_create($result['tgl_perolehan']), "d/m/Y"));
                // Change Number Format
                array_push($numfmtr, numfmt_format($this->numfmt, $result['harga']));
            }

            $data = [
                'assets' => [
                    'majority' => $results,
                    'dateFmtr' => $datefmtr,
                    'numFmtr' => $numfmtr
                ]
            ];

            $msg = [
                'data' => $this->showPages('aset/tableasetdata', $data)
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
                'data' => $this->showPages('aset/modaltambah')
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
                    'rules' => 'required|is_unique[aset.nama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} sudah terdaftar! {field} tidak boleh sama dengan yang sudah terdaftar'
                    ]
                ],
                'kode' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'tglPerolehan' => [
                    'label' => 'Tanggal Perolehan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'hargaPerolehan' => [
                    'label' => 'Harga Perolehan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'usiaTeknis' => [
                    'label' => 'Usia Teknis',
                    'rules' => 'required|is_natural_no_zero',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_natural_no_zero' => '{field} harus positif!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'kode' => $validation->getError('kode'),
                        'tglPerolehan' => $validation->getError('tglPerolehan'),
                        'hargaPerolehan' => $validation->getError('hargaPerolehan'),
                        'usiaTeknis' => $validation->getError('usiaTeknis')
                    ]
                ];
            } else {
                // insert ke DB
                $inputData = [
                    'nama' => $this->request->getVar('nama'),
                    'kode' => $this->request->getVar('kode'),
                    'tgl_perolehan' => $this->request->getVar('tglPerolehan'),
                    'harga' => $this->request->getVar('hargaPerolehan'),
                    'usia_teknis' => $this->request->getVar('usiaTeknis')
                ];

                $this->asetModel->save($inputData);

                // This line code deprecated since 27/10/22 because of BSI wants to input Asset Code manually
                // ######################################################################### //
                // Creating Aset Kode - Try to implement 08/10/22
                // dd($this->asetModel->findAll(), $this->asetModel->getInsertID());
                // $lastInsID = $this->asetModel->getInsertID();
                // $updateData = [
                //     'kode' => 'AS' . str_pad($lastInsID, 5, '0', STR_PAD_LEFT)
                // ];
                // $this->asetModel->update($lastInsID, $updateData);
                // ######################################################################### //

                // Creating Flash Data - Deprecated
                // $dataFlash = [
                //     'alert' => 'SUCCESS ! ',
                //     'msg' => 'Data berhasil ditambahkan.'
                // ];
                // session()->setFlashdata($dataFlash);

                $msg = [
                    'flashData' => 'Data aset berhasil ditambahkan.'
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
            $result = $this->asetModel->find($id);

            $data = [
                'id' => $result['id'],
                'nama' => $result['nama'],
                'kode' => $result['kode'],
                'tglPerolehan' => $result['tgl_perolehan'],
                'hargaPerolehan' => $result['harga'],
                'usiaTeknis' => $result['usia_teknis']
            ];

            $msg = [
                'data' => $this->showPages('aset/modaledit', $data)
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
            // Cek Nama Barang Before
            $id = $this->request->getVar('id');
            $result = $this->asetModel->find($id);
            if ($result['nama'] == $this->request->getVar('nama')) {
                $rule_nama = 'required';
            } else {
                $rule_nama = 'required|is_unique[aset.nama]';
            }

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Barang',
                    'rules' => $rule_nama,
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} sudah terdaftar! {field} tidak boleh sama dengan yang sudah terdaftar'
                    ]
                ],
                'kode' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'tglPerolehan' => [
                    'label' => 'Tanggal Perolehan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'hargaPerolehan' => [
                    'label' => 'Harga Perolehan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'usiaTeknis' => [
                    'label' => 'Usia Teknis',
                    'rules' => 'required|is_natural_no_zero',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_natural_no_zero' => '{field} harus positif!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'kode' => $validation->getError('kode'),
                        'tglPerolehan' => $validation->getError('tglPerolehan'),
                        'hargaPerolehan' => $validation->getError('hargaPerolehan'),
                        'usiaTeknis' => $validation->getError('usiaTeknis')
                    ]
                ];
            } else {
                // update ke DB
                $updatedData = [
                    'nama' => $this->request->getVar('nama'),
                    'kode' => $this->request->getVar('kode'),
                    'tgl_perolehan' => $this->request->getVar('tglPerolehan'),
                    'harga' => $this->request->getVar('hargaPerolehan'),
                    'usia_teknis' => $this->request->getVar('usiaTeknis')
                ];
                $this->asetModel->update($id, $updatedData);

                // Creating Flash Data - Deprecated
                // $dataFlash = [
                //     'alert' => 'SUCCESS ! ',
                //     'msg' => 'Data berhasil diubah.'
                // ];
                // session()->setFlashdata($dataFlash);
                $msg = [
                    'flashData' => 'Data aset berhasil diupdate.'
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
            $aset_img = $this->asetModel->find($id)['gambar_aset'];

            // kelola Gambar Aset
            if ($aset_img != 'default_img.jpg') unlink('img/' . $aset_img);

            // Delete 1 Row Asset Data
            $this->asetModel->delete($id);

            $msg = [
                'flashData' => 'Data aset berhasil dihapus.'
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

    public function detail($id = 0)
    {
        // Fetch Data
        $data['title'] = 'Detail Aset';
        $data['aset'] = $this->asetModel->find($id);

        // Configure dateNow and dateMax
        $dateNow = new DateTime(date('Y-m-d'));
        $dateExp = new DateTime($data['aset']['maks_u_teknis']);

        // different date and interval month
        $dateInterval = date_diff($dateNow, $dateExp);
        $intervalMonth = $dateInterval->invert ? 0 : ($dateInterval->y * 12 + $dateInterval->m + ($dateInterval->d != 0));

        // Menghitung nilaiBuku
        $nilaiBuku = ($data['aset']['harga'] / $data['aset']['usia_teknis']) * $intervalMonth;

        // Memasukkan data ke dalam objek
        $data['tglPerolehan'] = date_format(date_create($data['aset']['tgl_perolehan']), "d/m/Y");
        $data['harga'] = numfmt_format($this->numfmt, $data['aset']['harga']);
        $data['sisaUTeknis'] = $intervalMonth;
        $data['nilaiBuku'] = numfmt_format($this->numfmt, $nilaiBuku);
        $data['maksUTeknis'] = date_format(date_create($data['aset']['maks_u_teknis']), "d/m/Y");

        if (empty($data['aset'])) {
            return redirect()->to(base_url('aset'));
        }

        return $this->showPages('aset/detail', $data);
    }

    public function barcode($id)
    {
        // Deprecated since Oct 2022, now get code from DB
        // $result = $this->asetModel->find($id);
        // $code = 'AS' . str_pad($result['id'], 5, '0', STR_PAD_LEFT) . '-' . date_format(date_create($result['tgl_perolehan']), 'd/m/y');
        // $code = 'AS' . str_pad($result['id'], 5, '0', STR_PAD_LEFT);
        // $filename = 'AS' . str_pad($result['id'], 5, '0', STR_PAD_LEFT) . '.jpg';

        // Fetch data using Select statement for faster query time
        $query = $this->builder->select('kode')->where('id', $id)->get()->getResultArray()[0];
        $code = $query['kode'];
        $filename = $code . '.jpg';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: image/jpg;");
        $generator = new \Picqer\Barcode\BarcodeGeneratorJPG();
        file_put_contents('php://output', $generator->getBarcode($code, $generator::TYPE_CODE_128, 1, 50));
        exit;
    }

    public function img($id = 0)
    {
        $namaKolom = 'gambar_aset';
        $query = $this->builder->select($namaKolom)->where('id', $id);
        $data = [
            'title' => 'Gambar Aset',
            'id' => $id,
            'aset' => $query->get()->getResultArray()[0],
            'validation' => \Config\Services::validation()
        ];
        return $this->showPages('aset/formimg', $data);
    }

    public function editImg()
    {
        // Fetch Data
        $idAset = $this->request->getVar('id');

        // Validasi Aset Image
        $valid = $this->validate([
            'asetPict' => [
                'label' => 'Gambar Aset',
                'rules' => 'max_size[asetPict,5120]|is_image[asetPict]|mime_in[asetPict,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar! (max size: 5 MB)',
                    'is_image' => 'File yang Anda upload bukan gambar!',
                    'mime_in' => 'File yang Anda upload bukan gambar!'
                ]
            ]
        ]);

        if (!$valid) {
            return redirect()->to(base_url('aset/img/' . $idAset))->withInput();
        }

        // kelola Gambar Aset
        $fileAssetImage = $this->request->getFile('asetPict');
        // cek gambar
        if ($fileAssetImage->getError() == 4) $namaAssetImage = $this->request->getVar('oldAssetImage');
        else {
            // generate random filename
            $namaAssetImage = $fileAssetImage->getRandomName();
            // pindah lokasi gambar
            $fileAssetImage->move('img', $namaAssetImage);
            // hapus file yg lama (bila gambar aset tidak default_img.jpg)
            if ($this->request->getVar('oldAssetImage') != 'default_img.jpg') {
                unlink('img/' . $this->request->getVar('oldAssetImage'));
            }
        }

        // update ke DB
        $updatedData = [
            'gambar_aset' => $namaAssetImage
        ];
        $this->asetModel->builder()->update($updatedData, "id = $idAset");

        // pembuatan flashdata data diubah
        session()->setFlashdata('pesan', 'Gambar aset berhasil diupdate.');

        return redirect()->to(base_url('aset'));
    }
}
