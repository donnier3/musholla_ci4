<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use \Config\Services;

class User extends BaseController
{
    protected $helpers = ['text', 'form', 'url'];

    public function __construct()
    {
        $this->request = Services::request();
        $this->usersModel = new ModelUser($this->request);
        $this->setingModel = new ModelSeting($this->request);
    }


    public function index()
    {
        $data = [
            'seting' => $this->setingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
        ];
        return view('/administrator/user', $data);
    }

    public function ambildatauser()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'user' => $this->usersModel->getUsers()
            ];

            $msg = [
                'data' => view('/administrator/datausers', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listusers()
    {
        if ($this->request->isAJAX()) {
            $lists = $this->usersModel->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_user . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
                $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_user . "','" . $list->nama_user . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";

                $row[] = $no;
                $row[] = ucwords($list->nama_user);
                $row[] = $list->username;
                $row[] = ucwords($list->level_user);
                $row[] = ($list->status_user == 0) ? "<span class='badge badge-secondary'> Inactive </span>" : "<span class='badge badge-success'> Active </span>";
                $row[] = $list->created_at;
                $row[] = $btnEdit . " " . $btnDel;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->usersModel->count_all(),
                "recordsFiltered" => $this->usersModel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function modalTambahUsers()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('/administrator/modalTambahUsers'),

            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function tambahUsers()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'username' => [
                    'rules' => 'required|is_unique[tbl_user.username]|valid_email',
                    'errors' => [
                        'required' => 'Email tidak boleh kosong',
                        'is_unique' => 'Email sudah terdaftar',
                        'valid_email' => 'Email harus valid',
                    ]
                ],
                'nama_user' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama tidak boleh kosong'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[6]|alpha_numeric',
                    'errors' => [
                        'required' => 'Password tidak boleh kosong',
                        'min_length' => 'Password terlalu pendek (minimal 6 karakter)',
                        'alpha_numeric' => 'Password harus kombinasi huruf, angka dan simbol'
                    ]
                ],
                'level_user' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Level tidak boleh kosong'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_user' => $validation->getError('nama_user'),
                        'username' => $validation->getError('username'),
                        'password' => $validation->getError('password'),
                        'level_user' => $validation->getError('level_user'),
                    ]
                ];
            } else {
                $password = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
                $data = [
                    'username' => $this->request->getVar('username'),
                    'password' => $password,
                    'level_user' => $this->request->getVar('level_user'),
                    'nama_user' => $this->request->getVar('nama_user'),
                    'picture' => 'default.jpg',
                ];
                $this->usersModel->tambah($data);
                $msg = [
                    'sukses' => 'Data user berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editUsers()
    {
        if ($this->request->isAJAX()) {
            $id_user = $this->request->getVar('id_user');
            $u = $this->usersModel->find($id_user);
            $data = [
                'id_user' => $u['id_user'],
                'username' => $u['username'],
                'nama_user' => $u['nama_user'],
                'level_user' => $u['level_user'],
                'status_user' => $u['status_user']
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditUsers', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updateUsers()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'nama_user' => $this->request->getVar('nama_user'),
                'level_user' => $this->request->getVar('level_user'),
                'status_user' => $this->request->getVar('status_user'),
            ];
            $id_user = $this->request->getVar('id_user');

            $this->usersModel->update($id_user, $data);

            $msg = [
                'sukses' => 'Data user berhasil diupdate'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_user()
    {
        if ($this->request->isAJAX()) {
            $id_user = $this->request->getVar('id_user');
            $this->usersModel->hapus($id_user);
            $msg = [
                'sukses' => "Data user berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
