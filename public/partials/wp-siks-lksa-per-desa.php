<?php
global $wpdb;
$api_key = get_option(SIKS_APIKEY);
$url = admin_url('admin-ajax.php');
$center = $this->get_center();
$maps_all = $this->get_polygon();
$nama_kabkot = null;
$nama = null;

if (empty($nama) && is_user_logged_in()) {
    $nama = $_GET['nama'];
} else {
    die('error, coba login ulang');
}

$kabkot = $wpdb->get_row($wpdb->prepare('
    SELECT
        *
    FROM data_batas_desa_siks
    WHERE kab_kot=%s
        AND active=1
', $nama_kabkot), ARRAY_A);

$default_location = $this->getSearchLocation($kabkot);

$nama = $wpdb->get_row($wpdb->prepare('
    SELECT
        *
    FROM data_lksa_siks
    WHERE nama=%s
        AND active=1
', $nama), ARRAY_A);

// print_r($nama); die($wpdb->last_query);

?>
<style type="text/css">
    .wrap-table {
        overflow: auto;
        max-height: 100vh;
        width: 100%;
    }
</style>
<h1 class="text-center">Peta Sebaran<br><?php echo $nama['nama']; ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <div style="padding: 10px;margin:0 0 3rem 0;">
        <h1 class="text-center" style="margin:3rem;">Data<br><?php echo $nama['nama'] ?></h1>
        <div class="wrap-table">
            <table id="tableLKSAPerDesa" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Aksi</th>
                        <th class="text-center">Nama Lembaga</th>
                        <th class="text-center">Kabupaten/Kota</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Ketua Lembaga</th>
                        <th class="text-center">Nomor HP</th>
                        <th class="text-center">Akreditasi</th>
                        <th class="text-center">Anak Dalam LKSA</th>
                        <th class="text-center">Anak Luar LKSA</th>
                        <th class="text-center">Total Anak LKSA</th>
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
            get_data_lksa();
            cari_alamat_siks('<?php echo $default_location; ?>');
        });

        function get_data_lksa() {
            if (typeof tableLKSA === 'undefined') {
                window.tableLKSA = jQuery('#tableLKSAPerDesa').on('preXhr.dt', function(e, settings, data) {
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
                            'action': 'get_datatable_lksa',
                            'api_key': '<?php echo $api_key ?>',
                            'nama': '<?php echo $nama['nama']; ?>'
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
                        var api = this.api();
                        api.rows( {page:'current'} ).data().map(function(b, i){
                            if(b.lat && b.lng){
                                var data = b.aksi.split(", true, '")[1].split("')")[0];
                                setCenterSiks(b.lat, b.lng, true, data, true);
                            }
                        });
                        jQuery("#wrap-loading").hide();
                    },
                    "columns": [{
                            "data": 'aksi',
                            className: "text-center"
                        },
                        {
                            "data": 'nama',
                            className: "text-center"
                        },
                        {
                            "data": 'kabkot',
                            className: "text-center"
                        },
                        {
                            "data": 'alamat',
                            className: "text-center"
                        },
                        {
                            "data": 'ketua',
                            className: "text-center"
                        },
                        {
                            "data": 'no_hp',
                            className: "text-center"
                        },
                        {
                            "data": 'akreditasi',
                            className: "text-center"
                        },
                        {
                            "data": 'anak_dalam_lksa',
                            className: "text-center"
                        },
                        {
                            "data": 'anak_luar_lksa',
                            className: "text-center"
                        },
                        {
                            "data": 'total_anak',
                            className: "text-center"
                        },
                        {
                            "data": 'file_lampiran',
                            className: "text-center"
                        },
                    ]
                });
            } else {
                tableLKSA.draw();
            }
        }
    </script>
    <script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>