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
        // return view('kategori/index', $data);
        return $this->showPages('kategori/index', $data);
    }

    public function tambah()
    {
        // dd($_POST);
        // dd($this->request->getVar());
        // insert ke DB
        $this->kategoriModel->save([
            'nama' => $this->request->getVar('nama')
        ]);

        // Flash Data
        $dataFlash = [
            'alert' => 'SUCCESS ! ',
            'msg' => 'Data berhasil ditambahkan.'
        ];
        session()->setFlashdata($dataFlash);

        return redirect()->to('/kategori');
    }

    public function delete($id)
    {
        $this->kategoriModel->delete($id);

        // Flash Data
        $dataFlash = [
            'alert' => 'SUCCESS ! ',
            'msg' => 'Data berhasil dihapus.'
        ];
        session()->setFlashdata($dataFlash);

        return redirect()->to('/kategori');
    }
}
