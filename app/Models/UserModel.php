<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['username', 'password', 'email', 'full_name', 'user_image', 'session_key'];
    protected $useTimestamps = false;
    protected $dateFormat = 'date';
    protected $createdField = '';
    protected $updatedField = '';

    public function cek_session_key($id, $key)
    {
        $result_sk = $this->builder()->select('session_key')->where('id', $id)->get()->getFirstRow('array')['session_key'];
        return password_verify($key, $result_sk);
    }
}
