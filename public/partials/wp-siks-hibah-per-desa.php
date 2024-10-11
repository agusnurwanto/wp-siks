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
<h1 class="text-center">Peta Sebaran Penerima Hibah<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>

<div style="padding: 10px;margin:0 0 3rem 0;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h1 class="text-center" style="margin:3rem;">Data Penerima Hibah<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>
    <table id="tableData" class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center" style="width: 6%;">Aksi</th>
                <th class="text-center" style="width: 6%;">Kode</th>
                <th class="text-center" style="width: 12%;">Penerima</th>
                <th class="text-center" style="width: 12%;">Nama dan NIK Ketua</th>
                <th class="text-center" style="width: 8%;">Provinsi</th>
                <th class="text-center" style="width: 8%;">Kabupaten/Kota</th>
                <th class="text-center" style="width: 8%;">Kecamatan</th>
                <th class="text-center" style="width: 8%;">Desa/Kelurahan</th>
                <th class="text-center" style="width: 12%;">Alamat</th>
                <th class="text-center" style="width: 8%;">Anggaran</th>
                <th class="text-center" style="width: 6%;">Status Realisasi</th>
                <th class="text-center" style="width: 10%;">Peruntukan</th>
                <th class="text-center" style="width: 10%;">Keterangan</th>
                <th class="text-center" style="width: 6%;">Tahun Anggaran</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script>
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    jQuery(document).ready(function() {
        getDataTable();
        cari_alamat_siks('<?php echo $default_location; ?>');
    });

    function getDataTable() {
        if (typeof tableHibah === 'undefined') {
            window.tableHibah = jQuery('#tableData').on('preXhr.dt', function(e, settings, data) {
                jQuery("#wrap-loading").show();
            }).DataTable({
                "processing": true,
                "serverSide": true,
                "scrollX": true, // Enables horizontal scrolling
                "scrollY": '600px', // Enables vertical scrolling
                "scrollCollapse": true,
                "search": {
                    return: true
                },
                "ajax": {
                    url: ajax.url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'action': 'get_datatable_data_hibah',
                        'api_key': ajax.apikey,
                        'desa': '<?php echo $validate_user['desa']; ?>',
                        'kecamatan': '<?php echo $validate_user['kecamatan']; ?>',
                    }
                },
                lengthMenu: [
                    [20, 50, 100, -1],
                    [20, 50, 100, "All"]
                ],
                order: [],
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
                        "data": 'kode',
                        className: "text-center"
                    },
                    {
                        "data": 'penerima',
                        className: "text-left"
                    },
                    {
                        "data": 'nama_nik_ketua',
                        className: "text-left"
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
                        "data": 'desa_kelurahan',
                        className: "text-center"
                    },
                    {
                        "data": 'alamat',
                        className: "text-left"
                    },
                    {
                        "data": 'anggaran',
                        className: "text-right"
                    },
                    {
                        "data": 'status_realisasi',
                        className: "text-center"
                    },
                    {
                        "data": 'peruntukan',
                        className: "text-left"
                    },
                    {
                        "data": 'keterangan',
                        className: "text-center"
                    },
                    {
                        "data": 'tahun_anggaran',
                        className: "text-left"
                    }
                ]
            });
        } else {
            tableHibah.draw();
        }
    }
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>