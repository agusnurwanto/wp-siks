<?php
$input = shortcode_atts(array(
    'id_desa' => ''
), $atts);
if (empty($input['id_desa'])) {
    die('id_desa kosong');
}

$validate_user = $this->user_authorization($input['id_desa']);
if ($validate_user['status'] === 'error') {
    die($validate_user['message']);
} else {
    echo "<script>console.log('Debug Objects: " . $validate_user['message'] . "' );</script>";
}
global $wpdb;
$center = $this->get_center();
$maps_all = $this->get_polygon();
foreach ($maps_all as $i => $desa) {
    $html = '
        <table>
    ';
    foreach ($desa['data'] as $k => $v) {
        $html .= '
            <tr>
                <td><b>' . $k . '</b></td>
                <td>' . $v . '</td></a>
            </tr>
        ';
    }
    $html .= '</table>';
    $maps_all[$i]['html'] = $html;
}

$desa = $wpdb->get_row(
    $wpdb->prepare('
        SELECT
            *
        FROM data_batas_desa_siks
        WHERE desa=%s
          AND kecamatan=%s
          AND active=1
    ', $validate_user['desa'], $validate_user['kecamatan']),
    ARRAY_A
);
$default_location = $this->getSearchLocation($desa);
?>
<style type="text/css">
    .wrap-table {
        overflow: auto;
        max-height: 100vh;
        width: 100%;
    }
</style>
<h1 class="text-center">Peta Sebaran Penerima Bansos Bunda Kasih<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <div style="padding: 10px;margin:0 0 3rem 0;">
        <h1 class="text-center" style="margin:3rem;">Data Penerima Bansos Bunda Kasih<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>
        <div class="wrap-table">
            <table id="tableBundaKasihPerDesa" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
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
                        <th class="text-center">RT / RW</th>
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
            get_data_bunda_kasih();
            cari_alamat_siks('<?php echo $default_location; ?>');
        });

        function get_data_bunda_kasih() {
            if (typeof tableBundaKasih === 'undefined') {
                window.tableBundaKasih = jQuery('#tableBundaKasihPerDesa').on('preXhr.dt', function(e, settings, data) {
                    jQuery("#wrap-loading").show();
                }).DataTable({
                    "processing": true,
                    "serverSide": true,
                    "search": {
                        return: true
                    },
                    "ajax": {
                        url: ajax.url,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'action': 'get_datatable_bunda_kasih',
                            'api_key': ajax.apikey,
                            'desa': '<?php echo $validate_user['desa']; ?>',
                            'kecamatan': '<?php echo $validate_user['kecamatan']; ?>',
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
                        api.rows({
                            page: 'current'
                        }).data().map(function(b, i) {
                            if (b.lat && b.lng) {
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
                            "data": 'rt_rw',
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
                tableBundaKasih.draw();
            }
        }
    </script>
    <script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>