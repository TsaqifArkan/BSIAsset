<?php

namespace App\Controllers;

use App\Models\AsetModel;

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
            'title' => 'Kelola Aset',
            'assets' => [
                'majority' => $results,
                'dateFmtr' => $datefmtr,
                'numFmtr' => $numfmtr
            ]
            // 'numFmt' => $this->numfmt
            // 'dateFmt' => $datefmt
        ];

        return view('aset/index', $data);
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
        // Validation
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
                $this->asetModel->save([
                    'nama' => $this->request->getVar('nama'),
                    'tgl_perolehan' => $this->request->getVar('tglPerolehan'),
                    'harga' => $this->request->getVar('hargaPerolehan'),
                    'usia_teknis' => $this->request->getVar('usiaTeknis')
                ]);

                // Flash Data
                $dataFlash = [
                    'alert' => 'SUCCESS ! ',
                    'msg' => 'Data berhasil ditambahkan.'
                ];
                session()->setFlashdata($dataFlash);
            }
            echo json_encode($msg);
        } else {
            exit("Woops! seems you're quite curious..");
        }
    }

    public function detail($id = 0)
    {
        $data['title'] = 'Detail Aset';

        $this->builder->select('*');
        $this->builder->where('aset.id', $id);
        $query = $this->builder->get();

        $data['aset'] = $query->getRow();

        // Percobaan Sisa Usia Teknis menggunakan Detik
        // $dateNow = new DateTime(date('Y-m-d'));
        // $dateExp = new DateTime(date($data['aset']->maks_u_teknis));
        $dateNow = strtotime(date('Y-m-d'));
        $dateExp = strtotime($data['aset']->maks_u_teknis);
        $interval = ($dateExp - $dateNow) / 60 / 60 / 24 / 30;
        $interval = ($interval > 0) ? ceil($interval) : 0;

        // d($interval);

        // SUCCESS!
        // Percobaan menghitung nilai buku
        $nilaiBuku = ($data['aset']->harga / $data['aset']->usia_teknis) * $interval;

        // d(numfmt_format($numfmt, $nilaiBuku));

        // Memasukkan ke dalam objek
        $data['harga'] = numfmt_format($this->numfmt, $data['aset']->harga);
        $data['sisaUTeknis'] = $interval;
        $data['nilaiBuku'] = numfmt_format($this->numfmt, $nilaiBuku);

        if (empty($data['aset'])) {
            return redirect()->to('/aset');
        }

        return view('aset/detail', $data);
    }

    public function delete($id)
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

    public function edit()
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
