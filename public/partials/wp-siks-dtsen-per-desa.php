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
<h1 class="text-center">Peta Sebaran DTKS ( Data Terpadu Kesejahteraan Sosial )<br>Terintegrasi dengan DTSEN (Data Tunggal Sosial dan Ekonomi Nasional)<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>
<div style="padding: 10px;margin:0 0 3rem 0;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h1 class="text-center" style="margin:3rem;">Data DTSEN (Data Tunggal Sosial dan Ekonomi Nasional)<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>
    <div class="wrap-table">
        <table id="tableData">
            <thead>
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Desil Nasional</th>
                    <th class="text-center">Disabilitas</th>
                    <th class="text-center">Lansia</th>
                    <th class="text-center">No. KK</th>
                    <th class="text-center">Hubungan Keluarga</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">NIK</th>
                    <th class='text-center'>Pekerjaan Utama</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa/Kelurahan</th>
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
        cari_alamat_siks('<?php echo $default_location; ?>');
        generate_table();
    });

    function get_data_dtsen() {
        return jQuery.ajax({
            url: ajax.url,
            method: 'POST',
            data: {
                action: "get_data_dtsen_ajax",
                api_key: ajax.apikey,
                desa: "<?php echo $validate_user['desa']; ?>"
            },
            dataType: 'json',
        });
    }

    async function generate_table() {
        try {
            jQuery(`#wrap-loading`).show();
            const allData = await get_data_dtsen();
            if (allData.status) {
                let tbody = ``;
                let no = 1;
                allData.data.forEach(data => {
                    tbody += `
                        <tr>
                            <td class="text-center">${no++}</td>
                            <td class="text-center">${data.desil_nasional}</td>
                            <td class="text-left">${data.disabilitas}</td>
                            <td class="text-left">${data.lansia}</td>
                            <td class="text-left">${data.no_kk}</td>
                            <td class="text-left">${data.hub_kepala_keluarga}</td>
                            <td class="text-left">${data.alamat}</td>
                            <td class="text-left">${data.nama}</td>
                            <td class="text-left">${data.nik}</td>
                            <td class="text-left">${data.pekerjaan_utama}</td>
                            <td class="text-left">${data.provinsi}</td>
                            <td class="text-left">${data.kabupaten}</td>
                            <td class="text-left">${data.kecamatan}</td>
                            <td class="text-left">${data.kelurahan}</td>
                        </tr>
                    `;
                });

                jQuery(`#tableData tbody`).html(tbody);
            }

        } catch (error) {
            alert("Gagal generate table");
            console.log(error);
        } finally {
            jQuery(`#tableData`).dataTable();
            jQuery(`#wrap-loading`).hide();
        }
    }
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>