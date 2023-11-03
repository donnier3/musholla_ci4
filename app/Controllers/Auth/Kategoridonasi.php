<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelKategoridonasi;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use \Config\Services;

class Kategoridonasi extends BaseController
{
    protected $helpers = ['text', 'form', 'url'];

    public function __construct()
    {
        $this->request = Services::request();
        $this->kategoridonasiModel = new ModelKategoridonasi($this->request);
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
        return view('/administrator/kategoridonasi', $data);
    }

    public function ambildatakategoridonasi()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kategoridonasi' => $this->kategoridonasiModel->getkategoridonasi()
            ];

            $msg = [
                'data' => view('/administrator/datakategoridonasi', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listkategoridonasi()
    {
        if ($this->request->isAJAX()) {
            $lists = $this->kategoridonasiModel->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_kategoridonasi . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
                $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_kategoridonasi . "','" . $list->nama_kategoridonasi . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";

                $row[] = $no;
                $row[] = ucwords($list->nama_kategoridonasi);
                $row[] = $list->slug_kategoridonasi;
                $row[] = $list->jenis_kategoridonasi == '1' ? 'Online' : 'Offline';
                $row[] = $list->created_at;
                $row[] = $btnEdit . " " . $btnDel;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->kategoridonasiModel->count_all(),
                "recordsFiltered" => $this->kategoridonasiModel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function modalTambahkategoridonasi()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('/administrator/modalTambahkategoridonasi'),

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
                'nama_kategoridonasi' => [
                    'rules' => 'required|is_unique[tbl_kategoridonasi.nama_kategoridonasi]',
                    'errors' => [
                        'required' => 'Nama kategori tidak boleh kosong',
                        'is_unique' => 'Nama kategori sudah terdaftar',
                    ]
                ],
                'jenis_kategoridonasi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis donasi tidak boleh kosong'
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_kategoridonasi' => $validation->getError('nama_kategoridonasi'),
                        'jenis_kategoridonasi' => $validation->getError('jenis_kategoridonasi'),
                    ]
                ];
            } else {
                $nama_kategori = $this->request->getVar('nama_kategoridonasi');
                $slug = url_title($nama_kategori, '-', true);
                $data = [
                    'nama_kategoridonasi' => $nama_kategori,
                    'slug_kategoridonasi' => $slug,
                    'jenis_kategoridonasi' => $this->request->getVar('jenis_kategoridonasi'),
                ];
                $this->kategoridonasiModel->tambah($data);
                $msg = [
                    'sukses' => 'Data kategori berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editkategoridonasi()
    {
        if ($this->request->isAJAX()) {
            $id_kategoridonasi = $this->request->getVar('id_kategoridonasi');
            $u = $this->kategoridonasiModel->find($id_kategoridonasi);
            $data = [
                'id_kategoridonasi' => $u['id_kategoridonasi'],
                'nama_kategoridonasi' => $u['nama_kategoridonasi'],
                'slug_kategoridonasi' => $u['slug_kategoridonasi'],
                'jenis_kategoridonasi' => $u['jenis_kategoridonasi'],
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditkategoridonasi', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updateKategori()
    {
        if ($this->request->isAJAX()) {
            $slug = url_title($this->request->getVar('nama_kategoridonasi'), '-', TRUE);
            $data = [
                'nama_kategoridonasi' => $this->request->getVar('nama_kategoridonasi'),
                'slug_kategoridonasi' => $slug,
                'jenis_kategoridonasi' => $this->request->getVar('jenis_kategoridonasi'),
            ];
            $id_kategoridonasi = $this->request->getVar('id_kategoridonasi');

            $this->kategoridonasiModel->update($id_kategoridonasi, $data);

            $msg = [
                'sukses' => 'Data kategori berhasil diupdate'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_kategoridonasi()
    {
        if ($this->request->isAJAX()) {
            $id_kategoridonasi = $this->request->getVar('id_kategoridonasi');
            $this->kategoridonasiModel->hapus($id_kategoridonasi);
            $msg = [
                'sukses' => "Data kategori berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
