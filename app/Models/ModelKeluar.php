<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelKeluar extends Model
{
    protected $table = 'tbl_pengeluaran';
    protected $primaryKey = 'id_pengeluaran';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_kategorikeluar', 'id_subkategorikeluar', 'jumlah_keluar', 'tgl_keluar', 'bukti_keluar'];

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function hitungkeluar()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_pengeluaran');

        $builder->selectSum('jumlah_keluar');
        $query = $builder->get()->getResultArray();

        return $query;
    }

    public function getpengeluaran($id_pengeluaran = false)
    {
        if ($id_pengeluaran == false) {
            return $this->findAll();
        }
        return $this->where(['id_pengeluaran' => $id_pengeluaran])->first();
    }

    public function tambah($data)
    {
        $this->save($data);
    }

    public function hapus($id_pengeluaran)
    {
        $this->where('id_pengeluaran', $id_pengeluaran);
        $this->delete();
    }


    private function _get_datatables_query($table, $column_order, $column_search, $order)
    {
        $this->builder = $this->db->table($table);
        //jika ingin join formatnya adalah sebagai berikut :
        $this->builder->join('tbl_kategorikeluar', 'tbl_kategorikeluar.id_kategorikeluar = tbl_pengeluaran.id_kategorikeluar', 'left')
            ->join('tbl_subkategorikeluar', 'tbl_subkategorikeluar.id_subkategorikeluar=tbl_pengeluaran.id_subkategorikeluar', 'left');
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
}
