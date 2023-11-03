<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelKeluar;
use App\Models\ModelKategorikeluar;
use App\Models\ModelSubkategorikeluar;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use \Config\Services;

class Pengeluaran extends BaseController
{
    protected $helpers = ['text', 'form', 'url', 'number'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = Services::request();
        $this->keluarModel = new ModelKeluar($this->request);
        $this->kategorikeluarModel = new ModelKategorikeluar($this->request);
        $this->subkategorikeluarModel = new ModelSubkategorikeluar($this->request);
        $this->setingModel = new ModelSeting($this->request);
        $this->usersModel = new ModelUser($this->request);
    }

    public function index()
    {
        $data = [
            'seting' => $this->setingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
        ];
        return view('/administrator/pengeluaran', $data);
    }

    public function ambildatapengeluaran()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'pengeluaran' => $this->keluarModel->getpengeluaran()
            ];

            $msg = [
                'data' => view('/administrator/datapengeluaran', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listpengeluaran()
    {
        $list_data = $this->keluarModel;
        $where = ['id_pengeluaran !=' => 0];
        //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
        //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = [NULL, 'tbl_kategorikeluar.nama_kategorikeluar', 'tbl_subkategorikeluar.nama_subkategorikeluar', 'tbl_pengeluaran.jumlah_keluar', 'tbl_pengeluaran.tgl_keluar', NULL];
        $column_search = ['tbl_kategorikeluar.nama_kategorikeluar', 'tbl_subkategorikeluar.nama_subkategorikeluar', 'tbl_pengeluaran.tgl_keluar'];
        $order = ['id_pengeluaran' => 'asc'];
        $list = $list_data->get_datatables('tbl_pengeluaran', $column_order, $column_search, $order, $where);

        // $lists = $this->keluarModel->get_datatables();
        $data = [];
        $no = $this->request->getPost("start");
        foreach ($list as $list) {
            $no++;
            $row = [];

            $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_pengeluaran . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
            $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_pengeluaran . "','" . $list->nama_subkategorikeluar . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";
            // $btnUp = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Upload \" onclick=\"ajax_upload('" . $list->id_pengeluaran . "')\" class=\"btn btn-sm btn-warning\"><i class=\"fas fa-upload\"></i></button>";

            $row[] = $no;
            $row[] = ucwords($list->nama_kategorikeluar);
            $row[] = ucwords($list->nama_subkategorikeluar);
            $row[] = $list->tgl_keluar;
            $row[] = number_to_currency($list->jumlah_keluar, 'IDR');
            $row[] = "<span style='cursor:pointer' class='badge-success badge' onclick='ajax_view($list->id_pengeluaran)'>Lihat Bukti Pengeluaran</span>";
            $row[] = $btnEdit . " " . $btnDel;
            $data[] = $row;
        }
        $output = [
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->keluarModel->count_all('tbl_pengeluaran', $where),
            "recordsFiltered" => $this->keluarModel->count_filtered('tbl_pengeluaran', $column_order, $column_search, $order, $where),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function modalTambahpengeluaran()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'keluar' => $this->kategorikeluarModel->getKategorikeluar(),
                'subkeluar' => $this->subkategorikeluarModel->getSubkategorikeluar()
            ];
            $msg = [
                'data' => view('/administrator/modalTambahpengeluaran', $data),

            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function ambilkategori()
    {
        if ($this->request->isAJAX()) {
            $id_kategorikeluar = $this->request->getVar('id_kategorikeluar');
            $data = $this->subkategorikeluarModel->getidsubkategorikeluar($id_kategorikeluar);

            return $this->response->setJSON($data);
        }
    }

    public function tambahkeluar()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'id_kategorikeluar' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kategori pengeluaran tidak boleh kosong',
                    ]
                ],
                'id_subkategorikeluar' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama pengeluaran tidak boleh kosong',
                    ]
                ],
                'jumlah_keluar' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'Jumlah pengeluaran tidak boleh kosong',
                        'numeric' => 'Jumlah pengeluaran harus angka'
                    ]
                ],
                'tgl_keluar' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal pengeluaran tidak boleh kosong'
                    ]
                ],
                'bukti_keluar' => [
                    'rules' => 'uploaded[bukti_keluar]|max_size[bukti_keluar,1024]|is_image[bukti_keluar]|mime_in[bukti_keluar,image/jpg,image/jpeg,images/png]',
                    'errors' => [
                        'uploaded' => 'Bukti pengeluaran tidak boleh kosong',
                        'max_size' => 'Ukuran gambar terlalu besar',
                        'is_image' => 'Yang anda pilih bukan gambar',
                        'mime_is' => 'Yang anda pilih bukan gambar'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'id_kategorikeluar' => $validation->getError('id_kategorikeluar'),
                        'id_subkategorikeluar' => $validation->getError('id_subkategorikeluar'),
                        'jumlah_keluar' => $validation->getError('jumlah_keluar'),
                        'tgl_keluar' => $validation->getError('tgl_keluar'),
                        'bukti_keluar' => $validation->getError('bukti_keluar'),
                    ]
                ];
            } else {
                $gambar = $this->request->getFile('bukti_keluar');
                if ($gambar->getError() == 4) {
                    $namafile = 'no-images.jpg';
                } else {
                    //nama random
                    $namafile = $gambar->getRandomName();
                    //pindah ke folder img
                    $gambar->move('img/buktipengeluaran', $namafile);
                    //ambil nama file 
                    // $namaSampul = $bukti->getName();
                }

                $data = [
                    'id_kategorikeluar' => $this->request->getVar('id_kategorikeluar'),
                    'id_subkategorikeluar' => $this->request->getVar('id_subkategorikeluar'),
                    'tgl_keluar' => $this->request->getVar('tgl_keluar'),
                    'jumlah_keluar' => $this->request->getVar('jumlah_keluar'),
                    'bukti_keluar' => $namafile
                ];

                $this->keluarModel->tambah($data);

                $msg = [
                    'sukses' => 'Data donasi berhasil disimpan'
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
            $id_pengeluaran = $this->request->getVar('id_pengeluaran');
            $u = $this->keluarModel->find($id_pengeluaran);
            $data = [
                'id_pengeluaran' => $u['id_pengeluaran'],
                'bukti_keluar' => $u['bukti_keluar']
            ];
            $msg = [
                'sukses' => view('/administrator/modalviewbuktikeluar', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editpengeluaran()
    {
        if ($this->request->isAJAX()) {
            $id_pengeluaran = $this->request->getVar('id_pengeluaran');
            $u = $this->keluarModel->find($id_pengeluaran);
            $data = [
                'id_pengeluaran' => $u['id_pengeluaran'],
                'id_kategorikeluar' => $u['id_kategorikeluar'],
                'kategori' => $this->kategorikeluarModel->getKategorikeluar(),
                'id_subkategorikeluar' => $u['id_subkategorikeluar'],
                'subkategori' => $this->subkategorikeluarModel->getSubkategorikeluar(),
                'jumlah_keluar' => $u['jumlah_keluar'],
                'tgl_keluar' => $u['tgl_keluar'],
                'bukti_keluar' => $u['bukti_keluar']
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditkeluar', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updatekeluar()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $id_pengeluaran = $this->request->getVar('id_pengeluaran');
            $valid = $this->validate([
                'id_kategorikeluar' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kategori pengeluaran tidak boleh kosong',
                    ]
                ],
                'jumlah_keluar' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'Jumlah pengeluaran tidak boleh kosong',
                        'numeric' => 'Jumlah pengeluaran harus angka'
                    ]
                ],
                'tgl_keluar' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal pengeluaran tidak boleh kosong'
                    ]
                ],
                'bukti_keluar' => [
                    'rules' => 'max_size[bukti_keluar,1024]|is_image[bukti_keluar]|mime_in[bukti_keluar,image/jpg,image/jpeg,images/png]',
                    'errors' => [
                        'max_size' => 'Ukuran gambar terlalu besar',
                        'is_image' => 'Yang anda pilih bukan gambar',
                        'mime_is' => 'Yang anda pilih bukan gambar'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'jumlah_keluar' => $validation->getError('jumlah_keluar'),
                        'tgl_keluar' => $validation->getError('tgl_keluar'),
                        'bukti_keluar' => $validation->getError('bukti_keluar'),
                    ]
                ];
            } else {
                $gambar = $this->request->getFile('bukti_keluar');
                if ($gambar->getError() == 4) {
                    $namafile = $this->request->getVar('buktiLama');
                } else {
                    //nama random
                    $namafile = $gambar->getRandomName();
                    //pindah ke folder img
                    $gambar->move('img/buktipengeluaran', $namafile);
                    //ambil nama file 
                    // $namaSampul = $bukti->getName();
                    unlink('img/buktipengeluaran/' . $this->request->getVar('buktiLama'));
                }

                $data = [
                    'id_kategorikeluar' => $this->request->getVar('id_kategorikeluar'),
                    'id_subkategorikeluar' => $this->request->getVar('id_subkategorikeluar'),
                    'tgl_keluar' => $this->request->getVar('tgl_keluar'),
                    'jumlah_keluar' => $this->request->getVar('jumlah_keluar'),
                    'bukti_keluar' => $namafile
                ];

                $this->keluarModel->update($id_pengeluaran, $data);

                $msg = [
                    'sukses' => 'Data pengeluaran berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_pengeluaran()
    {
        if ($this->request->isAJAX()) {
            $id_pengeluaran = $this->request->getVar('id_pengeluaran');
            $u = $this->keluarModel->find($id_pengeluaran);
            unlink('img/buktipengeluaran/' . $u['bukti_keluar']);
            $this->keluarModel->hapus($id_pengeluaran);
            $msg = [
                'sukses' => "Data pengeluaran berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
