<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelKajian extends Model
{
    protected $table = 'tbl_kajian';
    protected $primaryKey = 'id_kajian';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_kajian', 'id_kategoriartikel', 'tgl_kajian', 'tema_kajian', 'pengisi_kajian', 'img_kajian', 'slug_kajian'];
    protected $column_order = [null, 'tema_kajian', 'pengisi_kajian', 'tgl_kajian', null];
    protected $column_search = ['tema_kajian', 'pengisi_kajian', 'tgl_kajian'];
    protected $order = ['id_kajian' => 'ASC'];
    // protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table)->select('*');
    }

    public function getKajian($id_kajian = false)
    {
        if ($id_kajian == false) {
            return $this->findAll();
        }
        return $this->where(['id_kajian' => $id_kajian])->first();
    }

    public function ambilkajian()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_kajian');
        $builder->join('tbl_kategoriartikel', 'tbl_kategoriartikel.id_kategoriartikel=tbl_kajian.id_kategoriartikel');
        $query = $builder->get()->getResultArray();

        return $query;
    }

    public function tambah($data)
    {
        $this->save($data);
    }

    public function hapus($id_kajian)
    {
        $this->where('id_kajian', $id_kajian);
        $this->delete();
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
