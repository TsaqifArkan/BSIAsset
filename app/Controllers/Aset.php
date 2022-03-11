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
        $data['title'] = 'Detail Aset';
        $data['aset'] = $this->asetModel->find($id);
        $dateNow = new DateTime(date('Y-m-d'));
        $dateExp = new DateTime($data['aset']['maks_u_teknis']);
        $dateInterval = date_diff($dateNow, $dateExp);
        $intervalMonth = $dateInterval->invert ? 0 : ($dateInterval->m + ($dateInterval->d != 0));

        $nilaiBuku = ($data['aset']['harga'] / $data['aset']['usia_teknis']) * $intervalMonth;

        // Memasukkan ke dalam objek
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


    public function deleteAAAAA($id)
    {
        $this->asetModel->delete($id);

        // Flash Data
        $dataFlash = [
            'alert' => 'SUCCESS ! ',
            'msg' => 'Data berhasil dihapus.'
        ];
        session()->setFlashdata($dataFlash);

        return redirect()->to('/aset');
    }

    public function getEdit()
    {
        // echo 'data akan segera dikirimkan gan';
        // echo $_POST["id"];
        // dd($this->detail($_POST["id"]));

        $this->builder->select('*');
        $this->builder->where('aset.id', $_POST["id"]);
        $query = $this->builder->get()->getRow();
        echo json_encode($query);
    }

    public function editAAAA()
    {
        // dd($_POST);

        // Update ke DB
        $data = [
            'nama' => $_POST["nama"],
            'tgl_perolehan'  => $_POST["tglPerolehan"],
            'harga'  => $_POST["hargaPerolehan"],
            'usia_teknis' => $_POST["usiaTeknis"]
        ];

        $this->builder->where('id', $_POST["id"]);
        $this->builder->update($data);

        // Flash Data
        $dataFlash = [
            'alert' => 'SUCCESS ! ',
            'msg' => 'Data berhasil diubah.'
        ];
        session()->setFlashdata($dataFlash);

        return redirect()->to('/aset');
    }
}
