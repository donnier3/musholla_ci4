<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelKonfirmasidonasi extends Model
{
    protected $table = 'tbl_konfirmasidonasi';
    protected $primaryKey = 'id_konfirmasidonasi';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_donatur', 'id_donasi', 'tgl_donasi', 'bukti_donasi'];

    public function totalkonfirmasi()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_konfirmasidonasi');
        $builder->selectCount('id_donatur');
        $builder->getWhere('bukti_donasi != NULL', NULL);
        $query = $builder->get()->getResultArray();

        return $query;
    }

    public function getKonfirmasidonasi($id_konfirmasidonasi = false)
    {
        if ($id_konfirmasidonasi == false) {
            return $this->findAll();
        }
        return $this->where(['id_konfirmasidonasi' => $id_konfirmasidonasi])->first();
    }

    public function tambah($data)
    {
        $this->save($data);
    }

    public function hapus($id_konfirmasidonasi)
    {
        $this->where('id_konfirmasidonasi', $id_konfirmasidonasi);
        $this->delete();
    }
}
