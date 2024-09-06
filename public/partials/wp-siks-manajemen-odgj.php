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
    <h1 class="text-center" style="margin:3rem;">Manajemen Data Orang Gangguan Jiwa ( ODGJ )</h1>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="tambah_data_odgj();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableManajemenODGJ" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Kartu Keluarga</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa</th>
                    <th class="text-center">RT</th>
                    <th class="text-center">RW</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">Usia</th>
                    <th class="text-center">Nama Orangtua</th>
                    <th class="text-center">Pengobatan</th>
                    <th class="text-center">Keterangan</th>
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
<div class="modal fade mt-4" id="modalTambahDataODGJ" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataODGJ" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataODGJ">Tambah Data Orang Gangguan Jiwa ( ODGJ )</h5>
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
                    <label for='rt' style='display:inline-block'>RT</label>
                    <input type='text' id='rt' name="rt" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='rw' style='display:inline-block'>RW</label>
                    <input type='text' id='rw' name="rw" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='jenis_kelamin' style='display:inline-block'>Jenis Kelamin</label>
                    <input type='text' id='jenis_kelamin' name="jenis_kelamin" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='usia' style='display:inline-block'>Usia</label>
                    <input type='text' id='usia' name="usia" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='nama_ortu' style='display:inline-block'>Nama Orangtua</label>
                    <input type='text' id='nama_ortu' name="nama_ortu" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='pengobatan' style='display:inline-block'>Pengobatan</label>
                    <input type='text' id='pengobatan' name="pengobatan" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='keterangan' style='display:inline-block'>Keterangan</label>
                    <input type='text' id='keterangan' name="keterangan" class="form-control" placeholder=''>
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
                <div><small>Upload file maksimal 1 Mb, berformat .pdf .png .jpg .jpeg</small></div>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="submitDataODGJ(this);" class="btn btn-primary send_data">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>
<script>
    window.global_file_upload = "<?php echo SIKS_PLUGIN_URL . 'public/media/odgj/'; ?>";
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    jQuery(document).ready(function() {
        get_data_odgj();
    });

    function get_data_odgj() {
        if (typeof tableODGJ === 'undefined') {
            window.tableODGJ = jQuery('#tableManajemenODGJ').DataTable({
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
                        'action': 'get_datatable_odgj',
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
                        "data": 'rt',
                        className: "text-center"
                    },
                    {
                        "data": 'rw',
                        className: "text-center"
                    },
                    {
                        "data": 'jenis_kelamin',
                        className: "text-center"
                    },
                    {
                        "data": 'usia',
                        className: "text-center"
                    },
                    {
                        "data": 'nama_ortu',
                        className: "text-center"
                    },
                    {
                        "data": 'pengobatan',
                        className: "text-center"
                    },
                    {
                        "data": 'keterangan',
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
            tableODGJ.draw();
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
                    'action': 'hapus_data_odgj_by_id',
                    'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    jQuery('#wrap-loading').hide();
                    if (response.status == 'success') {
                        get_data_odgj();
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
                'action': 'get_data_odgj_by_id',
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
                    jQuery('#rt').val(res.data.rt);
                    jQuery('#rw').val(res.data.rw);
                    jQuery('#jenis_kelamin').val(res.data.jenis_kelamin);
                    jQuery('#usia').val(res.data.usia);
                    jQuery('#nama_ortu').val(res.data.nama_ortu);
                    jQuery('#pengobatan').val(res.data.pengobatan);
                    jQuery('#keterangan').val(res.data.keterangan);
                    jQuery('#tahun_anggaran').val(res.data.tahun_anggaran);
                    jQuery('#latitude').val(res.data.lat);
                    jQuery('#longitude').val(res.data.lng);
                    jQuery('#lampiran').val('').show();
                    jQuery('#file_lampiran_existing').attr('href', global_file_upload + res.data.file_lampiran).html(res.data.file_lampiran).show();
                    jQuery('#modalTambahDataODGJ .send_data').show();
                    jQuery('#modalTambahDataODGJ').modal('show');
                } else {
                    alert(res.message);
                }
                jQuery('#wrap-loading').hide();
            }
        });
    }

    function tambah_data_odgj() {
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

        jQuery('#longitude').val(maps_center_siks['lng']).show();
        jQuery('#latitude').val(maps_center_siks['lat']).show();
        jQuery('#nama').val('').show();
        jQuery('#provinsi').val('').show();
        jQuery('#desa').val('').show();
        jQuery('#kecamatan').val('').show();
        jQuery('#nik').val('').show();
        jQuery('#kabkot').val('').show();
        jQuery('#kk').val('').show();
        jQuery('#rt').val('').show();
        jQuery('#rw').val('').show();
        jQuery('#jenis_kelamin').val('').show();
        jQuery('#nama_ortu').val('').show();
        jQuery('#usia').val('').show();
        jQuery('#pengobatan').val('').show();
        jQuery('#keterangan').val('').show();
        jQuery('#tahun_anggaran').val('').show();
        jQuery('#lampiran').val('').show();

        jQuery('#file_lampiran_existing').hide();
        jQuery('#file_lampiran_existing').closest('.form-group').find('input').show();
        jQuery('#modalTambahDataODGJ').modal('show');
    }

    function submitDataODGJ() {
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
        var rt = jQuery('#rt').val();
        if (rt == '') {
            return alert('Data RT tidak boleh kosong!');
        }
        var rw = jQuery('#rw').val();
        if (rw == '') {
            return alert('Data RW tidak boleh kosong!');
        }
        var jenis_kelamin = jQuery('#jenis_kelamin').val();
        if (jenis_kelamin == '') {
            return alert('Data Jenis Kelamin tidak boleh kosong!');
        }
        var usia = jQuery('#usia').val();
        if (usia == '') {
            return alert('Data Usia tidak boleh kosong!');
        }
        var nama_ortu = jQuery('#nama_ortu').val();
        if (nama_ortu == '') {
            return alert('Data Nama Ortu tidak boleh kosong!');
        }
        var pengobatan = jQuery('#pengobatan').val();
        if (pengobatan == '') {
            return alert('Data Pengobatan tidak boleh kosong!');
        }
        var keterangan = jQuery('#keterangan').val();
        if (keterangan == '') {
            return alert('Data Keterangan tidak boleh kosong!');
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
        tempData.append('action', 'tambah_data_odgj');
        tempData.append('api_key', '<?php echo get_option(SIKS_APIKEY); ?>');
        tempData.append('id_data', id_data);
        tempData.append('nama', nama);
        tempData.append('nik', nik);
        tempData.append('kabkot', kabkot);
        tempData.append('kecamatan', kecamatan);
        tempData.append('desa', desa);
        tempData.append('provinsi', provinsi);
        tempData.append('kk', kk);
        tempData.append('rt', rt);
        tempData.append('rw', rw);
        tempData.append('jenis_kelamin', jenis_kelamin);
        tempData.append('usia', usia);
        tempData.append('nama_ortu', nama_ortu);
        tempData.append('pengobatan', pengobatan);
        tempData.append('keterangan', keterangan);
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
                if (res.status == 'success') {
                    jQuery('#modalTambahDataODGJ').modal('hide');
                    get_data_odgj();
                }
                jQuery('#wrap-loading').hide();
            }
        });
    }
</script>