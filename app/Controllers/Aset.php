<?php

namespace App\Controllers;

use App\Models\AsetModel;
use DateInterval;
use DateTime;

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
        return view('aset/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {

            $results = $this->asetModel->findAll();

            // Specify a Generality
            $datefmtr = [];
            $numfmtr = [];
            foreach ($results as $result) {
                // Change Date Format
                array_push($datefmtr, date_format(date_create($result['tgl_perolehan']), "d/m/Y"));
                // Change Number Formatter
                array_push($numfmtr, numfmt_format($this->numfmt, $result['harga']));
            }

            $data = [
                'assets' => [
                    'majority' => $results,
                    'dateFmtr' => $datefmtr,
                    'numFmtr' => $numfmtr
                ]
                // 'numFmt' => $this->numfmt
                // 'dateFmt' => $datefmt
            ];

            $msg = [
                'data' => view('aset/tableasetdata', $data)
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
                'data' => view('aset/modaltambah')
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
                    'rules' => 'required|is_unique[aset.nama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} sudah terdaftar! {field} tidak boleh sama dengan yang sudah terdaftar'
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
            $msg = [];
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'tglPerolehan' => $validation->getError('tglPerolehan'),
                        'hargaPerolehan' => $validation->getError('hargaPerolehan'),
                        'usiaTeknis' => $validation->getError('usiaTeknis')
                    ]
                ];
            } else {
                // insert ke DB
                $inputData = [
                    'nama' => $this->request->getVar('nama'),
                    'tgl_perolehan' => $this->request->getVar('tglPerolehan'),
                    'harga' => $this->request->getVar('hargaPerolehan'),
                    'usia_teknis' => $this->request->getVar('usiaTeknis')
                ];

                $this->asetModel->save($inputData);

                // Flash Data
                // $dataFlash = [
                //     'alert' => 'SUCCESS ! ',
                //     'msg' => 'Data berhasil ditambahkan.'
                // ];

                $msg = [
                    'flashData' => 'Data aset berhasil ditambahkan.'
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
            $result = $this->asetModel->find($id);

            $data = [
                'id' => $result['id'],
                'nama' => $result['nama'],
                'tglPerolehan' => $result['tgl_perolehan'],
                'hargaPerolehan' => $result['harga'],
                'usiaTeknis' => $result['usia_teknis']
            ];

            $msg = [
                'data' => view('aset/modaledit', $data)
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
                        'tglPerolehan' => $validation->getError('tglPerolehan'),
                        'hargaPerolehan' => $validation->getError('hargaPerolehan'),
                        'usiaTeknis' => $validation->getError('usiaTeknis')
                    ]
                ];
            } else {
                // update ke DB
                $updatedData = [
                    'nama' => $this->request->getVar('nama'),
                    'tgl_perolehan' => $this->request->getVar('tglPerolehan'),
                    'harga' => $this->request->getVar('hargaPerolehan'),
                    'usia_teknis' => $this->request->getVar('usiaTeknis')
                ];
                $this->asetModel->update($id, $updatedData);

                // Flash Data
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
            $data['title'] = 'Woops!';
            return view('templates/404', $data);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $this->asetModel->delete($id);

            $msg = [
                'flashData' => 'Data aset berhasil dihapus.'
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
        $intervalMonth = $dateInterval->invert ? 0 : ($dateInterval->m + ($dateInterval->d != 0));

        // Menghitung nilaiBuku
        $nilaiBuku = ($data['aset']['harga'] / $data['aset']['usia_teknis']) * $intervalMonth;

        // Memasukkan data ke dalam objek
        $data['tglPerolehan'] = date_format(date_create($data['aset']['tgl_perolehan']), "d/m/Y");
        $data['harga'] = numfmt_format($this->numfmt, $data['aset']['harga']);
        $data['sisaUTeknis'] = $intervalMonth;
        $data['nilaiBuku'] = numfmt_format($this->numfmt, $nilaiBuku);
        $data['maksUTeknis'] = date_format(date_create($data['aset']['maks_u_teknis']), "d/m/Y");

        // dd($data['sisaUTeknis']);

        if (empty($data['aset'])) {
            return redirect()->to('/aset');
        }

        return view('aset/detail', $data);
    }

    public function barcode($id)
    {
        $result = $this->asetModel->find($id);

        $code = 'AS' . str_pad($result['id'], 5, '0', STR_PAD_LEFT) . '-' . date_format(date_create($result['tgl_perolehan']), 'd/m/y');

        // dd($code);

        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
        file_put_contents('img/' . 'AS' . str_pad($result['id'], 5, '0', STR_PAD_LEFT) . '.png', $generator->getBarcode($code, $generator::TYPE_CODE_128, 3, 50));
        // INI MANA RETURNNYA?!
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
        return view('aset/formimg', $data);
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
            return redirect()->to('aset/img/' . $idAset)->withInput();
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
            // hapus file yg lama (bila gambar aset tidak default_aset.jpg)
            if ($this->request->getVar('oldAssetImage') != 'default_aset.jpg') {
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

        return redirect()->to('aset');
    }
}
