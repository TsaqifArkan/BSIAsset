<?php

namespace App\Models;

use CodeIgniter\Model;

class CetakModel extends Model
{
    protected $table = 'cetak';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nama', 'jumlah', 'harga', 'd_k', 'keterangan', 'id_brgcetak'];
    protected $useTimestamps = true;
    protected $dateFormat = 'date';
    protected $createdField = 'tanggal';
    protected $updatedField = '';
}
