<?php
global $wpdb;
$center = $this->get_center();
$maps_all = $this->get_polygon();
$odgj_all = $this->get_odgj();

$total_data_odgj = 0;
$total_data_odgj = $wpdb->get_var(
    $wpdb->prepare("
       SELECT COUNT(*)
       FROM data_odgj_siks
       WHERE active = %d 
    ", 1)
);

$last_update = null;
$data_all_desa = array();
foreach ($odgj_all as $data) {
    $index = strtolower($data['provinsi']) . '.' . strtolower($data['kabkot']) . '.' . strtolower($data['kecamatan']) . '.' . strtolower($data['desa_kelurahan']);
    if (empty($data_all_desa[$index])) {
        $data_all_desa[$index] = array();
    }
    if ($last_update === null || $data['last_update'] > $last_update) {
        $last_update = $data['last_update'];
    }
    $data_all_desa[$index][] = $data;
}
// die(print_r($maps_all));
$total_data_kosong = 0;
$total_all = 0;
$body =  '';
foreach ($maps_all as $i => $desa) {
    $index = strtolower($desa['data']['provinsi']) . '.' . strtolower($desa['data']['kab_kot']) . '.' . strtolower($desa['data']['kecamatan']) . '.' . strtolower($desa['data']['desa']);
    $total_all_data = 0;
    if (!empty($data_all_desa[$index])) {
        foreach ($data_all_desa[$index] as $orang) {
            $total_all_data += $orang['jml'];
        }
    }

    if ($total_all_data <= 5) {
        $maps_all[$i]['color'] = '#0cbf00';
    } else if ($total_all_data <= 10) {
        $maps_all[$i]['color'] = '#fff70a';
    } else if ($total_all_data > 10) {
        $maps_all[$i]['color'] = '#ff0000';
    }

    $maps_all[$i]['index'] = $i;

    $html = '
        <table>
            <tr>
                <td><b>Total ODGJ</b></td>
                <td><b>' . $this->number_format($total_all_data) . ' Orang</b></td>
            </tr>
    ';
    foreach ($desa['data'] as $k => $v) {
        $html .= '
            <tr>
                <td><b>' . $k . '</b></td>
                <td>' . $v . '</td>
            </tr>
        ';
    }
    $html .= '</table>';
    $link_per_desa = '';
    if (is_user_logged_in()) {
        //generate page per desa
        $gen_page = $this->functions->generatePage(array(
            'nama_page' => 'ODGJ Per Desa | ' . $desa['data']['desa'],
            'content' => '[odgj_per_desa id_desa='. $desa['data']['id2012'] . ']',
            'show_header' => 1,
            'no_key' => 1,
            'post_status' => 'private'
        ));
        $link_per_desa = $gen_page['url'];
    }
    $maps_all[$i]['html'] = $html;

    $search = $this->getSearchLocation($desa['data']);
    $body .= "
        <tr>
            <td class='text-center'>" . $desa['data']['id2012'] . "</td>
            <td class='text-center'>" . $desa['data']['provinsi'] . "</td>
            <td class='text-center'>" . $desa['data']['kab_kot'] . "</td>
            <td class='text-center'>" . $desa['data']['kecamatan'] . "</td>
            <td class='text-center'>";
    if (!empty($link_per_desa)) {
        $body .= "<a href='" . esc_url($link_per_desa) . "' target='_blank'>" . esc_html($desa['data']['desa']) . "</a>";
    } else {
        $body .= esc_html($desa['data']['desa']);
    }
    $body .= "</td>
            <td class='text-center'>" . $total_all_data . "</td>
            <td class='text-center'><a style='margin-bottom: 5px;' onclick='cari_alamat_siks(\"" . $search . "\"); return false;' href='#' class='btn btn-danger'>Map</a></td>
        </tr>
    ";
    $total_all += $total_all_data;
}
?>
<h1 class="text-center">Peta Sebaran ODGJ<br>( Orang Dengan Gangguan Jiwa )<br><?php echo $this->getNamaDaerah(); ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h3 style="margin-top: 20px;">Keterangan</h3>
    <ol>
        <li>Warna hijau berarti jumlah ODGJ antara 0 sampai 5 orang</li>
        <li>Warna kuning berarti jumlah ODGJ antara 5 sampai 10 orang</li>
        <li>Warna merah berarti jumlah ODGJ diatas 10 orang</li>
    </ol>
    <h1 class="text-center">Tabel Data ODGJ<br>Total <?php echo $this->number_format($total_data_odgj); ?> Orang</h1>
    <h3 class="text-center">Terakhir diupdate <?php echo $last_update ?></h3>
    <div style="width: 100%; overflow: auto; height: 100vh;">
        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th class='text-center'>Kode Desa</th>
                    <th class='text-center'>Provinsi</th>
                    <th class='text-center'>Kabupaten/Kota</th>
                    <th class='text-center'>Kecamatan</th>
                    <th class='text-center'>Desa</th>
                    <th class='text-center'>Total ODGJ</th>
                    <th class='text-center'>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $body; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    jQuery('#table-data').dataTable({
        lengthMenu: [
            [20, 50, 100, -1],
            [20, 50, 100, "All"]
        ],
        order: [
            [5, 'desc']
        ]
    });
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>