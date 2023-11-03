<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelSubkategorikeluar;
use App\Models\ModelKategorikeluar;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use \Config\Services;

class Subkategorikeluar extends BaseController
{
    protected $helpers = ['text', 'form', 'url'];

    public function __construct()
    {
        $this->request = Services::request();
        $this->subkategorikeluarModel = new ModelSubkategorikeluar($this->request);
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
        return view('/administrator/subkategorikeluar', $data);
    }

    public function ambildatasubkategorikeluar()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'subkategorikeluar' => $this->subkategorikeluarModel->getSubkategorikeluar()
            ];

            $msg = [
                'data' => view('/administrator/datasubkategorikeluar', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listsubkategorikeluar()
    {
        if ($this->request->isAJAX()) {
            $lists = $this->subkategorikeluarModel->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_subkategorikeluar . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
                $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_subkategorikeluar . "','" . $list->nama_subkategorikeluar . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";

                $row[] = $no;
                $row[] = ucwords($list->nama_subkategorikeluar);
                $row[] = ucwords($list->nama_kategorikeluar);
                $row[] = $list->created_at;
                $row[] = $btnEdit . " " . $btnDel;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->subkategorikeluarModel->count_all(),
                "recordsFiltered" => $this->subkategorikeluarModel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function modalTambahsubkategorikeluar()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kategorikeluar' => $this->kategorikeluarModel->findAll()
            ];

            $msg = [
                'data' => view('/administrator/modalTambahsubkategorikeluar', $data),

            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function tambahSubkategori()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_subkategorikeluar' => [
                    'rules' => 'required|is_unique[tbl_subkategorikeluar.nama_subkategorikeluar]',
                    'errors' => [
                        'required' => 'Nama Subkategori tidak boleh kosong',
                        'is_unique' => 'Nama Subkategori sudah terdaftar',
                    ]
                ],
                'id_kategorikeluar' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kategori tidak boleh kosong'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_subkategorikeluar' => $validation->getError('nama_subkategorikeluar'),
                        'id_kategorikeluar' => $validation->getError('id_kategorikeluar'),
                    ]
                ];
            } else {
                $nama_subkategori = $this->request->getVar('nama_subkategorikeluar');
                $slug = url_title($nama_subkategori, '-', true);
                $data = [
                    'nama_subkategorikeluar' => $nama_subkategori,
                    'slug_subkategorikeluar' => $slug,
                    'id_kategorikeluar' => $this->request->getVar('id_kategorikeluar'),
                ];
                $this->subkategorikeluarModel->tambah($data);
                $msg = [
                    'sukses' => 'Data Subkategori berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editsubkategorikeluar()
    {
        if ($this->request->isAJAX()) {
            $id_subkategorikeluar = $this->request->getVar('id_subkategorikeluar');
            $u = $this->subkategorikeluarModel->find($id_subkategorikeluar);
            $data = [
                'id_subkategorikeluar' => $u['id_subkategorikeluar'],
                'id_kategorikeluar' => $u['id_kategorikeluar'],
                'kategorikeluar' => $this->kategorikeluarModel->getkategorikeluar(),
                'nama_subkategorikeluar' => $u['nama_subkategorikeluar'],
                'slug_subkategorikeluar' => $u['slug_subkategorikeluar'],
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditsubkategorikeluar', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updateSubkategori()
    {
        if ($this->request->isAJAX()) {
            $slug = url_title($this->request->getVar('nama_subkategorikeluar'), '-', TRUE);
            $data = [
                'id_kategorikeluar' => $this->request->getVar('id_kategorikeluar'),
                'nama_subkategorikeluar' => $this->request->getVar('nama_subkategorikeluar'),
                'slug_subkategorikeluar' => $slug,
            ];
            $id_subkategorikeluar = $this->request->getVar('id_subkategorikeluar');

            $this->subkategorikeluarModel->update($id_subkategorikeluar, $data);

            $msg = [
                'sukses' => 'Data kategori berhasil diupdate'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_subkategorikeluar()
    {
        if ($this->request->isAJAX()) {
            $id_subkategorikeluar = $this->request->getVar('id_subkategorikeluar');
            $this->subkategorikeluarModel->hapus($id_subkategorikeluar);
            $msg = [
                'sukses' => "Data kategori berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
