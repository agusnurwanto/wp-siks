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
<style>
    .wrap-table {
        overflow: auto;
        max-height: 100vh;
        width: 100%;
    }
</style>
<h1 class="text-center">Peta Sebaran DTKS<br>( Data Terpadu Kesejahteraan Sosial )<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>
<div style="padding: 10px;margin:0 0 3rem 0;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h1 class="text-center" style="margin:3rem;">Data DTKS<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>
    <div class="wrap-table">
        <table id="tableData" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">No KK</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa/Kelurahan</th>
                    <th class='text-center'>Atensi</th>
                    <th class='text-center'>BLT</th>
                    <th class='text-center'>BLT BBM</th>
                    <th class='text-center'>BNPT PPKM</th>
                    <th class='text-center'>BPNT</th>
                    <th class='text-center'>BST</th>
                    <th class='text-center'>FIRST SK</th>
                    <th class='text-center'>PBI</th>
                    <th class='text-center'>PENA</th>
                    <th class='text-center'>PERMAKANAN</th>
                    <th class='text-center'>RUTILAHU</th>
                    <th class='text-center'>SEMBAKO ADAPTIF</th>
                    <th class='text-center'>YAPI</th>
                    <th class='text-center'>PKH</th>
                    <th class='text-center'>UPDATE TERAKHIR</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>
<script>
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    jQuery(document).ready(function() {
        getDataTable().then(function() {
            jQuery("#search_filter_action").select2();
        });
        cari_alamat_siks('<?php echo $default_location; ?>');
    });

    function getDataTable() {
        jQuery("#wrap-loading").show();
        return new Promise(function(resolve, reject) {
            dataDtks = jQuery('#tableData').DataTable({
                "searchDelay": 500,
                "processing": true,
                "serverSide": true,
                "stateSave": false,
                "ajax": {
                    url: ajax.url,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'action': 'get_data_dtks_siks',
                        'api_key': ajax.apikey,
                        'desa': '<?php echo $validate_user['desa']; ?>',
                        'kecamatan': '<?php echo $validate_user['kecamatan']; ?>',
                    }
                },
                dom: 'Blfrtip',
                buttons: [{
                    "extend": 'excel',
                    "titleAttr": 'Excel',
                    "text": 'Download Excel',
                    "className": "btn btn-success",
                    "action": function(e, dt, button, config) {

                        let data = {};

                        data.action = 'export_excel_data_dtks_siks';

                        data.api_key = ajax.apikey;

                        if (
                            jQuery("#search_filter_action").val() != '' &&
                            jQuery("#search_filter_action").val() != '-') {
                            data.filter_kriteria = jQuery("#search_filter_action").val();
                        }

                        if (dataDtks.search() != '') {
                            data.search_value = dataDtks.search();
                        }

                        jQuery.ajax({
                            method: 'post',
                            url: ajax.url,
                            cache: false,
                            xhrFields: {
                                responseType: 'blob'
                            },
                            data: data,
                            beforeSend: function() {
                                jQuery("#wrap-loading").show();
                            },
                            success: function(response) {

                                jQuery("#wrap-loading").hide();
                                let link = document.createElement('a');
                                link.href = window.URL.createObjectURL(response);
                                link.download = `Export Data DTKS`;
                                link.click();
                            }
                        })
                    },
                }],
                initComplete: function(settings, json) {

                    jQuery("#wrap-loading").hide();

                    let html_filter = "" +
                        "<div class='row col-lg-12'>" +
                        "<div class='col-lg-12'>" +
                        "<select name='filter_status' class='ml-3 bulk-action' id='search_filter_action' style='width: 20%'>" +
                        "<option value='-'>Pilih Kriteria</option>" +
                        "</select>&nbsp;" +
                        "</div>" +
                        "</div>";

                    jQuery("#tableData").before(html_filter);

                    kriteria = [{
                            'kk_kosong': 'KK Kosong'
                        },
                        {
                            'nik_kosong': 'NIK Kosong'
                        },
                        {
                            'nik_atau_kk_kosong': 'NIK atau KK Kosong'
                        }
                    ];

                    for (var key in kriteria) {
                        var obj = kriteria[key];
                        for (var prop in obj) {
                            if (obj.hasOwnProperty(prop)) {
                                jQuery('#search_filter_action').append('<option value="' + prop + '">' + obj[prop] + '</option>');
                            }
                        }
                    }

                    jQuery('#search_filter_action').on('change', function() {
                        var option = jQuery(this).val();
                        switch (option) {
                            case 'kk_kosong':
                            case 'nik_atau_kk_kosong':
                                dataDtks.column(2).search('');
                                dataDtks.column(1).search(option).draw();
                                break;

                            case 'nik_kosong':
                                dataDtks.column(1).search('');
                                dataDtks.column(2).search(option).draw();
                                break;
                        }
                    });
                },

                lengthMenu: [
                    [20, 50, 100, -1],
                    [20, 50, 100, "All"]
                ],
                order: [
                    [1, 'asc']
                ],
                "columns": [{
                        "data": null
                    },
                    {
                        "data": 'Nama',
                        className: "text-left"
                    },
                    {
                        "data": 'NIK',
                        className: "text-center"
                    },
                    {
                        "data": 'NOKK',
                        className: "text-center"
                    },
                    {
                        "data": 'Alamat',
                        className: "text-left"
                    },
                    {
                        "data": 'provinsi',
                        className: "text-left"
                    },
                    {
                        "data": 'kabupaten',
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
                        "data": 'ATENSI',
                        className: "text-center"
                    },
                    {
                        "data": 'BLT',
                        className: "text-center"
                    },
                    {
                        "data": 'BLT_BBM',
                        className: "text-center"
                    },
                    {
                        "data": 'BNPT_PPKM',
                        className: "text-center"
                    },
                    {
                        "data": 'BPNT',
                        className: "text-center"
                    },
                    {
                        "data": 'BST',
                        className: "text-center"
                    },
                    {
                        "data": 'FIRST_SK',
                        className: "text-center"
                    },
                    {
                        "data": 'PBI',
                        className: "text-center"
                    },
                    {
                        "data": 'PENA',
                        className: "text-center"
                    },
                    {
                        "data": 'PERMAKANAN',
                        className: "text-center"
                    },
                    {
                        "data": 'RUTILAHU',
                        className: "text-center"
                    },
                    {
                        "data": 'SEMBAKO_ADAPTIF',
                        className: "text-center"
                    },
                    {
                        "data": 'YAPI',
                        className: "text-center"
                    },
                    {
                        "data": 'PKH',
                        className: "text-center"
                    },
                    {
                        "data": 'update_at',
                        className: "text-center"
                    },
                ],
                "columnDefs": [{
                    targets: 0,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1 + ".";
                    }
                }],
                "drawCallback": function() {
                    resolve();
                }
            });
        });
    }
</script>