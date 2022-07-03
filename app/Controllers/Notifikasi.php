<?php

namespace App\Controllers;

use App\Models\NotifikasiModel;

class Notifikasi extends BaseController
{
    private $notifikasiModel;

    public function __construct()
    {
        $this->notifikasiModel = new NotifikasiModel();
    }

    public function index()
    {
        $data['title'] = 'Panel Notifikasi';
        // FULLY DEPRECATED!
        // $query = $this->notifikasiModel->builder()->select('*')->orderBy('waktu', 'ASC');
        // $result = $query->get()->getResultArray();
        // $data['notifikasi'] = $result;
        // Until This Line.

        // $data['notifikasi'] = $this->notifikasiModel->findAll();
        // dd($data);
        // DEPRECATED!
        // $session = session();
        // if ($session->has('notif')) {
        //     $data['jatuhTempo'] = $session->get('notif');
        // } else {
        //     $data['jatuhTempo'] = [];
        // }
        return $this->showPages('notifikasi/index', $data);
        // return view('notifikasi/index', $data);
    }

    public function delNotif($id = NULL)
    {
        if ($this->request->isAJAX()) {
            $this->notifikasiModel->delete($id);

            // DEPRECATED!
            // session();
            // unset($_SESSION["notif"][$id]);
        } else {
            $data['title'] = 'Whoops!';
            return $this->showPages('templates/404', $data);
            // return view('templates/404', $data);
        }
    }
}
