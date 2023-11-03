<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelKategorikeluar;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use \Config\Services;

class Kategorikeluar extends BaseController
{
    protected $helpers = ['text', 'form', 'url'];

    public function __construct()
    {
        $this->request = Services::request();
        $this->kategorikeluarModel = new ModelKategorikeluar($this->request);
        $this->setingModel = new ModelSeting($this->request);
        $this->usersModel = new ModelUser($this->request);
    }


    public function index()
    {
        $data = [
            'seting' => $this->setingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
        ];
        return view('/administrator/kategorikeluar', $data);
    }

    public function ambildatakategorikeluar()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kategorikeluar' => $this->kategorikeluarModel->getkategorikeluar()
            ];

            $msg = [
                'data' => view('/administrator/datakategorikeluar', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listkategorikeluar()
    {
        if ($this->request->isAJAX()) {
            $lists = $this->kategorikeluarModel->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_kategorikeluar . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
                $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_kategorikeluar . "','" . $list->nama_kategorikeluar . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";

                $row[] = $no;
                $row[] = ucwords($list->nama_kategorikeluar);
                $row[] = $list->slug_kategorikeluar;
                $row[] = $list->created_at;
                $row[] = $btnEdit . " " . $btnDel;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->kategorikeluarModel->count_all(),
                "recordsFiltered" => $this->kategorikeluarModel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function modalTambahkategorikeluar()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('/administrator/modalTambahkategorikeluar'),

            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function tambahKategori()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_kategorikeluar' => [
                    'rules' => 'required|is_unique[tbl_kategorikeluar.nama_kategorikeluar]',
                    'errors' => [
                        'required' => 'Nama kategori tidak boleh kosong',
                        'is_unique' => 'Nama kategori sudah terdaftar',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_kategorikeluar' => $validation->getError('nama_kategorikeluar'),
                    ]
                ];
            } else {
                $nama_kategori = $this->request->getVar('nama_kategorikeluar');
                $slug = url_title($nama_kategori, '-', true);
                $data = [
                    'nama_kategorikeluar' => $nama_kategori,
                    'slug_kategorikeluar' => $slug,
                ];
                $this->kategorikeluarModel->tambah($data);
                $msg = [
                    'sukses' => 'Data kategori berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editkategorikeluar()
    {
        if ($this->request->isAJAX()) {
            $id_kategorikeluar = $this->request->getVar('id_kategorikeluar');
            $u = $this->kategorikeluarModel->find($id_kategorikeluar);
            $data = [
                'id_kategorikeluar' => $u['id_kategorikeluar'],
                'nama_kategorikeluar' => $u['nama_kategorikeluar'],
                'slug_kategorikeluar' => $u['slug_kategorikeluar'],
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditkategorikeluar', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updateKategori()
    {
        if ($this->request->isAJAX()) {
            $slug = url_title($this->request->getVar('nama_kategorikeluar'), '-', TRUE);
            $data = [
                'nama_kategorikeluar' => $this->request->getVar('nama_kategorikeluar'),
                'slug_kategorikeluar' => $slug,
            ];
            $id_kategorikeluar = $this->request->getVar('id_kategorikeluar');

            $this->kategorikeluarModel->update($id_kategorikeluar, $data);

            $msg = [
                'sukses' => 'Data kategori berhasil diupdate'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_kategorikeluar()
    {
        if ($this->request->isAJAX()) {
            $id_kategorikeluar = $this->request->getVar('id_kategorikeluar');
            $this->kategorikeluarModel->hapus($id_kategorikeluar);
            $msg = [
                'sukses' => "Data kategori berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
