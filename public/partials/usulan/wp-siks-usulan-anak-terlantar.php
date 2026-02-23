<?php
$input = shortcode_atts(array(
    'id_desa' => ''
), $atts);
if (empty($input['id_desa'])) {
    die('id_desa kosong');
}

$validate_user = $this->user_authorization($input['id_desa']);
if ($validate_user['status'] === 'error') {
    die($validate_user['message']);
} else {
    echo "<script>console.log('Debug Objects: " . $validate_user['message'] . "' );</script>";
}
global $wpdb;
$center = $this->get_center();
$maps_all = $this->get_polygon();

// auto input alamat
$provinsi  = get_option(SIKS_PROV);
$kabkot    = get_option(SIKS_KABKOT);

$get_desa_kel  = $wpdb->get_row(
    $wpdb->prepare('
        SELECT 
            is_kel,
            nama
        FROM data_alamat_siks
        WHERE id_desa = %d
          AND active = 1
    ', $input['id_desa']),
    ARRAY_A
);

if ($get_desa_kel['is_kel'] == 1) {
    $nama_desa_kelurahan = 'Kelurahan ' . $get_desa_kel['nama'];
} else {
    $nama_desa_kelurahan = 'Desa ' . $get_desa_kel['nama'];
}

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
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<div class="pb-4 mb-5">
    <h1 class="text-center my-4">Data Usulan Anak Terlantar</h1>
    <h2 class="text-center my-4"><?php echo strtoupper($nama_desa_kelurahan); ?></h2>
    <?php if ($validate_user['roles'] === 'desa'): ?>
        <div class="m-4">
            <button class="btn btn-primary" onclick="showModalTambahData();">
                <span class="dashicons dashicons-plus"></span> Tambah Data
            </button>
        </div>
    <?php endif; ?>
</div>
<div class="wrap-table m-4">
    <table id="tableData">
        <thead>
            <tr>
                <th class="text-center">Status Verifikasi</th>
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
                <th class="text-center">RT</th>
                <th class="text-center">RW</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Lampiran</th>
                <th class="text-center">Tahun Anggaran</th>
                <th class="text-center">Dibuat Pada</th>
                <th class="text-center">Terakhir Diperbarui</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade mt-4" id="modalTambahData" tabindex="-1" role="dialog" aria-labelledby="modalTambahData" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulmodalTambahData">Tambah Data Anak Terlantar</h5>
                <h5 class="modal-title" id="judulModalEdit">Edit Data Anak Terlantar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" id="id_data" name="id_data">

                    <!-- Card 0: General -->
                    <div class="card mb-4">
                        <div class="card-header">Tahun Anggaran</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tahun Anggaran</label>
                                        <input type="text" class="form-control" id="tahunAnggaran" name="tahunAnggaran" placeholder="Masukkan Tahun Anggaran">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 1: Data Diri -->
                    <div class="card mb-4">
                        <div class="card-header">Data Diri</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nomor Kartu Keluarga</label>
                                        <input type="number" class="form-control" id="kk" name="kk" placeholder="Masukkan Nomor KK (max 16 digit)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input type="number" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK (max 16 digit)">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select class="form-control" id="jenisKelamin" name="jenisKelamin">
                                            <option value="">Masukkan Jenis Kelamin</option>
                                            <option value="Laki-Laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pendidikan Terakhir</label>
                                        <input type="text" class="form-control" id="pendidikan" name="pendidikan" placeholder="Masukkan Pendidikan Terakhir">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Usia</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="usia" name="usia" placeholder="Masukkan Usia">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Tahun</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggalLahir">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Jenis Lembaga</label>
                                    <div class="form-group">
                                        <input type="radio" id="dalam_lembaga" name="statusLembaga" value="1" checked>
                                        <label class="mr-4" for="dalam_lembaga">Dalam Lembaga</label>
                                        <input type="radio" id="luar_lembaga" name="statusLembaga" value="0">
                                        <label for="luar_lembaga">Luar Lembaga</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Alamat -->
                    <div class="card mb-4">
                        <div class="card-header">Alamat</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Provinsi</label>
                                        <input type="text" class="form-control" id="provinsi" name="provinsi" value="<?php echo $provinsi; ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kabupaten/Kota</label>
                                        <input type="text" class="form-control" id="kabkot" name="kabkot" value="<?php echo $kabkot; ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?php echo strtoupper($validate_user['kecamatan']); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Desa/Kelurahan</label>
                                        <input type="text" class="form-control" id="desaKelurahan" name="desaKelurahan" value="<?php echo strtoupper($validate_user['desa']); ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for='rt'>RT</label>
                                        <input type='number' id='rt' name='rt' class='form-control' placeholder="Contoh: 01">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for='rw'>RW</label>
                                        <input type='number' id='rw' name='rw' class='form-control' placeholder="Contoh: 02">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Lampiran -->
                    <div class="card mb-4">
                        <div class="card-header">Lampiran</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Lampiran</label>
                                <input type="file" name="file" class="form-control-file" id="lampiran" accept="application/pdf, .png, .jpg, .jpeg">
                                <div style="padding-top: 10px; padding-bottom: 10px;"><a id="file_lampiran_existing"></a></div>
                                <small>Upload file maksimal 1 Mb, berformat .pdf, .png, .jpg, .jpeg</small>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Koordinat dan Map -->
                    <div class="card mb-4">
                        <div class="card-header">Koordinat dan Peta</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Koordinat Latitude</label>
                                        <input type="text" class="form-control" id="latitude" name="latitude" placeholder="0" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Koordinat Longitude</label>
                                        <input type="text" class="form-control" id="longitude" name="longitude" placeholder="0" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div style="height:600px; width:100%;" id="map-canvas-siks"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="submitData();" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal Verifikasi -->
<div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formVerifikasi">
                    <input type="hidden" name="idDataVerifikasi" id="idDataVerifikasi" value="">
                    <div class="mb-3">
                        <label for="verifikasiStatus" class="form-label">Status Verifikasi</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="verifikasiStatus" id="statusTerima" value="2">
                                <label class="form-check-label" for="statusTerima">Terima</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="verifikasiStatus" id="statusTolak" value="3">
                                <label class="form-check-label" for="statusTolak">Tolak</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="keteranganVerifikasi" class="form-label">Keterangan Verifikasi</label>
                        <textarea class="form-control" id="keteranganVerifikasi" name="keteranganVerifikasi" rows="3" placeholder="diterima/ditolak karena ..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitVerifikasi()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.global_file_upload = "<?php echo SIKS_PLUGIN_URL . 'public/media/anak_terlantar/'; ?>";
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    window.id_desa = <?php echo json_encode($input['id_desa']); ?>;
    jQuery(document).ready(function() {
        getDataTable();
    });

    function getDataTable() {
        if (typeof tableAnakTerlantar === 'undefined') {
            window.tableAnakTerlantar = jQuery('#tableData').on('preXhr.dt', function(e, settings, data) {
                jQuery("#wrap-loading").show();
            }).DataTable({
                "processing": true,
                "serverSide": true,
                "search": {
                    return: true
                },
                "ajax": {
                    url: ajax.url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'action': 'get_datatable_data_usulan_anak_terlantar',
                        'api_key': ajax.apikey,
                        'id_desa': id_desa
                    }
                },
                lengthMenu: [
                    [20, 50, 100, -1],
                    [20, 50, 100, "All"]
                ],
                order: [],
                "drawCallback": function(settings) {
                    jQuery("#wrap-loading").hide();
                },
                "columns": [{
                        "data": 'status_data',
                        className: "text-center"
                    },
                    {
                        "data": 'nama',
                        className: "text-left"
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
                        "data": 'rt',
                        className: "text-left"
                    },
                    {
                        "data": 'rw',
                        className: "text-left"
                    },
                    {
                        "data": 'alamat',
                        className: "text-left"
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
                        "data": 'create_at',
                        className: "text-center"
                    },
                    {
                        "data": 'update_at',
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
                url: ajax.url,
                type: 'post',
                data: {
                    'action': 'hapus_data_usulan_anak_terlantar_by_id',
                    'api_key': ajax.apikey,
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        alert("Berhasil Hapus Data!");
                        getDataTable();
                    } else {
                        alert(`GAGAL! \n${response.message}`);
                    }
                }
            });
        }
    }


    function edit_data(id) {
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: ajax.url,
            dataType: 'json',
            data: {
                'action': 'get_data_usulan_anak_terlantar_by_id',
                'api_key': ajax.apikey,
                'id': id,
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
                    jQuery('#judulModalEdit').show();
                    jQuery('#judulmodalTambahData').hide();

                    jQuery('#id_data').val(res.data.id);
                    jQuery('#tahunAnggaran').val(res.data.tahun_anggaran);
                    jQuery('#nama').val(res.data.nama);
                    jQuery('#kk').val(res.data.kk);
                    jQuery('#nik').val(res.data.nik).trigger('change')
                    jQuery('#jenisKelamin').val(res.data.jenis_kelamin).trigger('change')
                    jQuery('#tanggalLahir').val(res.data.tanggal_lahir).trigger('change')
                    jQuery('#usia').val(res.data.usia);
                    jQuery('#pendidikan').val(res.data.pendidikan);
                    jQuery('#alamat').val(res.data.alamat);
                    jQuery('#rt').val(res.data.rt);
                    jQuery('#rw').val(res.data.rw);
                    jQuery('input[name="statusLembaga"]').prop('checked', false);
                    if (res.data.kelembagaan === '1') {
                        jQuery('#dalam_lembaga').prop('checked', true);
                    } else if (res.data.kelembagaan === '0') {
                        jQuery('#luar_lembaga').prop('checked', true);
                    }
                    jQuery('#latitude').val(res.data.lat);
                    jQuery('#longitude').val(res.data.lng);

                    jQuery('#lampiran').val('').show();
                    jQuery('#file_lampiran_existing').attr('href', global_file_upload + res.data.file_lampiran).html(res.data.file_lampiran).show();
                    jQuery('#modalTambahData').modal('show');
                } else {
                    alert(res.message);
                }
                jQuery('#wrap-loading').hide();
            }
        });
    }

    function showModalTambahData() {
        let lokasi_center = new google.maps.LatLng(maps_center_siks['lat'], maps_center_siks['lng']);

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
        jQuery('#judulModalEdit').hide();
        jQuery('#judulmodalTambahData').show();

        jQuery('#id_data').val('');


        jQuery('#longitude').val(maps_center_siks['lng']);
        jQuery('#latitude').val(maps_center_siks['lat']);
        jQuery('#tahunAnggaran').val('');
        jQuery('#nama').val('');
        jQuery('#kk').val('');
        jQuery('#nik').val('');
        jQuery('#tanggalLahir').val('');
        jQuery('#jenisKelamin').val('');
        jQuery('#usia').val('');
        jQuery('#pendidikan').val('');
        jQuery('#usia').val('');
        jQuery('input[name="statusLembaga"]').prop('checked', false);
        jQuery('#alamat').val('');
        jQuery('#rt').val('');
        jQuery('#rw').val('');
        jQuery('#lampiran').val('');

        jQuery('#file_lampiran_existing').hide();
        jQuery('#file_lampiran_existing').closest('.form-group').find('input').show();

        jQuery('#modalTambahData').modal('show');
    }

    function showModalVerifikasi(id) {
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: ajax.url,
            dataType: 'JSON',
            data: {
                'action': 'get_status_verifikasi_usulan',
                'api_key': ajax.apikey,
                'id': id,
                'jenis_data': 'anak terlantar'
            },
            success: function(res) {
                if (res.status === 'success') {
                    jQuery('#idDataVerifikasi').val('');
                    jQuery('#idDataVerifikasi').val(res.data.id);
                    jQuery('#keteranganVerifikasi').text('');
                    jQuery('#keteranganVerifikasi').text(res.data.keterangan_verifikasi);
                    jQuery('input[name="verifikasiStatus"]').prop('checked', false);
                    if (res.data.status_data) {
                        switch (res.data.status_data) {
                            case '1':
                                jQuery('input[name="verifikasiStatus"]').prop('checked', false);
                                break;
                            case '2':
                                jQuery('#statusTerima').prop('checked', true);
                                break;
                            case '3':
                                jQuery('#statusTolak').prop('checked', true);
                                break;
                        }
                    }
                } else {
                    alert(res.message);
                    jQuery('#wrap-loading').hide();
                }
                jQuery('#wrap-loading').hide();
                jQuery('#verifikasiModal').modal('show');
            },
            error: function(e) {
                alert(e.message);
                jQuery('#wrap-loading').hide();
            }
        });
    }

    function submitVerifikasi() {
        const validationRules = {
            'idDataVerifikasi': 'id kosong!',
            'verifikasiStatus': 'Status verifikasi tidak boleh kosong!',
            'keteranganVerifikasi': 'Keterangan verifikasi tidak boleh kosong!',
            // Tambahkan field lain jika diperlukan
        };

        const {
            error,
            data
        } = validateForm(validationRules);
        if (error) {
            return alert(error);
        }

        const tempData = new FormData();
        tempData.append('action', 'submit_verifikasi_usulan');
        tempData.append('api_key', ajax.apikey);
        tempData.append('jenis_data', 'anak terlantar');

        for (const [key, value] of Object.entries(data)) {
            tempData.append(key, value);
        }
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: ajax.url,
            dataType: 'JSON',
            data: tempData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(res) {
                alert(res.message);
                jQuery('#wrap-loading').hide();
                jQuery('#verifikasiModal').modal('hide');
                getDataTable();
            },
            error: function(e) {
                alert(e.message);
                jQuery('#wrap-loading').hide();
            }
        });
    }

    function submitUsulan(id) {
        let confirmSubmitUsulan = confirm("Apakah anda yakin akan mensubmit data ini?");
        if (confirmSubmitUsulan) {
            const tempData = new FormData();
            tempData.append('action', 'submit_usulan');
            tempData.append('api_key', ajax.apikey);
            tempData.append('idDataVerifikasi', id);
            tempData.append('jenis_data', 'anak terlantar');

            jQuery('#wrap-loading').show();
            jQuery.ajax({
                method: 'post',
                url: ajax.url,
                dataType: 'JSON',
                data: tempData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(res) {
                    alert(res.message);
                    jQuery('#wrap-loading').hide();
                    jQuery('#verifikasiModal').modal('hide');
                    getDataTable();
                },
                error: function(e) {
                    alert(e.message);
                    jQuery('#wrap-loading').hide();
                }
            });
        }
    }

    function submitData() {
        const validationRules = {
            'tahunAnggaran': 'Tahun Anggaran tidak boleh kosong!',
            'nama': 'Nama tidak boleh kosong!',
            'kk': 'Nomor Kartu Keluarga tidak boleh kosong!',
            'nik': 'NIK tidak boleh kosong!',
            'jenisKelamin': 'Jenis Kelamin harus dipilih!',
            'tanggalLahir': 'Tanggal Lahir tidak boleh kosong!',
            'usia': 'Usia tidak boleh kosong!',
            'pendidikan': 'Pendidikan tidak boleh kosong!',
            'alamat': 'Alamat tidak boleh kosong!',
            'rt': 'RT tidak boleh kosong!',
            'rw': 'RW tidak boleh kosong!',
            'latitude': 'Koordinat Latitude tidak boleh kosong!',
            'longitude': 'Koordinat Longitude tidak boleh kosong!',
            'statusLembaga': 'Status Lembaga harus dipilih!'
        };

        const {
            error,
            data
        } = validateForm(validationRules);
        if (error) {
            return alert(error);
        }
        const lampiran = jQuery('#lampiran')[0].files[0];
        const id_data = jQuery('#id_data').val();
        if (id_data == '') {
            if (typeof lampiran == 'undefined') {
                return alert('Upload file lampiran dulu!');
            }
        }

        const tempData = new FormData();
        tempData.append('action', 'tambah_data_usulan_anak_terlantar');
        tempData.append('api_key', ajax.apikey);
        tempData.append('id_data', id_data);
        tempData.append('id_desa', id_desa);
        if (typeof lampiran != 'undefined') {
            tempData.append('lampiran', lampiran);
        }

        for (const [key, value] of Object.entries(data)) {
            tempData.append(key, value);
        }

        jQuery('#wrap-loading').show();

        jQuery.ajax({
            method: 'post',
            url: ajax.url,
            dataType: 'json',
            data: tempData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(res) {
                alert(res.message);
                jQuery('#wrap-loading').hide();
                if (res.status === 'success') {
                    jQuery('#modalTambahData').modal('hide');
                    getDataTable();
                }
            }
        });
    }
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>