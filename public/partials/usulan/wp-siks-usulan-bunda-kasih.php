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
    <h1 class="text-center my-4">Data Usulan bunda_kasih</h1>
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
                <th class="text-center">Aksi</th>
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
                <h5 class="modal-title" id="judulmodalTambahData">Tambah Data Bunda Kasih</h5>
                <h5 class="modal-title" id="judulModalEdit">Edit Data Bunda Kasih</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_data" name="id_data">

                <!-- Tahun Anggaran Card -->
                <div class="card bg-light mb-3">
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

                <!-- Personal Information Card -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Informasi Pribadi</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nik">NIK</label>
                                <input type="number" class="form-control" id="nik" name="nik">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tanggalLahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="usia">Usia</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="usia" name="usia">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Tahun</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information Card -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Informasi Alamat</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="provinsi">Provinsi</label>
                                <input type="text" class="form-control" id="provinsi" value="<?php echo $provinsi; ?>" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="kecamatan">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" value="<?php echo strtoupper($validate_user['kecamatan']); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="kabkot">Kabupaten / Kota</label>
                                <input type="text" class="form-control" id="kabkot" value="<?php echo $kabkot; ?>" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="desa">Desa</label>
                                <input type="text" class="form-control" id="desa" value="<?php echo strtoupper($validate_user['desa']); ?>" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Information Card -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Status Sosial dan Ekonomi</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="dokumenKependudukan">Dokumen Kependudukan</label>
                            <input type="text" class="form-control" id="dokumenKependudukan" name="dokumenKependudukan">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="statusTempatTinggal">Status Tempat Tinggal</label>
                                <input type="text" class="form-control" id="statusTempatTinggal" name="statusTempatTinggal">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="statusPemenuhanKebutuhan">Status Pemenuhan Kebutuhan</label>
                                <input type="text" class="form-control" id="statusPemenuhanKebutuhan" name="statusPemenuhanKebutuhan">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="statusDtks">Status DTKS</label>
                                <input type="text" class="form-control" id="statusDtks" name="statusDtks">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="statusKehidupanRumahTangga">Status Kehidupan Rumah Tangga</label>
                                <input type="text" class="form-control" id="statusKehidupanRumahTangga" name="statusKehidupanRumahTangga">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendation Card -->
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Rekomendasi Pendata</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="statusKepersertaanProgramBansos">Status Kepersertaan Program Bansos</label>
                                <input type="text" id="statusKepersertaanProgramBansos" name="statusKepersertaanProgramBansos" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="rekomendasiPendataLama">Rekomendasi Pendata Lama</label>
                                <input type="text" id="rekomendasiPendataLama" name="rekomendasiPendataLama" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="keteranganLainnyaLama">Keterangan Lainnya Lama</label>
                                <textarea id="keteranganLainnyaLama" name="keteranganLainnyaLama" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="rekomendasiPendata">Rekomendasi Pendata</label>
                                <input type="text" id="rekomendasiPendata" name="rekomendasiPendata" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="keteranganLainnya">Keterangan Lainnya</label>
                                <textarea id="keteranganLainnya" name="keteranganLainnya" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coordinates Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Koordinat dan Peta</strong>
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
                        <div class="form-row mt-4">
                            <div class="col-md-12">
                                <label for="map-canvas-siks">Map</label>
                                <div style="height:600px; width: 100%;" id="map-canvas-siks"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attachment Card -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Lampiran</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="lampiran">Lampiran</label>
                            <input type="file" class="form-control-file" id="lampiran" name="lampiran" accept="application/pdf, .png, .jpg, .jpeg">
                            <div style="padding-top: 10px; padding-bottom: 10px;">
                                <a id="fileLampiranExisting"></a>
                            </div>
                        </div>
                        <small>Upload file maksimal 1 Mb, berformat .pdf, .png, .jpg, .jpeg</small>
                    </div>
                </div>
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


<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>
<script>
    window.global_file_upload = "<?php echo SIKS_PLUGIN_URL . 'public/media/bunda_kasih/'; ?>";
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    window.id_desa = <?php echo json_encode($input['id_desa']); ?>;
    jQuery(document).ready(function() {
        getDataTable();
    });

    function getDataTable() {
        if (typeof tableWrse === 'undefined') {
            window.tableWrse = jQuery('#tableData').on('preXhr.dt', function(e, settings, data) {
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
                        'action': 'get_datatable_data_usulan_bunda_kasih',
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
            tableWrse.draw();
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
                    'action': 'hapus_data_usulan_bunda_kasih_by_id',
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
                'action': 'get_data_usulan_bunda_kasih_by_id',
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
        jQuery('#kecamatan').val('');
        jQuery('#desa').val('');
        jQuery('#provinsi').val('');
        jQuery('#nik').val('');
        jQuery('#kabkot').val('');
        jQuery('#kk').val('');
        jQuery('#rt_rw').val('');
        jQuery('#latitude').val('');
        jQuery('#longitude').val('');
        jQuery('#tahun_anggaran').val('');

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
                'jenis_data': 'bunda kasih'
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
        tempData.append('jenis_data', 'bunda_kasih');

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
            tempData.append('jenis_data', 'bunda_kasih');

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
            'longitude': 'Longitude tidak boleh kosong!',
            'latitude': 'Latitude tidak boleh kosong!',
            'nik': 'NIK tidak boleh kosong!',
            'nama': 'Nama tidak boleh kosong!',
            'tanggalLahir': 'Tanggal Lahir tidak boleh kosong!',
            'usia': 'Usia tidak boleh kosong!',
            'alamat': 'Alamat tidak boleh kosong!',
            'dokumenKependudukan': 'Dokumen Kependudukan tidak boleh kosong!',
            'statusTempatTinggal': 'Status Tempat Tinggal tidak boleh kosong!',
            'statusPemenuhanKebutuhan': 'Status Pemenuhan Kebutuhan tidak boleh kosong!',
            'statusKehidupanRumahTangga': 'Status Kehidupan Rumah Tangga tidak boleh kosong!',
            'statusDtks': 'Status DTKS tidak boleh kosong!',
            'statusKepersertaanProgramBansos': 'Status Kepersertaan Bansos tidak boleh kosong!',
            'rekomendasiPendataLama': 'Rekomendasi Pendata Lama tidak boleh kosong!',
            'keteranganLainnyaLama': 'Keterangan Lainya Lama tidak boleh kosong!',
            'rekomendasiPendata': 'Rekomendasi Pendata tidak boleh kosong!',
            'keteranganLainnya': 'Keterangan Lainnya tidak boleh kosong!'
        };

        const {
            error,
            data
        } = validateForm(validationRules);
        if (error) {
            return alert(error);
        }

        const id_data = jQuery('#id_data').val();
        const lampiran = jQuery('#lampiran')[0].files[0];
        if (id_data == '') {
            if (typeof lampiran == 'undefined') {
                return alert('Upload file lampiran dulu!');
            }
        }

        const tempData = new FormData();
        tempData.append('action', 'tambah_data_usulan_bunda_kasih');
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