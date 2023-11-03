<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelKajian;
use App\Models\ModelKategoriartikel;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use \Config\Services;

class Kajian extends BaseController
{
    protected $helpers = ['text', 'form', 'url', 'number'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = Services::request();
        $this->kajianModel = new ModelKajian($this->request);
        $this->kategoriartikelModel = new ModelKategoriartikel($this->request);
        $this->setingModel = new ModelSeting($this->request);
        $this->usersModel = new ModelUser($this->request);
    }


    public function index()
    {
        $data = [
            'seting' => $this->setingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
        ];
        return view('/administrator/kajian', $data);
    }

    public function ambildatakajian()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kajian' => $this->kajianModel->getKajian()
            ];

            $msg = [
                'data' => view('/administrator/datakajian', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listkajian()
    {
        if ($this->request->isAJAX()) {
            $lists = $this->kajianModel->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_kajian . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
                $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_kajian . "','" . $list->tema_kajian . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";

                $row[] = $no;
                $row[] = ucwords($list->tema_kajian);
                $row[] = $list->tgl_kajian;
                $row[] = ucwords($list->pengisi_kajian);
                $row[] = '<img src="' . base_url() . '/img/kajian/' . $list->img_kajian . '" class="img-thumbnail" width="100" height="50" >';
                $row[] = $list->created_at;
                $row[] = $btnEdit . " " . $btnDel;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->kajianModel->count_all(),
                "recordsFiltered" => $this->kajianModel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function modalTambahkajian()
    {
        if ($this->request->isAJAX()) {

            $msg = [
                'data' => view('/administrator/modalTambahkajian'),

            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function tambahkajian()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'id_kategoriartikel' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kategori kajian tidak boleh kosong'
                    ]
                ],
                'tema_kajian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tema kajian tidak boleh kosong',
                    ]
                ],
                'pengisi_kajian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pengisi kajian tidak boleh kosong',
                    ]
                ],
                'tgl_kajian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal kajian tidak boleh kosong'
                    ]
                ],
                'img_kajian' => [
                    'rules' => 'uploaded[img_kajian]|max_size[img_kajian,1024]|is_image[img_kajian]|mime_in[img_kajian,image/jpg,image/jpeg,images/png]',
                    'errors' => [
                        'uploaded' => 'Gambar tidak boleh kosong',
                        'max_size' => 'Ukuran gambar terlalu besar',
                        'is_image' => 'Yang anda pilih bukan gambar',
                        'mime_is' => 'Yang anda pilih bukan gambar'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'id_kategoriartikel' => $validation->getError('id_kategoriartikel'),
                        'tema_kajian' => $validation->getError('tema_kajian'),
                        'pengisi_kajian' => $validation->getError('pengisi_kajian'),
                        'tgl_kajian' => $validation->getError('tgl_kajian'),
                        'img_kajian' => $validation->getError('img_kajian'),
                    ]
                ];
            } else {
                $gambar = $this->request->getFile('img_kajian');
                if ($gambar->getError() == 4) {
                    $namafile = 'default.jpg';
                } else {
                    //nama random
                    $namafile = $gambar->getRandomName();
                    //pindah ke folder img
                    $gambar->move('img/kajian', $namafile);
                    //ambil nama file 
                    // $namaSampul = $bukti->getName();
                }
                $tema = $this->request->getVar('tema_kajian');
                $slug = url_title($tema, '-', true);
                $data = [
                    'id_kategoriartikel' => $this->request->getVar('id_kategoriartikel'),
                    'tema_kajian' => $tema,
                    'slug_kajian' => $slug,
                    'pengisi_kajian' => $this->request->getVar('pengisi_kajian'),
                    'tgl_kajian' => $this->request->getVar('tgl_kajian'),
                    'img_kajian' => $namafile
                ];

                $this->kajianModel->tambah($data);

                $msg = [
                    'sukses' => 'Data kajian berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editkajian()
    {
        if ($this->request->isAJAX()) {
            $id_kajian = $this->request->getVar('id_kajian');
            $u = $this->kajianModel->find($id_kajian);
            $data = [
                'id_kategoriartikel' => $u['id_kategoriartikel'],
                'kategori' => $this->kategoriartikelModel->findAll(),
                'id_kajian' => $u['id_kajian'],
                'tema_kajian' => $u['tema_kajian'],
                'tgl_kajian' => $u['tgl_kajian'],
                'pengisi_kajian' => $u['pengisi_kajian'],
                'img_kajian' => $u['img_kajian'],
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditkajian', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updatekajian()
    {
        if ($this->request->isAJAX()) {
            $id_kajian = $this->request->getVar('id_kajian');
            $gambar = $this->request->getFile('img_kajian');
            if ($gambar->getError() == 4) {
                $namafile = $this->request->getVar('imgLama');
            } else {
                //nama random
                $namafile = $gambar->getRandomName();
                //pindah ke folder img
                $gambar->move('img/kajian', $namafile);
                //ambil nama file 
                // $namaSampul = $bukti->getName();
                unlink('img/kajian/', $namafile);
            }
            $tema = $this->request->getVar('tema_kajian');
            $slug = url_title($tema, '-', true);
            $data = [
                'id_kategoriartikel' => $this->request->getVar('id_kategoriartikel'),
                'tema_kajian' => $tema,
                'slug_kajian' => $slug,
                'pengisi_kajian' => $this->request->getVar('pengisi_kajian'),
                'tgl_kajian' => $this->request->getVar('tgl_kajian'),
                'img_kajian' => $namafile
            ];

            $this->kajianModel->update($id_kajian, $data);

            $msg = [
                'sukses' => 'Data kajian berhasil disimpan'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_kajian()
    {
        if ($this->request->isAJAX()) {
            $id_kajian = $this->request->getVar('id_kajian');
            $u = $this->kajianModel->find($id_kajian);
            unlink('img/kajian/' . $u['img_kajian']);
            $this->kajianModel->hapus($id_kajian);
            $msg = [
                'sukses' => "Data kajian berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
