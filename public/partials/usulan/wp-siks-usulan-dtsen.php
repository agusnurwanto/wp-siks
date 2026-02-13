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
    <h1 class="text-center my-4">Data Usulan DTSEN</h1>
    <h2 class="text-center my-4">(Data Tunggal Sosial Ekonomi Nasional)</h2>
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
                <th class="text-center">No.</th>
                <th class="text-center">No. KK</th>
                <th class="text-center">Hubungan Keluarga</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Nama</th>
                <th class="text-center">NIK</th>
                <th class='text-center'>Pekerjaan Utama</th>
                <th class="text-center">Provinsi</th>
                <th class="text-center">Kabupaten / Kota</th>
                <th class="text-center">Kecamatan</th>
                <th class="text-center">Desa/Kelurahan</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- modal tambah data -->
<div class="modal fade mt-4" id="modalTambahData" tabindex="-1" role="dialog" aria-labelledby="modalTambahData" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulmodalTambahData">Tambah Data DTSEN</h5>
                <h5 class="modal-title" id="judulModalEdit">Edit Data DTSEN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-dtsen">
                    <input type="hidden" id="id_data" name="id_data">

                    <div class="card mb-3">
                        <div class="card-header bg-light font-weight-bold">
                            <i class="fas fa-user-tie mr-1"></i> Identitas Kepala Keluarga
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="no_kk">No. Kartu Keluarga <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="no_kk" name="no_kk" placeholder="16 digit No KK" required maxlength="16">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="nik">NIK Kepala Keluarga <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="16 digit NIK" required maxlength="16">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="nama_kepala_keluarga">Nama Lengkap Kepala Keluarga <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_kepala_keluarga" name="nama_kepala_keluarga" placeholder="Sesuai KTP" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light font-weight-bold">
                            <i class="fas fa-map-marker-alt mr-1"></i> Domisili & Wilayah
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="provinsi">Provinsi</label>
                                    <input type="text" class="form-control" id="provinsi" name="provinsi" disabled>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="kabupaten">Kabupaten/Kota</label>
                                    <input type="text" class="form-control" id="kabupaten" name="kabupaten" disabled>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="kecamatan">Kecamatan</label>
                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" disabled>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="kelurahan">Kelurahan/Desa</label>
                                    <input type="text" class="form-control" id="kelurahan" name="kelurahan" disabled>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="alamat">Alamat Lengkap (Jalan/RT/RW) <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan detail alamat, RT/RW, Dusun, dll." required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light mb-3">
                            <div class="card-header">Koordinat dan Peta</div>
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
                                <div class="form-row mt-4">
                                    <div class="col-md-12">
                                        <label for="map-canvas-siks">Map</label>
                                        <div style="height:600px; width: 100%;" id="map-canvas-siks"></div>
                                    </div>
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
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    window.id_desa = <?php echo json_encode($input['id_desa']); ?>;
    jQuery(document).ready(function() {
        generate_table();
    });

    function get_data_dtsen() {
        return jQuery.ajax({
            url: ajax.url,
            method: 'POST',
            data: {
                action: "get_data_usulan_dtsen_ajax",
                api_key: ajax.apikey,
                desa: "<?php echo $get_desa_kel['nama']; ?>"
            },
            dataType: 'json',
        });
    }

    async function generate_table() {
        try {
            jQuery(`#wrap-loading`).show();
            const allData = await get_data_dtsen();
            if (allData.status) {
                let tbody = ``;
                let no = 1;
                allData.data.forEach(data => {
                    tbody += `
                        <tr>
                            <td class="text-center">${no++}</td>
                            <td class="text-left">${data.no_kk}</td>
                            <td class="text-left">${data.hub_kepala_keluarga}</td>
                            <td class="text-left">${data.alamat}</td>
                            <td class="text-left">${data.nama}</td>
                            <td class="text-left">${data.nik}</td>
                            <td class="text-left">${data.pekerjaan_utama}</td>
                            <td class="text-left">${data.provinsi}</td>
                            <td class="text-left">${data.kabupaten}</td>
                            <td class="text-left">${data.kecamatan}</td>
                            <td class="text-left">${data.kelurahan}</td>
                        </tr>
                    `;
                });

                jQuery(`#tableData tbody`).html(tbody);
            }

        } catch (error) {
            alert("Gagal generate table");
            console.log(error);
        } finally {
            jQuery(`#tableData`).dataTable();
            jQuery(`#wrap-loading`).hide();
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
                    'action': 'hapus_data_usulan_dtsen_by_id',
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


    function edit_data(_id) {
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: ajax.url,
            dataType: 'JSON',
            data: {
                'action': 'get_data_usulan_dtsen_by_id',
                'api_key': ajax.apikey,
                'id': _id,
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

                jQuery('#judulmodalTambahData').hide();
                jQuery('#id_data').val(res.data.id);
                jQuery('#tahunAnggaran').val(res.data.tahun_anggaran);
                jQuery('#jenisData').val(res.data.jenis_data).trigger('change').prop('selected', false);
                jQuery('#nama').val(res.data.nama);
                jQuery('#usia').val(res.data.usia);
                jQuery('#alamat').text(res.data.alamat);
                jQuery('#latitude').val(res.data.lat);
                jQuery('#longitude').val(res.data.lng);

                jQuery('input[name="statusDtks"]').prop('checked', false);
                jQuery('input[name="statusPernikahan"]').prop('checked', false);
                jQuery('input[name="statusUsaha"]').prop('checked', false);
                switch (res.data.status_dtks) {
                    case 'Terdaftar':
                        jQuery('#terdaftar').prop('checked', true);
                        break;
                    case 'Tidak Terdaftar':
                        jQuery('#tidakTerdaftar').prop('checked', true);
                        break;
                    default:
                        jQuery('input[name="statusDtks"]').prop('checked', false);
                }
                switch (res.data.status_pernikahan) {
                    case 'Menikah':
                        jQuery('#menikah').prop('checked', true);
                        break;
                    case 'Belum Menikah':
                        jQuery('#belumMenikah').prop('checked', true);
                        break;
                    case 'Janda':
                        jQuery('#janda').prop('checked', true);
                        break;
                    default:
                        jQuery('input[name="statusPernikahan"]').prop('checked', false);
                }
                switch (res.data.mempunyai_usaha) {
                    case 'Ya':
                        jQuery('#ya').prop('checked', true);
                        break;
                    case 'Tidak':
                        jQuery('#tidak').prop('checked', true);
                        break;
                    default:
                        jQuery('input[name="statusUsaha"]').prop('checked', false);
                }
                jQuery('#keterangan').text(res.data.keterangan);

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
        jQuery('#tahunAnggaran').val('');
        jQuery('#jenisData').val('');
        jQuery('#nama').val('');
        jQuery('#usia').val('');
        jQuery('#alamat').text('');
        jQuery('input[name="statusDtks"]').prop('checked', false);
        jQuery('input[name="statusPernikahan"]').prop('checked', false);
        jQuery('input[name="statusUsaha"]').prop('checked', false);
        jQuery('#keterangan').text('');
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
                'jenis_data': 'dtsen'
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
        tempData.append('jenis_data', 'dtsen');

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
            tempData.append('jenis_data', 'dtsen');

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
            'nama': 'Data Nama tidak boleh kosong!',
            'usia': 'Data Usia tidak boleh kosong!',
            'alamat': 'Data Alamat tidak boleh kosong!',
            'tahunAnggaran': 'Data Tahun Anggaran tidak boleh kosong!',
            'statusDtks': 'Pilih Status DTKS!',
            'statusPernikahan': 'Pilih Status Pernikahan!',
            'statusUsaha': 'Pilih Status Usaha!',
            'jenisData': 'Pilih Jenis Data!',
            'keterangan': 'Keterangan tidak boleh kosong!',
            'longitude': 'Longitude tidak boleh kosong!',
            'latitude': 'Latitude tidak boleh kosong!',
            // Tambahkan field lain jika diperlukan
        };

        const {
            error,
            data
        } = validateForm(validationRules);
        if (error) {
            return alert(error);
        }

        const id_data = jQuery('#id_data').val();

        const tempData = new FormData();
        tempData.append('action', 'tambah_data_usulan_dtsen');
        tempData.append('api_key', ajax.apikey);
        tempData.append('id_data', id_data);
        tempData.append('id_desa', id_desa);

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