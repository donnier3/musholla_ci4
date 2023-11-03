<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelKategoriartikel;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use \Config\Services;

class Kategoriartikel extends BaseController
{
    protected $helpers = ['text', 'form', 'url'];

    public function __construct()
    {
        $this->request = Services::request();
        $this->kategoriartikelModel = new ModelKategoriartikel($this->request);
        $this->setingModel = new ModelSeting($this->request);
        $this->usersModel = new ModelUser($this->request);
    }


    public function index()
    {
        // return view('welcome_message');
        $data = [
            'seting' => $this->setingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
        ];
        return view('/administrator/kategoriartikel', $data);
    }

    public function ambildatakategoriartikel()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kategoriartikel' => $this->kategoriartikelModel->getkategoriartikel()
            ];

            $msg = [
                'data' => view('/administrator/datakategoriartikel', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listkategoriartikel()
    {
        if ($this->request->isAJAX()) {
            $lists = $this->kategoriartikelModel->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_kategoriartikel . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
                $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_kategoriartikel . "','" . $list->nama_kategoriartikel . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";

                $row[] = $no;
                $row[] = ucwords($list->nama_kategoriartikel);
                $row[] = $list->slug_kategoriartikel;
                $row[] = $list->created_at;
                $row[] = $btnEdit . " " . $btnDel;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->kategoriartikelModel->count_all(),
                "recordsFiltered" => $this->kategoriartikelModel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function modalTambahkategoriartikel()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('/administrator/modalTambahkategoriartikel'),

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
                'nama_kategoriartikel' => [
                    'rules' => 'required|is_unique[tbl_kategoriartikel.nama_kategoriartikel]',
                    'errors' => [
                        'required' => 'Nama kategori tidak boleh kosong',
                        'is_unique' => 'Nama kategori sudah terdaftar',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_kategoriartikel' => $validation->getError('nama_kategoriartikel'),
                    ]
                ];
            } else {
                $nama_kategori = $this->request->getVar('nama_kategoriartikel');
                $slug = url_title($nama_kategori, '-', true);
                $data = [
                    'nama_kategoriartikel' => $nama_kategori,
                    'slug_kategoriartikel' => $slug,
                ];
                $this->kategoriartikelModel->tambah($data);
                $msg = [
                    'sukses' => 'Data kategori berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editkategoriartikel()
    {
        if ($this->request->isAJAX()) {
            $id_kategoriartikel = $this->request->getVar('id_kategoriartikel');
            $u = $this->kategoriartikelModel->find($id_kategoriartikel);
            $data = [
                'id_kategoriartikel' => $u['id_kategoriartikel'],
                'nama_kategoriartikel' => $u['nama_kategoriartikel'],
                'slug_kategoriartikel' => $u['slug_kategoriartikel'],
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditkategoriartikel', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updateKategori()
    {
        if ($this->request->isAJAX()) {
            $slug = url_title($this->request->getVar('nama_kategoriartikel'), '-', TRUE);
            $data = [
                'nama_kategoriartikel' => $this->request->getVar('nama_kategoriartikel'),
                'slug_kategoriartikel' => $slug,
            ];
            $id_kategoriartikel = $this->request->getVar('id_kategoriartikel');

            $this->kategoriartikelModel->update($id_kategoriartikel, $data);

            $msg = [
                'sukses' => 'Data kategori berhasil diupdate'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_kategoriartikel()
    {
        if ($this->request->isAJAX()) {
            $id_kategoriartikel = $this->request->getVar('id_kategoriartikel');
            $this->kategoriartikelModel->hapus($id_kategoriartikel);
            $msg = [
                'sukses' => "Data kategori berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
