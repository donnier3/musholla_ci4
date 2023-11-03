<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelSeting;
use App\Models\ModelUser;
use \Config\Services;

class Setting extends BaseController
{
    protected $helpers = ['text', 'form'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = Services::request();
        $this->settingModel = new ModelSeting($this->request);
        $this->usersModel = new ModelUser($this->request);
    }


    public function index()
    {
        $data = [
            'setting' => $this->settingModel->findAll(),
            'seting' => $this->settingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
        ];

        return view('/administrator/setting', $data);
    }

    public function ambildatasetting()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'setting' => $this->settingModel->findAll()
            ];

            $msg = [
                'data' => view('/administrator/datasetting', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updatesetting()
    {
        if ($this->request->isAJAX()) {
            $id_setting = $this->request->getVar('id_setting');
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama tidak boleh kosong'
                    ]
                ],
                'about_me' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'About me tidak boleh kosong'
                    ]
                ],
                'email' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Email tidak boleh kosong'
                    ]
                ],
                'phone' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Telepon tidak boleh kosong'
                    ]
                ],
                'address' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat tidak boleh kosong'
                    ]
                ],
                'visi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Visi tidak boleh kosong'
                    ]
                ],
                'misi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Misi tidak boleh kosong'
                    ]
                ],
                'icon' => [
                    'rules' => 'max_size[icon,1024]|is_image[icon]|mime_in[icon,image/jpg,image/jpeg,images/png]',
                    'errors' => [
                        'max_size' => 'Ukuran file terlalu besar',
                        'is_image' => 'Yang anda pilih bukan gambar',
                        'mime_is' => 'Yang anda pilih bukan gambar'
                    ]
                ],
                'images' => [
                    'rules' => 'max_size[images,1024]|is_image[images]|mime_in[images,image/jpg,image/jpeg,images/png]',
                    'errors' => [
                        'max_size' => 'Ukuran file terlalu besar',
                        'is_image' => 'Yang anda pilih bukan gambar',
                        'mime_is' => 'Yang anda pilih bukan gambar'
                    ]
                ],
                'maps' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Lokasi google maps tidak boleh kosong'
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'about_me' => $validation->getError('about_me'),
                        'address' => $validation->getError('address'),
                        'email' => $validation->getError('email'),
                        'phone' => $validation->getError('phone'),
                        'visi' => $validation->getError('visi'),
                        'misi' => $validation->getError('misi'),
                        'icon' => $validation->getError('icon'),
                        'images' => $validation->getError('images'),
                        'maps' => $validation->getError('maps'),
                    ]
                ];
            } else {

                $icon = $this->request->getFile('icon');
                $images = $this->request->getFile('images');
                if ($icon->getError() == 4 && $images->getError() == 4) {
                    $namaicon = $this->request->getVar('icon_lama');
                    $namaimages = $this->request->getVar('images_lama');
                } else {
                    //nama random
                    $namaicon = $icon->getRandomName();
                    $namaimages = $images->getRandomName();
                    //pindah ke folder img
                    $icon->move('img/setting', $namaicon);
                    unlink('img/setting/' . $namaicon);
                    $images->move('img/setting', $namaimages);
                    unlink('img/setting/' . $namaimages);
                    //ambil nama file 
                }

                $data = [
                    'id_setting' => $id_setting,
                    'nama' => $this->request->getVar('nama'),
                    'about_me' => $this->request->getVar('about_me'),
                    'address' => $this->request->getVar('address'),
                    'email' => $this->request->getVar('email'),
                    'phone' => $this->request->getVar('phone'),
                    'visi' => $this->request->getVar('visi'),
                    'misi' => $this->request->getVar('misi'),
                    'maps' => $this->request->getVar('maps'),
                    'fb' => $this->request->getVar('fb'),
                    'ig' => $this->request->getVar('ig'),
                    'tw' => $this->request->getVar('tw'),
                    // 'icon' => $namaicon,
                    // 'images' => $namaimages,
                ];

                $this->settingModel->update($id_setting, $data);

                $msg = [
                    'sukses' => 'Aplikasi berhasil di setting'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
