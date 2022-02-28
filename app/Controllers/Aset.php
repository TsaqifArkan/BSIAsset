<?php

namespace App\Controllers;

use App\Models\AsetModel;
use DateTime;
use NumberFormatter;
use PhpParser\Node\Stmt\Echo_;

class Aset extends BaseController
{
    protected $asetModel, $db, $builder, $numfmt;

    public function __construct()
    {
        $this->asetModel    = new AsetModel();
        $this->db           = \Config\Database::connect();
        $this->builder      = $this->db->table('aset');
        // Percobaan NumberFormatter
        $this->numfmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
    }

    public function index()
    {
        $result = $this->asetModel->findAll();

        $data = [
            'title' => 'Kelola Aset',
            'assets' => $result,
            'numFmt' => $this->numfmt
        ];

        return view('aset/index', $data);
    }

    public function tambah()
    {
        // dd($_POST);
        // dd($this->request->getVar());
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

        return redirect()->to('/aset');
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
        // $dateExp = new DateTime(date($data['aset']->exp_date));
        $dateNow = strtotime(date('Y-m-d'));
        $dateExp = strtotime($data['aset']->exp_date);
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
}
