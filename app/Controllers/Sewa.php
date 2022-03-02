<?php

namespace App\Controllers;

use App\Models\SewaModel;

class Sewa extends BaseController
{
    protected $sewaModel;

    public function __construct()
    {
        $this->sewaModel    = new SewaModel();
    }

    public function index()
    {
        $result = $this->sewaModel->findAll();

        $data = [
            'title' => 'Sewa Barang',
            'rents' => $result,
            'numFmt' => $this->numfmt
        ];

        return view('sewa/index', $data);
    }
}
