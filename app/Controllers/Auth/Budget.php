<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\ModelBudget;
use App\Models\ModelDonasi;
use App\Models\ModelSubkategoridonasi;
use \Config\Services;
use App\Models\ModelUser;
use App\Models\ModelSeting;
use DateTime;

class Budget extends BaseController
{
    protected $helpers = ['text', 'form', 'url', 'number'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = Services::request();
        $this->budgetModel = new ModelBudget($this->request);
        $this->donasiModel = new ModelDonasi($this->request);
        $this->subkategoridonasiModel = new ModelSubkategoridonasi($this->request);
        $this->setingModel = new ModelSeting($this->request);
        $this->usersModel = new ModelUser($this->request);
    }


    public function index()
    {
        $data = [
            'seting' => $this->setingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
        ];
        return view('/administrator/budget', $data);
    }

    public function ambildatabudget()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'budget' => $this->budgetModel->getbudget()
            ];

            $msg = [
                'data' => view('/administrator/databudget', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function listbudget()
    {
        if ($this->request->isAJAX()) {
            // $request = \Config\Services::request();
            $list_data = $this->budgetModel;
            $where = ['tbl_budget.id_budget !=' => 0];
            //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
            //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
            $column_order = [NULL, 'tbl_subkategoridonasi.nama_subkategoridonasi', 'tbl_budget.jumlah_budget', 'tbl_budget.tgl_target', NULL];
            $column_search = ['tbl_subkategoridonasi.nama_subkategoridonasi', 'tbl_budget.jumlah_budget', 'tbl_budget.tgl_target'];
            $order = ['tbl_budget.id_budget' => 'asc'];
            $list = $list_data->get_datatables('tbl_budget', $column_order, $column_search, $order, $where);

            $data = [];
            $no = $this->request->getPost("start");
            foreach ($list as $list) {
                $no++;
                $row = [];

                $btnEdit = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Edit \" onclick=\"ajax_edit('" . $list->id_budget . "')\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-edit\"></i></button>";
                $btnDel = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Delete \" onclick=\"ajax_delete('" . $list->id_budget . "','" . $list->nama_subkategoridonasi . "')\" class=\"btn btn-sm btn-danger\"><i class=\"fas fa-trash\"></i></button>";
                // $btnUp = "<button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\" Upload \" onclick=\"ajax_upload('" . $list->id_budget . "')\" class=\"btn btn-sm btn-warning\"><i class=\"fas fa-upload\"></i></button>";

                $pr = round($list->donasi / $list->jumlah_budget * 100);

                if ($pr < 35) {
                    $persen = '<div class="progress progress-lg"><div class="progress-bar progress-bar-striped progress-bar-animated active bg-danger role="progressbar" style="width:' . $pr . '%">' . $pr . ' %</div></div>';
                } elseif ($pr < 75) {
                    $persen = '<div class="progress progress-lg"><div class="progress-bar progress-bar-striped progress-bar-animated active bg-warning role="progressbar" style="width:' . $pr . '%">' . $pr . ' %</div></div>';
                } elseif ($pr > 75) {
                    $persen = '<div class="progress progress-lg"><div class="progress-bar progress-bar-striped progress-bar-animated active bg-success role="progressbar" style="width:' . $pr . '%">' . $pr . ' %</div></div>';
                }

                $tgl = new DateTime($list->tgl_target);
                $now = new DateTime();
                $sisa = $now->diff($tgl);

                $row[] = $no;
                $row[] = ucwords($list->nama_subkategoridonasi);
                $row[] = number_to_currency($list->jumlah_budget, 'IDR');
                $row[] = ($list->donasi == NULL) ? number_to_currency(0, 'IDR') : number_to_currency($list->donasi, 'IDR');
                $row[] = $list->tgl_target;
                $row[] = $sisa->d . ' Hari ' . $sisa->m . ' Bulan ' . $sisa->y . ' Tahun';
                $row[] = $persen;
                $row[] = $btnEdit . " " . $btnDel;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->budgetModel->count_all('tbl_budget', $where),
                "recordsFiltered" => $this->budgetModel->count_filtered('tbl_budget', $column_order, $column_search, $order, $where),
                "data" => $data
            ];
            echo json_encode($output);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function modalTambahbudget()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'sub' => $this->subkategoridonasiModel->getSubkategoridonasi()
            ];
            $msg = [
                'data' => view('/administrator/modalTambahbudget', $data),

            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function tambahbudget()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'id_subkategoridonasi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama program tidak boleh kosong',
                    ]
                ],
                'jumlah_budget' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'Jumlah budget tidak boleh kosong',
                        'numeric' => 'Yang anda input bukan angka'
                    ]
                ],
                'tgl_target' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Target tidak boleh kosong'
                    ]
                ],
                'proposal' => [
                    'rules' => 'uploaded[proposal]|max_size[proposal,2048]|mime_in[proposal,application/pdf,application/force-download,application/x-download]',
                    'errors' => [
                        'uploaded' => 'Proposal masih kosong',
                        'max_size' => 'Ukuran file terlalu besar',
                        'mime_in' => 'Yang anda pilih bukan pdf'
                    ]
                ],
                'img_budget' => [
                    'rules' => 'uploaded[img_budget]|max_size[img_budget,1024]|is_image[img_budget]|mime_in[img_budget,image/jpg,image/jpeg,images/png]',
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
                        'id_subkategoridonasi' => $validation->getError('id_subkategoridonasi'),
                        'jumlah_budget' => $validation->getError('jumlah_budget'),
                        'tgl_target' => $validation->getError('tgl_target'),
                        'proposal' => $validation->getError('proposal'),
                        'img_budget' => $validation->getError('img_budget'),
                    ]
                ];
            } else {
                $berkas = $this->request->getFile('proposal');
                $gambar = $this->request->getFile('img_budget');
                //nama random
                $proposal = $berkas->getRandomName();
                $img = $gambar->getRandomName();
                //pindah ke folder img
                $berkas->move('assets/proposal', $proposal);
                $gambar->move('img/budget', $img);

                $data = [
                    'id_subkategoridonasi' => $this->request->getVar('id_subkategoridonasi'),
                    'jumlah_budget' => $this->request->getVar('jumlah_budget'),
                    'tgl_target' => $this->request->getVar('tgl_target'),
                    'proposal' => $proposal,
                    'img_budget' => $img
                ];
                $this->budgetModel->tambah($data);

                $msg = [
                    'sukses' => 'Data budget berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function editbudget()
    {
        if ($this->request->isAJAX()) {
            $id_budget = $this->request->getVar('id_budget');
            $u = $this->budgetModel->find($id_budget);

            $data = [
                'id_budget' => $u['id_budget'],
                'sub' => $this->subkategoridonasiModel->getSubkategoridonasi(),
                'id_subkategoridonasi' => $u['id_subkategoridonasi'],
                'jumlah_budget' => $u['jumlah_budget'],
                'tgl_target' => $u['tgl_target'],
                'proposal' => $u['proposal'],
                'img_budget' => $u['img_budget'],
            ];

            $msg = [
                'sukses' => view('/administrator/modalEditbudget', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function updatebudget()
    {
        if ($this->request->isAJAX()) {
            $id_budget = $this->request->getVar('id_budget');
            $berkas = $this->request->getFile('proposal');
            $gambar = $this->request->getFile('img_budget');
            if ($berkas->getError() == 4) {
                $proposal = $this->request->getVar('fileLama');
                $img = $this->request->getVar('imgLama');
            } else {
                //nama random
                $proposal = $berkas->getRandomName();
                $img = $gambar->getRandomName();
                //pindah ke folder img
                $berkas->move('assets/proposal', $proposal);
                $gambar->move('img/budget', $img);
                //ambil nama file 
                // $namaSampul = $bukti->getName();
                unlink('assets/proposal/' . $proposal);
                unlink('img/budget' . $this->request->getFile('imgLama'));
            }
            $data = [
                'id_budget' => $id_budget,
                'id_subkategoridonasi' => $this->request->getVar('id_subkategoridonasi'),
                'jumlah_budget' => $this->request->getVar('jumlah_budget'),
                'tgl_target' => $this->request->getVar('tgl_target'),
                'proposal' => $proposal,
                'img_budget' => $img
            ];
            $this->budgetModel->update($id_budget, $data);

            $msg = [
                'sukses' => 'Data budget berhasil diupdate'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }

    public function delete_budget()
    {
        if ($this->request->isAJAX()) {
            $id_budget = $this->request->getVar('id_budget');
            $u = $this->budgetModel->find($id_budget);
            unlink('img/budget/' . $u['img_budget']);
            unlink('assets/proposal/' . $u['proposal']);
            $this->budgetModel->hapus($id_budget);
            $msg = [
                'sukses' => "Data budget berhasil dihapus"
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, perintah tidak dikenali');
        }
    }
}
