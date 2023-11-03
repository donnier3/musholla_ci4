<?php

namespace App\Controllers\Auth;


use App\Models\ModelDonasi;
use App\Models\ModelDonatur;
use App\Models\ModelKonfirmasidonasi;
use App\Models\ModelKeluar;
use App\Models\ModelArtikel;
use App\Models\ModelSeting;
use App\Models\ModelUser;
use \Config\Services;

use App\Controllers\BaseController;

class Administrator extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = Services::request();
        $this->donasiModel = new ModelDonasi($this->request);
        $this->donaturModel = new ModelDonatur();
        $this->konfirmasidonasiModel = new ModelKonfirmasidonasi();
        $this->keluarModel = new ModelKeluar($this->request);
        $this->artikelModel = new ModelArtikel($this->request);
        $this->setingModel = new ModelSeting($this->request);
        $this->usersModel = new ModelUser($this->request);
    }

    public function index()
    {
        $query = $this->db->query("SELECT COUNT(id_donatur) AS Donatur FROM tbl_konfirmasidonasi WHERE bukti_donasi != ''");
        $donatur = $query->getResultArray();

        $q = $this->db->query("SELECT MONTHNAME(tgl_donasi) as Periode, IFNULL(SUM(CASE WHEN YEAR(tgl_donasi) = YEAR(CURDATE()) THEN jumlah_donasi END),0) AS Donasi FROM tbl_donasi LEFT JOIN tbl_konfirmasidonasi ON tbl_konfirmasidonasi.id_donasi = tbl_donasi.id_donasi RIGHT JOIN (SELECT 1 AS idMonth UNION SELECT 2 AS idMonth UNION SELECT 3 AS idMonth UNION SELECT 4 AS idMonth UNION SELECT 5 AS idMonth UNION SELECT 6 AS idMonth UNION SELECT 7 AS idMonth UNION SELECT 8 AS idMonth UNION SELECT 9 AS idMonth UNION SELECT 10 AS idMonth UNION SELECT 11 AS idMonth UNION SELECT 12 AS idMonth) AS Month ON Month.idMonth = MONTH(tgl_donasi) GROUP BY Month.idMonth");
        $donasitahun = $q->getResult();

        $qry = $this->db->query("SELECT CASE WHEN bukti_donasi <> '' THEN 'Sudah Konfirmasi' ELSE 'Belum Konfirmasi' END AS Status, COUNT(bukti_donasi) AS Data FROM tbl_konfirmasidonasi WHERE YEAR(created_at) = YEAR(CURDATE()) GROUP BY Status");
        $cfm = $qry->getResult();

        $p = $this->db->query("SELECT MONTHNAME(tgl_keluar) as Periode, IFNULL(SUM(CASE WHEN YEAR(tgl_keluar) = YEAR(CURDATE()) THEN jumlah_keluar END),0) AS Pengeluaran FROM tbl_pengeluaran RIGHT JOIN (SELECT 1 AS idMonth UNION SELECT 2 AS idMonth UNION SELECT 3 AS idMonth UNION SELECT 4 AS idMonth UNION SELECT 5 AS idMonth UNION SELECT 6 AS idMonth UNION SELECT 7 AS idMonth UNION SELECT 8 AS idMonth UNION SELECT 9 AS idMonth UNION SELECT 10 AS idMonth UNION SELECT 11 AS idMonth UNION SELECT 12 AS idMonth) AS MONTH ON MONTH.idMonth = MONTH(tgl_keluar) GROUP BY MONTH.idMonth");
        $keluar = $p->getResult();

        $data = [
            'seting' => $this->setingModel->getsetting(),
            'profile' => $this->usersModel->getUsers(),
            'donatur' => $donatur,
            'donasi' => $this->donasiModel->totaldonasi(),
            'keluar' => $this->keluarModel->hitungkeluar(),
            'donasitahun' => $donasitahun,
            'cfm' => $cfm,
            'luartahun' => $keluar,
        ];
        // dd($data);
        return view('/administrator/dashboard', $data);
    }
}
