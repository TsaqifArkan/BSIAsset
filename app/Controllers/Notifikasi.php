<?php

namespace App\Controllers;

class Notifikasi extends BaseController
{
    public function index()
    {
        $data['title'] = 'Panel Notifikasi';
        $session = session();
        if ($session->has('notif')) {
            $data['jatuhTempo'] = $session->get('notif');
        } else {
            $data['jatuhTempo'] = [];
        }
        return view('notifikasi/index', $data);
    }

    public function delNotif($id = NULL)
    {
        if ($this->request->isAJAX()) {
            session();
            unset($_SESSION["notif"][$id]);
        } else {
            $data['title'] = 'Woops!';
            return view('templates/404', $data);
        }
    }
}
