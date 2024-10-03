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
    <h1 class="text-center my-4">Data Usulan Penerima Hibah</h1>
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
                <th class="text-center">Kode</th>
                <th class="text-center">Penerima</th>
                <th class="text-center">Nama dan NIK Ketua</th>
                <th class="text-center">Provinsi</th>
                <th class="text-center">Kabupaten/Kota</th>
                <th class="text-center">Kecamatan</th>
                <th class="text-center">Desa/Kelurahan</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Anggaran</th>
                <th class="text-center">Status Realisasi</th>
                <th class="text-center">No NPHD</th>
                <th class="text-center">No SPM</th>
                <th class="text-center">No SP2D</th>
                <th class="text-center">Peruntukan</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Status Verifikasi</th>
                <th class="text-center">Tahun Anggaran</th>
                <th class="text-center">Jenis Data</th>
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
                <h5 class="modal-title" id="judulmodalTambahData">Tambah Data Hibah</h5>
                <h5 class="modal-title" id="judulModalEdit">Edit Data Hibah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data">

                <!-- Card 1: Tahun Anggaran dan Jenis Data -->
                <div class="card bg-light mb-3">
                    <div class="card-header">Tahun Anggaran dan Jenis Data</div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tahunAnggaran">Tahun Anggaran</label>
                                <input type="number" name="tahunAnggaran" class="form-control" id="tahunAnggaran" placeholder="Masukkan Tahun Anggaran">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jenisData">Jenis Data</label>
                                <select class="form-control" id="jenisData" name="jenisData">
                                    <option value="">Pilih Jenis Data</option>
                                    <option value="Induk">Induk</option>
                                    <option value="PAK">PAK</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Penerima dan Alamat Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">Data Penerima dan Alamat</div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="penerima">Penerima</label>
                                <input type="text" name="penerima" class="form-control" id="penerima" placeholder="Masukkan Penerima">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="provinsi">Provinsi</label>
                                <input type="text" name="provinsi" class="form-control" id="provinsi" value="<?php echo $provinsi; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="alamat">Alamat</label>
                                <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukkan Alamat">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="kecamatan">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control" id="kecamatan" value="<?php echo strtoupper($validate_user['kecamatan']); ?>" disabled>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="desaKel">Desa / Kelurahan</label>
                                <input type="text" name="desaKel" class="form-control" id="desaKel" value="<?php echo strtoupper($validate_user['desa']); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nama_nik_ketua">Nama dan NIK Ketua</label>
                                <input type="text" name="nama_nik_ketua" class="form-control" id="nama_nik_ketua" placeholder="Masukkan Nama dan NIK Ketua">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="kabKot">Kota / Kabupaten</label>
                                <input type="text" name="kabKot" class="form-control" id="kabKot" value="<?php echo $kabkot; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan Penerima</label>
                            <textarea name="keterangan" class="form-control" id="keterangan"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Dokumen Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">Dokumen Hibah</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="statusRealisasi">Status Realisasi</label>
                            <select class="form-control" aria-label="Pilih Status Realisasi" id="statusRealisasi" name="statusRealisasi">
                                <option value="">Pilih Status Realisasi</option>
                                <option value="Realisasi">Realisasi</option>
                                <option value="Tidak Realisasi">Tidak Realisasi</option>
                                <option value="Proses">Proses</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="anggaran">Anggaran</label>
                            <input type="number" name="anggaran" class="form-control" id="anggaran" placeholder="Masukkan Jumlah Anggaran">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="nphd">No NPHD</label>
                                <input type="text" name="nphd" class="form-control" id="nphd" placeholder="Masukkan NPHD">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="spm">No SPM</label>
                                <input type="text" name="spm" class="form-control" id="spm" placeholder="Masukkan SPM">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="sp2d">No SP2D</label>
                                <input type="text" name="sp2d" class="form-control" id="sp2d" placeholder="Masukkan SP2D">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="tglNphd">Tanggal NPHD</label>
                                <input type="date" name="tglNphd" class="form-control" id="tglNphd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tglSpm">Tanggal SPM</label>
                                <input type="date" name="tglSpm" class="form-control" id="tglSpm">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tglSp2d">Tanggal SP2D</label>
                                <input type="date" name="tglSp2d" class="form-control" id="tglSp2d">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="peruntukan">Peruntukan</label>
                            <textarea name="peruntukan" class="form-control" id="peruntukan"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Koordinat Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">Koordinat dan Peta</div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="latitude">Koordinat Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="0" disabled>
                            </div>
                            <div class="col-md-6">
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

                <div class="modal-footer">
                    <button type="submit" onclick="submitData();" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Tutup</button>
                </div>
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
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    window.id_desa = <?php echo json_encode($input['id_desa']); ?>;
    jQuery(document).ready(function() {
        getDataTable();
    });

    function getDataTable() {
        if (typeof tableHibah === 'undefined') {
            window.tableHibah = jQuery('#tableData').on('preXhr.dt', function(e, settings, data) {
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
                        'action': 'get_datatable_data_usulan_hibah',
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
                        "data": 'kode',
                        className: "text-center"
                    },
                    {
                        "data": 'penerima',
                        className: "text-left"
                    },
                    {
                        "data": 'nama_nik_ketua',
                        className: "text-left"
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
                        className: "text-left"
                    },
                    {
                        "data": 'anggaran',
                        className: "text-right"
                    },
                    {
                        "data": 'status_realisasi',
                        className: "text-center"
                    },
                    {
                        "data": 'no_nphd',
                        className: "text-center"
                    },
                    {
                        "data": 'no_spm',
                        className: "text-center"
                    },
                    {
                        "data": 'no_sp2d',
                        className: "text-center"
                    },
                    {
                        "data": 'peruntukan',
                        className: "text-left"
                    },
                    {
                        "data": 'keterangan',
                        className: "text-left"
                    },
                    {
                        "data": 'status_data',
                        className: "text-center"
                    },
                    {
                        "data": 'tahun_anggaran',
                        className: "text-center"
                    },
                    {
                        "data": 'jenis_data',
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
                    }
                ]
            });
        } else {
            tableHibah.draw();
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
                    'action': 'hapus_data_usulan_hibah_by_id',
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
                'action': 'get_data_usulan_hibah_by_id',
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
                jQuery('#tahunAnggaran').val(res.data.tahun_anggaran);
                jQuery('#jenisData').val(res.data.jenis_data).trigger('change');
                jQuery('#statusRealisasi').val(res.data.status_realisasi).trigger('change');
                jQuery('#anggaran').val(res.data.anggaran).val(res.data.anggaran);
                jQuery('#penerima').val(res.data.penerima);
                jQuery('#nama_nik_ketua').val(res.data.nama_nik_ketua);
                jQuery('#alamat').val(res.data.alamat);
                jQuery('#nphd').val(res.data.no_nphd);
                jQuery('#spm').val(res.data.no_spm);
                jQuery('#sp2d').val(res.data.no_sp2d);
                jQuery('#tglNphd').val(res.data.tgl_nphd);
                jQuery('#tglSpm').val(res.data.tgl_spm);
                jQuery('#tglSp2d').val(res.data.tgl_sp2d);
                jQuery('#peruntukan').val(res.data.peruntukan);
                jQuery('#keterangan').text(res.data.keterangan);

                jQuery('#judulmodalTambahData').hide();
                jQuery('#judulModalEdit').show();
                jQuery('#judulmodalTambahData').hide();
                jQuery('#modalTambahData').modal('show');
                jQuery('#wrap-loading').hide();
            },
            error: function(e) {
                alert(e.message)
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
        jQuery('#anggaran').val('');
        jQuery('#jenisData').val('');
        jQuery('#statusRealisasi').val('');
        jQuery('#penerima').val('');
        jQuery('#nama_nik_ketua').val('');
        jQuery('#alamat').val('');
        jQuery('#nphd').val('');
        jQuery('#spm').val('');
        jQuery('#sp2d').val('');
        jQuery('#tglNphd').val('');
        jQuery('#tglSpm').val('');
        jQuery('#tglSp2d').val('');
        jQuery('#peruntukan').val('');
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
                'jenis_data': 'hibah'
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
        tempData.append('jenis_data', 'hibah');

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
            tempData.append('jenis_data', 'hibah');

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
            'tahunAnggaran': 'Data Tahun Anggaran tidak boleh kosong!',
            'jenisData': 'Pilih Jenis Data!',
            'statusRealisasi': 'Pilih Status Realisasi!',
            'anggaran': 'Anggaran tidak boleh kosong!',
            'penerima': 'Data Penerima tidak boleh kosong!',
            'nama_nik_ketua': 'Nama dan NIK Ketua tidak boleh kosong!',
            'alamat': 'Data Alamat tidak boleh kosong!',
            'nphd': 'No NPHD tidak boleh kosong!',
            'spm': 'No SPM tidak boleh kosong!',
            'sp2d': 'No SP2D tidak boleh kosong!',
            'tglNphd': 'Tanggal NPHD tidak boleh kosong!',
            'tglSpm': 'Tanggal SPM tidak boleh kosong!',
            'tglSp2d': 'Tanggal SP2D tidak boleh kosong!',
            'peruntukan': 'Peruntukan tidak boleh kosong!',
            'longitude': 'Longitude tidak boleh kosong!',
            'latitude': 'Latitude tidak boleh kosong!',
            'keterangan': 'keterangan tidak boleh kosong!',
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
        tempData.append('action', 'tambah_data_usulan_hibah');
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