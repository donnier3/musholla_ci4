<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelSeting extends Model
{
    protected $table = 'tbl_setting';
    protected $primaryKey = 'id_setting';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'about_me', 'address', 'maps', 'phone', 'email', 'visi', 'misi', 'icon', 'images', 'fb', 'ig', 'tw'];

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table)->select('*');
    }

    public function getsetting($id_setting = false)
    {
        if ($id_setting == false) {
            return $this->findAll();
        }
        return $this->where(['id_setting' => $id_setting])->first();
    }

    public function tambah($data)
    {
        $this->save($data);
    }

    public function hapus($id_setting)
    {
        $this->where('id_setting', $id_setting);
        $this->delete();
    }
}
