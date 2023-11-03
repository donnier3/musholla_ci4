<?php

namespace App\Controllers;

use App\Models\ModelBudget;
use App\Models\ModelDonasi;
use App\Models\ModelSeting;
use App\Models\ModelKajian;
use App\Models\ModelKategoriartikel;
use App\Models\ModelArtikel;
use App\Models\ModelPesan;
use App\Models\ModelVideo;
use App\Models\ModelMateri;
use App\Models\ModelBank;
use App\Models\ModelKategoridonasi;
use App\Models\ModelSubkategoridonasi;
use App\Models\ModelDonatur;
use App\Models\ModelKonfirmasidonasi;
use App\Models\ModelKomentar;
use App\Models\ModelReply;
use App\Models\ModelUser;
use \Config\Services;

class Home extends BaseController
{
	protected $helpers = ['text', 'form', 'url'];

	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->request = Services::request();
		$this->budgetModel = new ModelBudget($this->request);
		$this->donasiModel = new ModelDonasi($this->request);
		$this->setingModel = new ModelSeting($this->request);
		$this->kajianModel = new ModelKajian($this->request);
		$this->kategoriartikelModel = new ModelKategoriartikel($this->request);
		$this->artikelModel = new ModelArtikel($this->request);
		$this->pesanModel = new ModelPesan($this->request);
		$this->videoModel = new ModelVideo($this->request);
		$this->materiModel = new ModelMateri($this->request);
		$this->bankModel = new ModelBank($this->request);
		$this->kategoridonasiModel = new ModelKategoridonasi($this->request);
		$this->subkategoridonasiModel = new ModelSubkategoridonasi($this->request);
		$this->donaturModel = new ModelDonatur();
		$this->konfirmasidonasiModel = new ModelKonfirmasidonasi();
		$this->komentarModel = new ModelKomentar($this->request);
		$this->replyModel = new ModelReply($this->request);
	}

	public function index()
	{
		$artikel = $this->db->query('SELECT id_artikel,slug_artikel,judul_artikel,isi_artikel,penulis,img_artikel,status_artikel,hits,A.created_at AS posting_date, A.id_kategoriartikel,slug_kategoriartikel,nama_kategoriartikel FROM tbl_artikel AS A LEFT JOIN tbl_kategoriartikel AS B ON B.id_kategoriartikel = A.id_kategoriartikel WHERE status_artikel = 1 ORDER BY A.created_at DESC LIMIT 6');
		$query = $artikel->getResultArray();

		$q = $this->db->query('SELECT *,COUNT(C.id_subkategoridonasi) AS Donatur, SUM(jumlah_donasi) AS Dana,nama_subkategoridonasi as Donasi,tgl_target FROM tbl_budget AS A LEFT JOIN tbl_subkategoridonasi AS B ON B.id_subkategoridonasi=A.id_subkategoridonasi LEFT JOIN tbl_donasi AS C ON C.id_subkategoridonasi=B.id_subkategoridonasi GROUP BY Donasi');
		$donasi = $q->getResultArray();
		// dd($donasi);
		$data = [
			'page' => 'Home',
			'hitungbudget' => $this->budgetModel->hitungbudget(),
			'budget' => $this->budgetModel->getbudget(),
			// 'donasi' => $this->budgetModel->join('tbl_subkategoridonasi', 'tbl_subkategoridonasi.id_subkategoridonasi = tbl_budget.id_subkategoridonasi', 'left')->findAll(),
			'donasi' => $donasi,
			'hitung' => $this->donasiModel->hitungdonasi(),
			'seting' => $this->setingModel->getsetting(),
			'kajian' => $this->kajianModel->orderBy('created_at', 'desc')->findAll($limit = 6),
			'video' => $this->videoModel->orderBy('created_at', 'desc')->findAll($limit = 6),
			'katartikel' => $this->kategoriartikelModel->findAll(),
			// 'artikel' => $this->artikelModel->join('tbl_kategoriartikel', 'tbl_kategoriartikel.id_kategoriartikel=tbl_artikel.id_kategoriartikel', 'right')->where('status_artikel', 1)->orderBy('tbl_artikel.created_at', 'desc')->findAll(),
			'artikel' => $query,
		];

		return view('index', $data);
	}

	public function profile()
	{
		$data = [
			'page' => 'Profile',
			'seting' => $this->setingModel->getsetting(),
		];

		return view('home/profile', $data);
	}

	public function read($slug_artikel)
	{
		$data = [
			'page' => 'Artikel',
			'seting' => $this->setingModel->getsetting(),
			'katartikel' => $this->kategoriartikelModel->findAll(),
			'artikel' => $this->artikelModel->readArtikel($slug_artikel),
			'news' => $this->artikelModel->where('status_artikel', 1)->orderBy('hits', 'desc')->findAll($limit = 5),
		];

		$id_artikel = $data['artikel']->id_artikel;

		$a = [
			'hits' => $data['artikel']->hits + 1
		];

		$this->artikelModel->update($id_artikel, $a);

		if (empty($data['artikel'])) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul artikel ' . $slug_artikel . ' tidak ditemukan');
		}

		return view('home/detail_artikel', $data);
	}

	public function kajian()
	{
		$data = [
			'page' => 'Kajian',
			'seting' => $this->setingModel->getsetting(),
			'katartikel' => $this->kategoriartikelModel->findAll(),
			'kajian' => $this->kategoriartikelModel->join('tbl_kajian', 'tbl_kajian.id_kategoriartikel=tbl_kategoriartikel.id_kategoriartikel')->orderBy('tbl_kajian.created_at', 'desc')->paginate(6, 'kajian'),
			'pager' => $this->kategoriartikelModel->join('tbl_kajian', 'tbl_kajian.id_kategoriartikel=tbl_kategoriartikel.id_kategoriartikel')->orderBy('tbl_kajian.created_at', 'desc')->pager,
		];

		return view('home/kajian', $data);
	}

	public function contact()
	{
		$data = [
			'page' => 'Contact',
			'seting' => $this->setingModel->getsetting(),
		];

		return view('home/contact', $data);
	}

	public function kirim_pesan()
	{
		if ($this->request->isAJAX()) {
			$validation = \Config\Services::validation();
			$valid = $this->validate([
				'nama' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'nama tidak boleh kosong'
					]
				],
				'email' => [
					'rules' => 'required|valid_email',
					'errors' => [
						'required' => 'Email tidak boleh kosong',
						'valid_email' => 'Email tidak valid'
					]
				],
				'subject' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Subject tidak boleh kosong',
					]
				],
				'pesan' => [
					'rules' => 'required|min_length[10]',
					'errors' => [
						'required' => 'Pesan tidak boleh kosong',
						'min_length' => 'Pesan terlalu pendek, minimal 10 karakter'
					]
				]
			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'nama' => $validation->getError('nama'),
						'email' => $validation->getError('email'),
						'subject' => $validation->getError('subject'),
						'pesan' => $validation->getError('pesan'),
					]
				];
			} else {
				$data = [
					'nama' => $this->request->getVar('nama'),
					'email' => $this->request->getVar('email'),
					'subject' => $this->request->getVar('subject'),
					'pesan' => $this->request->getVar('pesan'),
				];

				$this->pesanModel->save($data);

				$msg = [
					'sukses' => 'Terima kasih atas keritik/saran yang anda kirimkan'
				];
			}

			echo json_encode($msg);
		} else {
			exit('Maaf, perintah tidak dikenali');
		}
	}

	public function video()
	{
		$data = [
			'page' => 'Video',
			'seting' => $this->setingModel->getsetting(),
			'katartikel' => $this->kategoriartikelModel->findAll(),
			'video' => $this->kategoriartikelModel->join('tbl_video', 'tbl_video.id_kategoriartikel=tbl_kategoriartikel.id_kategoriartikel')->paginate(6, 'kajian'),
			'pager' => $this->kategoriartikelModel->join('tbl_video', 'tbl_video.id_kategoriartikel=tbl_kategoriartikel.id_kategoriartikel')->pager,
		];

		return view('home/video', $data);
	}

	public function download()
	{
		$data = [
			'page' => 'Download',
			'seting' => $this->setingModel->getsetting(),
			'materi' => $this->materiModel->getmateri(),
		];

		return view('home/download', $data);
	}

	public function listdownload()
	{
		if ($this->request->isAJAX()) {
			$lists = $this->materiModel->get_datatables();
			$data = [];
			$no = $this->request->getPost("start");
			foreach ($lists as $list) {
				$no++;
				$row = [];

				$row[] = $no;
				$row[] = ucwords($list->judul_materi);
				$row[] = ucwords($list->pemateri);
				$row[] = $list->hits . ' Kali';
				// $row[] = "<button type=\"button\" onclick=\"ajax_download('" . $list->id_materi . "')\" class=\"btn btn-sm btn-outline-primary\"><i class=\"fas fa-download\"></i></button>";
				$row[] = "<a class=\"btn btn-xs btn-primary text-white\" href=\"/download/$list->slug_materi\" style=\"text-decoration:none; color:#8d9498;\"><i class=\"fas fa-download\"></i></a>";
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

	public function unduh()
	{
		$id_materi = $this->request->getVar('id_materi');
		$file = $this->materiModel->find($id_materi);

		$a = [
			'hits' => $file[0]['hits'] + 1
		];

		$this->materiModel->update($id_materi, $a);

		return $this->response->download('assets/materi/' . $file[0]['file_materi'], null)
			->setFileName('Materi ' . $file[0]['judul_materi'] . '.pdf');
	}

	public function artikel()
	{
		$data = [
			'page' => 'Artikel',
			'seting' => $this->setingModel->getsetting(),
			'katartikel' => $this->kategoriartikelModel->findAll(),
			'artikel' => $this->kategoriartikelModel->select('*, tbl_artikel.created_at as posting_date')->join('tbl_artikel', 'tbl_artikel.id_kategoriartikel=tbl_kategoriartikel.id_kategoriartikel')->where('status_artikel', 1)->orderBy('tbl_artikel.created_at', 'DESC')->paginate(6, 'artikel'),
			'pager' => $this->kategoriartikelModel->select('*, tbl_artikel.created_at as posting_date')->join('tbl_artikel', 'tbl_artikel.id_kategoriartikel=tbl_kategoriartikel.id_kategoriartikel')->where('status_artikel', 1)->orderBy('tbl_artikel.created_at', 'DESC')->pager,
		];

		return view('home/artikel', $data);
	}

	public function kategoriartikel($slug_kategoriartikel)
	{
		$data = [
			'page' => 'Artikel',
			'seting' => $this->setingModel->getsetting(),
			'kategori' => $this->request->uri->getSegment(3),
			'artikel' => $this->kategoriartikelModel->select('*, tbl_artikel.created_at as posting_date')->join('tbl_artikel', 'tbl_artikel.id_kategoriartikel=tbl_kategoriartikel.id_kategoriartikel')->where(['status_artikel' => 1, 'slug_kategoriartikel' => $slug_kategoriartikel])->orderBy('tbl_artikel.created_at', 'DESC')->paginate(6, 'artikel'),
			'pager' => $this->kategoriartikelModel->select('*, tbl_artikel.created_at as posting_date')->join('tbl_artikel', 'tbl_artikel.id_kategoriartikel=tbl_kategoriartikel.id_kategoriartikel')->where(['status_artikel' => 1, 'slug_kategoriartikel' => $slug_kategoriartikel])->orderBy('tbl_artikel.created_at', 'DESC')->pager,
		];

		return view('home/kategoriartikel', $data);
	}

	public function kategorivideo($slug_kategoriartikel)
	{
		$data = [
			'page' => 'Video',
			'seting' => $this->setingModel->getsetting(),
			'video' => $this->kategoriartikelModel->join('tbl_video', 'tbl_video.id_kategoriartikel=tbl_kategoriartikel.id_kategoriartikel')->where('slug_kategoriartikel', $slug_kategoriartikel)->orderBy('id_video', 'asc')->paginate(6, 'video'),
			'pager' => $this->kategoriartikelModel->join('tbl_video', 'tbl_video.id_kategoriartikel=tbl_kategoriartikel.id_kategoriartikel')->where('slug_kategoriartikel', $slug_kategoriartikel)->orderBy('id_video', 'asc')->pager,
			'kategori' => $this->request->uri->getSegment(3),
		];

		return view('home/kategorivideo', $data);
	}

	public function kategorikajian($slug_kategoriartikel)
	{
		$data = [
			'page' => 'Kajian',
			'seting' => $this->setingModel->getsetting(),
			'kajian' => $this->kategoriartikelModel->join('tbl_kajian', 'tbl_kajian.id_kategoriartikel=tbl_kategoriartikel.id_kategoriartikel')->where('slug_kategoriartikel', $slug_kategoriartikel)->orderBy('id_kajian', 'asc')->paginate(6, 'kajian'),
			'pager' => $this->kategoriartikelModel->join('tbl_kajian', 'tbl_kajian.id_kategoriartikel=tbl_kategoriartikel.id_kategoriartikel')->where('slug_kategoriartikel', $slug_kategoriartikel)->orderBy('id_kajian', 'asc')->pager,
			'kategori' => $this->request->uri->getSegment(3),
		];

		return view('home/kategorikajian', $data);
	}

	public function donasi()
	{
		$data = [
			'page' => 'Donasi',
			'seting' => $this->setingModel->getsetting(),
			'donasi' => $this->kategoridonasiModel->where('jenis_kategoridonasi', 1)->getKategoridonasi(),
			'bank' => $this->bankModel->getbank(),
		];

		return view('home/donasi', $data);
	}

	public function kirim_donasi()
	{
		if ($this->request->isAJAX()) {
			$validation = \Config\Services::validation();
			$valid = $this->validate([
				'nama_donatur' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Nama donatur tidak boleh kosong',
					]
				],
				'email_donatur' => [
					'rules' => 'required|valid_email',
					'errors' => [
						'required' => 'Email tidak boleh kosong',
						'valid_email' => 'Masukan email yang valid'
					]
				],
				'id_kategoridonasi' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Jenis donasi tidak boleh kosong'
					]
				],
				'id_subkategoridonasi' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Keterangan donasi tidak boleh kosong'
					]
				],
				'hp_donatur' => [
					'rules' => 'required|numeric|min_length[10]|max_length[12]',
					'errors' => [
						'required' => 'Nomor handphone tidak boleh kosong',
						'numeric' => 'Nomor handphone harus angka',
						'min_length' => 'Nomor handphone terlalu pendek (minimal 10 digit)',
						'max_length' => 'Nomor handphone terlalu panjang (maksimal 12 digit)',
					]
				],
				'jumlah_donasi' => [
					'rules' => 'required|numeric',
					'errors' => [
						'required' => 'Jumlah donasi tidak boleh kosong',
						'numeric' => 'Jumlah donasi harus angka'
					]
				],
				'id_bank' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Pilih metode pembayaran'
					]
				]
			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'nama_donatur' => $validation->getError('nama_donatur'),
						'email_donatur' => $validation->getError('email_donatur'),
						'id_kategoridonasi' => $validation->getError('id_kategoridonasi'),
						'hp_donatur' => $validation->getError('hp_donatur'),
						'jumlah_donasi' => $validation->getError('jumlah_donasi'),
						'id_bank' => $validation->getError('id_bank'),
					]
				];
			} else {
				$kode = $this->request->getVar('kode_donasi');
				$data1 = [
					'id_kategoridonasi' => $this->request->getVar('id_kategoridonasi'),
					'id_subkategoridonasi' => $this->request->getVar('id_subkategoridonasi'),
					'jumlah_donasi' => $this->request->getVar('jumlah_donasi'),
					'id_bank' => $this->request->getVar('id_bank'),
					'kode_donasi' => $kode,
				];

				$id_donasi = $this->donasiModel->insert($data1);

				$data = [
					'id_donasi' => $id_donasi,
					'nama_donatur' => $this->request->getVar('nama_donatur'),
					'hp_donatur' => $this->request->getVar('hp_donatur'),
					'email_donatur' => $this->request->getVar('email_donatur'),
					'alamat_donatur' => $this->request->getVar('alamat_donatur')
				];

				$id_donatur = $this->donaturModel->insert($data);

				$data2 = [
					'id_donasi' => $id_donasi,
					'id_donatur' => $id_donatur,
				];

				$this->konfirmasidonasiModel->insert($data2);

				$msg = [
					'sukses' => 'Data donasi berhasil disimpan',
					'link' => '/donasi/validation/' . $kode,
				];
			}
			echo json_encode($msg);
		} else {
			exit('Maaf, perintah tidak dikenali');
		}
	}

	public function validasi_donasi($kode)
	{
		$u = $this->donasiModel->join('tbl_donatur', 'tbl_donatur.id_donasi=tbl_donasi.id_donasi', 'left')
			->join('tbl_kategoridonasi', 'tbl_kategoridonasi.id_kategoridonasi=tbl_donasi.id_kategoridonasi', 'left')
			->join('tbl_subkategoridonasi', 'tbl_subkategoridonasi.id_subkategoridonasi=tbl_donasi.id_subkategoridonasi', 'left')
			->join('tbl_bank', 'tbl_bank.id_bank=tbl_donasi.id_bank', 'left')
			->where('tbl_donasi.kode_donasi', $kode)
			->first();

		$data = [
			'page' => 'Video',
			'seting' => $this->setingModel->getsetting(),
			'id_donasi' => $u['id_donasi'],
			'id_kategoridonasi' => $u['id_kategoridonasi'],
			'nama_kategoridonasi' => $u['nama_kategoridonasi'],
			'nama_subkategoridonasi' => $u['nama_subkategoridonasi'],
			'kode_donasi' => $u['kode_donasi'],
			'jumlah_donasi' => $u['jumlah_donasi'],
			'nama_donatur' => $u['nama_donatur'],
			'nama_bank' => $u['nama_bank'],
			'no_rekening' => $u['no_rekening'],
			'kode_bank' => $u['kode_bank'],
			'nama_rekening' => $u['nama_rekening'],
			'email_donatur' => $u['email_donatur'],
			'hp_donatur' => $u['hp_donatur'],
			'alamat_donatur' => $u['alamat_donatur'],
			'created_at' => $u['created_at'],
		];

		return view('home/page_validasi', $data);
	}

	public function konfirmasidonasi()
	{
		$data = [
			'page' => 'Konfirmasi',
			'seting' => $this->setingModel->getsetting(),
			'validation' => \Config\Services::validation()
		];

		return view('home/konfirmasi', $data);
	}

	public function getkonfirmasi()
	{
		if ($this->request->isAJAX()) {
			$kode_donasi = $this->request->getVar('kode_donasi');
			$validation = \Config\Services::validation();
			$valid = $this->validate([
				'kode_donasi' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Kode donasi tidak boleh kosong',
					]
				]
			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'kode_donasi' => $validation->getError('kode_donasi'),
					]
				];
			} else {
				$cek = $this->db->query("SELECT * FROM tbl_donasi WHERE kode_donasi ='$kode_donasi'");
				$row = $cek->getResult();

				if (count($row) > 0) {
					$msg = [
						// 'link' => '/konfirmasi-donasi/' . $kode_donasi,
						'link' => "/konfirmasi-donasi/kode=$kode_donasi",
					];
				} else {
					$msg = [
						'eror' => [
							'kode_donasi' => 'Kode ' . '<strong>' . $kode_donasi . '</strong>' . ' tidak ditemukan'
						]
					];
				}
			}
			echo json_encode($msg);
		} else {
			exit('Maaf, perintah tidak dikenali');
		}
	}

	public function getformkonfirmasi($kode_donasi)
	{
		$u = $this->donasiModel->join('tbl_donatur', 'tbl_donatur.id_donasi=tbl_donasi.id_donasi', 'left')
			->join('tbl_kategoridonasi', 'tbl_kategoridonasi.id_kategoridonasi=tbl_donasi.id_kategoridonasi', 'left')
			->join('tbl_subkategoridonasi', 'tbl_subkategoridonasi.id_subkategoridonasi=tbl_donasi.id_subkategoridonasi', 'left')
			->join('tbl_bank', 'tbl_bank.id_bank=tbl_donasi.id_bank', 'left')
			->join('tbl_konfirmasidonasi', 'tbl_konfirmasidonasi.id_donasi=tbl_donasi.id_donasi')
			->where('tbl_donasi.kode_donasi', $kode_donasi)
			->first();

		$data = [
			'page' => '',
			'seting' => $this->setingModel->getsetting(),
			'id_donasi' => $u['id_donasi'],
			'id_kategoridonasi' => $u['id_kategoridonasi'],
			'id_konfirmasidonasi' => $u['id_konfirmasidonasi'],
			'nama_kategoridonasi' => $u['nama_kategoridonasi'],
			'nama_subkategoridonasi' => $u['nama_subkategoridonasi'],
			'kode_donasi' => $u['kode_donasi'],
			'jumlah_donasi' => $u['jumlah_donasi'],
			'nama_donatur' => $u['nama_donatur'],
			'nama_bank' => $u['nama_bank'],
			'no_rekening' => $u['no_rekening'],
			'kode_bank' => $u['kode_bank'],
			'nama_rekening' => $u['nama_rekening'],
			'email_donatur' => $u['email_donatur'],
			'hp_donatur' => $u['hp_donatur'],
			'alamat_donatur' => $u['alamat_donatur'],
			'bukti_donasi' => $u['bukti_donasi'],
			'tgl_donasi' => $u['tgl_donasi'],
		];

		return view('home/formkonfirmasi', $data);
	}

	public function kirim_bukti()
	{
		if ($this->request->isAJAX()) {
			$id_donasi = $this->request->getVar('id_donasi');
			$id_konfirmasidonasi = $this->request->getVar('id_konfirmasidonasi');
			$validation = \Config\Services::validation();
			$valid = $this->validate([
				'tgl_donasi' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Tanggal donasi tidak boleh kosong',
					]
				],
				'bukti_donasi' => [
					'rules' => 'uploaded[bukti_donasi]|max_size[bukti_donasi,1024]|is_image[bukti_donasi]|mime_in[bukti_donasi,image/jpg,image/jpeg,images/png]',
					'errors' => [
						'uploaded' => 'Bukti donasi tidak boleh kosong',
						'max_size' => 'Ukuran gambar terlalu besar',
						'is_image' => 'Yang anda pilih bukan gambar',
						'mime_is' => 'Yang anda pilih bukan gambar'
					]
				]
			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'tgl_donasi' => $validation->getError('tgl_donasi'),
						'bukti_donasi' => $validation->getError('bukti_donasi'),
					]
				];
			} else {

				$gambar = $this->request->getFile('bukti_donasi');
				if ($gambar->getError() == 4) {
					$namafile = 'default.jpg';
				} else {
					//nama random
					$namafile = $gambar->getRandomName();
					//pindah ke folder img
					$gambar->move('img/buktidonasi', $namafile);
					//ambil nama file 
					// $namaSampul = $bukti->getName();
				}

				$data = [
					'tgl_donasi' => $this->request->getVar('tgl_donasi'),
					'bukti_donasi' => $namafile,
				];

				$this->konfirmasidonasiModel->update($id_konfirmasidonasi, $data);

				$msg = [
					'sukses' => 'Bukti donasi berhasil disimpan',
					'link' => '/donasi'
				];
			}
			echo json_encode($msg);
		} else {
			exit('Maaf, perintah tidak dikenali');
		}
	}

	public function donasi_spesifik($slug_subkategoridonasi)
	{
		$sub = $this->subkategoridonasiModel->where('slug_subkategoridonasi', $slug_subkategoridonasi)->first();
		$data = [
			'page' => 'Donasi',
			'seting' => $this->setingModel->getsetting(),
			'donasi' => $this->kategoridonasiModel->where(['jenis_kategoridonasi' => 1, 'id_kategoridonasi' => $sub['id_kategoridonasi']])->getKategoridonasi(),
			'sub' => $sub,
			'bank' => $this->bankModel->getbank(),
		];

		// dd($data['donasi']);

		return view('home/donasi_spesifik', $data);
	}

	public function invoice($filename = "Dokumen.pdf", $options = ["Attachment" => 1])
	{
		$dompdf = new \Dompdf\Dompdf();
		$kode_donasi = $this->request->uri->getSegment(4);
		$kode = substr($kode_donasi, 5);
		$u = $this->donasiModel->join('tbl_donatur', 'tbl_donatur.id_donasi=tbl_donasi.id_donasi', 'left')
			->join('tbl_kategoridonasi', 'tbl_kategoridonasi.id_kategoridonasi=tbl_donasi.id_kategoridonasi', 'left')
			->join('tbl_subkategoridonasi', 'tbl_subkategoridonasi.id_subkategoridonasi=tbl_donasi.id_subkategoridonasi', 'left')
			->join('tbl_bank', 'tbl_bank.id_bank=tbl_donasi.id_bank', 'left')
			->join('tbl_konfirmasidonasi', 'tbl_konfirmasidonasi.id_donasi=tbl_donasi.id_donasi')
			->where('tbl_donasi.kode_donasi', $kode)
			->first();

		$icon = $this->setingModel->findColumn('icon');
		$image = file_get_contents('./img/setting/' . $icon[0]);
		$data = [
			'id_donasi' => $u['id_donasi'],
			'seting' => $this->setingModel->getsetting(),
			'id_kategoridonasi' => $u['id_kategoridonasi'],
			'id_konfirmasidonasi' => $u['id_konfirmasidonasi'],
			'nama_kategoridonasi' => $u['nama_kategoridonasi'],
			'nama_subkategoridonasi' => $u['nama_subkategoridonasi'],
			'kode_donasi' => $u['kode_donasi'],
			'jumlah_donasi' => $u['jumlah_donasi'],
			'nama_donatur' => $u['nama_donatur'],
			'nama_bank' => $u['nama_bank'],
			'no_rekening' => $u['no_rekening'],
			'kode_bank' => $u['kode_bank'],
			'nama_rekening' => $u['nama_rekening'],
			'email_donatur' => $u['email_donatur'],
			'hp_donatur' => $u['hp_donatur'],
			'alamat_donatur' => $u['alamat_donatur'],
			'bukti_donasi' => $u['bukti_donasi'],
			'tgl_donasi' => $u['tgl_donasi'],
			'icon' => '<img src="data:image/png;base64,' . base64_encode($image) . '"  width="80" />',
			'created_at' => $u['created_at'],
		];

		$template = view('home/invoice', $data);

		$dompdf->loadHtml($template);
		$dompdf->setPaper('A5', 'potrait');
		$dompdf->render();
		$dompdf->stream($filename, $options);
	}

	public function kirim_komentar()
	{
		if ($this->request->isAJAX()) {
			$validation = \Config\Services::validation();
			$valid = $this->validate([
				'nama' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'nama tidak boleh kosong'
					]
				],
				'email' => [
					'rules' => 'required|valid_email',
					'errors' => [
						'required' => 'Email tidak boleh kosong',
						'valid_email' => 'Email tidak valid'
					]
				],
				'komentar' => [
					'rules' => 'required|min_length[10]',
					'errors' => [
						'required' => 'Komentar tidak boleh kosong',
						'min_length' => 'Komentar terlalu pendek, minimal 10 karakter'
					]
				]
			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'nama' => $validation->getError('nama'),
						'email' => $validation->getError('email'),
						'komentar' => $validation->getError('komentar'),
					]
				];
			} else {
				$data = [
					'parent_id_komentar' => $this->request->getVar('parent_id_komentar'),
					'id_artikel' => $this->request->getVar('id_artikel'),
					'nama' => $this->request->getVar('nama'),
					'email' => $this->request->getVar('email'),
					'komentar' => $this->request->getVar('komentar'),
				];

				$this->komentarModel->save($data);

				$msg = [
					'sukses' => 'Komentar berhasil di kirim'
				];
			}

			echo json_encode($msg);
		} else {
			exit('Maaf, perintah tidak dikenali');
		}
	}

	public function getkomentar()
	{
		// if ($this->request->isAJAX()) {
		$id_artikel = $this->request->getVar('id_artikel');

		$kom = $this->komentarModel->getJml($id_artikel);
		$id = $this->komentarModel->getId($id_artikel);
		$jml = $kom->jmlkom + $id->jmlrep;

		$data = [
			'komentar' => $this->komentarModel->where('id_artikel', $id_artikel)->findAll(),
			'hitung' => $jml,
			'reply' => $this->replyModel->findAll(),
		];

		$msg = [
			'data' => view('/home/viewkomentar', $data)
		];

		echo json_encode($msg);
		// } else {
		// 	exit('Maaf, perintah tidak dikenali');
		// }
	}

	public function getreply()
	{
		if ($this->request->isAJAX()) {
			$parent_id_komentar = $this->request->getVar('parent_id_komentar');
			$data = [
				'reply' => $this->komentarModel->where('parent_id_komentar', $parent_id_komentar)->findAll(),
			];

			$msg = [
				'data' => view('/home/viewreply', $data)
			];

			echo json_encode($data);
		} else {
			exit('Maaf, perintah tidak dikenali');
		}
	}

	public function kirim_balasan()
	{
		if ($this->request->isAJAX()) {
			$validation = \Config\Services::validation();
			$valid = $this->validate([
				'nama' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'nama tidak boleh kosong'
					]
				],
				'email' => [
					'rules' => 'required|valid_email',
					'errors' => [
						'required' => 'Email tidak boleh kosong',
						'valid_email' => 'Email tidak valid'
					]
				],
				'komentar' => [
					'rules' => 'required|min_length[10]',
					'errors' => [
						'required' => 'Komentar tidak boleh kosong',
						'min_length' => 'Komentar terlalu pendek, minimal 10 karakter'
					]
				]
			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'nama' => $validation->getError('nama'),
						'email' => $validation->getError('email'),
						'komentar' => $validation->getError('komentar'),
					]
				];
			} else {
				$data = [
					'id_komentar' => $this->request->getVar('id_komentar'),
					'nama' => $this->request->getVar('nama'),
					'email' => $this->request->getVar('email'),
					'komentar' => $this->request->getVar('komentar'),
				];

				$this->replyModel->save($data);

				$msg = [
					'sukses' => 'Komentar berhasil di kirim'
				];
			}

			echo json_encode($msg);
		} else {
			exit('Maaf, perintah tidak dikenali');
		}
	}
}
