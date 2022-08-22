<?php

namespace App\Controllers;

// use App\Models\NotifikasiModel;

define('ERR_TITLE', 'Whoops!');
define('ERR_404', 'templates/404');

class Notifikasi extends BaseController
{
    // Deprecated since Notif implemented in BaseCont
    // private $notifikasiModel;

    // public function __construct()
    // {
    //     $this->notifikasiModel = new NotifikasiModel();
    // }

    public function index()
    {
        // $data['title'] = 'Panel Notifikasi';
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
        // return $this->showPages('notifikasi/index', $data);
        // return view('notifikasi/index', $data);

        // Just in case someone is curious..
        $data['title'] = ERR_TITLE;
        return $this->showPages(ERR_404, $data);
    }

    public function delNotif($id = NULL)
    {
        if ($this->request->isAJAX()) {
            // $this->notifikasiModel->delete($id);

            // DEPRECATED! - Try to implement again 18/07/22
            session();
            unset($_SESSION["notif"][$id]);
        } else {
            $data['title'] = ERR_TITLE;
            return $this->showPages(ERR_404, $data);
        }
    }
}
