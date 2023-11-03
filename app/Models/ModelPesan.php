<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelPesan extends Model
{
    protected $table = 'tbl_pesan';
    protected $primaryKey = 'id_pesan';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_pesan', 'nama', 'email', 'subject', 'pesan'];
    protected $column_order = [null, 'nama', 'email', 'subject', 'pesan', null];
    protected $column_search = ['nama', 'email', 'subject'];
    protected $order = ['id_pesan' => 'ASC'];
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

    public function getpesan($id_pesan = false)
    {
        if ($id_pesan == false) {
            return $this->findAll();
        }
        return $this->where(['id_pesan' => $id_pesan])->first();
    }

    public function tambah($data)
    {
        $this->save($data);
    }

    public function hapus($id_pesan)
    {
        $this->where('id_pesan', $id_pesan);
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
