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
    <h1 class="text-center" style="margin:3rem;">Manajemen Data Anak Terlantar</h1>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="tambah_data_anak_terlantar();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableManajemenAnakTerlantar" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Nama</th>
                    <th class="text-center">No KK</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">Tanggal Lahir</th>
                    <th class="text-center">Usia</th>
                    <th class="text-center">Pendidikan</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten/Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa/Kelurahan</th>
                    <th class="text-center">Alamat</th>
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
<div class="modal fade mt-4" id="modalTambahDataAnakTerlantar" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataAnakTerlantarLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataAnakTerlantarLabel">Tambah Data AnakTerlantar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data">
                <div class="form-group">
                    <label>Tahun Anggaran</label>
                    <input type="text" class="form-control" id="tahun_anggaran" placeholder="Masukkan Tahun Anggaran">
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama">
                </div>
                <div class="form-group">
                    <label>Nomor Kartu Keluarga</label>
                    <input type="number" class="form-control" id="kk" min="16" max="16" placeholder="Masukkan Nomor KK (max 16 digit)">
                </div>
                <div class="form-group">
                    <label>NIK</label>
                    <input type="number" class="form-control" id="nik" max="16" placeholder="Masukkan NIK (max 16 digit)">
                </div>
                <div class="form-group">
                    <label for="jenisKelamin">Jenis Kelamin</label>
                    <select class="form-control" id="jenisKelamin" name="jenisKelamin">
                        <option selected disabled>Masukkan Jenis Kelamin</option>
                        <option id="1" value="Laki-Laki">Laki-laki</option>
                        <option id="2" value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                </div>
                <div class="form-group">
                    <label>Usia</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="usia" placeholder="Masukkan Usia">
                        <div class="input-group-append">
                            <span class="input-group-text">Tahun</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Pendidikan</label>
                    <input type="text" class="form-control" id="pendidikan" placeholder="Masukkan Pendidikan">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" id="alamat" rows="4" placeholder="Masukkan Alamat"></textarea>
                </div>
                <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" class="form-control" id="provinsi" placeholder="Masukkan Provinsi">
                </div>
                <div class="form-group">
                    <label>Kabupaten/Kota</label>
                    <input type="text" class="form-control" id="kabkot" placeholder="Masukkan Kabupaten/Kota">
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <input type="text" class="form-control" id="kecamatan" placeholder="Masukkan Kecamatan">
                </div>
                <div class="form-group">
                    <label>Desa/Kelurahan</label>
                    <input type="text" class="form-control" id="desa_kelurahan" placeholder="Masukkan Desa/Kelurahan">
                </div>
                <div class="row form-group">
                    <label for='status_lembaga' class="col-md-12">Status Lembaga <span class="required">*</span></label>
                    <div class="col-md-12">
                        <input type='radio' id='dalam_lembaga' name='status_lembaga' value='1' checked>
                        <label class='mr-4' for='dalam_lembaga'>Dalam Lembaga</label>
                        <input type='radio' id='luar_lembaga' name='status_lembaga' value='0'>
                        <label for='luar_lembaga'>Luar Lembaga</label>
                    </div>
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
                <button type="submit" onclick="submitDataAnakTerlantar(this);" class="btn btn-primary send_data">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.global_file_upload = "<?php echo SIKS_PLUGIN_URL . 'public/media/anak_terlantar/'; ?>";
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    jQuery(document).ready(function() {
        get_data_anak_terlantar();
    });

    function get_data_anak_terlantar() {
        if (typeof tableAnakTerlantar === 'undefined') {
            window.tableAnakTerlantar = jQuery('#tableManajemenAnakTerlantar').DataTable({
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
                        'action': 'get_datatable_anak_terlantar',
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
                        "data": 'nama',
                        className: "text-center"
                    },
                    {
                        "data": 'kk',
                        className: "text-center"
                    },
                    {
                        "data": 'nik',
                        className: "text-center"
                    },
                    {
                        "data": 'jenis_kelamin',
                        className: "text-center"
                    },
                    {
                        "data": 'tanggal_lahir',
                        className: "text-center"
                    },
                    {
                        "data": 'usia',
                        className: "text-center"
                    },
                    {
                        "data": 'pendidikan',
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
                        "data": 'desa_kelurahan',
                        className: "text-center"
                    },
                    {
                        "data": 'alamat',
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
            tableAnakTerlantar.draw();
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
                    'action': 'hapus_data_anak_terlantar_by_id',
                    'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    jQuery('#wrap-loading').hide();
                    if (response.status == 'success') {
                        get_data_anak_terlantar();
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
                'action': 'get_anak_terlantar_by_id',
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
                    jQuery('#tahun_anggaran').val(res.data.tahun_anggaran);
                    jQuery('#nama').val(res.data.nama);
                    jQuery('#kk').val(res.data.kk);
                    jQuery('#nik').val(res.data.nik).trigger('change').prop('disabled', false);
                    jQuery('#jenisKelamin').val(res.data.jenis_kelamin).trigger('change').prop('disabled', false);
                    jQuery('#tanggal_lahir').val(res.data.tanggal_lahir).trigger('change').prop('disabled', false);
                    jQuery('#usia').val(res.data.usia);
                    jQuery('#pendidikan').val(res.data.pendidikan);
                    jQuery('#provinsi').val(res.data.provinsi);
                    jQuery('#alamat').val(res.data.alamat);
                    jQuery('#kabkot').val(res.data.kabkot);
                    jQuery('#kecamatan').val(res.data.kecamatan);
                    jQuery('#desa_kelurahan').val(res.data.desa_kelurahan);
                    if (res.data.status_lembaga === '1') {
                        jQuery('#dalam_lembaga').prop('checked', true);
                    } else if (res.data.status_lembaga === '0') {
                        jQuery('#luar_lembaga').prop('checked', true);
                    }
                    jQuery('#latitude').val(res.data.lat);
                    jQuery('#longitude').val(res.data.lng);
                    jQuery('#lampiran').val('').show();
                    jQuery('#file_lampiran_existing').attr('href', global_file_upload + res.data.file_lampiran).html(res.data.file_lampiran).show();
                    jQuery('#modalTambahDataAnakTerlantar').modal('show');
                } else {
                    alert(res.message);
                }
                jQuery('#wrap-loading').hide();
            }
        });
    }

    function tambah_data_anak_terlantar() {
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
        jQuery('#tahun_anggaran').val('').show();
        jQuery('#nama').val('').show();
        jQuery('#kk').val('').show();
        jQuery('#nik').val('').show();
        jQuery('#tanggal_lahir').prop('disabled', false);
        jQuery('#jenisKelamin').val('').prop('disabled', false);
        jQuery('#usia').val('').show();
        jQuery('#pendidikan').val('').show();
        jQuery('#usia').val('').show();
        jQuery('input[name="status_lembaga"]').prop('disabled', false);
        jQuery('#provinsi').val('').show();
        jQuery('#alamat').val('').show();
        jQuery('#kabkot').val('').show();
        jQuery('#desa_kelurahan').val('').show();
        jQuery('#kecamatan').val('').show();
        jQuery('#lampiran').val('').show();

        jQuery('#file_lampiran_existing').hide();
        jQuery('#file_lampiran_existing').closest('.form-group').find('input').show();
        jQuery('#modalTambahDataAnakTerlantar').modal('show');
    }

    function submitDataAnakTerlantar() {
        var id_data = jQuery('#id_data').val();
        var nama = jQuery('#nama').val();
        if (nama == '') {
            return alert('Data Nama tidak boleh kosong!');
        }
        var nik = jQuery('#nik').val().toString();
        if (nik.length > 16) {
            alert("Input NIK maksimal 16 digit");
            return;
        }
        var kk = jQuery('#kk').val().toString();
        if (kk.length > 16) {
            alert("Input KK maksimal 16 digit");
            return;
        }
        var tanggal_lahir = jQuery('#tanggal_lahir').val();
        if (tanggal_lahir == '') {
            return alert('Data Tanggal Lahir tidak boleh kosong!');
        }
        var provinsi = jQuery('#provinsi').val();
        if (provinsi == '') {
            return alert('Data Provinsi tidak boleh kosong!');
        }
        var kabkot = jQuery('#kabkot').val();
        if (kabkot == '') {
            return alert('Data Kabupaten / Kota tidak boleh kosong!');
        }
        var kecamatan = jQuery('#kecamatan').val();
        if (kecamatan == '') {
            return alert('Data Kecamatan tidak boleh kosong!');
        }
        var desa_kelurahan = jQuery('#desa_kelurahan').val();
        if (desa_kelurahan == '') {
            return alert('Data Desa tidak boleh kosong!');
        }
        var alamat = jQuery('#alamat').val();
        if (alamat == '') {
            return alert('Data Alamat tidak boleh kosong!');
        }
        var usia = jQuery('#usia').val();
        if (usia == '') {
            return alert('Data Usia tidak boleh kosong!');
        }
        var status_lembaga = jQuery('input[name="status_lembaga"]:checked').val();
        if (status_lembaga == '') {
            return alert('Data Status Lembaga tidak boleh kosong!');
        }
        var jenisKelamin = jQuery('#jenis_kelamin').val();
        if (jenisKelamin == '') {
            return alert('Data Jenis Kelamin tidak boleh kosong!');
        }
        var pendidikan = jQuery('#pendidikan').val();
        if (pendidikan == '') {
            return alert('Data  Pendidikan tidak boleh kosong!');
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
        tempData.append('action', 'tambah_data_anak_terlantar');
        tempData.append('api_key', '<?php echo get_option(SIKS_APIKEY); ?>');
        tempData.append('id_data', id_data);
        tempData.append('nama', nama);
        tempData.append('kk', kk);
        tempData.append('nik', nik);
        tempData.append('tanggal_lahir', tanggal_lahir);
        tempData.append('jenis_kelamin', jenisKelamin);
        tempData.append('provinsi', provinsi);
        tempData.append('kabkot', kabkot);
        tempData.append('kecamatan', kecamatan);
        tempData.append('desa_kelurahan', desa_kelurahan);
        tempData.append('alamat', alamat);
        tempData.append('usia', usia);
        tempData.append('pendidikan', pendidikan);
        tempData.append('kelembagaan', status_lembaga);
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
                    jQuery('#modalTambahDataAnakTerlantar').modal('hide');
                    get_data_anak_terlantar();
                }
            }
        });
    }
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>