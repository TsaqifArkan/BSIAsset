<?php

namespace App\Models;

use CodeIgniter\Model;

class CetakModel extends Model
{
    protected $table = 'cetak';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['tanggal', 'nama', 'harga', 'keluar', 'masuk', 'keterangan'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = '';
    protected $updatedField = '';
}
