<?php

namespace App\Models;

use CodeIgniter\Model;

class BrgCetakModel extends Model
{
    protected $table = 'brgcetak';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nama', 'tanggal', 'stok'];
    protected $useTimestamps = true;
    protected $dateFormat = 'date';
    protected $createdField = '';
    protected $updatedField = '';
}
