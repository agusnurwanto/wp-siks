<?php
$api_key = get_option(SIKS_APIKEY);
$url = admin_url('admin-ajax.php');
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
?>
<style type="text/css">
    .wrap-table {
        overflow: auto;
        max-height: 100vh;
        width: 100%;
    }
</style>
<div style="padding: 10px;margin:0 0 3rem 0;">
    <h1 class="text-center" style="margin:3rem;">Manajemen Data Penerima Bansos Bunda Kasih</h1>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="tambah_data_bunda_kasih();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableManajemenBundaKasih" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Kartu Keluarga</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa</th>
                    <th class="text-center">RT / RW</th>
                    <th class="text-center">Lampiran</th>
                    <th class="text-center">Tahun Anggaran</th>
                    <th class="text-center" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade mt-4" id="modalTambahDataBundaKasih" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataBundaKasihLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataBundaKasihLabel">Tambah Data Bunda Kasih</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data" placeholder=''>
                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" class="form-control" id="nik">
                </div>
                <div class="form-group">
                    <label>Kartu Keluarga</label>
                    <input type="text" class="form-control" id="kk">
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama">
                </div>
                <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" class="form-control" id="provinsi">
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <input type="text" class="form-control" id="kecamatan">
                </div>
                <div class="form-group">
                    <label>Kabupaten / Kota</label>
                    <input type="text" class="form-control" id="kabkot">
                </div>
                <div class="form-group">
                    <label>Desa</label>
                    <input type="text" class="form-control" id="desa">
                </div>
                <div class="form-group">
                    <label for='rt_rw' style='display:inline-block'>RT / RW</label>
                    <input type='text' id='rt_rw' name="rt_rw" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label>Tahun Anggaran</label>
                    <input type="text" class="form-control" id="tahun_anggaran">
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Koordinat Latitude</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="latitude" name="latitude" placeholder="0" disabled>
                    </div>
                    <label class="col-md-2 col-form-label">Koordinat Longitude</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="longitude" name="longitude" placeholder="0" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Map</label>
                    <div class="col-md-10">
                        <div style="height:600px; width: 100%;" id="map-canvas-siks"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Lampiran</label>
                    <input type="file" name="file" class="form-control-file" id="lampiran" accept="application/pdf, .png, .jpg, .jpeg">
                    <div style="padding-top: 10px; padding-bottom: 10px;"><a id="file_lampiran_existing"></a></div>
                </div>
                <div>
                    <small>Upload file maksimal 1 Mb, berformat .pdf .png .jpg .jpeg</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="submitDataBundaKasih(this);" class="btn btn-primary send_data">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.global_file_upload = "<?php echo SIKS_PLUGIN_URL . 'public/media/bunda_kasih/'; ?>";
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    jQuery(document).ready(function() {
        get_data_bunda_kasih();
    });

    function get_data_bunda_kasih() {
        if (typeof tableBundaKasih === 'undefined') {
            window.tableBundaKasih = jQuery('#tableManajemenBundaKasih').DataTable({
                "processing": true,
                "serverSide": true,
                "search": {
                    return: true
                },
                "ajax": {
                    url: '<?php echo $url ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'action': 'get_datatable_bunda_kasih',
                        'api_key': '<?php echo $api_key ?>',
                    }
                },
                lengthMenu: [
                    [20, 50, 100, -1],
                    [20, 50, 100, "All"]
                ],
                order: [
                    [0, 'asc']
                ],
                "drawCallback": function(settings) {
                    jQuery("#wraploading").hide();
                },
                "columns": [{
                        "data": 'nik',
                        className: "text-center"
                    },
                    {
                        "data": 'kk',
                        className: "text-center"
                    },
                    {
                        "data": 'nama',
                        className: "text-center"
                    },
                    {
                        "data": 'provinsi',
                        className: "text-center"
                    },
                    {
                        "data": 'kabkot',
                        className: "text-center"
                    },
                    {
                        "data": 'kecamatan',
                        className: "text-center"
                    },
                    {
                        "data": 'desa',
                        className: "text-center"
                    },
                    {
                        "data": 'rt_rw',
                        className: "text-center"
                    },
                    {
                        "data": 'file_lampiran',
                        className: "text-center"
                    },
                    {
                        "data": 'tahun_anggaran',
                        className: "text-center"
                    },
                    {
                        "data": 'aksi',
                        className: "text-center"
                    },

                ]
            });
        } else {
            tableBundaKasih.draw();
        }
    }

    function hapus_data(id) {
        let confirmDelete = confirm("Apakah anda yakin akan menghapus data ini?");
        if (confirmDelete) {
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'post',
                data: {
                    'action': 'hapus_data_bunda_kasih_by_id',
                    'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    jQuery('#wrap-loading').hide();
                    if (response.status == 'success') {
                        get_data_bunda_kasih();
                    } else {
                        alert(`GAGAL! \n${response.message}`);
                    }
                }
            });
        }
    }

    function edit_data(_id) {
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            dataType: 'json',
            data: {
                'action': 'get_data_bunda_kasih_by_id',
                'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
                'id': _id,
            },
            success: function(res) {
                if (res.status == 'success') {

                    // Lokasi Center Map
                    if (
                        !res.data.lat ||
                        !res.data.lng
                    ) {
                        var lokasi_center = new google.maps.LatLng(maps_center_siks['lat'], maps_center_siks['lng']);
                    } else {
                        var lokasi_center = new google.maps.LatLng(res.data.lat, res.data.lng);
                    }

                    if (typeof evm != 'undefined') {
                        evm.setMap(null);
                    }

                    // Menampilkan Marker
                    window.evm = new google.maps.Marker({
                        position: lokasi_center,
                        map,
                        draggable: true,
                        title: 'Lokasi Map'
                    });

                    window.infoWindow = new google.maps.InfoWindow({
                        content: JSON.stringify(res.data)
                    });

                    google.maps.event.addListener(evm, 'click', function(event) {
                        infoWindow.setPosition(event.latLng);
                        infoWindow.open(map);
                    });

                    google.maps.event.addListener(evm, 'mouseup', function(event) {
                        jQuery('input[name="latitude"]').val(event.latLng.lat());
                        jQuery('input[name="longitude"]').val(event.latLng.lng());
                    });

                    jQuery('#id_data').val(res.data.id);
                    jQuery('#nama').val(res.data.nama);
                    jQuery('#kecamatan').val(res.data.kecamatan);
                    jQuery('#desa').val(res.data.desa);
                    jQuery('#provinsi').val(res.data.provinsi);
                    jQuery('#nik').val(res.data.nik);
                    jQuery('#kabkot').val(res.data.kabkot);
                    jQuery('#kk').val(res.data.kk);
                    jQuery('#rt_rw').val(res.data.rt_rw);
                    jQuery('#latitude').val(res.data.lat);
                    jQuery('#longitude').val(res.data.lng);
                    jQuery('#tahun_anggaran').val(res.data.tahun_anggaran);
                    jQuery('#file_lampiran_existing').attr('href', global_file_upload + res.data.file_lampiran).html(res.data.file_lampiran).show();
                    jQuery('#lampiran').val('').show();
                    jQuery('#modalTambahDataBundaKasih .send_data').show();
                    jQuery('#modalTambahDataBundaKasih').modal('show');
                } else {
                    alert(res.message);
                }
                jQuery('#wrap-loading').hide();
            }
        });
    }

    function tambah_data_bunda_kasih() {
        var lokasi_center = new google.maps.LatLng(maps_center_siks['lat'], maps_center_siks['lng']);

        if (typeof evm != 'undefined') {
            evm.setMap(null);
        }

        // Menampilkan Marker
        window.evm = new google.maps.Marker({
            position: lokasi_center,
            map,
            draggable: true,
            title: 'Lokasi Map'
        });

        google.maps.event.addListener(evm, 'mouseup', function(event) {
            jQuery('input[name="latitude"]').val(event.latLng.lat());
            jQuery('input[name="longitude"]').val(event.latLng.lng());
        });

        jQuery('#nama').val('').show();
        jQuery('#provinsi').val('').show();
        jQuery('#desa').val('').show();
        jQuery('#kecamatan').val('').show();
        jQuery('#nik').val('').show();
        jQuery('#kabkot').val('').show();
        jQuery('#kk').val('').show();
        jQuery('#rt_rw').val('').show();
        jQuery('#tahun_anggaran').val('').show();
        jQuery('#longitude').val(maps_center_siks['lng']).show();
        jQuery('#latitude').val(maps_center_siks['lat']).show();
        jQuery('#lampiran').val('').show();

        jQuery('#file_lampiran_existing').hide();
        jQuery('#file_lampiran_existing').closest('.form-group').find('input').show();
        jQuery('#modalTambahDataBundaKasih').modal('show');
    }

    function submitDataBundaKasih() {
        var id_data = jQuery('#id_data').val();
        var nama = jQuery('#nama').val();
        if (nama == '') {
            return alert('Data Nama tidak boleh kosong!');
        }
        var nik = jQuery('#nik').val();
        if (nik == '') {
            return alert('Data NIK tidak boleh kosong!');
        }
        var kabkot = jQuery('#kabkot').val();
        if (kabkot == '') {
            return alert('Data Kabupaten / Kota tidak boleh kosong!');
        }
        var kecamatan = jQuery('#kecamatan').val();
        if (kecamatan == '') {
            return alert('Data Kecamatan tidak boleh kosong!');
        }
        var desa = jQuery('#desa').val();
        if (desa == '') {
            return alert('Data Desa tidak boleh kosong!');
        }
        var provinsi = jQuery('#provinsi').val();
        if (provinsi == '') {
            return alert('Data Provinsi tidak boleh kosong!');
        }
        var kk = jQuery('#kk').val();
        if (kk == '') {
            return alert('Data Kartu Keluarga tidak boleh kosong!');
        }
        var rt_rw = jQuery('#rt_rw').val();
        if (rt_rw == '') {
            return alert('Data RT / RW tidak boleh kosong!');
        }
        var tahun_anggaran = jQuery('#tahun_anggaran').val();
        if (tahun_anggaran == '') {
            return alert('Data Tahun Anggaran tidak boleh kosong!');
        }
        var lampiran = jQuery('#lampiran')[0].files[0];
        if (id_data == '') {
            if (typeof lampiran == 'undefined') {
                return alert('Upload file lampiran dulu!');
            }
        }

        let tempData = new FormData();
        tempData.append('action', 'tambah_data_bunda_kasih');
        tempData.append('api_key', '<?php echo get_option(SIKS_APIKEY); ?>');
        tempData.append('id_data', id_data);
        tempData.append('nama', nama);
        tempData.append('nik', nik);
        tempData.append('kabkot', kabkot);
        tempData.append('kecamatan', kecamatan);
        tempData.append('desa', desa);
        tempData.append('provinsi', provinsi);
        tempData.append('kk', kk);
        tempData.append('rt_rw', rt_rw);
        tempData.append('tahun_anggaran', tahun_anggaran);
        tempData.append('lat', jQuery('input[name="latitude"]').val());
        tempData.append('lng', jQuery('input[name="longitude"]').val());

        if (typeof lampiran != 'undefined') {
            tempData.append('lampiran', lampiran);
        }
        tempData.append('lampiran', lampiran);

        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            dataType: 'json',
            data: tempData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(res) {
                alert(res.message);
                jQuery('#wrap-loading').hide();
                if (res.status == 'success') {
                    jQuery('#modalTambahDataBundaKasih').modal('hide');
                    get_data_bunda_kasih();
                }
            }
        });
    }
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>