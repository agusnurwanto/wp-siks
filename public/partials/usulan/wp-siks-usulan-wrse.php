<?php
global $wpdb;

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

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<div style="padding: 10px;margin:0 0 3rem 0;">
    <h1 class="text-center" style="margin:3rem;">Data Usulan WRSE</h1>
    <h2 class="text-center" style="margin:3rem;">(Wanita Rawan Sosial Ekonomi)</h2>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="showModalTambahData();"><span class="dashicons dashicons-plus"></span> Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableData" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width: 12%;">Nama</th>
                    <th class="text-center" style="width: 5%;">Usia</th>
                    <th class="text-center" style="width: 8%;">Provinsi</th>
                    <th class="text-center" style="width: 10%;">Kota / Kabupaten</th>
                    <th class="text-center" style="width: 10%;">Kecamatan</th>
                    <th class="text-center" style="width: 10%;">Desa / Kelurahan</th>
                    <th class="text-center" style="width: 15%;">Alamat</th>
                    <th class="text-center" style="width: 7%;">Status DTKS</th>
                    <th class="text-center" style="width: 8%;">Status Pernikahan</th>
                    <th class="text-center" style="width: 8%;">Mempunyai Usaha</th>
                    <th class="text-center" style="width: 10%;">Keterangan</th>
                    <th class="text-center" style="width: 7%;">Jenis Data</th>
                    <th class="text-center" style="width: 7%;">Tahun Anggaran</th>
                    <th class="text-center" style="width: 8%;">Dibuat Pada</th>
                    <th class="text-center" style="width: 8%;">Terakhir Diperbarui</th>
                    <th class="text-center" style="width: 8%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade mt-4" id="modalTambahData" tabindex="-1" role="dialog" aria-labelledby="modalTambahData" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulmodalTambahData">Tambah Data WRSE</h5>
                <h5 class="modal-title" id="judulModalEdit">Edit Data WRSE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data">

                <div class="form-group">
                    <label for="tahunAnggaran">Tahun Anggaran</label>
                    <input type="number" name="tahunAnggaran" class="form-control" id="tahunAnggaran" placeholder="Masukkan Tahun Anggaran">
                </div>

                <div class="form-group">
                    <label for="jenisData">Jenis Data</label>
                    <select class="form-control" aria-label="Pilih Jenis Data" id="jenisData" name="jenisData">
                        <option value="">Pilih Jenis Data</option>
                        <option value="Induk">Induk</option>
                        <option value="PAK">PAK</option>
                    </select>
                </div>

                <div class="card bg-light p-3 mb-3">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="usia">Usia</label>
                            <input type="number" name="usia" class="form-control" id="usia" placeholder="Masukkan Usia">
                        </div>
                    </div>
                </div>

                <div class="card bg-light p-3 mb-3">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukkan Alamat">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="desaKel">Desa / Kelurahan</label>
                            <input type="text" name="desaKel" class="form-control" id="desaKel" placeholder="Masukkan Desa / Kelurahan">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="kecamatan">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" id="kecamatan" placeholder="Masukkan Kecamatan">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="provinsi">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" id="provinsi" placeholder="Masukkan Provinsi">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kabKot">Kota / Kabupaten</label>
                            <input type="text" name="kabKot" class="form-control" id="kabKot" placeholder="Masukkan Kota / Kabupaten">
                        </div>
                    </div>
                </div>

                <div class="card bg-light p-3 mb-3">
                    <div class="form-row">
                        <div class="col-md-4">
                            <label for='statusDtks'>Status DTKS</label>
                            <div class="pl-4">
                                <input class="form-check-input" type='radio' id='terdaftar' name='statusDtks' value='Terdaftar'>
                                <label class='form-check-label' for='terdaftar'>Terdaftar</label>
                            </div>
                            <div class="pl-4">
                                <input class="form-check-input" type='radio' id='tidakTerdaftar' name='statusDtks' value='Tidak Terdaftar'>
                                <label class='form-check-label' for='tidakTerdaftar'>Tidak Terdaftar</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for='statusPernikahan'>Status Pernikahan</label>
                            <div class="pl-4">
                                <input class="form-check-input" type='radio' id='menikah' name='statusPernikahan' value='Menikah'>
                                <label class='form-check-label' for='menikah'>Menikah</label>
                            </div>
                            <div class="pl-4">
                                <input class="form-check-input" type='radio' id='belumMenikah' name='statusPernikahan' value='Belum Menikah'>
                                <label class='form-check-label' for='belumMenikah'>Belum Menikah</label>
                            </div>
                            <div class="pl-4">
                                <input class="form-check-input" type='radio' id='janda' name='statusPernikahan' value='Janda'>
                                <label class='form-check-label' for='janda'>Janda</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for='statusUsaha'>Mempunyai Usaha</label>
                            <div class="pl-4">
                                <input class="form-check-input" type='radio' id='ya' name='statusUsaha' value='Ya'>
                                <label class='form-check-label' for='ya'>Ya</label>
                            </div>
                            <div class="pl-4">
                                <input class="form-check-input" type='radio' id='tidak' name='statusUsaha' value='Tidak'>
                                <label class='form-check-label' for='tidak'>Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" class="form-control" id="keterangan"></textarea>
                </div>

                <div class="card bg-light p-3 mb-3">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="pl-4">
                                <label for="latitude">Koordinat Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="0" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pl-4">
                                <label for="longitude">Koordinat Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" placeholder="0" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col-md-12">
                            <div class="pl-4">
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
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>
<script>
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
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
                        'action': 'get_datatable_data_usulan_wrse',
                        'api_key': ajax.apikey,
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
                        "data": 'nama',
                        className: "text-left"
                    },
                    {
                        "data": 'usia',
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
                        className: "text-left"
                    },
                    {
                        "data": 'status_dtks',
                        className: "text-center"
                    },
                    {
                        "data": 'status_pernikahan',
                        className: "text-center"
                    },
                    {
                        "data": 'mempunyai_usaha',
                        className: "text-center"
                    },
                    {
                        "data": 'keterangan',
                        className: "text-left"
                    },
                    {
                        "data": 'jenis_data',
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
                    }
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
                    'action': 'hapus_data_usulan_wrse_by_id',
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
                'action': 'get_data_usulan_wrse_by_id',
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
                jQuery('#usia').val(res.data.usia);
                jQuery('#alamat').val(res.data.alamat);
                jQuery('#desaKel').val(res.data.desa_kelurahan);
                jQuery('#kecamatan').val(res.data.kecamatan);
                jQuery('#provinsi').val(res.data.provinsi);
                jQuery('#kabKot').val(res.data.kabkot);
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
        jQuery('#alamat').val('');
        jQuery('#desaKel').val('');
        jQuery('#kecamatan').val('');
        jQuery('#kabKot').val('');
        jQuery('#provinsi').val('');
        jQuery('input[name="statusDtks"]').prop('checked', false);
        jQuery('input[name="statusPernikahan"]').prop('checked', false);
        jQuery('input[name="statusUsaha"]').prop('checked', false);
        jQuery('#keterangan').text('');
        jQuery('#judulmodalTambahData').show();
        jQuery('#judulModalEdit').hide();
        jQuery('#modalTambahData').modal('show');
    }


    function submitData() {
        const validationRules = {
            'nama': 'Data Nama tidak boleh kosong!',
            'usia': 'Data Usia tidak boleh kosong!',
            'alamat': 'Data Alamat tidak boleh kosong!',
            'desaKel': 'Data Desa tidak boleh kosong!',
            'kabKot': 'Data Kabupaten / Kota tidak boleh kosong!',
            'provinsi': 'Data Provinsi tidak boleh kosong!',
            'kecamatan': 'Data Kecamatan tidak boleh kosong!',
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
        tempData.append('action', 'tambah_data_usulan_wrse');
        tempData.append('api_key', ajax.apikey);
        tempData.append('id_data', id_data);

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
                if (res.status === 'success') {
                    jQuery('#modalTambahData').modal('hide');
                    getDataTable();
                }
            }
        });
    }
</script>