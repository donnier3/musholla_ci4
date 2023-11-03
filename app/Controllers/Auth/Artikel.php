<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelKategoriartikel;
use App\Models\ModelArtikel;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use \Config\Services;

class Artikel extends BaseController
{
    protected $helpers = ['text', 'form', 'url'];

    public function __construct()
    {
        $this->request = Services::request();
        $this->kategoriartikelModel = new ModelKategoriartikel($this->request);
        $this->artikelModel = new ModelArtikel($this->request);
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
        return view('/administrator/artikel', $data);
    }

    public function ambildataartikel()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'artikel' => $this->artikelModel->getArtikel()
            ];

            $msg = [
                'data' => view('/administrator/dataartikel', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listartikel()
    {
        if ($this->request->isAJAX()) {
            $lists = $this->artikelModel->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_artikel . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
                $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_artikel . "','" . $list->judul_artikel . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";
                $img = "<img src='assets/img/artikel/'" . $list->img_artikel . ">";

                $row[] = $no;
                $row[] = ucwords($list->penulis);
                $row[] = ucwords($list->nama_kategoriartikel);
                $row[] = ucwords($list->judul_artikel);
                $row[] = '<img src="' . base_url() . '/img/artikel/' . $list->img_artikel . '" class="img-thumbnail" width="100" height="50" >';
                $row[] = ($list->status_artikel == 0) ? "<span class='badge badge-secondary'> Draft </span>" : "<span class='badge badge-success'> Publish </span>";
                $row[] = $list->created_at;
                $row[] = $btnEdit . " " . $btnDel;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->artikelModel->count_all(),
                "recordsFiltered" => $this->artikelModel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function modalTambahartikel()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kategoriartikel' => $this->kategoriartikelModel->findAll()
            ];
            $msg = [
                'data' => view('/administrator/modalTambahartikel', $data),

            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function tambahartikel()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'penulis' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama penulis tidak boleh kosong',
                    ]
                ],
                'id_kategoriartikel' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kategori artikel tidak boleh kosong'
                    ]
                ],
                'judul_artikel' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Judul artikel tidak boleh kosong'
                    ]
                ],
                'isi_artikel' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Artikel tidak boleh kosong'
                    ]
                ],
                'img_artikel' => [
                    'rules' => 'uploaded[img_artikel]|max_size[img_artikel,1024]|is_image[img_artikel]|mime_in[img_artikel,image/jpg,image/jpeg,images/png]',
                    'errors' => [
                        'uploaded' => 'Gambar masih kosong',
                        'max_size' => 'Ukuran gambar terlalu besar',
                        'is_image' => 'Yang anda pilih bukan gambar',
                        'mime_is' => 'Yang anda pilih bukan gambar'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'penulis' => $validation->getError('penulis'),
                        'id_kategoriartikel' => $validation->getError('id_kategoriartikel'),
                        'judul_artikel' => $validation->getError('judul_artikel'),
                        'isi_artikel' => $validation->getError('isi_artikel'),
                        'img_artikel' => $validation->getError('img_artikel'),
                    ]
                ];
            } else {

                $gambar = $this->request->getFile('img_artikel');
                if ($gambar->getError() == 4) {
                    $namafile = 'no-images.jpg';
                } else {
                    //nama random
                    $namafile = $gambar->getRandomName();
                    //pindah ke folder img
                    $gambar->move('img/artikel', $namafile);
                    //ambil nama file 
                    // $namaSampul = $bukti->getName();
                }
                $judul = $this->request->getVar('judul_artikel');
                $slug = url_title($judul, '-', true);
                $data = [
                    'penulis' => $this->request->getVar('penulis'),
                    'id_kategoriartikel' => $this->request->getVar('id_kategoriartikel'),
                    'slug_artikel' => $slug,
                    'judul_artikel' => $judul,
                    'isi_artikel' => $this->request->getVar('isi_artikel'),
                    'status_artikel' => $this->request->getVar('status_artikel'),
                    'img_artikel' => $namafile,
                ];
                $this->artikelModel->tambah($data);
                $msg = [
                    'sukses' => 'Artikel berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editartikel()
    {
        if ($this->request->isAJAX()) {
            $id_artikel = $this->request->getVar('id_artikel');
            $u = $this->artikelModel->find($id_artikel);
            $data = [
                'id_artikel' => $u['id_artikel'],
                'penulis' => $u['penulis'],
                'id_kategoriartikel' => $u['id_kategoriartikel'],
                'kategoriartikel' => $this->kategoriartikelModel->getKategoriartikel(),
                'judul_artikel' => $u['judul_artikel'],
                'status_artikel' => $u['status_artikel'],
                'img_artikel' => $u['img_artikel'],
                'isi_artikel' => $u['isi_artikel']
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditartikel', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function uploadImg()
    {
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'upload' => [
                'uploaded[upload]',
                'max_size[upload,1024]',
                'mime_in[upload,image/jpg,image/jpeg,images/png]',
            ]
        ]);
        if ($valid) {
            $file = $this->request->getFile('upload');
            $namafile = $file->getRandomName();
            //pindah ke folder img
            $file->move('img/artikel', $namafile);

            $data = [
                'uploaded' => true,
                'url' => base_url('/img/artikel/' . $namafile),
            ];
        } else {
            $data = [
                "uploaded" => false,
                "error" => [
                    "upload" => $validation->getError("upload"),
                ],
            ];
        }
        return $this->response->setJSON($data);
    }

    public function updateartikel()
    {
        if ($this->request->isAJAX()) {
            $id_artikel = $this->request->getVar('id_artikel');
            $gambar = $this->request->getFile('img_artikel');
            if ($gambar->getError() == 4) {
                $namafile = $this->request->getVar('imgLama');
            } else {
                //nama random
                $namafile = $gambar->getRandomName();
                //pindah ke folder img
                $gambar->move('img/artikel', $namafile);
                //ambil nama file 
                // $namaSampul = $bukti->getName();
                unlink('img/artikel/', $namafile);
            }
            $judul = $this->request->getVar('judul_artikel');
            $slug = url_title($judul, '-', true);
            $data = [
                'penulis' => $this->request->getVar('penulis'),
                'id_kategoriartikel' => $this->request->getVar('id_kategoriartikel'),
                'slug_artikel' => $slug,
                'judul_artikel' => $judul,
                'isi_artikel' => $this->request->getVar('isi_artikel'),
                'status_artikel' => $this->request->getVar('status_artikel'),
                'img_artikel' => $namafile,
            ];
            $this->artikelModel->update($id_artikel, $data);
            $msg = [
                'sukses' => 'Artikel berhasil diupdate'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_artikel()
    {
        if ($this->request->isAJAX()) {
            $id_artikel = $this->request->getVar('id_artikel');
            $u = $this->artikelModel->find($id_artikel);
            unlink('img/artikel/' . $u['img_artikel']);
            $this->artikelModel->hapus($id_artikel);
            $msg = [
                'sukses' => "Data artikel berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
