<?php
$center = $this->get_center();
$maps_all = $this->get_polygon();
$data_lksa = $this->get_lksa();
$anak_terlantar_dalam = $this->get_anak_terlantar();
$anak_terlantar_luar = $this->get_anak_terlantar_luar_magetan();

$data_all_lksa = array();
$anak_terlantar_dalam_magetan = array();
$anak_terlantar_luar_magetan = array();
$last_update_terlantar_dalam = null;
$last_update_terlantar_luar = null;
$last_update_lksa = null;
$url_all_kec = array();

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
    if ($last_update_terlantar_dalam === null || $data['last_update'] > $last_update_terlantar_dalam) {
        $last_update_terlantar_dalam = $data['last_update'];
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
    if ($last_update_terlantar_luar === null || $data['last_update'] > $last_update_terlantar_luar) {
        $last_update_terlantar_luar = $data['last_update'];
    }
    $anak_terlantar_luar_magetan[$index][] = $data;
}

// Pengolahan data luar Magetan
foreach ($data_lksa as $data) {
    $nama_lksa = isset($data['nama']) ? strtolower($data['nama']) : '';
    $kabkot = isset($data['kabkot']) ? strtolower($data['kabkot']) : '';
    $alamat = isset($data['alamat']) ? strtolower($data['alamat']) : '';
    $anak_dalam_lksa = isset($data['anak_dalam_lksa']) ? strtolower($data['anak_dalam_lksa']) : '';
    $anak_luar_lksa = isset($data['anak_luar_lksa']) ? strtolower($data['anak_luar_lksa']) : '';
    $total_anak = isset($data['total_anak']) ? strtolower($data['total_anak']) : '';

    $index = $nama_lksa . '.' . $kabkot . '.' . $alamat . '.' . $anak_dalam_lksa . '.' . $anak_luar_lksa . '.' . $total_anak;

    if (empty($data_all_lksa[$index])) {
        $data_all_lksa[$index] = array();
    }
    if ($last_update_lksa === null || $data['last_update'] > $last_update_lksa) {
        $last_update_lksa = $data['last_update'];
    }
    $data_all_lksa[$index][] = $data;
}

$total_dalam = 0;
$body_dalam = '';
$total_luar = 0;
$body_luar = '';
$total_lembaga = 0;
$body_lksa = '';

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
    $link_per_desa = '';
    if (is_user_logged_in()) {
        $gen_page = $this->functions->generatePage(array(
            'nama_page' => 'Anak Terlantar Per Desa | ' . $desa['data']['desa'],
            'content' => '[anak_terlantar_per_desa id_desa=' . $desa['data']['id2012'] . ']',
            'show_header' => 1,
            'no_key' => 1,
            'post_status' => 'publish'
        ));
        $link_per_desa = $gen_page['url'];
    }
    $maps_all[$i]['html'] = $html;

    $search = $this->getSearchLocation($desa['data']);
    $body_dalam .= "
        <tr>
            <td class='text-center'>" . $desa['data']['id2012'] . "</td>
            <td class='text-center'>" . $desa['data']['provinsi'] . "</td>
            <td class='text-center'>" . $desa['data']['kab_kot'] . "</td>
            <td class='text-center'>" . $desa['data']['kecamatan'] . "</td>
            <td class='text-center'>";
    if (!empty($link_per_desa)) {
        $body_dalam .= "<a href='" . esc_url($link_per_desa) . "' target='_blank'>" . esc_html($desa['data']['desa']) . "</a>";
    } else {
        $body_dalam .= esc_html($desa['data']['desa']);
    }
    $body_dalam .= "</td>
            <td class='text-center'>" . $total_anak_terlantar . "</td>
            <td class='text-center'><a style='margin-bottom: 5px;' onclick='cari_alamat_siks(\"" . $search . "\"); return false;' href='#' class='btn btn-danger'>Map</a></td>
            </tr>
            ";
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

