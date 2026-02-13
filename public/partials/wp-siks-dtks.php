<?php
$center = $this->get_center();
$maps_all = $this->get_polygon();
$dtks_all = $this->get_dtks();

$last_update_dtks = null;
$dtks_all_desa = array();
foreach ($dtks_all as $data) {
    $index = strtolower($data['provinsi']) . '.' . strtolower($data['kabupaten']) . '.' . strtolower($data['kecamatan']) . '.' . strtolower($data['desa_kelurahan']);
    if (empty($dtks_all_desa[$index])) {
        $dtks_all_desa[$index] = array();
    }
    if ($last_update_dtks === null || $data['last_update'] > $last_update_dtks) {
        $last_update_dtks = $data['last_update'];
    }
    $dtks_all_desa[$index][] = $data;
}
$total_all = 0;
$body =  '';
foreach ($maps_all as $i => $desa) {
    $index = strtolower($desa['data']['provinsi']) . '.' . strtolower($desa['data']['kab_kot']) . '.' . strtolower($desa['data']['kecamatan']) . '.' . strtolower($desa['data']['desa']);
    $total_dtks = 0;
    $total_blt = array();
    $total_blt_bbm = array();
    $total_bpnt = array();
    $total_pkh = array();
    $total_pbi = array();
    if (!empty($dtks_all_desa[$index])) {
        foreach ($dtks_all_desa[$index] as $orang) {
            $total_dtks += $orang['jml'];
            if ($orang['BLT'] != 'TIDAK') {
                if (empty($total_blt[$orang['BLT']])) {
                    $total_blt[$orang['BLT']] = 0;
                }
                $total_blt[$orang['BLT']] += $orang['jml'];
            }
            if ($orang['BLT_BBM'] != 'TIDAK') {
                if (empty($total_blt_bbm[$orang['BLT_BBM']])) {
                    $total_blt_bbm[$orang['BLT_BBM']] = 0;
                }
                $total_blt_bbm[$orang['BLT_BBM']] += $orang['jml'];
            }
            if ($orang['BPNT'] != 'TIDAK') {
                if (empty($total_bpnt[$orang['BPNT']])) {
                    $total_bpnt[$orang['BPNT']] = 0;
                }
                $total_bpnt[$orang['BPNT']] += $orang['jml'];
            }
            if ($orang['PKH'] != 'TIDAK') {
                if (empty($total_pkh[$orang['PKH']])) {
                    $total_pkh[$orang['PKH']] = 0;
                }
                $total_pkh[$orang['PKH']] += $orang['jml'];
            }
            if ($orang['PBI'] != 'TIDAK') {
                if (empty($total_pbi[$orang['PBI']])) {
                    $total_pbi[$orang['PBI']] = 0;
                }
                $total_pbi[$orang['PBI']] += $orang['jml'];
            }
        }
        foreach ($total_blt as $key => $data) {
            $total_blt[$key] = $key . ': ' . $data;
        }
        foreach ($total_blt_bbm as $key => $data) {
            $total_blt_bbm[$key] = $key . ': ' . $data;
        }
        foreach ($total_bpnt as $key => $data) {
            $total_bpnt[$key] = $key . ': ' . $data;
        }
        foreach ($total_pkh as $key => $data) {
            $total_pkh[$key] = $key . ': ' . $data;
        }
        foreach ($total_pbi as $key => $data) {
            $total_pbi[$key] = $key . ': ' . $data;
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
            'nama_page' => 'DTKS Per Desa | ' . $desa['data']['desa'],
            'content' => '[dtks_per_desa id_desa=' . $desa['data']['id2012'] . ']',
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
            <td class='text-center'>" . $total_dtks . "</td>
            <td>" . implode('<hr>', $total_blt) . "</td>
            <td>" . implode('<hr>', $total_blt_bbm) . "</td>
            <td>" . implode('<hr>', $total_bpnt) . "</td>
            <td>" . implode('<hr>', $total_pkh) . "</td>
            <td>" . implode('<hr>', $total_pbi) . "</td>
            <td class='text-center'><a style='margin-bottom: 5px;' onclick='cari_alamat(\"" . $search . "\"); return false;' href='#' class='btn btn-danger'>Map</a></td>
        </tr>
    ";
    $total_all += $total_dtks;
}
?>
<h1 class="text-center">Peta Sebaran DTKS (Data Terpadu Kesejahteraan Sosial)<br><?php echo $this->getNamaDaerah(); ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h3 style="margin-top: 20px;">Keterangan</h3>
    <ol>
        <li>Warna hijau berarti jumlah DTKS antara 0 sampai 1500 orang</li>
        <li>Warna kuning berarti jumlah DTKS antara 1501 sampai 3000 orang</li>
        <li>Warna merah berarti jumlah DTKS diatas 3000 orang</li>
        <li><b>BLT</b> (Bantuan Langsung Tunai)</li>
        <li><b>BLT-BBM</b> (Bantuan Langsung Tunai Bahan Bakar Minyak) adalah salah satu program jaring pengaman sosial yang diberikan sebagai upaya meringankan beban masyarakat akibat kenaikan harga bahan pokok kebutuhan hidup sehari-hari.</li>
        <li><b>BPNT</b> (Bantuan Pangan Non Tunai) adalah bantuan sosial pangan dalam bentuk non tunai dari pemerintah yang diberikan kepada KPM setiap bulannya. Penyaluran bansos BPNT melalui mekanisme akun elektronik yang digunakan hanya untuk membeli bahan pangan di pedagang bahan pangan/e-warong yang bekerjasama dengan bank.</li>
        <li><b>PKH</b> (Program Keluarga Harapan) adalah program yang dibuat sebagai upaya percepatan penanggulangan kemiskinan. PKH membuka akses keluarga miskin terutama ibu hamil dan anak untuk memanfaatkan berbagai fasilitas layanan kesehatan (faskes) dan fasilitas layanan pendidikan (fasdik) yang tersedia di sekitar tempat tinggal mereka.</li>
        <li><b>PBI-JK</b> (Penerima Bantuan Iuran Jaminan Kesehatan) adalah peserta jaminan kesehatan yang tergolong fakir miskin dan orang tidak mampu yang iuran BPJS Kesehatannya dibayarkan oleh pemerintah.</li>
    </ol>
    <h1 class="text-center">Tabel Data DTKS<br>Total <?php echo $this->number_format($total_all); ?> Orang</h1>
    <h3 class="text-center">Terakhir diupdate <?php echo $last_update_dtks; ?></h3>
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
                    <th class='text-center'>BLT</th>
                    <th class='text-center'>BLT BBM</th>
                    <th class='text-center'>BPNT</th>
                    <th class='text-center'>PKH</th>
                    <th class='text-center'>PBI</th>
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