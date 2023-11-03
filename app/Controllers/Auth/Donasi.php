<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelDonasi;
use App\Models\ModelKategoridonasi;
use App\Models\ModelSubkategoridonasi;
use App\Models\ModelDonatur;
use App\Models\ModelKonfirmasidonasi;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use \Config\Services;

class Donasi extends BaseController
{
    protected $helpers = ['text', 'form', 'url', 'number'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = Services::request();
        $this->donasiModel = new ModelDonasi($this->request);
        $this->kategoridonasiModel = new ModelKategoridonasi($this->request);
        $this->subkategoridonasiModel = new ModelSubkategoridonasi($this->request);
        $this->donaturModel = new ModelDonatur();
        $this->konfirmasidonasiModel = new ModelKonfirmasidonasi();
        $this->setingModel = new ModelSeting($this->request);
        $this->usersModel = new ModelUser($this->request);
    }


    public function index()
    {
        $data = [
            'seting' => $this->setingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
        ];
        return view('/administrator/donasi', $data);
    }

    public function ambildatadonasi()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'donasi' => $this->donasiModel->getDonasi()
            ];

            $msg = [
                'data' => view('/administrator/datadonasi', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listdonasi()
    {
        $request = \Config\Services::request();
        $list_data = $this->donasiModel;
        $where = ['tbl_donasi.id_donasi !=' => 0];
        //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
        //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = [NULL, 'tbl_donatur.nama_donatur', 'tbl_donatur.hp_donatur', 'tbl_kategoridonasi.nama_kategoridonasi', 'tbl_subkategoridonasi.nama_subkategoridonasi', 'tbl_donasi.tgl_donasi', 'tbl_donasi.jumlah_donasi', 'tbl_bank.nama_bank'];
        $column_search = ['tbl_donatur.nama_donatur', 'tbl_donatur.hp_donatur', 'tbl_kategoridonasi.nama_kategoridonasi', 'tbl_subkategoridonasi.nama_subkategoridonasi', 'tbl_bank.nama_bank'];
        $order = ['tbl_donasi.id_donasi' => 'asc'];
        $list = $list_data->get_datatables('tbl_donasi', $column_order, $column_search, $order, $where);

        // $lists = $this->donasiModel->get_datatables();
        $data = [];
        $no = $this->request->getPost("start");
        foreach ($list as $list) {
            $no++;
            $row = [];

            $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_donasi . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
            $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_donasi . "','" . $list->nama_donatur . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";
            // $btnUp = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Upload \" onclick=\"ajax_upload('" . $list->id_donasi . "')\" class=\"btn btn-sm btn-warning\"><i class=\"fas fa-upload\"></i></button>";
            // $btnVal = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Upload \" onclick=\"ajax_upload('" . $list->id_donasi . "')\" class=\"btn btn-sm btn-warning\"><i class=\"fas fa-paper-plane\"></i></button>";

            $row[] = $no;
            $row[] = ucwords($list->nama_donatur);
            $row[] = '+62' . $list->hp_donatur;
            $row[] = ucwords($list->nama_kategoridonasi) . ' - ' . ucwords($list->nama_subkategoridonasi);
            // $row[] = $list->tgl_donasi;
            //$row[] = number_to_currency($list->jumlah_donasi, 'IDR');
            $row[] = $list->jumlah_donasi;
            $row[] = ($list->bukti_donasi == '') ? "<span style='cursor:pointer' class='badge badge-warning' onclick='ajax_upload($list->id_konfirmasidonasi)'> Upload Bukti Transfer </span>" : "<span style='cursor:pointer' class='badge-success badge' onclick='ajax_view($list->id_konfirmasidonasi)'>Lihat Bukti Transfer</span>";
            $row[] = ucwords($list->nama_bank);
            $row[] = $btnEdit . " " . $btnDel;
            $data[] = $row;
        }
        $output = [
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->donasiModel->count_all('tbl_donasi', $where),
            "recordsFiltered" => $this->donasiModel->count_filtered('tbl_donasi', $column_order, $column_search, $order, $where),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function modalTambahdonasi()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'donasi' => $this->kategoridonasiModel->getKategoridonasi(),
                'subdonasi' => $this->subkategoridonasiModel->getSubkategoridonasi()
            ];
            $msg = [
                'data' => view('/administrator/modalTambahdonasi', $data),

            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function ambilkategori()
    {
        if ($this->request->isAJAX()) {
            $id_kategoridonasi = $this->request->getVar('id_kategoridonasi');
            $data = $this->subkategoridonasiModel->getidsubkategoridonasi($id_kategoridonasi);

            return $this->response->setJSON($data);
        }
    }

    public function tambahdonasi()
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
                    'rules' => 'required|numeric|min_length[11]|max_length[12]',
                    'errors' => [
                        'required' => 'Nomor handphone tidak boleh kosong',
                        'numeric' => 'Nomor handphone harus angka',
                        'min_length' => 'Nomor handphone terlalu pendek (minimal 11 digit)',
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
                'tgl_donasi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal donasi tidak boleh kosong'
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
                        'tgl_donasi' => $validation->getError('tgl_donasi'),
                    ]
                ];
            } else {

                $data1 = [
                    'id_kategoridonasi' => $this->request->getVar('id_kategoridonasi'),
                    'id_subkategoridonasi' => $this->request->getVar('id_subkategoridonasi'),
                    'tgl_donasi' => $this->request->getVar('tgl_donasi'),
                    'jumlah_donasi' => $this->request->getVar('jumlah_donasi'),
                    'kode_donasi' => $this->request->getVar('kode_donasi'),
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
                    'sukses' => 'Data donasi berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editdonasi()
    {
        if ($this->request->isAJAX()) {
            $id_donasi = $this->request->getVar('id_donasi');
            $this->builder = $this->db->table('tbl_donasi');
            $this->builder->join('tbl_donatur', 'tbl_donatur.id_donasi=tbl_donasi.id_donasi')
                ->join('tbl_kategoridonasi', 'tbl_kategoridonasi.id_kategoridonasi=tbl_donasi.id_kategoridonasi', 'left')
                ->join('tbl_subkategoridonasi', 'tbl_subkategoridonasi.id_subkategoridonasi=tbl_donasi.id_subkategoridonasi', 'left')
                ->join('tbl_konfirmasidonasi', 'tbl_konfirmasidonasi.id_donasi=tbl_donasi.id_donasi', 'left')
                ->join('tbl_bank', 'tbl_bank.id_bank=tbl_donasi.id_bank')
                ->where('tbl_donasi.id_donasi', $id_donasi);
            $query = $this->builder->get()->getResultArray();
            // $u = $this->donasiModel->find($id_donasi);
            $id_kategoridonasi = $query[0]['id_kategoridonasi'];
            $data = [
                'id_donasi' => $query[0]['id_donasi'],
                'id_donatur' => $query[0]['id_donatur'],
                'id_konfirmasidonasi' => $query[0]['id_konfirmasidonasi'],
                'nama_donatur' => $query[0]['nama_donatur'],
                'id_kategoridonasi' => $query[0]['id_kategoridonasi'],
                'donasi' => $this->kategoridonasiModel->getKategoridonasi(),
                'subkategori' => $this->subkategoridonasiModel->getidsubkategoridonasi($id_kategoridonasi),
                'id_subkategoridonasi' => $query[0]['id_subkategoridonasi'],
                'hp_donatur' => $query[0]['hp_donatur'],
                'jumlah_donasi' => $query[0]['jumlah_donasi'],
                'nama_bank' => $query[0]['nama_bank'],
                'tgl_donasi' => $query[0]['tgl_donasi'],
                'alamat_donatur' => $query[0]['alamat_donatur'],
                'email_donatur' => $query[0]['email_donatur']
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditdonasi', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function uploadbuktidonasi()
    {
        if ($this->request->isAJAX()) {
            $id_konfirmasidonasi = $this->request->getVar('id_konfirmasidonasi');
            $u = $this->konfirmasidonasiModel->find($id_konfirmasidonasi);
            $data = [
                'id_konfirmasidonasi' => $u['id_konfirmasidonasi'],
            ];
            $msg = [
                'sukses' => view('/administrator/modaluploadbuktidonasi', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updatedonasi()
    {
        if ($this->request->isAJAX()) {

            $data1 = [
                'id_kategoridonasi' => $this->request->getVar('id_kategoridonasi'),
                'id_subkategoridonasi' => $this->request->getVar('id_subkategoridonasi'),
                'tgl_donasi' => $this->request->getVar('tgl_donasi'),
                'jumlah_donasi' => $this->request->getVar('jumlah_donasi'),
                'kode_donasi' => $this->request->getVar('kode_donasi'),
            ];
            $id = $this->request->getVar('id_donasi');

            $this->donasiModel->update($id, $data1);

            $data = [
                'id_donasi' => $id,
                'nama_donatur' => $this->request->getVar('nama_donatur'),
                'hp_donatur' => $this->request->getVar('hp_donatur'),
                'email_donatur' => $this->request->getVar('email_donatur'),
                'alamat_donatur' => $this->request->getVar('alamat_donatur')
            ];

            $id_d = $this->request->getVar('id_donatur');

            $this->donaturModel->update($id_d, $data);

            $data2 = [
                'id_donasi' => $id,
                'id_donatur' => $id_d,
            ];

            $id_k = $this->request->getVar('id_konfirmasidonasi');

            $this->konfirmasidonasiModel->update($id_k, $data2);

            // $data = [
            //     'id_kategoridonasi' => $this->request->getVar('id_kategoridonasi'),
            //     'hp_donatur' => $this->request->getVar('hp_donatur'),
            //     'tgl_donasi' => $this->request->getVar('tgl_donasi'),
            //     'jumlah_donasi' => $this->request->getVar('jumlah_donasi'),
            //     'nama_donatur' => $this->request->getVar('nama_donatur'),
            // ];
            // $id_donasi = $this->request->getVar('id_donasi');

            // $this->donasiModel->update($id_donasi, $data);

            $msg = [
                'sukses' => 'Data donasi berhasil diupdate'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function uploaddonasi()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'bukti_donasi' => [
                    'rules' => 'uploaded[bukti_donasi]|max_size[bukti_donasi,1024]|is_image[bukti_donasi]|mime_in[bukti_donasi,image/jpg,image/jpeg,images/png]',
                    'errors' => [
                        'uploaded' => 'Bukti transaksi masih kosong',
                        'max_size' => 'Ukuran file terlalu besar',
                        'is_image' => 'Yang anda pilih bukan gambar',
                        'mime_is' => 'Yang anda pilih bukan gambar'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'bukti_donasi' => $validation->getError('bukti_donasi')
                    ]
                ];
            } else {

                $bukti = $this->request->getFile('bukti_donasi');
                if ($bukti->getError() == 4) {
                    $namafile = '';
                } else {
                    //nama random
                    $namafile = $bukti->getRandomName();
                    //pindah ke folder img
                    $bukti->move('img/buktidonasi', $namafile);
                    //ambil nama file 
                    // $namaSampul = $bukti->getName();
                }

                $data = [
                    'bukti_donasi' => $namafile
                ];

                $id_konfirmasidonasi = $this->request->getVar('id_konfirmasidonasi');

                $this->konfirmasidonasiModel->update($id_konfirmasidonasi, $data);

                $msg = [
                    'sukses' => 'Bukti donasi berhasil di upload'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function viewbukti()
    {
        if ($this->request->isAJAX()) {
            $id_konfirmasidonasi = $this->request->getVar('id_konfirmasidonasi');
            $u = $this->konfirmasidonasiModel->find($id_konfirmasidonasi);
            $data = [
                'id_konfirmasidonasi' => $u['id_konfirmasidonasi'],
                'bukti_donasi' => $u['bukti_donasi']
            ];
            $msg = [
                'sukses' => view('/administrator/modalviewbuktidonasi', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_donasi()
    {
        if ($this->request->isAJAX()) {
            $id_donasi = $this->request->getVar('id_donasi');
            $this->donasiModel->hapus($id_donasi);
            $this->donaturModel->hapus($id_donasi);
            $this->konfirmasidonasiModel->hapus($id_donasi);
            $u = $this->konfirmasidonasiModel->find($id_donasi);
            if (isset($u['bukti_donasi']) != "") {
                unlink('img/buktidonasi/' . $u['bukti_donasi']);
            }
            $msg = [
                'sukses' => "Data donasi berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
