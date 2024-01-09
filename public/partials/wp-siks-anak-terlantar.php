<?php
$center = $this->get_center();
$maps_all = $this->get_polygon();
$anak_terlantar_dalam = $this->get_anak_terlantar(); // Data dalam Magetan
$anak_terlantar_luar = $this->get_anak_terlantar_luar_magetan(); // Data luar Magetan

$anak_terlantar_dalam_magetan = array();
$anak_terlantar_luar_magetan = array();

// Pengolahan data dalam Magetan
foreach ($anak_terlantar_dalam as $data) {
    $provinsi = isset($data['provinsi']) ? strtolower($data['provinsi']) : '';
    $kabkot = isset($data['kabkot']) ? strtolower($data['kabkot']) : '';
    $kecamatan = isset($data['kecamatan']) ? strtolower($data['kecamatan']) : '';
    $desa_kelurahan = isset($data['desa_kelurahan']) ? strtolower($data['desa_kelurahan']) : '';

    $index = $provinsi . '.' . $kabkot . '.' . $kecamatan . '.' . $desa_kelurahan;

    if (empty($anak_terlantar_dalam_magetan[$index])) {
        $anak_terlantar_dalam_magetan[$index] = array();
    }
    $anak_terlantar_dalam_magetan[$index][] = $data;
}

// Pengolahan data luar Magetan
foreach ($anak_terlantar_luar as $data) {
    $provinsi = isset($data['provinsi']) ? strtolower($data['provinsi']) : '';
    $kabkot = isset($data['kabkot']) ? strtolower($data['kabkot']) : '';
    $kecamatan = isset($data['kecamatan']) ? strtolower($data['kecamatan']) : '';
    $desa_kelurahan = isset($data['desa_kelurahan']) ? strtolower($data['desa_kelurahan']) : '';

    $index = $provinsi . '.' . $kabkot . '.' . $kecamatan . '.' . $desa_kelurahan;

    if (empty($anak_terlantar_luar_magetan[$index])) {
        $anak_terlantar_luar_magetan[$index] = array();
    }
    $anak_terlantar_luar_magetan[$index][] = $data;
}

$total_dalam = 0;
$body_dalam = '';
$total_luar = 0;
$body_luar = '';

// Proses data untuk Kabupaten Magetan
foreach ($maps_all as $i => $desa) {
    $index = strtolower($desa['data']['provinsi']) . '.' . strtolower($desa['data']['kab_kot']) . '.' . strtolower($desa['data']['kecamatan']) . '.' . strtolower($desa['data']['desa']);
    $total_anak_terlantar = 0;
    if (!empty($anak_terlantar_dalam_magetan[$index])) {
        foreach ($anak_terlantar_dalam_magetan[$index] as $orang) {
            $total_anak_terlantar += $orang['jml'];
        }
    }
    if ($total_anak_terlantar <= 15) {
        $maps_all[$i]['color'] = '#0cbf00';
    } else if ($total_anak_terlantar <= 40) {
        $maps_all[$i]['color'] = '#fff70a';
    } else if ($total_anak_terlantar > 40) {
        $maps_all[$i]['color'] = '#ff0000';
    }
    $maps_all[$i]['index'] = $i;

    $html = '
        <table>
            <tr>
                <td><b>Total Anak Terlantar</b></td>
                <td><b>' . $this->number_format($total_anak_terlantar) . ' Orang</b></td>
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
    $body_dalam .= "
        <tr>
            <td class='text-center'>" . $desa['data']['id2012'] . "</td>
            <td class='text-center'>" . $desa['data']['provinsi'] . "</td>
            <td class='text-center'>" . $desa['data']['kab_kot'] . "</td>
            <td class='text-center'>" . $desa['data']['kecamatan'] . "</td>
            <td class='text-center'>" . $desa['data']['desa'] . "</td>
            <td class='text-center'>" . $total_anak_terlantar . "</td>
            </tr>
            ";
    // <td class='text-center'><a style='margin-bottom: 5px;' onclick='cari_alamat_siks(\"" . $desa['data']['search'] . "\"); return false;' href='#' class='btn btn-danger'>Map</a></td>
    $total_dalam += $total_anak_terlantar;
}

// Proses data untuk luar Kabupaten Magetan
foreach ($anak_terlantar_luar_magetan as $index => $data_luar) {
    $total_anak_terlantar_luar = array_sum(array_column($data_luar, 'jml'));
    foreach ($data_luar as $data) {
        $body_luar .= "
            <tr>
                <td class='text-center' style='text-transform:uppercase'>" . $data['provinsi'] . "</td>
                <td class='text-center' style='text-transform:uppercase'>" . $data['kabkot'] . "</td>
                <td class='text-center' style='text-transform:uppercase'>" . $data['kecamatan'] . "</td>
                <td class='text-center' style='text-transform:uppercase'>" . $data['desa_kelurahan'] . "</td>
                <td class='text-center'>" . $data['jml'] . "</td>
            </tr>
        ";
    }
    $total_luar += $total_anak_terlantar_luar;
}

?>

<h1 class="text-center">Peta Sebaran Anak Terlantar<br><?php echo $this->getNamaDaerah(); ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h3 style="margin-top: 20px;">Keterangan</h3>
    <ol>
        <li>Warna hijau berarti jumlah Anak Terlantar antara 0 sampai 15 orang</li>
        <li>Warna kuning berarti jumlah Anak Terlantar antara 16 sampai 40 orang</li>
        <li>Warna merah berarti jumlah Anak Terlantar diatas 40 orang</li>
    </ol>
    <h2 class="text-center">Tabel Data Anak Terlantar Kabupaten Magetan<br>Total <?php echo $this->number_format($total_dalam); ?> Orang</h2>
    <div style="width: 100%; overflow: auto; height: 100vh;">
        <table class="table table-bordered" id="table-data-dalam">
            <thead>
                <tr>
                    <th class='text-center'>Kode Desa</th>
                    <th class='text-center'>Provinsi</th>
                    <th class='text-center'>Kabupaten/Kota</th>
                    <th class='text-center'>Kecamatan</th>
                    <th class='text-center'>Desa</th>
                    <th class='text-center'>Total Anak Terlantar</th>
                    <th class='text-center'>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $body_dalam; ?>
            </tbody>
        </table>
    </div><br><br>
    <h2 class="text-center">Tabel Data Anak Terlantar Luar Kabupaten Magetan<br>Total <?php echo $this->number_format($total_luar); ?> Orang</h2>
    <div style="width: 100%; overflow: auto; height: 100vh;">
        <table class="table table-bordered" id="table-data-luar">
            <thead>
                <tr>
                    <th class='text-center'>Provinsi</th>
                    <th class='text-center'>Kabupaten/Kota</th>
                    <th class='text-center'>Kecamatan</th>
                    <th class='text-center'>Desa</th>
                    <th class='text-center'>Total Anak Terlantar</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $body_luar; ?>
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