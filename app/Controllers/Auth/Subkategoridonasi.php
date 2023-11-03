<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelSubkategoridonasi;
use App\Models\ModelKategoridonasi;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use \Config\Services;

class Subkategoridonasi extends BaseController
{
    protected $helpers = ['text', 'form', 'url'];

    public function __construct()
    {
        $this->request = Services::request();
        $this->subkategoridonasiModel = new ModelSubkategoridonasi($this->request);
        $this->kategoridonasiModel = new ModelKategoridonasi($this->request);
        $this->setingModel = new ModelSeting($this->request);
        $this->usersModel = new ModelUser($this->request);
    }


    public function index()
    {
        $data = [
            'seting' => $this->setingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
        ];
        return view('/administrator/subkategoridonasi', $data);
    }

    public function ambildatasubkategoridonasi()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'subkategoridonasi' => $this->subkategoridonasiModel->getSubkategoridonasi()
            ];

            $msg = [
                'data' => view('/administrator/datasubkategoridonasi', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listsubkategoridonasi()
    {
        if ($this->request->isAJAX()) {
            $lists = $this->subkategoridonasiModel->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_subkategoridonasi . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
                $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_subkategoridonasi . "','" . $list->nama_subkategoridonasi . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";

                $row[] = $no;
                $row[] = ucwords($list->nama_subkategoridonasi);
                $row[] = ucwords($list->nama_kategoridonasi);
                $row[] = $list->created_at;
                $row[] = $btnEdit . " " . $btnDel;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->subkategoridonasiModel->count_all(),
                "recordsFiltered" => $this->subkategoridonasiModel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function modalTambahsubkategoridonasi()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kategoridonasi' => $this->kategoridonasiModel->findAll()
            ];

            $msg = [
                'data' => view('/administrator/modalTambahsubkategoridonasi', $data),

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
                'nama_subkategoridonasi' => [
                    'rules' => 'required|is_unique[tbl_subkategoridonasi.nama_subkategoridonasi]',
                    'errors' => [
                        'required' => 'Nama Subkategori tidak boleh kosong',
                        'is_unique' => 'Nama Subkategori sudah terdaftar',
                    ]
                ],
                'id_kategoridonasi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kategori tidak boleh kosong'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_subkategoridonasi' => $validation->getError('nama_subkategoridonasi'),
                        'id_kategoridonasi' => $validation->getError('id_kategoridonasi'),
                    ]
                ];
            } else {
                $nama_subkategori = $this->request->getVar('nama_subkategoridonasi');
                $slug = url_title($nama_subkategori, '-', true);
                $data = [
                    'nama_subkategoridonasi' => $nama_subkategori,
                    'slug_subkategoridonasi' => $slug,
                    'id_kategoridonasi' => $this->request->getVar('id_kategoridonasi'),
                ];
                $this->subkategoridonasiModel->tambah($data);
                $msg = [
                    'sukses' => 'Data Subkategori berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editsubkategoridonasi()
    {
        if ($this->request->isAJAX()) {
            $id_subkategoridonasi = $this->request->getVar('id_subkategoridonasi');
            $u = $this->subkategoridonasiModel->find($id_subkategoridonasi);
            $data = [
                'id_subkategoridonasi' => $u['id_subkategoridonasi'],
                'id_kategoridonasi' => $u['id_kategoridonasi'],
                'kategoridonasi' => $this->kategoridonasiModel->getkategoridonasi(),
                'nama_subkategoridonasi' => $u['nama_subkategoridonasi'],
                'slug_subkategoridonasi' => $u['slug_subkategoridonasi'],
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditsubkategoridonasi', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updateSubkategori()
    {
        if ($this->request->isAJAX()) {
            $slug = url_title($this->request->getVar('nama_subkategoridonasi'), '-', TRUE);
            $data = [
                'id_kategoridonasi' => $this->request->getVar('id_kategoridonasi'),
                'nama_subkategoridonasi' => $this->request->getVar('nama_subkategoridonasi'),
                'slug_subkategoridonasi' => $slug,
            ];
            $id_subkategoridonasi = $this->request->getVar('id_subkategoridonasi');

            $this->subkategoridonasiModel->update($id_subkategoridonasi, $data);

            $msg = [
                'sukses' => 'Data kategori berhasil diupdate'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_subkategoridonasi()
    {
        if ($this->request->isAJAX()) {
            $id_subkategoridonasi = $this->request->getVar('id_subkategoridonasi');
            $this->subkategoridonasiModel->hapus($id_subkategoridonasi);
            $msg = [
                'sukses' => "Data kategori berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
