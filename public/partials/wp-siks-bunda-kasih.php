<?php
$center = $this->get_center();
$maps_all = $this->get_polygon();
$bunda_kasih_all = $this->get_bunda_kasih();

$bunda_kasih_all_desa = array();
foreach($bunda_kasih_all as $data){
    $index = strtolower($data['provinsi']).'.'.strtolower($data['kabkot']).'.'.strtolower($data['kecamatan']).'.'.strtolower($data['desa']);
    if(empty($bunda_kasih_all_desa[$index])){
        $bunda_kasih_all_desa[$index] = array();
    }
    $bunda_kasih_all_desa[$index][] = $data;
}

$total_all = 0;
$body =  '';
foreach($maps_all as $i => $desa){
    $index = strtolower($desa['data']['provinsi']).'.'.strtolower($desa['data']['kab_kot']).'.'.strtolower($desa['data']['kecamatan']).'.'.strtolower($desa['data']['desa']);
    $total_bunda_kasih = 0;
    if(!empty($bunda_kasih_all_desa[$index])){
        foreach($bunda_kasih_all_desa[$index] as $orang){
            $total_bunda_kasih += $orang['jml'];
        }
    }
    if($total_bunda_kasih <= 15){
        $maps_all[$i]['color'] = '#0cbf00';
    }else if($total_bunda_kasih <= 40){
        $maps_all[$i]['color'] = '#fff70a';
    }else if($total_bunda_kasih > 40){
        $maps_all[$i]['color'] = '#ff0000';
    }
    $maps_all[$i]['index'] = $i;

    $html = '
        <table>
            <tr>
                <td><b>Total bunda_kasih</b></td>
                <td><b>'.$this->number_format($total_bunda_kasih).' Orang</b></td>
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
            <td class='text-center'>".$total_bunda_kasih."</td>
            <td class='text-center'><a style='margin-bottom: 5px;' onclick='cari_alamat_siks(\"".$search."\"); return false;' href='#' class='btn btn-danger'>Map</a></td>
        </tr>
    ";
    $total_all += $total_bunda_kasih;
}
?>
<h1 class="text-center">Peta Sebaran Bunda Kasih<br><?php echo $this->getNamaDaerah(); ?></h1>
<div style="width: 95%; margin: 0 auto; min-height: 90vh; padding-bottom: 75px;">
    <div id="map-canvas-siks" style="width: 100%; height: 400px;"></div>
    <h3 style="margin-top: 20px;">Keterangan</h3>
    <ol>
        <li>Warna hijau berarti jumlah Bunda Kasih antara 0 sampai 5 orang</li>
        <li>Warna kuning berarti jumlah Bunda Kasih antara 5 sampai 15 orang</li>
        <li>Warna merah berarti jumlah Bunda Kasih diatas 15 orang</li>
    </ol>
    <h2 class="text-center">Tabel Data Bunda Kasih<br>Total <?php echo $this->number_format($total_all); ?> Orang</h1>
    <div style="width: 100%; overflow: auto; height: 100vh;">
        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th class='text-center'>Kode Desa</th>
                    <th class='text-center'>Provinsi</th>
                    <th class='text-center'>Kabupaten/Kota</th>
                    <th class='text-center'>Kecamatan</th>
                    <th class='text-center'>Desa</th>
                    <th class='text-center'>Total Bunda Kasih</th>
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