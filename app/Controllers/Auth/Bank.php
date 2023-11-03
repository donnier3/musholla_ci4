<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelBank;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use \Config\Services;

class Bank extends BaseController
{
    protected $helpers = ['text', 'form', 'url', 'number'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = Services::request();
        $this->bankModel = new ModelBank($this->request);
        $this->setingModel = new ModelSeting($this->request);
        $this->usersModel = new ModelUser($this->request);
    }


    public function index()
    {
        $data = [
            'seting' => $this->setingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
        ];
        return view('/administrator/bank', $data);
    }

    public function ambildatabank()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'bank' => $this->bankModel->getbank()
            ];

            $msg = [
                'data' => view('/administrator/databank', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listbank()
    {
        if ($this->request->isAJAX()) {
            $lists = $this->bankModel->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_bank . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
                $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_bank . "','" . $list->nama_bank . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";

                $row[] = $no;
                $row[] = $list->kode_bank;
                $row[] = ucwords($list->nama_bank);
                $row[] = ucwords($list->cabang);
                $row[] = $list->no_rekening;
                $row[] = ucwords($list->nama_rekening);
                $row[] = $btnEdit . " " . $btnDel;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->bankModel->count_all(),
                "recordsFiltered" => $this->bankModel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function modalTambahbank()
    {
        if ($this->request->isAJAX()) {

            $msg = [
                'data' => view('/administrator/modalTambahbank'),

            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function tambahbank()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_bank' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama bank tidak boleh kosong'
                    ]
                ],
                'no_rekening' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nomor rekening tidak boleh kosong',
                    ]
                ],
                'nama_rekening' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama rekening tidak boleh kosong',
                    ]
                ],
                'logo_bank' => [
                    'rules' => 'uploaded[logo_bank]|max_size[logo_bank,1024]|is_image[logo_bank]|mime_in[logo_bank,image/jpg,image/jpeg,images/png]',
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
                        'nama_bank' => $validation->getError('nama_bank'),
                        'no_rekening' => $validation->getError('no_rekening'),
                        'nama_rekening' => $validation->getError('nama_rekening'),
                        'logo_bank' => $validation->getError('logo_bank'),
                    ]
                ];
            } else {
                $gambar = $this->request->getFile('logo_bank');
                if ($gambar->getError() == 4) {
                    $namafile = 'default.jpg';
                } else {
                    //nama random
                    $namafile = $gambar->getRandomName();
                    //pindah ke folder img
                    $gambar->move('img/bank', $namafile);
                    //ambil nama file 
                    // $namaSampul = $bukti->getName();
                }
                $data = [
                    'kode_bank' => $this->request->getVar('kode_bank'),
                    'nama_bank' => $this->request->getVar('nama_bank'),
                    'cabang' => $this->request->getVar('cabang'),
                    'no_rekening' => $this->request->getVar('no_rekening'),
                    'nama_rekening' => $this->request->getVar('nama_rekening'),
                    'logo_bank' => $namafile
                ];

                $this->bankModel->tambah($data);

                $msg = [
                    'sukses' => 'Data bank berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editbank()
    {
        if ($this->request->isAJAX()) {
            $id_bank = $this->request->getVar('id_bank');
            $u = $this->bankModel->find($id_bank);
            $data = [
                'id_bank' => $u['id_bank'],
                'kode_bank' => $u['kode_bank'],
                'nama_bank' => $u['nama_bank'],
                'cabang' => $u['cabang'],
                'no_rekening' => $u['no_rekening'],
                'nama_rekening' => $u['nama_rekening'],
                'logo_bank' => $u['logo_bank'],
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditbank', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updatebank()
    {
        if ($this->request->isAJAX()) {
            $id_bank = $this->request->getVar('id_bank');
            $gambar = $this->request->getFile('logo_bank');
            if ($gambar->getError() == 4) {
                $namafile = $this->request->getVar('imgLama');
            } else {
                //nama random
                $namafile = $gambar->getRandomName();
                //pindah ke folder img
                $gambar->move('img/bank', $namafile);
                //ambil nama file 
                // $namaSampul = $bukti->getName();
                unlink('img/bank/' . $this->request->getVar('imgLama'));
            }
            $data = [
                'kode_bank' => $this->request->getVar('kode_bank'),
                'nama_bank' => $this->request->getVar('nama_bank'),
                'cabang' => $this->request->getVar('cabang'),
                'no_rekening' => $this->request->getVar('no_rekening'),
                'nama_rekening' => $this->request->getVar('nama_rekening'),
                'logo_bank' => $namafile
            ];

            $this->bankModel->update($id_bank, $data);

            $msg = [
                'sukses' => 'Data bank berhasil disimpan'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_bank()
    {
        if ($this->request->isAJAX()) {
            $id_bank = $this->request->getVar('id_bank');
            $u = $this->bankModel->find($id_bank);
            unlink('img/bank/' . $u['logo_bank']);
            $this->bankModel->hapus($id_bank);
            $msg = [
                'sukses' => "Data bank berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
