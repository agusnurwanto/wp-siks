<?php
global $wpdb;
$api_key = get_option(SIKS_APIKEY);
$url = admin_url('admin-ajax.php');
$maps_all = $this->get_polygon();
$center = $this->get_center();
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
<h1 class="text-center">Peta Sebaran P3KE<br>DESA <?php echo $nama_desa; ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <div style="padding: 10px;margin:0 0 3rem 0;">
        <h1 class="text-center" style="margin:3rem;">Data P3KE<br>DESA <?php echo $nama_desa ?></h1>
        <div class="wrap-table">
            <table id="tableP3kePerDesa" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Aksi</th>
                        <th class="text-center">NIK</th>
                        <th class="text-center">Kartu Keluarga</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Provinsi</th>
                        <th class="text-center">Kabupaten / Kota</th>
                        <th class="text-center">Kecamatan</th>
                        <th class="text-center">Desa</th>
                        <th class="text-center">RT</th>
                        <th class="text-center">RW</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Pekerjaan</th>
                        <th class="text-center">Program</th>
                        <th class="text-center">Penghasilan</th>
                        <th class="text-center">Keterangan</th>
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
            get_data_p3ke_per_desa();
            cari_alamat_siks('<?php echo $default_location; ?>');
        });

        function get_data_p3ke_per_desa() {
            if (typeof tableP3KE === 'undefined') {
                window.tableP3KE = jQuery('#tableP3kePerDesa').on('preXhr.dt', function(e, settings, data) {
                    jQuery("#wrap-loading").show();
                }).DataTable({
                    "processing": true,
                    "serverSide": true,
                    "search": {
                        return: true
                    },
                    "ajax": {
                        url: '<?php echo $url ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'action': 'get_datatable_p3ke',
                            'api_key': '<?php echo $api_key ?>',
                            'desa': '<?php echo $nama_desa ?>',
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
                            "data": 'kk',
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
                            "data": 'alamat',
                            className: "text-center"
                        },
                        {
                            "data": 'pekerjaan',
                            className: "text-center"
                        },
                        {
                            "data": 'program',
                            className: "text-center"
                        },
                        {
                            "data": 'penghasilan',
                            className: "text-center"
                        },
                        {
                            "data": 'keterangan',
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
                tableP3KE.draw();
            }
        }
    </script>
    <script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>