<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // return view('auth/login');
        return $this->showPages('auth/login');
    }

    public function register()
    {
        // return view('auth/register');
        return $this->showPages('auth/register');
    }

    public function user()
    {
        // return view('user/index');
        return $this->showPages('user/index');
    }
}
