<?php
$center = $this->get_center();
$maps_all = $this->get_polygon();
$lansia_all = $this->get_lansia();

$last_update_lansia =  null;
$lansia_all_desa = array();
foreach($lansia_all as $data){
    $index = strtolower($data['provinsi']).'.'.strtolower($data['kabkot']).'.'.strtolower($data['kecamatan']).'.'.strtolower($data['desa']);
    if(empty($lansia_all_desa[$index])){
        $lansia_all_desa[$index] = array();
    }
    if ($last_update_lansia === null || $data['last_update'] > $last_update_lansia) {
        $last_update_lansia = $data['last_update'];
    }
    $lansia_all_desa[$index][] = $data;
}

$total_all = 0;
$body =  '';
foreach($maps_all as $i => $desa){
    $index = strtolower($desa['data']['provinsi']).'.'.strtolower($desa['data']['kab_kot']).'.'.strtolower($desa['data']['kecamatan']).'.'.strtolower($desa['data']['desa']);
    $total_lansia = 0;
    if($total_lansia <= 0){
        $maps_all[$i]['color'] = '#0cbf00';
    }
    $maps_all[$i]['index'] = $i;

    $html = '
        <table>
            <tr>
                <td><b>Total Gepeng</b></td>
                <td><b>'.$this->number_format($total_lansia).' Orang</b></td>
            </tr>
    ';
    foreach($desa['data'] as $k => $v){
        $html .= '
            <tr>
                <td><b>'.$k.'</b></td>
                <td>'.$v.'</td>
            </tr>
        ';
    }
    $html .= '</table>';
    $maps_all[$i]['html'] = $html;

    $search = $this->getSearchLocation($desa['data']);
    $body .= "
        <tr>
            <td class='text-center'>".$desa['data']['id2012']."</td>
            <td class='text-center'>".$desa['data']['provinsi']."</td>
            <td class='text-center'>".$desa['data']['kab_kot']."</td>
            <td class='text-center'>".$desa['data']['kecamatan']."</td>
            <td class='text-center'>".$desa['data']['desa']."</td>
            <td class='text-center'>0</td>
            <td class='text-center'><a style='margin-bottom: 5px;' onclick='cari_alamat_siks(\"".$search."\"); return false;' href='#' class='btn btn-danger'>Map</a></td>
        </tr>
    ";
    $total_all += $total_lansia;
}
?>
<h1 class="text-center">Peta Sebaran Gepeng ( Gelandangan dan Pengemis )<br><?php echo $this->getNamaDaerah(); ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h3 style="margin-top: 20px;">Keterangan</h3>
    <ol>
        <li>Warna hijau berarti jumlah Gepeng antara 0 sampai 15 orang</li>
        <li>Warna kuning berarti jumlah Gepeng antara 16 sampai 40 orang</li>
        <li>Warna merah berarti jumlah Gepeng diatas 40 orang</li>
    </ol>
    <h2 class="text-center">Tabel Data Gepeng<br>Total 0 Orang</h1>
    <h3 class="text-center">Terakhir diupdate <?php echo $last_update_lansia?></h3>
    <div style="width: 100%; overflow: auto; height: 100vh;">
        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th class='text-center'>Kode Desa</th>
                    <th class='text-center'>Provinsi</th>
                    <th class='text-center'>Kabupaten/Kota</th>
                    <th class='text-center'>Kecamatan</th>
                    <th class='text-center'>Desa</th>
                    <th class='text-center'>Total Gepeng</th>
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
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        order: [[5, 'desc']]
    });
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>