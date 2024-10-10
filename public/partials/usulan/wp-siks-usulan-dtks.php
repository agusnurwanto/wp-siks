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
    <h1 class="text-center my-4">Data Usulan DTKS</h1>
    <h2 class="text-center my-4">(Data Terpadu Kesejahteraan Sosial)</h2>
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
                <th class="text-center">NIK</th>
                <th class="text-center">No KK</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Provinsi</th>
                <th class="text-center">Kabupaten / Kota</th>
                <th class="text-center">Kecamatan</th>
                <th class="text-center">Desa/Kelurahan</th>
                <th class='text-center'>Atensi</th>
                <th class='text-center'>BLT</th>
                <th class='text-center'>BLT BBM</th>
                <th class='text-center'>BNPT PPKM</th>
                <th class='text-center'>BPNT</th>
                <th class='text-center'>BST</th>
                <th class='text-center'>FIRST SK</th>
                <th class='text-center'>PBI</th>
                <th class='text-center'>PENA</th>
                <th class='text-center'>PERMAKANAN</th>
                <th class='text-center'>RUTILAHU</th>
                <th class='text-center'>SEMBAKO ADAPTIF</th>
                <th class='text-center'>YAPI</th>
                <th class='text-center'>PKH</th>
                <th class='text-center'>Terakhir Update</th>
                <th class='text-center'>Aksi</th>
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
                <h5 class="modal-title" id="judulmodalTambahData">Tambah Data DTKS</h5>
                <h5 class="modal-title" id="judulModalEdit">Edit Data DTKS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_data" name="id_data">
                <!-- Card: Data Pribadi -->
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Data Pribadi</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nik">NIK</label>
                                <input type="number" class="form-control" id="nik" name="nik">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="noKk">No KK</label>
                            <input type="number" class="form-control" id="noKk" name="noKk">
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
                                <input type="text" class="form-control" id="provinsi" name="provinsi" value="<?php echo $provinsi; ?>" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="kabupatenKota">Kabupaten / Kota</label>
                                <input type="text" class="form-control" id="kabupatenKota" name="kabupatenKota" value="<?php echo $kabkot; ?>" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="kecamatan">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?php echo strtoupper($validate_user['kecamatan']); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="desaKelurahan">Desa/Kelurahan</label>
                                <input type="text" class="form-control" id="desaKelurahan" name="desaKelurahan" value="<?php echo strtoupper($validate_user['desa']); ?>" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Program dan Atensi</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <!-- Atensi -->
                            <div class="form-group col-md-4">
                                <label for="atensi">Atensi</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline mr-3">
                                        <input class="form-check-input" type="radio" name="atensi" id="atensiYa" value="YA">
                                        <label class="form-check-label" for="atensiYa">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="atensi" id="atensiTidak" value="TIDAK">
                                        <label class="form-check-label" for="atensiTidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <!-- BLT -->
                            <div class="form-group col-md-4">
                                <label for="blt">BLT</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline mr-3">
                                        <input class="form-check-input" type="radio" name="blt" id="bltYa" value="YA">
                                        <label class="form-check-label" for="bltYa">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="blt" id="bltTidak" value="TIDAK">
                                        <label class="form-check-label" for="bltTidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <!-- BLT BBM -->
                            <div class="form-group col-md-4">
                                <label for="bltBbm">BLT BBM</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline mr-3">
                                        <input class="form-check-input" type="radio" name="bltBbm" id="bltBbmYa" value="YA">
                                        <label class="form-check-label" for="bltBbmYa">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="bltBbm" id="bltBbmTidak" value="TIDAK">
                                        <label class="form-check-label" for="bltBbmTidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row 2 -->
                        <div class="form-row">
                            <!-- BNPT PPKM -->
                            <div class="form-group col-md-4">
                                <label for="bnptPpkm">BNPT PPKM</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline mr-3">
                                        <input class="form-check-input" type="radio" name="bnptPpkm" id="bnptPpkmYa" value="YA">
                                        <label class="form-check-label" for="bnptPpkmYa">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="bnptPpkm" id="bnptPpkmTidak" value="TIDAK">
                                        <label class="form-check-label" for="bnptPpkmTidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <!-- BPNT -->
                            <div class="form-group col-md-4">
                                <label for="bpnt">BPNT</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline mr-3">
                                        <input class="form-check-input" type="radio" name="bpnt" id="bpntYa" value="YA">
                                        <label class="form-check-label" for="bpntYa">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="bpnt" id="bpntTidak" value="TIDAK">
                                        <label class="form-check-label" for="bpntTidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <!-- BST -->
                            <div class="form-group col-md-4">
                                <label for="bst">BST</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline mr-3">
                                        <input class="form-check-input" type="radio" name="bst" id="bstYa" value="YA">
                                        <label class="form-check-label" for="bstYa">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="bst" id="bstTidak" value="TIDAK">
                                        <label class="form-check-label" for="bstTidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row 3 -->
                        <div class="form-row">
                            <!-- PBI -->
                            <div class="form-group col-md-4">
                                <label for="pbi">PBI</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline mr-3">
                                        <input class="form-check-input" type="radio" name="pbi" id="pbiYa" value="YA">
                                        <label class="form-check-label" for="pbiYa">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pbi" id="pbiTidak" value="TIDAK">
                                        <label class="form-check-label" for="pbiTidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <!-- PENA -->
                            <div class="form-group col-md-4">
                                <label for="pena">PENA</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline mr-3">
                                        <input class="form-check-input" type="radio" name="pena" id="penaYa" value="YA">
                                        <label class="form-check-label" for="penaYa">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pena" id="penaTidak" value="TIDAK">
                                        <label class="form-check-label" for="penaTidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <!-- PERMAKANAN -->
                            <div class="form-group col-md-4">
                                <label for="permakanan">PERMAKANAN</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline mr-3">
                                        <input class="form-check-input" type="radio" name="permakanan" id="permakananYa" value="YA">
                                        <label class="form-check-label" for="permakananYa">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="permakanan" id="permakananTidak" value="TIDAK">
                                        <label class="form-check-label" for="permakananTidak">Tidak</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-row">
                            <!-- RUTILAHU -->
                            <div class="form-group col-md-4">
                                <label for="rutilahu">RUTILAHU</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline mr-3">
                                        <input class="form-check-input" type="radio" name="rutilahu" id="rutilahuYa" value="YA">
                                        <label class="form-check-label" for="rutilahuYa">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rutilahu" id="rutilahuTidak" value="TIDAK">
                                        <label class="form-check-label" for="rutilahuTidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <!-- SEMBAKO ADAPTIF -->
                            <div class="form-group col-md-4">
                                <label for="sembakoAdaptif">SEMBAKO ADAPTIF</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline mr-3">
                                        <input class="form-check-input" type="radio" name="sembakoAdaptif" id="sembakoAdaptifYa" value="YA">
                                        <label class="form-check-label" for="sembakoAdaptifYa">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sembakoAdaptif" id="sembakoAdaptifTidak" value="TIDAK">
                                        <label class="form-check-label" for="sembakoAdaptifTidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <!-- YAPI -->
                            <div class="form-group col-md-4">
                                <label for="yapi">YAPI</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline mr-3">
                                        <input class="form-check-input" type="radio" name="yapi" id="yapiYa" value="YA">
                                        <label class="form-check-label" for="yapiYa">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="yapi" id="yapiTidak" value="TIDAK">
                                        <label class="form-check-label" for="yapiTidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <!-- RUTILAHU -->
                            <div class="form-group col-md-4">
                                <label for="pkh">PKH</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline mr-3">
                                        <input class="form-check-input" type="radio" name="pkh" id="pkhYa" value="YA">
                                        <label class="form-check-label" for="pkhYa">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pkh" id="pkhTidak" value="TIDAK">
                                        <label class="form-check-label" for="pkhTidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="firstSK">FIRST SK</label>
                            <input class="form-control" type="date" name="firstSK" id="firstSK">
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
    // window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    // window.maps_center_siks = <?php echo json_encode($center); ?>;
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
                        'action': 'get_datatable_data_usulan_dtks',
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
                        "data": 'Nama',
                        className: "text-left"
                    },
                    {
                        "data": 'NIK',
                        className: "text-center"
                    },
                    {
                        "data": 'NOKK',
                        className: "text-center"
                    },
                    {
                        "data": 'Alamat',
                        className: "text-left"
                    },
                    {
                        "data": 'provinsi',
                        className: "text-left"
                    },
                    {
                        "data": 'kabupaten',
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
                        "data": 'ATENSI',
                        className: "text-center"
                    },
                    {
                        "data": 'BLT',
                        className: "text-center"
                    },
                    {
                        "data": 'BLT_BBM',
                        className: "text-center"
                    },
                    {
                        "data": 'BNPT_PPKM',
                        className: "text-center"
                    },
                    {
                        "data": 'BPNT',
                        className: "text-center"
                    },
                    {
                        "data": 'BST',
                        className: "text-center"
                    },
                    {
                        "data": 'FIRST_SK',
                        className: "text-center"
                    },
                    {
                        "data": 'PBI',
                        className: "text-center"
                    },
                    {
                        "data": 'PENA',
                        className: "text-center"
                    },
                    {
                        "data": 'PERMAKANAN',
                        className: "text-center"
                    },
                    {
                        "data": 'RUTILAHU',
                        className: "text-center"
                    },
                    {
                        "data": 'SEMBAKO_ADAPTIF',
                        className: "text-center"
                    },
                    {
                        "data": 'YAPI',
                        className: "text-center"
                    },
                    {
                        "data": 'PKH',
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
                    'action': 'hapus_data_usulan_dtks_by_id',
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
                'action': 'get_data_usulan_dtks_by_id',
                'api_key': ajax.apikey,
                'id': id,
            },
            success: function(res) {
                // Set value untuk input text
                jQuery('#id_data').val(res.data.id);
                jQuery('#nama').val(res.data.Nama);
                jQuery('#nik').val(res.data.NIK);
                jQuery('#noKk').val(res.data.NOKK);
                jQuery('#firstSK').val(res.data.FIRST_SK);
                jQuery('#alamat').text(res.data.Alamat);

                // Reset radio buttons untuk opsi-opsi
                jQuery('input[name="atensi"]').prop('checked', false);
                jQuery('input[name="blt"]').prop('checked', false);
                jQuery('input[name="bltBbm"]').prop('checked', false);
                jQuery('input[name="bnptPpkm"]').prop('checked', false);
                jQuery('input[name="bpnt"]').prop('checked', false);
                jQuery('input[name="bst"]').prop('checked', false);
                jQuery('input[name="pbi"]').prop('checked', false);
                jQuery('input[name="pena"]').prop('checked', false);
                jQuery('input[name="permakanan"]').prop('checked', false);
                jQuery('input[name="rutilahu"]').prop('checked', false);
                jQuery('input[name="sembakoAdaptif"]').prop('checked', false);
                jQuery('input[name="yapi"]').prop('checked', false);
                jQuery('input[name="pkh"]').prop('checked', false);

                if (res.data.ATENSI === 'YA') {
                    jQuery('#atensiYa').prop('checked', true);
                } else {
                    jQuery('#atensiTidak').prop('checked', true);
                }

                if (res.data.BLT === 'YA') {
                    jQuery('#bltYa').prop('checked', true);
                } else {
                    jQuery('#bltTidak').prop('checked', true);
                }

                if (res.data.BLT_BBM === 'YA') {
                    jQuery('#bltBbmYa').prop('checked', true);
                } else {
                    jQuery('#bltBbmTidak').prop('checked', true);
                }

                if (res.data.BNPT_PPKM === 'YA') {
                    jQuery('#bnptPpkmYa').prop('checked', true);
                } else {
                    jQuery('#bnptPpkmTidak').prop('checked', true);
                }

                if (res.data.BPNT === 'YA') {
                    jQuery('#bpntYa').prop('checked', true);
                } else {
                    jQuery('#bpntTidak').prop('checked', true);
                }

                if (res.data.BST === 'YA') {
                    jQuery('#bstYa').prop('checked', true);
                } else {
                    jQuery('#bstTidak').prop('checked', true);
                }

                if (res.data.PBI === 'YA') {
                    jQuery('#pbiYa').prop('checked', true);
                } else {
                    jQuery('#pbiTidak').prop('checked', true);
                }

                if (res.data.PENA === 'YA') {
                    jQuery('#penaYa').prop('checked', true);
                } else {
                    jQuery('#penaTidak').prop('checked', true);
                }

                if (res.data.PERMAKANAN === 'YA') {
                    jQuery('#permakananYa').prop('checked', true);
                } else {
                    jQuery('#permakananTidak').prop('checked', true);
                }

                if (res.data.RUTILAHU === 'YA') {
                    jQuery('#rutilahuYa').prop('checked', true);
                } else {
                    jQuery('#rutilahuTidak').prop('checked', true);
                }

                if (res.data.SEMBAKO_ADAPTIF === 'YA') {
                    jQuery('#sembakoAdaptifYa').prop('checked', true);
                } else {
                    jQuery('#sembakoAdaptifTidak').prop('checked', true);
                }

                if (res.data.YAPI === 'YA') {
                    jQuery('#yapiYa').prop('checked', true);
                } else {
                    jQuery('#yapiTidak').prop('checked', true);
                }

                if (res.data.PKH === 'YA') {
                    jQuery('#pkhYa').prop('checked', true);
                } else {
                    jQuery('#pkhTidak').prop('checked', true);
                }


                // Show modal edit, hide modal tambah data
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
        jQuery('#id_data').val('');
        jQuery('#nama').val('');
        jQuery('#nik').val('');
        jQuery('#noKk').val('');
        jQuery('#firstSK').val('');
        jQuery('#alamat').text('');

        jQuery('input[name="atensi"]').prop('checked', false);
        jQuery('input[name="blt"]').prop('checked', false);
        jQuery('input[name="bltBbm"]').prop('checked', false);
        jQuery('input[name="bnptPpkm"]').prop('checked', false);
        jQuery('input[name="bpnt"]').prop('checked', false);
        jQuery('input[name="bst"]').prop('checked', false);
        jQuery('input[name="pbi"]').prop('checked', false);
        jQuery('input[name="pena"]').prop('checked', false);
        jQuery('input[name="permakanan"]').prop('checked', false);
        jQuery('input[name="rutilahu"]').prop('checked', false);
        jQuery('input[name="sembakoAdaptif"]').prop('checked', false);
        jQuery('input[name="yapi"]').prop('checked', false);
        jQuery('input[name="pkh"]').prop('checked', false);

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
                'jenis_data': 'dtks'
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
        tempData.append('jenis_data', 'dtks');

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
            tempData.append('jenis_data', 'dtks');

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
            'noKk': 'Nomor KK tidak boleh kosong!',
            'alamat': 'Alamat tidak boleh kosong!',
            'atensi': 'Atensi tidak boleh kosong!',
            'blt': 'BLT tidak boleh kosong!',
            'bltBbm': 'BLT BBM tidak boleh kosong!',
            'bnptPpkm': 'BNPT PPKM tidak boleh kosong!',
            'bpnt': 'BPNT tidak boleh kosong!',
            'bst': 'BST tidak boleh kosong!',
            'pbi': 'PBI tidak boleh kosong!',
            'pena': 'PENA tidak boleh kosong!',
            'permakanan': 'Permakanan tidak boleh kosong!',
            'rutilahu': 'Rutilahu tidak boleh kosong!',
            'sembakoAdaptif': 'Sembako Adaptif tidak boleh kosong!',
            'yapi': 'YAPI tidak boleh kosong!',
            'pkh': 'PKH tidak boleh kosong!',
            'firstSK': 'First SK tidak boleh kosong!',
            // Tambahkan field lain jika diperlukan
        }

        const {
            error,
            data
        } = validateForm(validationRules);
        if (error) {
            return alert(error);
        }

        const id_data = jQuery('#id_data').val();

        const tempData = new FormData();
        tempData.append('action', 'tambah_data_usulan_dtks');
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