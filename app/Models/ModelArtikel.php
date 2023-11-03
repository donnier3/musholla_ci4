<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelArtikel extends Model
{
    protected $table = 'tbl_artikel';
    protected $primaryKey = 'id_artikel';
    protected $useTimestamps = true;
    protected $allowedFields = ['judul_artikel', 'slug_artikel', 'penulis', 'img_artikel', 'status_artikel', 'isi_artikel', 'id_kategoriartikel', 'hits'];
    protected $column_order = [null, 'judul_artikel', 'slug_artikel', 'penulis', 'created_at', null];
    protected $column_search = ['judul_artikel', 'penulis'];
    protected $order = ['tbl_artikel.created_at' => 'DESC'];
    // protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table)->select('*')->join('tbl_kategoriartikel', 'tbl_kategoriartikel.id_kategoriartikel=tbl_artikel.id_kategoriartikel');
    }

    public function getArtikel($id_artikel = false)
    {
        if ($id_artikel == false) {
            return $this->findAll();
        }
        return $this->where(['id_artikel' => $id_artikel])->first();
    }

    public function readArtikel($slug_artikel = false)
    {
        if ($slug_artikel == false) {
            return $this->findAll();
        }
        // return $this->where(['slug_artikel' => $slug_artikel])->first();
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_artikel');
        $builder->join('tbl_kategoriartikel', 'tbl_kategoriartikel.id_kategoriartikel=tbl_artikel.id_kategoriartikel');
        $builder->where('slug_artikel', $slug_artikel);
        $query = $builder->get()->getRow();

        return $query;
    }

    public function tambah($data)
    {
        $this->save($data);
    }

    public function hapus($id_artikel)
    {
        $this->where('id_artikel', $id_artikel);
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
