<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelKomentar extends Model
{
    protected $table = 'tbl_komentar';
    protected $primaryKey = 'id_komentar';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_komentar', 'id_artikel', 'nama', 'email', 'komentar'];

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function getkomentar($id_komentar = false)
    {
        if ($id_komentar == false) {
            return $this->findAll();
        }
        return $this->where(['id_komentar' => $id_komentar])->first();
    }

    public function getJml($id_artikel)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_komentar');
        $builder->selectCount('id_komentar', 'jmlkom');
        $builder->where(['id_artikel' => $id_artikel]);
        $query = $builder->get()->getRow();
        return $query;
    }

    public function getId($id_artikel)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_komentar');

        $builder->selectCount('tbl_reply.id_komentar', 'jmlrep');
        $builder->join('tbl_reply', 'tbl_reply.id_komentar=tbl_komentar.id_komentar');
        $builder->where('id_artikel', $id_artikel);
        $query = $builder->get()->getRow();
        return $query;
    }

    public function tambah($data)
    {
        $this->save($data);
    }

    public function hapus($id_komentar)
    {
        $this->where('id_komentar', $id_komentar);
        $this->delete();
    }

    private function _get_datatables_query($table, $column_order, $column_search, $order)
    {
        $this->builder = $this->db->table($table);
        //jika ingin join formatnya adalah sebagai berikut :
        $this->builder->join('tbl_artikel', 'tbl_artikel.id_artikel = tbl_komentar.id_artikel', 'left');
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
