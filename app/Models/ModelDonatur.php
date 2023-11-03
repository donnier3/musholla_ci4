<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelDonatur extends Model
{
    protected $table = 'tbl_donatur';
    protected $primaryKey = 'id_donatur';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_donatur', 'id_donasi', 'nama_donatur', 'email_donatur', 'hp_donatur', 'alamat_donatur'];


    public function getDonatur($id_donatur = false)
    {
        if ($id_donatur == false) {
            return $this->findAll();
        }
        return $this->where(['id_donatur' => $id_donatur])->first();
    }

    public function tambah($data)
    {
        $this->save($data);
    }

    public function hapus($id_donatur)
    {
        $this->where('id_donatur', $id_donatur);
        $this->delete();
    }
}
