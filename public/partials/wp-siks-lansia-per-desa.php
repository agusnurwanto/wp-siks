<?php
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
?>
<style type="text/css">
    .wrap-table {
        overflow: auto;
        max-height: 100vh;
        width: 100%;
    }
</style>
<h1 class="text-center">Peta Sebaran Lansia<br>DESA <?= $nama_desa; ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <div style="padding: 10px;margin:0 0 3rem 0;">
        <h1 class="text-center" style="margin:3rem;">Data Lansia Per Desa <?= $nama_desa ?></h1>
        <div class="wrap-table">
            <table id="tableLansiaPerDesa" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">NIK</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Provinsi</th>
                        <th class="text-center">Kabupaten / Kota</th>
                        <th class="text-center">Kecamatan</th>
                        <th class="text-center">Desa</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Tanggal Lahir</th>
                        <th class="text-center">Usia</th>
                        <th class="text-center">Dokumen Kependudukan</th>
                        <th class="text-center">Status Tempat Tinggal</th>
                        <th class="text-center">Status Pemenuhan Kebutuhan</th>
                        <th class="text-center">Status Kehidupan Rumah Tangga</th>
                        <th class="text-center">Status DTKS</th>
                        <th class="text-center">Status Kepersertaan Program Bansos</th>
                        <th class="text-center">Rekomendasi Pendata Lama</th>
                        <th class="text-center">Keterangan Lainnya Lama</th>
                        <th class="text-center">Rekomendasi Pendata</th>
                        <th class="text-center">Keterangan Lainnya</th>
                        <th class="text-center">Lampiran</th>
                        <th class="text-center">Tahun Anggaran</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
        window.maps_center_siks = <?php echo json_encode($center); ?>;
        jQuery(document).ready(function() {
            get_data_lansia();
        });

        function get_data_lansia() {
            if (typeof tableLansia === 'undefined') {
                window.tableLansia = jQuery('#tableLansiaPerDesa').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: '<?php echo $url ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'action': 'get_datatable_lansia',
                            'api_key': '<?php echo $api_key ?>',
                            'desa': '<?= $nama_desa ?>',
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
                        jQuery("#wraploading").hide();
                    },
                    "columns": [{
                            "data": 'nik',
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
                            "data": 'alamat',
                            className: "text-center"
                        },
                        {
                            "data": 'tanggal_lahir',
                            className: "text-center"
                        },
                        {
                            "data": 'usia',
                            className: "text-center"
                        },
                        {
                            "data": 'dokumen_kependudukan',
                            className: "text-center"
                        },
                        {
                            "data": 'status_tempat_tinggal',
                            className: "text-center"
                        },
                        {
                            "data": 'status_pemenuhan_kebutuhan',
                            className: "text-center"
                        },
                        {
                            "data": 'status_kehidupan_rumah_tangga',
                            className: "text-center"
                        },
                        {
                            "data": 'status_dtks',
                            className: "text-center"
                        },
                        {
                            "data": 'status_kepersertaan_program_bansos',
                            className: "text-center"
                        },
                        {
                            "data": 'rekomendasi_pendata_lama',
                            className: "text-center"
                        },
                        {
                            "data": 'keterangan_lainnya_lama',
                            className: "text-center"
                        },
                        {
                            "data": 'rekomendasi_pendata',
                            className: "text-center"
                        },
                        {
                            "data": 'keterangan_lainnya',
                            className: "text-center"
                        },
                        {
                            "data": 'file_lampiran',
                            className: "text-center"
                        },
                        {
                            "data": 'tahun_anggaran',
                            className: "text-center"
                        },

                    ]
                });
            } else {
                tableLansia.draw();
            }
        }
    </script>
    <script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>