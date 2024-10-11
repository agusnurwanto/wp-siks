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
    <h1 class="text-center my-4">Data Usulan P3KE</h1>
    <h2 class="text-center my-4">(Penyasaran Percepatan Penghapusan Kemiskinan Ekstrem)</h2>
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
                <th class="text-center">NIK</th>
                <th class="text-center">Kartu Keluarga</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Provinsi</th>
                <th class="text-center">Kabupaten / Kota</th>
                <th class="text-center">Kecamatan</th>
                <th class="text-center">Desa</th>
                <th class="text-center">RT</th>
                <th class="text-center">RW</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Pekerjaan</th>
                <th class="text-center">Program</th>
                <th class="text-center">Penghasilan</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Lampiran</th>
                <th class="text-center">Tahun Anggaran</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- modal tambah data -->
<div class="modal fade mt-4" id="modalTambahData" tabindex="-1" role="dialog" aria-labelledby="judulmodalTambahData" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulmodalTambahData">Tambah Data P3KE</h5>
                <h5 class="modal-title" id="judulModalEdit">Edit Data P3KE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_data" name="id_data">

                <!-- Card: Tahun Anggaran -->
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Tahun Anggaran</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tahunAnggaran">Tahun Anggaran</label>
                            <input type="number" class="form-control" id="tahunAnggaran" name="tahunAnggaran">
                        </div>
                    </div>
                </div>

                <!-- Card: Data Pribadi -->
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Data Pribadi</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nik">NIK</label>
                                <input type="number" class="form-control" id="nik" name="nik">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="kk">Kartu Keluarga</label>
                                <input type="number" class="form-control" id="kk" name="kk">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                    </div>
                </div>

                <!-- Card: Alamat -->
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Alamat</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="provinsi">Provinsi</label>
                                <input type="text" class="form-control" id="provinsi" value="<?php echo $provinsi; ?>" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="kabkot">Kabupaten / Kota</label>
                                <input type="text" class="form-control" id="kabkot" value="<?php echo $kabkot; ?>" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="kecamatan">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" value="<?php echo strtoupper($validate_user['kecamatan']); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="desa">Desa</label>
                                <input type="text" class="form-control" id="desa" value="<?php echo strtoupper($validate_user['desa']); ?>" disabled>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="rt">RT</label>
                                <input type="text" class="form-control" id="rt" name="rt">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="rw">RW</label>
                                <input type="text" class="form-control" id="rw" name="rw">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat Lengkap</label>
                            <input type="text" class="form-control" id="alamat" name="alamat">
                        </div>
                    </div>
                </div>

                <!-- Card: Pekerjaan dan Program -->
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Pekerjaan dan Program</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
                        </div>
                        <div class="form-group">
                            <label for="program">Program</label>
                            <input type="text" class="form-control" id="program" name="program">
                        </div>
                        <div class="form-group">
                            <label for="penghasilan">Penghasilan</label>
                            <input type="text" class="form-control" id="penghasilan" name="penghasilan">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>
                    </div>
                </div>

                <!-- Card: Peta & Koordinat -->
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Peta & Koordinat</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="latitude">Koordinat Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="0" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="longitude">Koordinat Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" placeholder="0" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="map-canvas-siks">Map</label>
                            <div style="height:600px; width: 100%;" id="map-canvas-siks"></div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Lampiran -->
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>
                            Lampiran
                        </strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Lampiran</label>
                            <input type="file" name="file" class="form-control-file" id="lampiran" accept="application/pdf, .png, .jpg, .jpeg">
                            <div style="padding-top: 10px; padding-bottom: 10px;"><a id="fileLampiranExisting"></a></div>
                            <small>Upload file maksimal 1 Mb, berformat .pdf, .png, .jpg, .jpeg</small>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
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
    window.global_file_upload = "<?php echo SIKS_PLUGIN_URL . 'public/media/p3ke/'; ?>";
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    window.id_desa = <?php echo json_encode($input['id_desa']); ?>;
    jQuery(document).ready(function() {
        getDataTable();
    });

    function getDataTable() {
        if (typeof tableP3ke === 'undefined') {
            window.tableP3ke = jQuery('#tableData').on('preXhr.dt', function(e, settings, data) {
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
                        'action': 'get_datatable_data_usulan_p3ke',
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
                        "data": 'alamat',
                        className: "text-center"
                    },
                    {
                        "data": 'pekerjaan',
                        className: "text-center"
                    },
                    {
                        "data": 'program',
                        className: "text-center"
                    },
                    {
                        "data": 'penghasilan',
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
            tableP3ke.draw();
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
                    'action': 'hapus_data_usulan_p3ke_by_id',
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
            dataType: 'JSON',
            data: {
                'action': 'get_data_usulan_p3ke_by_id',
                'api_key': ajax.apikey,
                'id': id,
            },
            success: function(res) {
                // Lokasi Center Map
                if (!res.data.lat || !res.data.lng) {
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
                jQuery('#nik').val(res.data.nik);
                jQuery('#kk').val(res.data.kk);
                jQuery('#rt').val(res.data.rt);
                jQuery('#rw').val(res.data.rw);
                jQuery('#alamat').val(res.data.alamat);
                jQuery('#pekerjaan').val(res.data.pekerjaan);
                jQuery('#program').val(res.data.program);
                jQuery('#penghasilan').val(res.data.penghasilan);
                jQuery('#keterangan').val(res.data.keterangan);
                jQuery('#tahunAnggaran').val(res.data.tahun_anggaran);
                jQuery('#latitude').val(res.data.lat);
                jQuery('#longitude').val(res.data.lng);

                jQuery('#lampiran').val('').show();
                jQuery('#fileLampiranExisting').attr('href', global_file_upload + res.data.file_lampiran).html(res.data.file_lampiran).show();

                jQuery('#judulModalEdit').show();
                jQuery('#judulmodalTambahData').hide();
                jQuery('#modalTambahData').modal('show');
                jQuery('#wrap-loading').hide();
            },
            error: function() {
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

        jQuery('#longitude').val(maps_center_siks['lng']).show();
        jQuery('#latitude').val(maps_center_siks['lat']).show();

        jQuery('#id_data').val('');
        jQuery('#nama').val('');
        jQuery('#nik').val('');
        jQuery('#kk').val('');
        jQuery('#rt').val('');
        jQuery('#rw').val('');
        jQuery('#alamat').val('');
        jQuery('#pekerjaan').val('');
        jQuery('#program').val('');
        jQuery('#penghasilan').val('');
        jQuery('#keterangan').val('');
        jQuery('#tahunAnggaran').val('');
        jQuery('#lampiran').val('');

        jQuery('#fileLampiranExisting').hide();
        jQuery('#fileLampiranExisting').closest('.form-group').find('input').show();

        jQuery('#judulmodalTambahData').show();
        jQuery('#judulModalEdit').hide();
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
                'jenis_data': 'p3ke'
            },
            success: function(res) {
                jQuery('#idDataVerifikasi').val(res.data.id);
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
        tempData.append('jenis_data', 'p3ke');

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
            tempData.append('jenis_data', 'p3ke');

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
            'nama': 'Nama tidak boleh kosong!',
            'nik': 'NIK tidak boleh kosong!',
            'kk': 'Nomor KK tidak boleh kosong!',
            'rt': 'RT tidak boleh kosong!',
            'rw': 'RW tidak boleh kosong!',
            'alamat': 'Alamat tidak boleh kosong!',
            'pekerjaan': 'Pekerjaan tidak boleh kosong!',
            'program': 'Program tidak boleh kosong!',
            'penghasilan': 'Penghasilan tidak boleh kosong!',
            'keterangan': 'Keterangan tidak boleh kosong!',
            'tahunAnggaran': 'Tahun Anggaran tidak boleh kosong!',
            'longitude': 'Longitude tidak boleh kosong!',
            'latitude': 'Latitude tidak boleh kosong!'
            // Tambahkan field lain jika diperlukan
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
        tempData.append('action', 'tambah_data_usulan_p3ke');
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