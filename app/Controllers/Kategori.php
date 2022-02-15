<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    public function index()
    {
        $data['title'] = 'Kategori Barang';
        $categories = new KategoriModel();
        $data['categories'] = $categories->findAll();

        return view('kategori/index', $data);
    }
}
