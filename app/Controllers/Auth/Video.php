<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelVideo;
use App\Models\ModelKategoriartikel;
use App\Models\ModelSeting;
use App\Models\ModelUser;
use \Config\Services;

class Video extends BaseController
{
    protected $helpers = ['text', 'form'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = Services::request();
        $this->videoModel = new ModelVideo($this->request);
        $this->kategoriartikelModel = new ModelKategoriartikel($this->request);
        $this->setingModel = new ModelSeting($this->request);
        $this->usersModel = new ModelUser($this->request);
    }


    public function index()
    {
        $data = [
            'video' => $this->videoModel->findAll(),
            'seting' => $this->setingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
        ];

        return view('/administrator/video', $data);
    }

    public function ambildatavideo()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'video' => $this->videoModel->getvideo(),
            ];

            $msg = [
                'data' => view('/administrator/datavideo', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listvideo()
    {
        if ($this->request->isAJAX()) {

            $list_data = $this->videoModel;
            $where = ['tbl_video.id_video !=' => 0];
            //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
            //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
            $column_order = [NULL, 'tbl_kategoriartikel.nama_kategoriartikel', 'judul_video', 'hits', 'link_video'];
            $column_search = ['tbl_kategoriartikel.nama_kategoriartikel', 'judul_video', 'link_video'];
            $order = ['tbl_video.id_video' => 'asc'];
            $list = $list_data->get_datatables('tbl_video', $column_order, $column_search, $order, $where);

            // $lists = $this->videoModel->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($list as $list) {
                $no++;
                $row = [];

                $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_video . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
                $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_video . "','" . $list->judul_video . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";

                $row[] = $no;
                $row[] = ucwords($list->nama_kategoriartikel);
                $row[] = ucwords($list->judul_video);
                $row[] = $list->hits;
                $row[] = $list->link_video;
                $row[] = $btnEdit . " " . $btnDel;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->videoModel->count_all('tbl_video', $where),
                "recordsFiltered" => $this->videoModel->count_filtered('tbl_video', $column_order, $column_search, $order, $where),
                "data" => $data
            ];
            echo json_encode($output);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function modalTambahvideo()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'kategori' => $this->kategoriartikelModel->getkategoriartikel()
            ];

            $msg = [
                'data' => view('/administrator/modalTambahvideo', $data),
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function tambahvideo()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'id_kategoriartikel' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kategori tidak boleh kosong'
                    ]
                ],
                'judul_video' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Judul video tidak boleh kosong',
                    ]
                ],
                'link_video' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Link video tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'id_kategoriartikel' => $validation->getError('id_kategoriartikel'),
                        'judul_video' => $validation->getError('judul_video'),
                        'link_video' => $validation->getError('link_video'),
                    ]
                ];
            } else {
                $judul = $this->request->getVar('judul_video');
                $slug = url_title($judul, '-', true);
                $data = [
                    'judul_video' => $judul,
                    'slug_video' => $slug,
                    'id_kategoriartikel' => $this->request->getVar('id_kategoriartikel'),
                    'link_video' => $this->request->getVar('link_video'),
                ];
                $this->videoModel->tambah($data);

                $msg = [
                    'sukses' => 'Data video berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editvideo()
    {
        if ($this->request->isAJAX()) {
            $id_video = $this->request->getVar('id_video');
            $u = $this->videoModel->find($id_video);

            $data = [
                'id_video' => $u['id_video'],
                'kategori' => $this->kategoriartikelModel->getkategoriartikel(),
                'id_kategoriartikel' => $u['id_kategoriartikel'],
                'judul_video' => $u['judul_video'],
                'slug_video' => $u['slug_video'],
                'link_video' => $u['link_video'],
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditvideo', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updatevideo()
    {
        if ($this->request->isAJAX()) {
            $id_video = $this->request->getVar('id_video');
            $judul = $this->request->getVar('judul_video');
            $slug = url_title($judul, '-', true);
            $data = [
                'id_video' => $id_video,
                'judul_video' => $judul,
                'slug_video' => $slug,
                'id_kategoriartikel' => $this->request->getVar('id_kategoriartikel'),
                'link_video' => $this->request->getVar('link_video'),
            ];
            $this->videoModel->update($id_video, $data);

            $msg = [
                'sukses' => 'Data video berhasil diupdate'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_video()
    {
        if ($this->request->isAJAX()) {
            $id_video = $this->request->getVar('id_video');
            $this->videoModel->hapus($id_video);
            $msg = [
                'sukses' => "Data video berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
