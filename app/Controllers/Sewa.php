<?php

namespace App\Controllers;

use App\Models\SewaModel;
use DateTime;

class Sewa extends BaseController
{
    protected $sewaModel, $db, $builder;

    public function __construct()
    {
        $this->sewaModel    = new SewaModel();
        $this->db           = \Config\Database::connect();
        $this->builder      = $this->db->table('sewa');
    }

    public function index()
    {
        $data['title'] = 'Sewa Barang';
        return view('sewa/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {

            $results = $this->sewaModel->findAll();

            // Specify a Generality
            $datefmtrsewa = [];
            $datefmtrtempo = [];
            $numfmtr = [];
            $timeleft = [];
            $now = strtotime(date('Y-m-d'));
            foreach ($results as $result) {
                // Change Date Format Tanggal Sewa
                array_push($datefmtrsewa, date_format(date_create($result['tgl_sewa']), "d/m/Y"));
                // Change Date Format Jatuh Tempo
                array_push($datefmtrtempo, date_format(date_create($result['jatuh_tempo']), "d/m/Y"));
                // Change Number Formatter
                array_push($numfmtr, numfmt_format($this->numfmt, $result['harga']));
                // Count sisa hari
                $sisaWaktu = (strtotime($result['jatuh_tempo']) - $now) / 86400;
                array_push($timeleft, $sisaWaktu > 0 ? $sisaWaktu : 0);
            }

            $data = [
                'rents' => [
                    'majority' => $results,
                    'dateFmtrSewa' => $datefmtrsewa,
                    'dateFmtrTempo' => $datefmtrtempo,
                    'numFmtr' => $numfmtr,
                    'timeLeft' => $timeleft
                ]
                // 'numFmt' => $this->numfmt
                // 'dateFmt' => $datefmt
            ];

            $msg = [
                'data' => view('sewa/tablesewadata', $data)
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
                'data' => view('sewa/modaltambah')
            ];
            echo json_encode($msg);
        } else {
            $data['title'] = 'Woops!';
            return view('templates/404', $data);
        }
    }
}
