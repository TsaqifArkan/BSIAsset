<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['jumlah', 'harga', 'd_k', 'keterangan', 'id_brgcetak'];
    protected $useTimestamps = true;
    protected $dateFormat = 'date';
    protected $createdField = 'tanggal';
    protected $updatedField = '';
}
