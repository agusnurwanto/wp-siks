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
$is_rt = ($validate_user['roles'] === 'rt');
$rt_filter = '';
$rw_filter = '';

if ($is_rt) {
    $rt_filter = $validate_user['rt'] ?? '';
    $rw_filter = $validate_user['rw'] ?? '';
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
    <?php if ($is_rt): ?>
        <h3 class="text-center my-2">RT <?php echo esc_html($rt_filter); ?> / RW <?php echo esc_html($rw_filter); ?></h3>
    <?php endif; ?>

    <?php if ($validate_user['roles'] === 'desa' || $is_rt): ?>
        <div class="m-4">
            <button class="btn btn-primary" onclick="showModalTambahData();">
                <span class="dashicons dashicons-plus"></span> Tambah Data
            </button>
        </div>
    <?php endif; ?>
</div>
<div class="table-responsive p-2">
    <table id="tableData" class="table table-bordered table-striped w-100">
        <thead>
            <tr>
                <th class="text-center">Status</th>
                <th class="text-center">No. KK</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Provinsi</th>
                <th class="text-center">Kabupaten / Kota</th>
                <th class="text-center">Kecamatan</th>
                <th class="text-center">Desa/Kelurahan</th>
                <th class="text-center">RT</th>
                <th class="text-center">RW</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="modal fade mt-4" data-backdrop="static" id="modalTambahData" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulmodalTambahData">Tambah Data Keluarga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-keluarga">
                    <input type="hidden" id="id_keluarga_input" name="id_keluarga">

                    <div class="card mb-3">
                        <div class="card-header bg-light font-weight-bold">
                            <i class="dashicons dashicons-location mr-1"></i> Data Kartu Keluarga & Wilayah
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="no_kk">No. Kartu Keluarga <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="no_kk" name="no_kk" placeholder="16 digit No KK" required maxlength="16">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Provinsi</label>
                                    <input type="text" class="form-control" name="provinsi" value="<?php echo $provinsi; ?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kabupaten/Kota</label>
                                    <input type="text" class="form-control" name="kabupaten" value="<?php echo $kabkot; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Kecamatan</label>
                                    <input type="text" class="form-control" name="kecamatan" value="<?php echo strtoupper($validate_user['kecamatan']); ?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kelurahan/Desa</label>
                                    <input type="text" class="form-control" name="kelurahan" value="<?php echo strtoupper($validate_user['desa']); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for='rt'>RT</label>
                                        <input type='number' id='rt' name='rt' class='form-control' placeholder="Contoh: 01" value="<?php echo $is_rt ? esc_attr($rt_filter) : ''; ?>" <?php echo $is_rt ? 'readonly' : ''; ?>>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for='rw'>RW</label>
                                        <input type='number' id='rw' name='rw' class='form-control'  placeholder="Contoh: 02" value="<?php echo $is_rt ? esc_attr($rw_filter) : ''; ?>" <?php echo $is_rt ? 'readonly' : ''; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="alamat">Alamat Lengkap (Jalan/RT/RW) <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan detail alamat, RT/RW, Dusun, dll." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="submitKeluarga();" class="btn btn-primary">Simpan Keluarga</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAnggotaKeluarga" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulmodalAnggotaKeluarga">Daftar Anggota Keluarga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button class="btn btn-info mb-3" onclick="showModalTambahDataAnggota();" title="Tambah Anggota Keluarga">
                    <span class="dashicons dashicons-plus-alt"></span> Tambah Anggota
                </button>
                <div class="table-responsive p-2">
                    <table id="tableDataAnggotaKeluarga" class="table table-bordered table-hover w-100">
                        <thead>
                            <tr>
                                <th class="text-center">NIK</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Hubungan</th>
                                <th class="text-center">Pekerjaan Utama</th>
                                <th class="text-center">Status di KK</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahDataAnggota" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulmodalTambahDataAnggota">Tambah Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-anggota">
                    <input type="hidden" id="id_anggota" name="id_anggota">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="is_kepala_keluarga">Status di Keluarga <span class="text-danger">*</span></label>
                                    <select class="form-control" id="is_kepala_keluarga" name="is_kepala_keluarga" required>
                                        <option value="0">Anggota Keluarga (Istri/Anak/dll)</option>
                                        <option value="1">Kepala Keluarga</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="nik_anggota">NIK <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nik_anggota" name="nik" placeholder="16 digit NIK" required maxlength="16">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="nama_anggota">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_anggota" name="nama" placeholder="Sesuai KTP" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="hub_kepala_keluarga">Hubungan (Text) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="hub_kepala_keluarga" name="hub_kepala_keluarga" placeholder="Contoh: ISTRI, ANAK, KEPALA KELUARGA" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pekerjaan_utama_anggota">Pekerjaan Utama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="pekerjaan_utama_anggota" name="pekerjaan_utama" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="submitAnggota();" class="btn btn-primary">Simpan Anggota</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="verifikasiModal" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Data Keluarga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formVerifikasi">
                    <input type="hidden" name="idDataVerifikasi" id="idDataVerifikasi" value="">
                    <div class="mb-3">
                        <label class="form-label">Status Verifikasi</label>
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
                        <label class="form-label">Keterangan Verifikasi</label>
                        <textarea class="form-control" id="keteranganVerifikasi" name="keteranganVerifikasi" rows="3" placeholder="Alasan ditolak/diterima..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitVerifikasi()">Simpan Verifikasi</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.id_desa = <?php echo json_encode($input['id_desa']); ?>;
    window.user_role = <?php echo json_encode($validate_user['roles']); ?>;
    window.rt_filter = <?php echo json_encode($rt_filter); ?>;
    window.rw_filter = <?php echo json_encode($rw_filter); ?>;
    window.id_keluarga_aktif = null;
    window.tableDtsen;
    window.tableAnggotaDtsen;

    jQuery(document).ready(function() {
        initTableDtsen();
    });

    // ==========================================
    // 1. KELUARGA (PARENT) - CRUD
    // ==========================================
    function showModalTambahData() {
        jQuery('#form-keluarga')[0].reset();
        jQuery('#id_keluarga_input').val('');
        jQuery('#judulmodalTambahData').html('Tambah Data Keluarga Baru');
        if (window.user_role === 'rt') {
            jQuery('#rt').val(window.rt_filter).attr('readonly', true);
            jQuery('#rw').val(window.rw_filter).attr('readonly', true);
        }

        jQuery('#modalTambahData').modal('show');
    }

    function showModalKeluarga(editId) {
        jQuery('#form-keluarga')[0].reset();
        jQuery('#wrap-loading').show();

        jQuery.post(ajax.url, {
            action: 'get_detail_keluarga_usulan_dtsen_ajax',
            api_key: ajax.apikey,
            id: editId
        }, function(res) {
            jQuery('#wrap-loading').hide();
            if (res.success) {
                let d = res.data;
                jQuery('#id_keluarga_input').val(d.id);
                jQuery('#no_kk').val(d.no_kk);
                jQuery('#alamat').val(d.alamat);
                jQuery('#judulmodalTambahData').html('Edit Data Keluarga');

                if (window.user_role === 'rt') {
                    jQuery('#rt').val(window.rt_filter).attr('readonly', true);
                    jQuery('#rw').val(window.rw_filter).attr('readonly', true);
                } else {
                    jQuery('#rt').val(d.rt);
                    jQuery('#rw').val(d.rw);
                }

                jQuery('#modalTambahData').modal('show');
            } else {
                alert(res.data.message);
            }
        });
    }

    function submitKeluarga() {
        let form = jQuery('#form-keluarga')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        let data = new FormData(form);
        data.append('action', 'save_keluarga_usulan_dtsen_ajax');
        data.append('api_key', ajax.apikey);
        data.append('id_wilayah', window.id_desa);

        jQuery('#wrap-loading').show();
        jQuery.ajax({
            url: ajax.url,
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function(res) {
                jQuery('#wrap-loading').hide();
                if (res.success) {
                    alert(res.data.message);
                    jQuery('#modalTambahData').modal('hide');
                    if (tableDtsen) tableDtsen.ajax.reload(null, false);
                } else {
                    alert(res.data.message);
                }
            }
        });
    }

    function hapusKeluarga(id) {
        if (confirm('Yakin ingin menghapus Data Keluarga ini? Pastikan seluruh anggotanya sudah dihapus terlebih dahulu.')) {
            jQuery('#wrap-loading').show();
            jQuery.post(ajax.url, {
                action: 'delete_keluarga_usulan_dtsen_ajax',
                api_key: ajax.apikey,
                id_keluarga: id
            }, function(res) {
                jQuery('#wrap-loading').hide();
                if (res.success) {
                    alert(res.data.message);
                    tableDtsen.ajax.reload(null, false);
                } else {
                    alert(res.data.message);
                }
            }).fail(function(xhr) {
                jQuery('#wrap-loading').hide();
                alert(xhr.responseJSON?.data?.message || 'Error server saat menghapus keluarga');
            });
        }
    }

    // ==========================================
    // 2. ANGGOTA (CHILD) - CRUD
    // ==========================================
    function showModalAnggotaKeluarga(id_keluarga) {
        window.id_keluarga_aktif = id_keluarga;
        initTableAnggotaDtsen(id_keluarga);
        jQuery('#modalAnggotaKeluarga').modal('show');
    }

    function showModalTambahDataAnggota() {
        jQuery('#form-anggota')[0].reset();
        jQuery('#id_anggota').val('');
        jQuery('#judulmodalTambahDataAnggota').html('Tambah Anggota Keluarga');
        jQuery('#modalTambahDataAnggota').modal('show');
    }

    function editAnggota(id_anggota) {
        jQuery('#form-anggota')[0].reset();
        jQuery('#wrap-loading').show();

        jQuery.post(ajax.url, {
            action: 'get_detail_anggota_usulan_dtsen_ajax',
            api_key: ajax.apikey,
            id: id_anggota
        }, function(res) {
            jQuery('#wrap-loading').hide();
            if (res.success) {
                let d = res.data;
                jQuery('#id_anggota').val(d.id);
                jQuery('#is_kepala_keluarga').val(d.is_kepala_keluarga);
                jQuery('#nik_anggota').val(d.nik);
                jQuery('#nama_anggota').val(d.nama);
                jQuery('#hub_kepala_keluarga').val(d.hub_kepala_keluarga);
                jQuery('#pekerjaan_utama_anggota').val(d.pekerjaan_utama);

                jQuery('#judulmodalTambahDataAnggota').html('Edit Anggota Keluarga');
                jQuery('#modalTambahDataAnggota').modal('show');
            } else {
                alert(res.data.message);
            }
        });
    }

    function submitAnggota() {
        let form = jQuery('#form-anggota')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        let data = new FormData(form);
        data.append('action', 'save_anggota_usulan_dtsen_ajax');
        data.append('api_key', ajax.apikey);
        data.append('id_keluarga', window.id_keluarga_aktif);

        jQuery('#wrap-loading').show();
        jQuery.ajax({
            url: ajax.url,
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function(res) {
                jQuery('#wrap-loading').hide();
                if (res.success) {
                    alert(res.data.message);
                    jQuery('#modalTambahDataAnggota').modal('hide');
                    if (tableAnggotaDtsen) tableAnggotaDtsen.ajax.reload(null, false);
                } else {
                    alert(res.data.message);
                }
            }
        });
    }

    function hapusAnggota(id) {
        if (confirm('Yakin ingin menghapus Anggota Keluarga ini?')) {
            jQuery('#wrap-loading').show();
            jQuery.post(ajax.url, {
                action: 'delete_anggota_usulan_dtsen_ajax',
                api_key: ajax.apikey,
                id_anggota: id
            }, function(res) {
                jQuery('#wrap-loading').hide();
                if (res.success) {
                    alert(res.data.message);
                    tableAnggotaDtsen.ajax.reload(null, false);
                } else {
                    alert(res.data.message);
                }
            }).fail(function(xhr) {
                jQuery('#wrap-loading').hide();
                alert(xhr.responseJSON?.data?.message || 'Error server saat menghapus anggota');
            });
        }
    }

    // ==========================================
    // 3. FUNGSI VERIFIKASI & PENGAJUAN (SUBMIT)
    // ==========================================
    function submitUsulan(id_keluarga) {
        if (confirm('Yakin ingin mengajukan data ini ke Admin? Pastikan anggota sudah lengkap.')) {
            jQuery('#wrap-loading').show();
            jQuery.post(ajax.url, {
                action: 'submit_usulan_dtsen_ajax',
                api_key: ajax.apikey,
                id_keluarga: id_keluarga
            }, function(res) {
                jQuery('#wrap-loading').hide();
                if (res.success) {
                    alert(res.data.message);
                    tableDtsen.ajax.reload(null, false);
                } else {
                    alert(res.data.message);
                }
            }).fail(function(xhr) {
                jQuery('#wrap-loading').hide();
                alert(xhr.responseJSON?.data?.message || 'Gagal mengajukan data.');
            });
        }
    }

    function showModalVerifikasi(id_keluarga) {
        jQuery('#formVerifikasi')[0].reset();
        jQuery('#idDataVerifikasi').val(id_keluarga);
        jQuery('#verifikasiModal').modal('show');
    }

    function submitVerifikasi() {
        let id_keluarga = jQuery('#idDataVerifikasi').val();
        let status = jQuery('input[name="verifikasiStatus"]:checked').val();
        let keterangan = jQuery('#keteranganVerifikasi').val();

        if (!status) {
            alert('Pilih status Terima atau Tolak');
            return;
        }

        jQuery('#wrap-loading').show();
        jQuery.post(ajax.url, {
            action: 'verifikasi_keluarga_usulan_dtsen_ajax',
            api_key: ajax.apikey,
            id_keluarga: id_keluarga,
            status_data: status,
            keterangan_verifikasi: keterangan
        }, function(res) {
            jQuery('#wrap-loading').hide();
            if (res.success) {
                alert(res.data.message);
                jQuery('#verifikasiModal').modal('hide');
                tableDtsen.ajax.reload(null, false);
            } else {
                alert(res.data.message);
            }
        });
    }

    // ==========================================
    // 4. INIT DATATABLES
    // ==========================================
    function initTableDtsen() {
        if (jQuery.fn.DataTable.isDataTable('#tableData')) {
            jQuery('#tableData').DataTable().ajax.reload();
            return;
        }
        tableDtsen = jQuery('#tableData').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": ajax.url,
                "type": "POST",
                "data": function(d) {
                    d.action = "get_datatable_data_usulan_dtsen";
                    d.api_key = ajax.apikey;
                    d.desa = "<?php echo $get_desa_kel['nama']; ?>";
                    // Kirim rt/rw jika user RT
                    if (window.user_role === 'rt') {
                        d.rt_filter = window.rt_filter;
                        d.rw_filter = window.rw_filter;
                    }
                }
            },
            "columns": [
                { "data": "status_data", "className": "text-center" },
                { "data": "no_kk" },
                { "data": "alamat" },
                { "data": "provinsi" },
                { "data": "kabupaten" },
                { "data": "kecamatan" },
                { "data": "kelurahan" },
                { "data": "rt" },
                { "data": "rw" },
                { "data": "aksi", "className": "text-center", "orderable": false }
            ]
        });
    }

    function initTableAnggotaDtsen(id_keluarga) {
        if (jQuery.fn.DataTable.isDataTable('#tableDataAnggotaKeluarga')) {
            jQuery('#tableDataAnggotaKeluarga').DataTable().destroy();
        }
        tableAnggotaDtsen = jQuery('#tableDataAnggotaKeluarga').DataTable({
            "processing": true,
            "serverSide": false,
            "responsive": true,
            "ajax": {
                "url": ajax.url,
                "type": "POST",
                "data": function(d) {
                    d.action = "get_datatable_anggota_usulan_dtsen_ajax";
                    d.api_key = ajax.apikey;
                    d.id_keluarga = id_keluarga;
                }
            },
            "columns": [{
                    "data": "nik"
                },
                {
                    "data": "nama"
                },
                {
                    "data": "hub_kepala_keluarga"
                },
                {
                    "data": "pekerjaan_utama"
                },
                {
                    "data": "status_kepala",
                    "className": "text-center"
                },
                {
                    "data": "aksi",
                    "className": "text-center",
                    "orderable": false
                }
            ]
        });
    }
</script>