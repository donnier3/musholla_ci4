<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelMateri;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use \Config\Services;

class Materi extends BaseController
{
    protected $helpers = ['text', 'form'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = Services::request();
        $this->materiModel = new ModelMateri($this->request);
        $this->setingModel = new ModelSeting($this->request);
        $this->usersModel = new ModelUser($this->request);
    }


    public function index()
    {
        $data = [
            'materi' => $this->materiModel->findAll(),
            'seting' => $this->setingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
        ];

        return view('/administrator/materi', $data);
    }

    public function ambildatamateri()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'materi' => $this->materiModel->getmateri()
            ];

            $msg = [
                'data' => view('/administrator/datamateri', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listmateri()
    {
        if ($this->request->isAJAX()) {
            $lists = $this->materiModel->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_materi . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
                $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_materi . "','" . $list->judul_materi . "','" . $list->file_materi . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";

                $row[] = $no;
                $row[] = ucwords($list->judul_materi);
                $row[] = ucwords($list->pemateri);
                $row[] = $list->hits;
                $row[] = "<i class='fas fa-file-pdf text-danger fa-2x' style='cursor:pointer' onclick='ajax_view($list->id_materi)'></i>";
                $row[] = $btnEdit . " " . $btnDel;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->materiModel->count_all(),
                "recordsFiltered" => $this->materiModel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function modalTambahmateri()
    {
        if ($this->request->isAJAX()) {

            $msg = [
                'data' => view('/administrator/modalTambahmateri'),

            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function tambahmateri()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'judul_materi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Judul materi tidak boleh kosong',
                    ]
                ],
                'pemateri' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pemateri tidak boleh kosong',
                    ]
                ],
                'file_materi' => [
                    'rules' => 'uploaded[file_materi]|max_size[file_materi,2048]|mime_in[file_materi,application/pdf,application/force-download,application/x-download]',
                    'errors' => [
                        'uploaded' => 'File masih kosong',
                        'max_size' => 'Ukuran file terlalu besar',
                        'mime_in' => 'Yang anda pilih bukan pdf'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'judul_materi' => $validation->getError('judul_materi'),
                        'pemateri' => $validation->getError('pemateri'),
                        'file_materi' => $validation->getError('file_materi'),
                    ]
                ];
            } else {
                $berkas = $this->request->getFile('file_materi');
                //nama random
                $namaFile = $berkas->getRandomName();
                //pindah ke folder img
                $berkas->move('assets/materi', $namaFile);

                $judul = $this->request->getVar('judul_materi');
                $slug = url_title($judul, '-', true);
                $data = [
                    'judul_materi' => $judul,
                    'slug_materi' => $slug,
                    'pemateri' => $this->request->getVar('pemateri'),
                    'file_materi' => $namaFile,
                ];
                $this->materiModel->tambah($data);

                $msg = [
                    'sukses' => 'Data materi berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editmateri()
    {
        if ($this->request->isAJAX()) {
            $id_materi = $this->request->getVar('id_materi');
            $u = $this->materiModel->find($id_materi);

            $data = [
                'id_materi' => $u['id_materi'],
                'judul_materi' => $u['judul_materi'],
                'slug_materi' => $u['slug_materi'],
                'pemateri' => $u['pemateri'],
                'file_materi' => $u['file_materi'],
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditmateri', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updatemateri()
    {
        if ($this->request->isAJAX()) {
            $id_materi = $this->request->getVar('id_materi');
            $berkas = $this->request->getFile('file_materi');
            if ($berkas->getError() == 4) {
                $namafile = $this->request->getVar('fileLama');
            } else {
                //nama random
                $namafile = $berkas->getRandomName();
                //pindah ke folder img
                $berkas->move('assets/materi', $namafile);
                //ambil nama file 
                // $namaSampul = $bukti->getName();
                unlink('assets/materi/' . $namafile);
            }
            $judul = $this->request->getVar('judul_materi');
            $slug = url_title($judul, '-', true);
            $data = [
                'judul_materi' => $judul,
                'slug_materi' => $slug,
                'pemateri' => $this->request->getVar('pemateri'),
                'file_materi' => $namafile
            ];

            $this->materiModel->update($id_materi, $data);

            $msg = [
                'sukses' => 'Data materi berhasil diupdate'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_materi()
    {
        if ($this->request->isAJAX()) {
            $id_materi = $this->request->getVar('id_materi');

            $namaFile = $this->materiModel->find($id_materi);

            unlink('assets/materi/' . $namaFile['file_materi']);

            $this->materiModel->hapus($id_materi);

            $msg = [
                'sukses' => "Data materi berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function viewfile()
    {
        if ($this->request->isAJAX()) {
            $id_materi = $this->request->getVar('id_materi');
            $u = $this->materiModel->find($id_materi);
            $data = [
                'id_materi' => $u['id_materi'],
                'file_materi' => $u['file_materi']
            ];
            $msg = [
                'sukses' => view('/administrator/modalviewmaterifile', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
