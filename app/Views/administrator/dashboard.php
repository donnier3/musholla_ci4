<?= $this->extend('template/administrator') ?>
<?= $this->section('content') ?>
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('msglogin'); ?>"></div>
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Selamat Datang</h2>
                    <h5 class="text-white op-7 mb-2">Di Website <?= ucwords($seting[0]['nama']) ?></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="mt--3">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats bg-primary-gradient card-round border border-white border-5">
                        <div class="card-body" style="cursor: pointer;">
                            <div class="row text-white">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-users"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category text-white">Donatur</p>
                                        <h4 class="card-title text-white"><?= $donatur[0]['Donatur'] ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats bg-warning-gradient card-round border border-white border-5">
                        <div class="card-body" style="cursor: pointer;">
                            <div class="row text-white">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-interface-6"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category text-white">Pengeluaran</p>
                                        <h4 class="card-title text-white">Rp <?= $keluar[0]['jumlah_keluar'] = 0 ? '0' : number_format($keluar[0]['jumlah_keluar'], 0, ',', '.'); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats bg-success-gradient card-round border border-white border-5">
                        <div class="card-body " style="cursor: pointer;">
                            <div class="row text-white">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-analytics"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category text-white">Pemasukan</p>
                                        <h4 class="card-title text-white">Rp <?= count($donasi) != 0 ? number_format($donasi[0]['jumlah_donasi'], 0, ',', '.') : '0'; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats bg-secondary-gradient card-round border border-white border-5">
                        <div class="card-body" style="cursor: pointer;">
                            <div class="row text-white">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-coins"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category text-white">Saldo</p>
                                        <h4 class="card-title text-white">Rp <?= number_format(count($donasi) != 0 ? $donasi[0]['jumlah_donasi'] : '0' - $keluar[0]['jumlah_keluar'], 0, ',', '.'); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                        <div class="card-header text-center">
                            <div class="card-title">Grafik Donasi</div>
                            <div class="text-muted">Periode Tahun <?= date('Y') ?></div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <div id="chartDonut"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                        <div class="card-header text-center">
                            <div class="card-title">Grafik Jumlah Donasi vs Pengeluaran</div>
                            <div class="text-muted">Periode Tahun <?= date('Y') ?></div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <div id="chartLine"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    const flashdata = $('.flash-data').data('flashdata');
    console.log(flashdata);
    if (flashdata) {
        swal.fire({
            toast: true,
            position: 'top',
            icon: 'success',
            title: 'Selamat Datang, ' + flashdata,
            showConfirmButton: false,
            timer: 2000
        });
    }

    Highcharts.chart('chartLine', {
        chart: {
            style: {
                fontFamily: 'Lato'
            }
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Dalam Jutaan'
            }
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                lineWidth: 2.5,
            }
        },
        series: [{
            name: 'Pemasukan',
            color: '#5cb85c ',
            data: [
                <?php foreach ($donasitahun as $dt) :
                    echo "['"  .
                        "'," . $dt->Donasi .
                        "],\n";
                endforeach ?>
            ],
            dataLabels: {
                enabled: true,
                color: '#848484',
                formatter: function() {
                    return Highcharts.numberFormat(this.y / 10000, 0); //Menghilangkan 3 didit di belakang nominal
                },
                y: 0,
            },
        }, {
            name: 'Pengeluaran',
            color: '#f0ad4e',
            data: [
                <?php foreach ($luartahun as $l) :
                    echo "['" .
                        "'," . $l->Pengeluaran .
                        "],\n";
                endforeach ?>
            ],
            dataLabels: {
                enabled: true,
                color: '#848484',
                formatter: function() {
                    return Highcharts.numberFormat(this.y / 1000, 0); //Menghilangkan 3 didit di belakang nominal
                },
                y: 0,
            },
        }]
    });

    Highcharts.chart('chartDonut', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: false,
            plotShadow: false,
            type: 'pie',
            style: {
                fontFamily: 'Lato'
            }
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}<br>: {point.percentage:.1f} %',
                    distance: 2,
                    color: '#848484',
                    shadow: false,
                }
            }
        },
        series: [{
            name: 'Donasi',
            colorByPoint: true,
            innerSize: '50%',
            colors: ['#fdaf4b', '#1d7af3'],
            data: [
                <?php foreach ($cfm as $cfm) :
                    echo "['" . $cfm->Status . "'," . $cfm->Data . "],\n";
                endforeach ?>
            ]
        }]
    });
</script>
<?= $this->endSection() ?>