// Proses data untuk luar Kabupaten Magetan
foreach ($data_all_lksa as $index => $lksa_data) {
    $total_lksa = array_sum(array_column($lksa_data, 'jml'));
    foreach ($lksa_data as $data) {
        $url_lksa = add_query_arg('nama', urlencode($data['nama']), home_url('/lksa-per-desa/'));
        $nama_lksa = str_replace('kabkot ', '', strtolower($data['nama']));
        $url_all_lksa[$nama_lksa] = $url_lksa;

        $nama_lksa_all = $nama_lksa;

        if (is_user_logged_in()) {
            $nama_lksa_all = "<a href='" . $url_all_lksa[$nama_lksa] . "' target='_blank'>" . $nama_lksa . "</a>";
        }
        $body_lksa .= "
            <tr>
                <td class='text-left' style='text-transform:uppercase'>" . $nama_lksa_all . "</td>
                <td class='text-left' style='text-transform:uppercase'>" . $data['kabkot'] . "</td>
                <td class='text-left' style='text-transform:uppercase'>" . $data['alamat'] . "</td>
                <td class='text-center' style='text-transform:uppercase'>" . $data['anak_dalam_lksa'] . "</td>
                <td class='text-center' style='text-transform:uppercase'>" . $data['anak_luar_lksa'] . "</td>
                <td class='text-center' style='text-transform:uppercase'>" . $data['total_anak'] . "</td>
            </tr>
        ";
    }
    $total_lembaga += $total_lksa;
}
?>]
<h1 class="text-center">Peta Sebaran Anak Terlantar<br><?php echo $this->getNamaDaerah(); ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h3 style="margin-top: 20px;">Keterangan</h3>
    <ol>
        <li>Warna hijau berarti jumlah Anak Terlantar antara 0 sampai 15 Anak</li>
        <li>Warna kuning berarti jumlah Anak Terlantar antara 16 sampai 40 Anak</li>
        <li>Warna merah berarti jumlah Anak Terlantar diatas 40 Anak</li>
    </ol>
    <h2 class="text-center">Tabel Data Anak Terlantar Kabupaten Magetan<br>Total <?php echo $this->number_format($total_dalam); ?> Anak</h2>
    <h3 class="text-center">Terakhir diupdate <?php echo $last_update_terlantar_dalam ?></h3>
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
    </div><br>
    <h2 class="text-center">Tabel Data Anak Terlantar Luar Kabupaten Magetan<br>Total <?php echo $this->number_format($total_luar); ?> Anak</h2>
    <h3 class="text-center">Terakhir diupdate <?php echo $last_update_terlantar_luar ?></h3>
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
    </div><br>
    <h2 class="text-center">Tabel Data LKSA (Lembaga Kesejahteraan Sosial Anak)<br>Total <?php echo $this->number_format($total_lembaga); ?> Lembaga</h2>
    <h3 class="text-center">Terakhir diupdate <?php echo $last_update_lksa ?></h3>
    <div style="width: 100%; overflow: auto; height: 100vh;">
        <table class="table table-bordered" id="table-data-lksa">
            <thead>
                <tr>
                    <th class='text-center'>Nama Lembaga</th>
                    <th class='text-center'>Kabupaten/Kota</th>
                    <th class='text-center'>Alamat</th>
                    <th class='text-center'>Total Dalam Lembaga</th>
                    <th class='text-center'>Total Luar Lembaga</th>
                    <th class='text-center'>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $body_lksa; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    jQuery('#table-data-dalam').dataTable({
        lengthMenu: [
            [20, 50, 100, -1],
            [20, 50, 100, "All"]
        ],
        order: [
            [5, 'desc']
        ]
    });
    jQuery('#table-data-luar').dataTable({
        lengthMenu: [
            [20, 50, 100, -1],
            [20, 50, 100, "All"]
        ],
        order: [
            [4, 'desc']
        ]
    });
    jQuery('#table-data-lksa').dataTable({
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