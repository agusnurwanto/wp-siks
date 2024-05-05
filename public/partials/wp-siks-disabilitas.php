<?php
$center = $this->get_center();
$maps_all = $this->get_polygon();
$disabilitas_all = $this->get_disabilitas();

$last_update_disabilitas = null;
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

$total_all = 0;
$total_all_jenis = array();
$nama_jenis = array();
$body =  '';
$body2 =  '';
foreach ($maps_all as $i => $desa) {
    $index = strtolower($desa['data']['provinsi']) . '.' . strtolower($desa['data']['kab_kot']) . '.' . strtolower($desa['data']['kecamatan']) . '.' . strtolower($desa['data']['desa']);
    $total_disabilitas = 0;
    $total_jenis = array();
    $total_jenis_disabilitas = array();
    $nama_jenis = array();
    if (!empty($disabilitas_all_desa[$index])) {
        foreach ($disabilitas_all_desa[$index] as $orang) {
            $total_disabilitas += $orang['jml'];
            if ($orang['jenis_disabilitas'] != '') {
                if (empty($total_jenis_disabilitas[$orang['jenis_disabilitas']])) {
                    $total_jenis_disabilitas[$orang['jenis_disabilitas']] = 0;
                }
                if (empty($total_all_jenis[$orang['jenis_disabilitas']])) {
                    $total_all_jenis[$orang['jenis_disabilitas']] = 0;
                }
                if (empty($nama_jenis[$orang['jenis_disabilitas']])) {
                    $nama_jenis[$orang['jenis_disabilitas']] = array();
                }
                $nama_jenis[$orang['jenis_disabilitas']] = array();
                $total_jenis_disabilitas[$orang['jenis_disabilitas']] += $orang['jml'];
                $total_all_jenis[$orang['jenis_disabilitas']] += $orang['jml'];
            }
        }
        foreach ($total_jenis_disabilitas as $key => $data) {
            $total_jenis_disabilitas[$key] = $key . ': ' . $data;
        }
        foreach ($nama_jenis as $key => $data) {
            $nama_jenis[$key] = $key;
        }
    }
    if ($total_disabilitas <= 15) {
        $maps_all[$i]['color'] = '#0cbf00';
    } else if ($total_disabilitas <= 40) {
        $maps_all[$i]['color'] = '#fff70a';
    } else if ($total_disabilitas > 40) {
        $maps_all[$i]['color'] = '#ff0000';
    }
    $maps_all[$i]['index'] = $i;

    $html = '
        <table>
            <tr>
                <td><b>Total Disabilitas</b></td>
                <td><b>' . $this->number_format($total_disabilitas) . ' Orang</b></td>
            </tr>
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
    $link_per_desa = '';
    if (is_user_logged_in()) {
        $link_per_desa = add_query_arg('desa', urlencode($desa['data']['desa']), home_url('/disabilitas-per-desa/'));
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
        $body .= "<a href='" . esc_url($link_per_desa) . "'>" . esc_html($desa['data']['desa']) . "</a>";
    } else {
        $body .= esc_html($desa['data']['desa']);
    }

    $body .= "</td>
        <td class='text-center'>" . $total_disabilitas . "</td>
        <td>" . implode('<hr>', $total_jenis_disabilitas) . "</td>
        <td class='text-center'><a style='margin-bottom: 5px;' onclick='cari_alamat_siks(\"" . $search . "\"); return false;' href='#' class='btn btn-danger'>Map</a></td>
    </tr>
";
    $total_all += $total_disabilitas;
}

foreach ($total_all_jenis as $key => $data) {
    $body2 .= "
        <tr>
            <td class='text-left'>" . $key . "</td>
            <td class='text-center'>" . $data . "</td>
        </tr>
    ";
}
?>
<h1 class="text-center">Peta Sebaran Disabilitas<br><?php echo $this->getNamaDaerah(); ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h3 style="margin-top: 20px;">Keterangan</h3>
    <ol>
        <li>Warna hijau berarti jumlah Disabilitas antara 0 sampai 15 orang</li>
        <li>Warna kuning berarti jumlah Disabilitas antara 16 sampai 40 orang</li>
        <li>Warna merah berarti jumlah Disabilitas diatas 40 orang</li>
    </ol>
    <h1 class="text-center">Tabel Data Disabilitas<br>Total <?php echo $this->number_format($total_all); ?> Orang</h1>
    <h3 class="text-center">Terakhir diupdate <?php echo $last_update_disabilitas ?></h3>
    <div style="width: 100%; overflow: auto; height: 100vh;">
        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th class='text-center'>Kode Desa</th>
                    <th class='text-center'>Provinsi</th>
                    <th class='text-center'>Kabupaten/Kota</th>
                    <th class='text-center'>Kecamatan</th>
                    <th class='text-center'>Desa</th>
                    <th class='text-center'>Total Disabilitas</th>
                    <th class='text-center'>Jenis Disabilitas</th>
                    <th class='text-center'>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $body; ?>
            </tbody>
        </table>
    </div><br>
    <h2 class="text-center">Tabel Total Data <br>per Jenis Disabilitas</h2>
    <table class="table table-bordered" id="table-data-jenis">
        <thead>
            <tr>
                <th class="text-center">Jenis Disabilitas</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $body2; ?>
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
    jQuery('#table-data-jenis').dataTable({
        lengthMenu: [
            [20, 50, 100, -1],
            [20, 50, 100, "All"]
        ],
        order: [
            [1, 'desc']
        ]
    });
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>