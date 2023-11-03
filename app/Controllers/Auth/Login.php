<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use DateTime;
use DateTimeZone;
use \Config\Services;

class Login extends BaseController
{
	protected $helpers = ['text', 'form'];
	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->request = Services::request();
		$this->usersModel = new ModelUser($this->request);
		$this->setingModel = new ModelSeting($this->request);
	}

	public function index()
	{
		// return view('welcome_message');
		if (!isset($_SESSION['login_user'])) {
			$data = [
				'seting' => $this->setingModel->getsetting(),
				'profile' => $this->usersModel->getUsers(),
			];
			return view('login', $data);
		} else {
			if ($_SESSION['level_user'] == 'administrator') {
				return redirect()->to('/auth/administrator/dashboard');
			} else if ($_SESSION['level_user'] == 'admin') {
				return redirect()->to('/admin');
			} else if ($_SESSION['level_user'] == 'user') {
				return redirect()->to('/user');
			}
		}
	}

	// public function pswd()
	// {
	// 	echo password_hash('admin', PASSWORD_BCRYPT);
	// }

	public function cek_login()
	{
		if ($this->request->isAJAX()) {

			$validation = \Config\Services::validation();

			if (!$this->validate([
				'email' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Please fill in your username ',
					]
				],
				'password' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Please fill in your password'
					]
				]
			])) {

				$msg = [
					'errors' => [
						'email' => $validation->getError('email'),
						'password' => $validation->getError('password')
					]
				];
			} else {
				$email = $this->request->getVar('email');
				$password = $this->request->getVar('password');

				$cek = $this->db->query("SELECT * FROM tbl_user WHERE username ='$email'");
				$row = $cek->getResult();

				if (count($row) > 0) {
					$u = $cek->getRow();
					$pass = $u->password;

					if (password_verify($password, $pass)) {

						if ($u->status_user == 0) {
							$msg = [
								'error' => "User sudah tidak aktif"
							];
						} else {
							$sesi_user = [
								'id_user' => $u->id_user,
								'username' => $u->username,
								'nama_user' => $u->nama_user,
								'level_user' => $u->level_user,
								'status_user' => $u->status_user,
								'login_user' => TRUE
							];

							session()->set($sesi_user);
							session()->setFlashdata('msglogin', ucwords($u->nama_user));
							$msg = [
								'sukses' => [
									'link' => '/auth/administrator/dashboard'
								]
							];
						}
					} else {
						$msg = [
							'error' => "email atau password salah"
						];
					}
				} else {
					$msg = [
						'error' => "email atau password salah"
					];
				}
			}
			echo json_encode($msg);
		} else {
			exit('Maaf, request tidak dapat diproses');
		}
	}

	public function logout()
	{
		session()->setFlashdata('msglogin', 'logout');

		unset($_SESSION['login_user'], $_SESSION['status_user']);
		return redirect()->to('/auth/login');
	}
}
