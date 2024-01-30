<?php
global $wpdb;
$api_key = get_option(SIKS_APIKEY);
$url = admin_url('admin-ajax.php');
$center = $this->get_center();
$maps_all = $this->get_polygon();
$nama_desa = null;

if (empty($nama_desa) && is_user_logged_in()) {
    $nama_desa = $_GET['desa'];
} else {
    die('error, coba login ulang');
}

$desa = $wpdb->get_row($wpdb->prepare('
    SELECT
        *
    FROM data_batas_desa_siks
    WHERE desa=%s
        AND active=1
', $nama_desa), ARRAY_A);
$default_location = $this->getSearchLocation($desa);
?>
<style type="text/css">
    .wrap-table {
        overflow: auto;
        max-height: 100vh;
        width: 100%;
    }
</style>
<h1 class="text-center">Peta Sebaran Disabilitas<br>DESA <?= $nama_desa; ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h1 class="text-center" style="margin:3rem;">Tabel Data Disabilitas Desa <?= $nama_desa ?></h1>
    <div class="wrap-table">
        <table id="tableDisabilitasPerDesa" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Aksi</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Nomor Kartu Keluarga</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa</th>
                    <th class="text-center">RT</th>
                    <th class="text-center">RW</th>
                    <th class="text-center">Tempat Lahir</th>
                    <th class="text-center">Tanggal Lahir</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Dokumen Kewarganegaraan</th>
                    <th class="text-center">No Handphone</th>
                    <th class="text-center">Pendidikan Terakhir</th>
                    <th class="text-center">Nama Sekolah</th>
                    <th class="text-center">Keterangan Lulus</th>
                    <th class="text-center">jenis disabilitas</th>
                    <th class="text-center">Keterangan Disabilitas</th>
                    <th class="text-center">Sebab Disabilitas</th>
                    <th class="text-center">Diagnosa Medis</th>
                    <th class="text-center">Penyakit Lain</th>
                    <th class="text-center">Tempat Pengobatan</th>
                    <th class="text-center">Perawat</th>
                    <th class="text-center">Aktivitas</th>
                    <th class="text-center">Aktivitas Bantuan</th>
                    <th class="text-center">Perlu Bantu</th>
                    <th class="text-center">Alat Bantu</th>
                    <th class="text-center">Alat yang Dimiliki</th>
                    <th class="text-center">Kondisi Alat</th>
                    <th class="text-center">Jaminan Kesehatan</th>
                    <th class="text-center">Cara Menggunakan Jamkes</th>
                    <th class="text-center">Jaminan Sosial</th>
                    <th class="text-center">Pekerjaan</th>
                    <th class="text-center">Lokasi Bekerja</th>
                    <th class="text-center">Alasan Tidak Bekerja</th>
                    <th class="text-center">Pendapatan Bulan</th>
                    <th class="text-center">Pengeluaran Bulan</th>
                    <th class="text-center">Pendapatan Lain</th>
                    <th class="text-center">Minat Kerja</th>
                    <th class="text-center">Keterampilan</th>
                    <th class="text-center">Pelatihan yang Diikuti</th>
                    <th class="text-center">Pelatihan yang Diminat</th>
                    <th class="text-center">Status Rumah</th>
                    <th class="text-center">Lantai</th>
                    <th class="text-center">Kamar Mandi</th>
                    <th class="text-center">WC</th>
                    <th class="text-center">Akses ke Lingkungan</th>
                    <th class="text-center">Dinding</th>
                    <th class="text-center">Sarana Air</th>
                    <th class="text-center">Penerangan</th>
                    <th class="text-center">Desa PAUD</th>
                    <th class="text-center">TK di Desa</th>
                    <th class="text-center">Kecamatan SLB</th>
                    <th class="text-center">SD Menerima ABK</th>
                    <th class="text-center">SMP Menerima ABK</th>
                    <th class="text-center">Jumlah Posyandu</th>
                    <th class="text-center">Kader Posyandu</th>
                    <th class="text-center">Layanan Kesehatan</th>
                    <th class="text-center">Sosialitas ke Tetangga</th>
                    <th class="text-center">Keterlibatan Berorganisasi</th>
                    <th class="text-center">Kegiatan Kemasyarakatan</th>
                    <th class="text-center">Keterlibatan Musrembang</th>
                    <th class="text-center">Alat Bantu Bantuan</th>
                    <th class="text-center">Asal Alat Bantu</th>
                    <th class="text-center">Tahun Pemberian</th>
                    <th class="text-center">Bantuan UEP</th>
                    <th class="text-center">Asal UEP</th>
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Lainnya</th>
                    <th class="text-center">Rehabilitas</th>
                    <th class="text-center">Lokasi Rehabilitas</th>
                    <th class="text-center">Tahun Rehabilitas</th>
                    <th class="text-center">Keahlian Khusus</th>
                    <th class="text-center">Prestasi</th>
                    <th class="text-center">Nama Perawat Wali</th>
                    <th class="text-center">Hubungan Dengan PD</th>
                    <th class="text-center">Nomor Handphone PD</th>
                    <th class="text-center">Kelayakan</th>
                    <th class="text-center">Lampiran</th>
                    <th class="text-center">Tahun Anggaran</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
        window.maps_center_siks = <?php echo json_encode($center); ?>;
        jQuery(document).ready(function() {
            get_datatable_disabilitas_per_desa();
            cari_alamat_siks('<?php echo $default_location; ?>');
        })

        function get_datatable_disabilitas_per_desa() {
            if (typeof tableDisabilitas === 'undefined') {
                window.tableDisabilitas = jQuery('#tableDisabilitasPerDesa').on('preXhr.dt', function(e, settings, data) {
                    jQuery("#wrap-loading").show();
                }).DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: '<?php echo $url ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'action': 'get_datatable_disabilitas',
                            'api_key': '<?php echo $api_key ?>',
                            'desa': '<?php echo $nama_desa ?>'
                        }
                    },
                    lengthMenu: [
                        [20, 50, 100, -1],
                        [20, 50, 100, "All"]
                    ],
                    order: [
                        [0, 'asc']
                    ],
                    "drawCallback": function(settings) {
                        jQuery("#wrap-loading").hide();
                    },
                    "columns": [{
                            "data": 'aksi',
                            className: "text-center"
                        },
                        {
                            "data": 'nik',
                            className: "text-center"
                        },
                        {
                            "data": 'nomor_kk',
                            className: "text-center"
                        },
                        {
                            "data": 'nama',
                            className: "text-center"
                        },
                        {
                            "data": 'provinsi',
                            className: "text-center"
                        },
                        {
                            "data": 'kabkot',
                            className: "text-center"
                        },
                        {
                            "data": 'kecamatan',
                            className: "text-center"
                        },
                        {
                            "data": 'desa',
                            className: "text-center"
                        },
                        {
                            "data": 'rt',
                            className: "text-center"
                        },
                        {
                            "data": 'rw',
                            className: "text-center"
                        },
                        {
                            "data": 'tempat_lahir',
                            className: "text-center"
                        },
                        {
                            "data": 'tanggal_lahir',
                            className: "text-center"
                        },
                        {
                            "data": 'gender',
                            className: "text-center"
                        },
                        {
                            "data": 'status',
                            className: "text-center"
                        },
                        {
                            "data": 'dokumen_kewarganegaraan',
                            className: "text-center"
                        },
                        {
                            "data": 'no_hp',
                            className: "text-center"
                        },
                        {
                            "data": 'pendidikan_terakhir',
                            className: "text-center"
                        },
                        {
                            "data": 'nama_sekolah',
                            className: "text-center"
                        },
                        {
                            "data": 'keterangan_lulus',
                            className: "text-center"
                        },
                        {
                            "data": 'jenis_disabilitas',
                            className: "text-center"
                        },
                        {
                            "data": 'keterangan_disabilitas',
                            className: "text-center"
                        },
                        {
                            "data": 'sebab_disabilitas',
                            className: "text-center"
                        },
                        {
                            "data": 'diagnosa_medis',
                            className: "text-center"
                        },
                        {
                            "data": 'penyakit_lain',
                            className: "text-center"
                        },
                        {
                            "data": 'tempat_pengobatan',
                            className: "text-center"
                        },
                        {
                            "data": 'perawat',
                            className: "text-center"
                        },
                        {
                            "data": 'aktivitas',
                            className: "text-center"
                        },
                        {
                            "data": 'aktivitas_bantuan',
                            className: "text-center"
                        },
                        {
                            "data": 'perlu_bantu',
                            className: "text-center"
                        },
                        {
                            "data": 'alat_bantu',
                            className: "text-center"
                        },
                        {
                            "data": 'alat_yang_dimiliki',
                            className: "text-center"
                        },
                        {
                            "data": 'kondisi_alat',
                            className: "text-center"
                        },
                        {
                            "data": 'jaminan_kesehatan',
                            className: "text-center"
                        },
                        {
                            "data": 'cara_menggunakan_jamkes',
                            className: "text-center"
                        },
                        {
                            "data": 'jaminan_sosial',
                            className: "text-center"
                        },
                        {
                            "data": 'pekerjaan',
                            className: "text-center"
                        },
                        {
                            "data": 'lokasi_bekerja',
                            className: "text-center"
                        },
                        {
                            "data": 'alasan_tidak_bekerja',
                            className: "text-center"
                        },
                        {
                            "data": 'pendapatan_bulan',
                            className: "text-center"
                        },
                        {
                            "data": 'pengeluaran_bulan',
                            className: "text-center"
                        },
                        {
                            "data": 'pendapatan_lain',
                            className: "text-center"
                        },
                        {
                            "data": 'minat_kerja',
                            className: "text-center"
                        },
                        {
                            "data": 'keterampilan',
                            className: "text-center"
                        },
                        {
                            "data": 'pelatihan_yang_diikuti',
                            className: "text-center"
                        },
                        {
                            "data": 'pelatihan_yang_diminat',
                            className: "text-center"
                        },
                        {
                            "data": 'status_rumah',
                            className: "text-center"
                        },
                        {
                            "data": 'lantai',
                            className: "text-center"
                        },
                        {
                            "data": 'kamar_mandi',
                            className: "text-center"
                        },
                        {
                            "data": 'wc',
                            className: "text-center"
                        },
                        {
                            "data": 'akses_ke_lingkungan',
                            className: "text-center"
                        },
                        {
                            "data": 'dinding',
                            className: "text-center"
                        },
                        {
                            "data": 'sarana_air',
                            className: "text-center"
                        },
                        {
                            "data": 'penerangan',
                            className: "text-center"
                        },
                        {
                            "data": 'desa_paud',
                            className: "text-center"
                        },
                        {
                            "data": 'tk_di_desa',
                            className: "text-center"
                        },
                        {
                            "data": 'kecamatan_slb',
                            className: "text-center"
                        },
                        {
                            "data": 'sd_menerima_abk',
                            className: "text-center"
                        },
                        {
                            "data": 'smp_menerima_abk',
                            className: "text-center"
                        },
                        {
                            "data": 'jumlah_posyandu',
                            className: "text-center"
                        },
                        {
                            "data": 'kader_posyandu',
                            className: "text-center"
                        },
                        {
                            "data": 'layanan_kesehatan',
                            className: "text-center"
                        },
                        {
                            "data": 'sosialitas_ke_tetangga',
                            className: "text-center"
                        },
                        {
                            "data": 'keterlibatan_berorganisasi',
                            className: "text-center"
                        },
                        {
                            "data": 'kegiatan_kemasyarakatan',
                            className: "text-center"
                        },
                        {
                            "data": 'keterlibatan_musrembang',
                            className: "text-center"
                        },
                        {
                            "data": 'alat_bantu_bantuan',
                            className: "text-center"
                        },
                        {
                            "data": 'asal_alat_bantu',
                            className: "text-center"
                        },
                        {
                            "data": 'tahun_pemberian',
                            className: "text-center"
                        },
                        {
                            "data": 'bantuan_uep',
                            className: "text-center"
                        },
                        {
                            "data": 'asal_uep',
                            className: "text-center"
                        },
                        {
                            "data": 'tahun',
                            className: "text-center"
                        },
                        {
                            "data": 'lainnya',
                            className: "text-center"
                        },
                        {
                            "data": 'rehabilitas',
                            className: "text-center"
                        },
                        {
                            "data": 'lokasi_rehabilitas',
                            className: "text-center"
                        },
                        {
                            "data": 'tahun_rehabilitas',
                            className: "text-center"
                        },
                        {
                            "data": 'keahlian_khusus',
                            className: "text-center"
                        },
                        {
                            "data": 'prestasi',
                            className: "text-center"
                        },
                        {
                            "data": 'nama_perawat_wali',
                            className: "text-center"
                        },
                        {
                            "data": 'hubungan_dengan_pd',
                            className: "text-center"
                        },
                        {
                            "data": 'nomor_hp',
                            className: "text-center"
                        },
                        {
                            "data": 'kelayakan',
                            className: "text-center"
                        },
                        {
                            "data": 'file_lampiran',
                            className: "text-center"
                        },
                        {
                            "data": 'tahun_anggaran',
                            className: "text-center"
                        }
                    ]
                });
            } else {
                tableDisabilitas.draw();
            }
        }
    </script>
    <script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>