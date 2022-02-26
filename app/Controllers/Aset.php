<?php

namespace App\Controllers;

use App\Models\AsetModel;
use PhpParser\Node\Stmt\Echo_;

class Aset extends BaseController
{
    protected $asetModel;

    public function __construct()
    {
        $this->asetModel = new AsetModel();
    }

    public function index()
    {
        $result = $this->asetModel->findAll();

        $data = [
            'title' => 'Kelola Aset',
            'assets' => $result
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
}
