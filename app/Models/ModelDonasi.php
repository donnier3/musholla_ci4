<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelDonasi extends Model
{
    protected $table = 'tbl_donasi';
    protected $primaryKey = 'id_donasi';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_kategoridonasi', 'id_subkategoridonasi', 'kode_donasi', 'id_bank', 'jumlah_donasi'];

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function donasitahun()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_donasi');
    }

    public function totaldonasi()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_donasi');
        $builder->join('tbl_konfirmasidonasi', 'tbl_konfirmasidonasi.id_donasi=tbl_donasi.id_donasi');
        $builder->selectSum('jumlah_donasi');
        $builder->where('bukti_donasi != ""');
        $query = $builder->get()->getResultArray();

        return $query;
    }

    public function hitungdonasi()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_donasi');
        $builder->selectSum('jumlah_donasi');
        $builder->selectCount('tbl_donasi.id_subkategoridonasi', 'jml_donasi');
        $builder->join('tbl_budget', 'tbl_budget.id_subkategoridonasi=tbl_donasi.id_subkategoridonasi');
        $builder->groupBy('tbl_donasi.id_subkategoridonasi');
        $query = $builder->get()->getResultArray();

        return $query;
    }

    private function _get_datatables_query($table, $column_order, $column_search, $order)
    {
        $this->builder = $this->db->table($table);
        //jika ingin join formatnya adalah sebagai berikut :
        $this->builder->join('tbl_donatur', 'tbl_donatur.id_donasi = tbl_donasi.id_donasi', 'left')
            ->join('tbl_kategoridonasi', 'tbl_kategoridonasi.id_kategoridonasi=tbl_donasi.id_kategoridonasi', 'left')
            ->join('tbl_subkategoridonasi', 'tbl_subkategoridonasi.id_subkategoridonasi=tbl_donasi.id_subkategoridonasi', 'left')
            ->join('tbl_konfirmasidonasi', 'tbl_konfirmasidonasi.id_donasi=tbl_donasi.id_donasi')
            ->join('tbl_bank', 'tbl_bank.id_bank=tbl_donasi.id_bank');
        //end Join
        $i = 0;
        foreach ($column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->builder->groupStart();
                    $this->builder->like($item, $_POST['search']['value']);
                } else {
                    $this->builder->orLike($item, $_POST['search']['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->builder->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->builder->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->builder->orderBy(key($order), $order[key($order)]);
        }
    }

    function get_datatables($table, $column_order, $column_search, $order, $data = '')
    {
        $this->_get_datatables_query($table, $column_order, $column_search, $order);
        if ($_POST['length'] != -1)
            $this->builder->limit($_POST['length'], $_POST['start']);
        if ($data) {
            $this->builder->where($data);
        }
        $query = $this->builder->get();
        return $query->getResult();
    }

    function count_filtered($table, $column_order, $column_search, $order, $data = '')
    {
        $this->_get_datatables_query($table, $column_order, $column_search, $order);
        if ($data) {
            $this->builder->where($data);
        }
        $this->builder->get();
        return $this->builder->countAll();
    }

    public function count_all($table, $data = '')
    {
        if ($data) {
            $this->builder->where($data);
        }
        $this->builder->from($table);

        return $this->builder->countAll();
    }


    public function getDonasi($id_donasi = false)
    {
        if ($id_donasi == false) {
            return $this->findAll();
        }
        return $this->where(['id_donasi' => $id_donasi])->first();
    }

    public function tambah($data)
    {
        $this->save($data);
    }

    public function hapus($id_donasi)
    {
        $del = $this->db->table($this->table)->select('*')
            ->join('tbl_kategoridonasi', 'tbl_kategoridonasi.id_kategoridonasi=tbl_donasi.id_kategoridonasi')
            ->join('tbl_donatur', 'tbl_donasi.id_donatur = tbl_donatur.id_donatur');
        $del->where('id_donasi', $id_donasi);
        $del->delete();
    }
}
