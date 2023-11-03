<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use \Config\Services;

class Profile extends BaseController
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
        // return view('welcome_message');
        $data = [
            'seting' => $this->setingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
        ];
        return view('/administrator/profile', $data);
    }

    public function ambildataprofile()
    {
        if ($this->request->isAJAX()) {

            $id_user = $_SESSION['id_user'];

            $data = [
                'profile' => $this->usersModel->where('id_user', $id_user)->find(),

            ];

            $msg = [
                'data' => view('/administrator/dataprofile', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updateprofile()
    {
        if ($this->request->isAJAX()) {
            $id_user = $this->request->getVar('id_user');
            $picture = $this->request->getFile('picture');
            if ($picture->getError() == 4) {
                $namapicture = $this->request->getVar('picture_lama');
            } else {
                //nama random
                $namapicture = $picture->getRandomName();
                //pindah ke folder img
                $picture->move('img/profile', $namapicture);
                unlink('img/profile/' . $this->request->getVar('picture_lama'));
                //ambil nama file 
            }

            if ($this->request->getVar('password') == "") {
                $password = $this->request->getVar('password_lama');
            } else {
                $password = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
            }

            $data = [
                'id_user' => $id_user,
                'nama_user' => $this->request->getVar('nama_user'),
                'password' => $password,
                'picture' => $namapicture,
            ];

            $this->usersModel->update($id_user, $data);

            $msg = [
                'sukses' => 'Profile berhasil di update'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
