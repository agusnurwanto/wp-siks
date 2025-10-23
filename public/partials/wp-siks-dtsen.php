<?php
$center = $this->get_center();
$maps_all = $this->get_polygon();
$dtsen = $this->get_dtsen();
// END GET

// START PROCCESS
$last_update = null;
$dtsen_desa = array();
foreach ($dtsen as $data) {
    $index = strtolower($data['provinsi']) . '.' . strtolower($data['kabupaten']) . '.' . strtolower($data['kecamatan']) . '.' . strtolower($data['kelurahan']);
    if (empty($dtsen_desa[$index])) {
        $dtsen_desa[$index] = array();
    }
    if ($last_update === null || $data['last_update'] > $last_update) {
        $last_update = $data['last_update'];
    }
    $dtsen_desa[$index][] = $data;
}
// die(var_dump($dtsen_desa));

// START PROCESS MAP
$total_all = 0;
$body =  '';
foreach ($maps_all as $i => $desa) {
    $index = strtolower($desa['data']['provinsi']) . '.' . strtolower($desa['data']['kab_kot']) . '.' . strtolower($desa['data']['kecamatan']) . '.' . strtolower($desa['data']['desa']);

    $total_dtsen = 0;
    $total_desil_1_disabilitas = 0;
    $total_desil_2_disabilitas = 0;
    $total_desil_3_disabilitas = 0;
    $total_desil_4_disabilitas = 0;
    $total_desil_5_disabilitas = 0;
    $total_desil_1_lansia = 0;
    $total_desil_2_lansia = 0;
    $total_desil_3_lansia = 0;
    $total_desil_4_lansia = 0;
    $total_desil_5_lansia = 0;
    if (!empty($dtsen_desa[$index])) {
        foreach ($dtsen_desa[$index] as $orang) {
            $total_dtsen += $orang['jumlah'];
            $total_desil_1_disabilitas += $orang['total_desil_1_disabilitas'];
            $total_desil_2_disabilitas += $orang['total_desil_2_disabilitas'];
            $total_desil_3_disabilitas += $orang['total_desil_3_disabilitas'];
            $total_desil_4_disabilitas += $orang['total_desil_4_disabilitas'];
            $total_desil_5_disabilitas += $orang['total_desil_5_disabilitas'];
            $total_desil_1_lansia += $orang['total_desil_1_lansia'];
            $total_desil_2_lansia += $orang['total_desil_2_lansia'];
            $total_desil_3_lansia += $orang['total_desil_3_lansia'];
            $total_desil_4_lansia += $orang['total_desil_4_lansia'];
            $total_desil_5_lansia += $orang['total_desil_5_lansia'];
        }
    }

    if ($total_dtsen <= 1500) {
        $maps_all[$i]['color'] = '#0cbf00';
    } else if ($total_dtsen <= 3000) {
        $maps_all[$i]['color'] = '#fff70a';
    } else if ($total_dtsen > 3000) {
        $maps_all[$i]['color'] = '#ff0000';
    }
    $maps_all[$i]['index'] = $i;

    $html = '
        <table>
            <tr>
                <td><b>Total DTSEN</b></td>
                <td><b>' . $this->number_format($total_dtsen) . ' Orang</b></td>
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
        $gen_page = $this->functions->generatePage(array(
            'nama_page' => 'DTSEN per desa | Desa ' . $desa['data']['desa'],
            'content' => '[dtsen_per_desa id_desa=' . $desa['data']['id2012'] . ']',
            'show_header' => 1,
            'no_key' => 1,
            'post_status' => 'publish'
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
            <td class='text-center'>" . $total_dtsen . "</td>
            <td class='text-center'>" . $total_desil_1_disabilitas . "</td>
            <td class='text-center'>" . $total_desil_2_disabilitas . "</td>
            <td class='text-center'>" . $total_desil_3_disabilitas . "</td>
            <td class='text-center'>" . $total_desil_4_disabilitas . "</td>
            <td class='text-center'>" . $total_desil_5_disabilitas . "</td>
            <td class='text-center'>" . $total_desil_1_lansia . "</td>
            <td class='text-center'>" . $total_desil_2_lansia . "</td>
            <td class='text-center'>" . $total_desil_3_lansia . "</td>
            <td class='text-center'>" . $total_desil_4_lansia . "</td>
            <td class='text-center'>" . $total_desil_5_lansia . "</td>
            <td class='text-center'><a style='margin-bottom: 5px;' onclick='cari_alamat_siks(\"" . $search . "\"); return false;' href='#' class='btn btn-danger'>Map</a></td>
        </tr>
    ";
    $total_all += $total_dtsen;
}

?>
<h1 class="text-center">Peta Sebaran DTKS (Data Terpadu Kesejahteraan Sosial)<br>Terintegrasi dengan DTSEN (Data Tunggal Sosial dan Ekonomi Nasional)<br><?php echo $this->getNamaDaerah(); ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h3 style="margin-top: 20px;">Keterangan</h3>
    <ol>
        <li>Warna hijau berarti jumlah DTSEN antara 0 sampai 1500 orang</li>
        <li>Warna kuning berarti jumlah DTSEN antara 1501 sampai 3000 orang</li>
        <li>Warna merah berarti jumlah DTSEN diatas 3000 orang</li>
    </ol>
    <h2 class="text-center">Tabel Data DTSEN (Data Tunggal Sosial dan Ekonomi Nasional)<br>Desil 1 s.d 5<br>Total <?php echo $this->number_format($total_all); ?> Orang</h1>
    <h3 class="text-center">Terakhir diupdate <?php echo $last_update; ?></h3>
    <div style="width: 100%; overflow: auto; height: 100vh;">
        <table id="table-data" class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan='2' class='text-center'>Kode Desa</th>
                    <th rowspan='2' class='text-center'>Provinsi</th>
                    <th rowspan='2' class='text-center'>Kabupaten/Kota</th>
                    <th rowspan='2' class='text-center'>Kecamatan</th>
                    <th rowspan='2' class='text-center'>Desa</th>
                    <th rowspan='2' class='text-center'>Total DTSEN</th>
                    <th colspan='5' class='text-center'>Disabilitas</th>
                    <th colspan='5' class='text-center'>Lansia</th>
                    <th rowspan='2' class='text-center'>Aksi</th>
                </tr>
                <tr>
                    <th class="text-center">1</th>
                    <th class="text-center">2</th>
                    <th class="text-center">3</th>
                    <th class="text-center">4</th>
                    <th class="text-center">5</th>
                    <th class="text-center">1</th>
                    <th class="text-center">2</th>
                    <th class="text-center">3</th>
                    <th class="text-center">4</th>
                    <th class="text-center">5</th>
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