<?php
$center = $this->get_center();
$maps_all = $this->get_polygon();
$lansia_all = $this->get_lansia();
$disabilitas_all = $this->get_disabilitas();
$dtks_all = $this->get_dtks();

$last_update_dtks = null;
$last_update_lansia = null;
$last_update_disabilitas = null;
$lansia_all_desa = array();
foreach ($lansia_all as $data) {
    $index = strtolower($data['provinsi']) . '.' . strtolower($data['kabkot']) . '.' . strtolower($data['kecamatan']) . '.' . strtolower($data['desa']);
    if (empty($lansia_all_desa[$index])) {
        $lansia_all_desa[$index] = array();
    }
    if ($last_update_lansia === null || $data['last_update'] > $last_update_lansia) {
        $last_update_lansia = $data['last_update'];
    }
    $lansia_all_desa[$index][] = $data;
}

$disabilitas_all_desa = array();
foreach ($disabilitas_all as $data) {
    $index = strtolower($data['provinsi']) . '.' . strtolower($data['kabkot']) . '.' . strtolower($data['kecamatan']) . '.' . strtolower($data['desa']);
    if (empty($disabilitas_all_desa[$index])) {
        $disabilitas_all_desa[$index] = array();
    }
    if ($last_update_disabilitas === null || $data['last_update'] > $last_update_disabilitas) {
        $last_update_disabilitas = $data['last_update'];
    }
    $disabilitas_all_desa[$index][] = $data;
}

$dtks_all_desa = array();
foreach ($dtks_all as $data) {
    $index = strtolower($data['provinsi']) . '.' . strtolower($data['kabkot']) . '.' . strtolower($data['kecamatan']) . '.' . strtolower($data['desa_kelurahan']);
    if (empty($dtks_all_desa[$index])) {
        $dtks_all_desa[$index] = array();
    }
    if ($last_update_dtks === null || $data['last_update'] > $last_update_dtks) {
        $last_update_dtks = $data['last_update'];
    }
    $dtks_all_desa[$index][] = $data;
}

$total_all_dtks = 0;
$total_all_lansia = 0;
$total_all_disabilitas = 0;
$body =  '';
foreach ($maps_all as $i => $desa) {
    $index = strtolower($desa['data']['provinsi']) . '.' . strtolower($desa['data']['kab_kot']) . '.' . strtolower($desa['data']['kecamatan']) . '.' . strtolower($desa['data']['desa']);
    $total_dtks = 0;
    $total_lansia = 0;
    $total_disabilitas = 0;
    if (!empty($lansia_all_desa[$index])) {
        foreach ($lansia_all_desa[$index] as $orang) {
            $total_lansia += $orang['jml'];
        }
    }
    if (!empty($dtks_all_desa[$index])) {
        foreach ($dtks_all_desa[$index] as $orang) {
            $total_dtks += $orang['jml'];
        }
    }
    if (!empty($disabilitas_all_desa[$index])) {
        foreach ($disabilitas_all_desa[$index] as $orang) {
            $total_disabilitas += $orang['jml'];
        }
    }
    if ($total_dtks <= 1500) {
        $maps_all[$i]['color'] = '#0cbf00';
    } else if ($total_dtks <= 3000) {
        $maps_all[$i]['color'] = '#fff70a';
    } else if ($total_dtks > 3000) {
        $maps_all[$i]['color'] = '#ff0000';
    }
    $maps_all[$i]['index'] = $i;

    $html = '
        <table>
            <tr>
                <td><b>Total DTKS</b></td>
                <td><b>' . $this->number_format($total_dtks) . ' Orang</b></td>
            </tr>
            <tr>
                <td><b>Total Lansia</b></td>
                <td><b>' . $this->number_format($total_lansia) . ' Orang</b></td>
            </tr>
            <tr>
                <td><b>Total Lansia</b></td>
                <td><b>' . $this->number_format($total_disabilitas) . ' Orang</b></td>
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
    $maps_all[$i]['html'] = $html;

    $search = $this->getSearchLocation($desa['data']);
    $body .= "
        <tr>
            <td class='text-center'>" . $desa['data']['id2012'] . "</td>
            <td class='text-center'>" . $desa['data']['provinsi'] . "</td>
            <td class='text-center'>" . $desa['data']['kab_kot'] . "</td>
            <td class='text-center'>" . $desa['data']['kecamatan'] . "</td>
            <td class='text-center'>" . $desa['data']['desa'] . "</td>
            <td class='text-center'>" . $total_dtks . "</td>
            <td class='text-center'>" . $total_lansia . "</td>
            <td class='text-center'>" . $total_disabilitas . "</td>
            <td class='text-center'><a style='margin-bottom: 5px;' onclick='cari_alamat_siks(\"" . $search . "\"); return false;' href='#' class='btn btn-danger'>Map</a></td>
        </tr>
    ";
    $total_all_dtks += $total_dtks;
    $total_all_lansia += $total_lansia;
    $total_all_disabilitas += $total_disabilitas;
}
?>
<h1 class="text-center">Peta Data Terpadu Sosial Terintegrasi<br><?php echo $this->getNamaDaerah(); ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h3 style="margin-top: 20px;">Keterangan</h3>
    <ol>
        <li>Warna hijau berarti jumlah DTKS antara 0 sampai 1500 orang</li>
        <li>Warna kuning berarti jumlah DTKS antara 1501 sampai 3000 orang</li>
        <li>Warna merah berarti jumlah DTKS diatas 3000 orang</li>
    </ol>
    <h1 class="text-center">Tabel Data Terpadu<br>Total DTKS <?php echo $this->number_format($total_all_dtks); ?> Orang</h1>
    <h3 class="text-center">Terakhir diupdate <?php echo $last_update_dtks; ?></h3>
    <h1 class="text-center">Total Lansia <?php echo $this->number_format($total_all_lansia); ?> Orang</h1>
    <h3 class="text-center">Terakhir diupdate <?php echo $last_update_lansia; ?></h3>
    <h1 class="text-center">Total Disabilitas <?php echo $this->number_format($total_all_disabilitas); ?> Orang</h1>
    <h3 class="text-center">Terakhir diupdate <?php echo $last_update_disabilitas; ?></h3>
    <div style="width: 100%; overflow: auto; height: 100vh;">
        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th class='text-center'>Kode Desa</th>
                    <th class='text-center'>Provinsi</th>
                    <th class='text-center'>Kabupaten/Kota</th>
                    <th class='text-center'>Kecamatan</th>
                    <th class='text-center'>Desa</th>
                    <th class='text-center'>Total DTKS</th>
                    <th class='text-center'>Total Lansia</th>
                    <th class='text-center'>Total Disabilitas</th>
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