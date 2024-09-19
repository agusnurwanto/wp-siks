<?php
$validate_user = $this->user_authorization($_GET['desa']);
if ($validate_user['status'] === 'error') {
    die($validate_user['message']);
} else {
    echo "<script>console.log('Debug Objects: " . $validate_user['message'] . "' );</script>";
    $nama_desa = $validate_user['data'];
}

global $wpdb;
$center = $this->get_center();
$maps_all = $this->get_polygon();

$desa = $wpdb->get_row(
    $wpdb->prepare('
        SELECT
            *
        FROM data_batas_desa_siks
        WHERE desa=%s
          AND kecamatan=%s
          AND active=1
    ', $nama_desa, $validate_user['kecamatan']),
    ARRAY_A
);
$default_location = $this->getSearchLocation($desa);
?>
<h1 class="text-center">Peta Sebaran WRSE<br>( Wanita Rawan Sosial Ekonomi )<br>DESA <?php echo $nama_desa; ?></h1>

<div style="padding: 10px;margin:0 0 3rem 0;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h1 class="text-center" style="margin:3rem;">Data WRSE<br>DESA <?php echo $nama_desa ?></h1>
    <table id="tableData" class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center" style="width: 6%;">Aksi</th>
                <th class="text-center" style="width: 12%;">Nama</th>
                <th class="text-center" style="width: 6%;">Usia</th>
                <th class="text-center" style="width: 6%;">Provinsi</th>
                <th class="text-center" style="width: 6%;">Kota / Kabupaten</th>
                <th class="text-center" style="width: 6%;">Kecamatan</th>
                <th class="text-center" style="width: 6%;">Desa / Kelurahan</th>
                <th class="text-center" style="width: 12%;">Alamat</th>
                <th class="text-center" style="width: 6%;">Status DTKS</th>
                <th class="text-center" style="width: 6%;">Status Pernikahan</th>
                <th class="text-center" style="width: 6%;">Mempunyai Usaha</th>
                <th class="text-center" style="width: 10%;">Keterangan</th>
                <th class="text-center" style="width: 6%;">Tahun Anggaran</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>
<script>
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    jQuery(document).ready(function() {
        getDataTable();
        cari_alamat_siks('<?php echo $default_location; ?>');
    });

    function getDataTable() {
        if (typeof tableWrse === 'undefined') {
            window.tableWrse = jQuery('#tableData').on('preXhr.dt', function(e, settings, data) {
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
                        'action': 'get_datatable_data_wrse',
                        'api_key': ajax.apikey,
                        'desa': '<?php echo $nama_desa; ?>',
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
                        "data": 'nama',
                        className: "text-left"
                    },
                    {
                        "data": 'usia',
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
                        "data": 'desa_kelurahan',
                        className: "text-center"
                    },
                    {
                        "data": 'alamat',
                        className: "text-left"
                    },
                    {
                        "data": 'status_dtks',
                        className: "text-center"
                    },
                    {
                        "data": 'status_pernikahan',
                        className: "text-center"
                    },
                    {
                        "data": 'mempunyai_usaha',
                        className: "text-center"
                    },
                    {
                        "data": 'keterangan',
                        className: "text-left"
                    },
                    {
                        "data": 'tahun_anggaran',
                        className: "text-center"
                    }
                ]
            });
        } else {
            tableWrse.draw();
        }
    }
</script>