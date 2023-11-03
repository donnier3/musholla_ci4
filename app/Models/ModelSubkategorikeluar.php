<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelSubkategorikeluar extends Model
{
    protected $table = 'tbl_subkategorikeluar';
    protected $primaryKey = 'id_subkategorikeluar';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_subkategorikeluar', 'slug_subkategorikeluar', 'id_kategorikeluar'];
    protected $column_order = [null, 'nama_subkategorikeluar', 'slug_subkategorikeluar', 'created_at', null];
    protected $column_search = ['nama_subkategorikeluar'];
    protected $order = ['id_subkategorikeluar' => 'ASC'];
    // protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table)->select('*')->join('tbl_kategorikeluar', 'tbl_subkategorikeluar.id_kategorikeluar = tbl_kategorikeluar.id_kategorikeluar');
    }

    public function getSubkategorikeluar($id_subkategorikeluar = false)
    {
        if ($id_subkategorikeluar == false) {
            $this->select('tbl_subkategorikeluar.*');
            $query = $this->get();
            return $query->getResultArray();
            // return $this->findAll();
        }
        return $this->where(['id_subkategorikeluar' => $id_subkategorikeluar])->first();
    }

    public function tambah($data)
    {
        $this->save($data);
    }

    public function hapus($id_subkategorikeluar)
    {
        $this->where('id_subkategorikeluar', $id_subkategorikeluar);
        $this->delete();
    }

    public function getidsubkategorikeluar($id_kategorikeluar)
    {
        return $this->where(['id_kategorikeluar' => $id_kategorikeluar])->findAll();
    }

    private function _get_datatables_query()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }
}
