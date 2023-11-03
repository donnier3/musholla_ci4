<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelSubkategoridonasi extends Model
{
    protected $table = 'tbl_subkategoridonasi';
    protected $primaryKey = 'id_subkategoridonasi';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_subkategoridonasi', 'slug_subkategoridonasi', 'id_kategoridonasi'];
    protected $column_order = [null, 'nama_subkategoridonasi', 'slug_subkategoridonasi', 'created_at', null];
    protected $column_search = ['nama_subkategoridonasi'];
    protected $order = ['id_subkategoridonasi' => 'ASC'];
    // protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table)->select('*')->join('tbl_kategoridonasi', 'tbl_subkategoridonasi.id_kategoridonasi = tbl_kategoridonasi.id_kategoridonasi');
    }

    public function getSubkategoridonasi($id_subkategoridonasi = false)
    {
        if ($id_subkategoridonasi == false) {
            $this->select('tbl_subkategoridonasi.*');
            $query = $this->get();
            return $query->getResultArray();
            // return $this->findAll();
        }
        return $this->where(['id_subkategoridonasi' => $id_subkategoridonasi])->first();
    }

    public function tambah($data)
    {
        $this->save($data);
    }

    public function hapus($id_subkategoridonasi)
    {
        $this->where('id_subkategoridonasi', $id_subkategoridonasi);
        $this->delete();
    }

    public function getidsubkategoridonasi($id_kategoridonasi)
    {
        return $this->where(['id_kategoridonasi' => $id_kategoridonasi])->findAll();
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
