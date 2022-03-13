<?php

namespace App\Controllers;

class Notifikasi extends BaseController
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $session = session();
        if ($session->has('notif')) {
            $data['jatuhTempo'] = $session->get('notif');
        } else {
            $data['jatuhTempo'] = [];
        }
        // dd($session->get('notif'));
        return view('notifikasi/index', $data);
    }

    public function delNotif($id = NULL)
    {
        if ($this->request->isAJAX()) {
            $session = session();
            unset($_SESSION["notif"][$id]);
        } else {
            $data['title'] = 'Woops!';
            return view('templates/404', $data);
        }
    }
}
