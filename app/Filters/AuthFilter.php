<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        if (session('user_session.id') && session('user_session.session_key')) {
            $model = new UserModel();
            if ($model->cek_session_key(session('user_session.id'), session('user_session.session_key'))) {
                session()->setTempdata('user_session', [
                    'id' => session('user_session.id'),
                    'session_key' => session('user_session.session_key')
                ], 1800);
                return;
            }
        }

        return redirect()->to(base_url('auth'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
