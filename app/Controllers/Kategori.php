<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data['title'] = 'Kategori Barang';
        // $categories = new KategoriModel();
        $data['categories'] = $this->kategoriModel->findAll();

        return view('kategori/index', $data);
    }

    public function tambah()
    {
        // dd($_POST);
        // dd($this->request->getVar());
        // cara insert ke DB
        $this->kategoriModel->save([
            'nama' => $this->request->getVar('nama')
        ]);

        return redirect()->to('/kategori');
    }
}
