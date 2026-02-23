<?php
$input = shortcode_atts(array(
    'id_desa' => isset($_GET['id_desa']) ? intval($_GET['id_desa'])              : '',
    'rt'      => isset($_GET['rt'])      ? sanitize_text_field($_GET['rt'])      : '',
    'rw'      => isset($_GET['rw'])      ? sanitize_text_field($_GET['rw'])      : '',
), $atts);

$current_user = wp_get_current_user();
$user_roles = $current_user->roles;
$is_rt_role = in_array('rt', $user_roles);
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
$center   = $this->get_center();
$maps_all = $this->get_polygon();
foreach ($maps_all as $i => $desa) {
    $html = '<table>';
    foreach ($desa['data'] as $k => $v) {
        $html .= '<tr><td><b>' . $k . '</b></td><td>' . $v . '</td></tr>';
    }
    $html .= '</table>';
    $maps_all[$i]['html'] = $html;
}

$desa = $wpdb->get_row(
    $wpdb->prepare('
        SELECT * FROM data_batas_desa_siks
        WHERE desa=%s AND kecamatan=%s AND active=1
    ', $validate_user['desa'], $validate_user['kecamatan']),
    ARRAY_A
);
$default_location = $this->getSearchLocation($desa);
?>

<style>
    .wrap-table { 
        overflow: auto; 
        max-height: 100vh; 
        width: 100%; 
    }
    #modal-rt-rw-overlay-ds { 
        display:none; 
        position:fixed; 
        inset:0; 
        background:rgba(0,0,0,.55); 
        z-index:99999; 
        align-items:center; 
        justify-content:center; 
    }
    #modal-rt-rw-overlay-ds.active { 
        display:flex; 
    }
    #modal-rt-rw-ds { 
        background:#fff; 
        border-radius:8px; 
        padding:28px 32px; 
        width:100%; 
        max-width:640px; 
        max-height:90vh; 
        overflow-y:auto; 
        box-shadow:0 8px 32px rgba(0,0,0,.22); 
        position:relative; 
    }
    #modal-rt-rw-ds h4 { 
        margin:0 0 18px; 
        font-size:18px; 
        font-weight:700; 
        color:#1a1a2e; 
    }
    #modal-rt-rw-ds .modal-close { 
        position:absolute; 
        top:14px; 
        right:18px; 
        background:none; 
        border:none; 
        font-size:22px; 
        cursor:pointer; 
        color:#666; 
    }
    #modal-rt-rw-ds .modal-close:hover { 
        color:#c0392b; 
    }
    #modal-nama-list-ds { 
        max-height:180px; 
        overflow-y:auto; 
        border:1px solid #dee2e6; 
        border-radius:5px; 
        padding:8px 12px; 
        margin-bottom:18px; 
        background:#f8f9fa; 
    }
    #modal-nama-list-ds p { 
        margin:3px 0; 
        font-size:13.5px; 
        color:#333; 
    }
    #notif-rt-rw-ds { 
        display:none; 
        background:#fff3cd; 
        border:1px solid #ffc107; 
        color:#856404; 
        border-radius:5px; 
        padding:10px 14px; 
        margin-bottom:14px; 
        font-size:13.5px; 
    }
    .form-rt-rw-ds { 
        display:flex; 
        gap:16px; 
        margin-bottom:20px; 
    }
    .form-rt-rw-ds .form-group { 
        flex:1; 
    }
    .form-rt-rw-ds label { 
        font-weight:600; 
        font-size:13px; 
        margin-bottom:4px; 
        display:block; 
    }
    .form-rt-rw-ds input { 
        width:100%; 
        padding:7px 10px; 
        border:1px solid #ced4da; 
        border-radius:5px; 
        font-size:14px; 
    }
    .modal-actions-ds { 
        display:flex; 
        gap:10px; 
        justify-content:flex-end; 
    }
    #toolbar-rt-rw-ds { 
        margin-bottom:10px; 
    }
    #btn-tambah-rt-rw-ds { 
        display:none; 
    }
</style>

<h1 class="text-center">
    Peta Sebaran DTKS ( Data Terpadu Kesejahteraan Sosial )<br>
    Terintegrasi dengan DTSEN (Data Tunggal Sosial dan Ekonomi Nasional)<br>
    DESA <?php echo strtoupper($validate_user['desa']); ?>
</h1>

<div style="padding:10px; margin:0 0 3rem 0;">
    <div id="map-canvas-siks" style="width:100%; height:400px;"></div>
    <h1 class="text-center" style="margin:3rem;">
        Data DTSEN (Data Tunggal Sosial dan Ekonomi Nasional)<br>
        DESA <?php echo strtoupper($validate_user['desa']); ?>
    </h1>

    <?php if (!$is_rt_role): ?>
        <div id="toolbar-rt-rw-wr">
            <button id="btn-tambah-rt-rw-ls" class="btn btn-primary">
                <i class="dashicons dashicons-edit" style="vertical-align:middle;"></i>
                Tambah RT RW
            </button>
        </div>
    <?php endif; ?>

    <div class="wrap-table">
        <table id="tableData">
            <thead>
                <tr>
                    <th class="text-center">
                        <input type="checkbox" id="check-all-ds" title="Pilih Semua">
                    </th>
                    <th class="text-center">No.</th>
                    <th class="text-center">Desil Nasional</th>
                    <th class="text-center">Disabilitas</th>
                    <th class="text-center">Lansia</th>
                    <th class="text-center">No. KK</th>
                    <th class="text-center">Hubungan Keluarga</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Pekerjaan Utama</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa/Kelurahan</th>
                    <th class="text-center">RT</th>
                    <th class="text-center">RW</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="modal-rt-rw-overlay-ds">
    <div id="modal-rt-rw-ds">
        <button class="modal-close" id="btn-modal-close-ds">&times;</button>
        <h4>Tambah / Edit RT &amp; RW — DTSEN</h4>
        <p style="font-size:13px;color:#555;margin-bottom:8px;"><strong>Data yang dipilih:</strong></p>
        <div id="modal-nama-list-ds"></div>
        <div class="form-rt-rw-ds">
            <div class="form-group">
                <label for="input-rt-ds">RT</label>
                <input type="text" id="input-rt-ds" placeholder="Contoh: 01" maxlength="10">
            </div>
            <div class="form-group">
                <label for="input-rw-ds">RW</label>
                <input type="text" id="input-rw-ds" placeholder="Contoh: 02" maxlength="10">
            </div>
        </div>
        <div class="modal-actions-ds">
            <button class="btn btn-secondary" id="btn-modal-cancel-ds">Batal</button>
            <button class="btn btn-primary" id="btn-modal-save-ds">Simpan</button>
        </div>
    </div>
</div>

<script>
    window.maps_all_siks    = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;

    var selectedRowsDs = [];

    function updateToolbarDs() {
        jQuery('#btn-tambah-rt-rw-ds').toggle(selectedRowsDs.length > 0);
    }

    function openModalDs() {
        var html = '';
        selectedRowsDs.forEach(function(r) { html += '<p>&#9656; ' + r.Nama + '</p>'; });
        jQuery('#modal-nama-list-ds').html(html);

        var rtValues = [...new Set(selectedRowsDs.map(function(r){ return (r.rt || '').trim(); }))];
        var rwValues = [...new Set(selectedRowsDs.map(function(r){ return (r.rw || '').trim(); }))];
        jQuery('#modal-rt-rw-overlay-ds').addClass('active');
    }

    function closeModalDs() {
        jQuery('#modal-rt-rw-overlay-ds').removeClass('active');
        jQuery('#input-rt-ds, #input-rw-ds').val('');
    }

    function bindCheckboxDs() {
        jQuery('#check-all-ds').off('change').on('change', function() {
            jQuery('#tableData tbody input.row-check-ds')
                .prop('checked', jQuery(this).is(':checked'))
                .trigger('change');
        });

        jQuery('#tableData tbody')
            .off('change', 'input.row-check-ds')
            .on('change', 'input.row-check-ds', function() {
                var cb   = jQuery(this);
                var id   = String(cb.data('id'));
                var nama = cb.data('nama');
                var rt   = String(cb.data('rt')  || '');
                var rw   = String(cb.data('rw')  || '');

                if (cb.is(':checked')) {
                    if (!selectedRowsDs.find(function(r){ return r.id === id; })) {
                        selectedRowsDs.push({ id: id, Nama: nama, rt: rt, rw: rw });
                    }
                } else {
                    selectedRowsDs = selectedRowsDs.filter(function(r){ return r.id !== id; });
                    jQuery('#check-all-ds').prop('checked', false);
                }
                updateToolbarDs();
            });
    }

    jQuery(document).ready(function() {
        cari_alamat_siks('<?php echo $default_location; ?>');
        generate_table();

        jQuery('#btn-tambah-rt-rw-ds').on('click', function() {
            if (selectedRowsDs.length > 0) openModalDs();
        });

        jQuery('#btn-modal-close-ds, #btn-modal-cancel-ds').on('click', closeModalDs);
        jQuery('#modal-rt-rw-overlay-ds').on('click', function(e) {
            if (e.target === this) closeModalDs();
        });

        jQuery('#btn-modal-save-ds').on('click', function() {
            var rt = jQuery('#input-rt-ds').val().trim();
            var rw = jQuery('#input-rw-ds').val().trim();
            if (rt === '' || rw === '') { alert('RT dan RW tidak boleh kosong!'); return; }

            var postData = {
                action:  'update_rt_rw_siks',
                api_key: ajax.apikey,
                tipe:    'dtsen',
                rt:      rt,
                rw:      rw
            };
            selectedRowsDs.forEach(function(r, i) { postData['ids[' + i + ']'] = r.id; });

            jQuery.ajax({
                url: ajax.url, type: 'POST', dataType: 'json', data: postData,
                beforeSend: function() {
                    jQuery('#wrap-loading').show();
                    jQuery('#btn-modal-save-ds').prop('disabled', true).text('Menyimpan…');
                },
                success: function(res) {
                    jQuery('#wrap-loading').hide();
                    if (res && res.status) {
                        closeModalDs();
                        selectedRowsDs = [];
                        updateToolbarDs();
                        jQuery('#check-all-ds').prop('checked', false);
                        generate_table();
                        alert('RT & RW berhasil diperbarui!');
                    } else {
                        alert('Gagal: ' + (res.message || 'Terjadi kesalahan'));
                    }
                },
                error: function() { jQuery('#wrap-loading').hide(); alert('Terjadi kesalahan koneksi.'); },
                complete: function() { jQuery('#btn-modal-save-ds').prop('disabled', false).text('Simpan'); }
            });
        });
    });

    function get_data_dtsen() {
        return jQuery.ajax({
            url:      ajax.url,
            method:   'POST',
            data: {
                action:  'get_data_dtsen_ajax',
                api_key: ajax.apikey,                
                rt: '<?php echo esc_js($input['rt']); ?>',
                rw: '<?php echo esc_js($input['rw']); ?>',
                desa:    '<?php echo $validate_user['desa']; ?>'
            },
            dataType: 'json',
        });
    }

    async function generate_table() {
        try {
            jQuery('#wrap-loading').show();

            if (jQuery.fn.DataTable.isDataTable('#tableData')) {
                jQuery('#tableData').DataTable().destroy();
            }

            const allData = await get_data_dtsen();

            if (allData.status) {
                selectedRowsDs = [];
                updateToolbarDs();
                jQuery('#check-all-ds').prop('checked', false);

                let tbody = '';
                let no    = 1;
                allData.data.forEach(function(data) {
                    var id   = String(data.id   || '');
                    var nama = (data.nama || '').replace(/"/g, '&quot;');
                    var rt   = (data.rt   || '').replace(/"/g, '&quot;');
                    var rw   = (data.rw   || '').replace(/"/g, '&quot;');

                    var checkbox = '<input type="checkbox" class="row-check-ds"' +
                                   ' data-id="'   + id   + '"' +
                                   ' data-nama="' + nama + '"' +
                                   ' data-rt="'   + rt   + '"' +
                                   ' data-rw="'   + rw   + '">';

                    tbody += '<tr>' +
                        '<td class="text-center">'  + checkbox                    + '</td>' +
                        '<td class="text-center">'  + (no++)                      + '</td>' +
                        '<td class="text-center">'  + (data.desil_nasional || '') + '</td>' +
                        '<td class="text-left">'    + (data.disabilitas    || '') + '</td>' +
                        '<td class="text-left">'    + (data.lansia         || '') + '</td>' +
                        '<td class="text-left">'    + (data.no_kk          || '') + '</td>' +
                        '<td class="text-left">'    + (data.hub_kepala_keluarga || '') + '</td>' +
                        '<td class="text-left">'    + (data.alamat         || '') + '</td>' +
                        '<td class="text-left">'    + (data.nama           || '') + '</td>' +
                        '<td class="text-left">'    + (data.nik            || '') + '</td>' +
                        '<td class="text-left">'    + (data.pekerjaan_utama || '') + '</td>' +
                        '<td class="text-left">'    + (data.provinsi       || '') + '</td>' +
                        '<td class="text-left">'    + (data.kabupaten      || '') + '</td>' +
                        '<td class="text-left">'    + (data.kecamatan      || '') + '</td>' +
                        '<td class="text-left">'    + (data.kelurahan      || '') + '</td>' +
                        '<td class="text-center">'  + (data.rt             || '') + '</td>' +
                        '<td class="text-center">'  + (data.rw             || '') + '</td>' +
                    '</tr>';
                });

                jQuery('#tableData tbody').html(tbody);
            }

        } catch (error) {
            alert('Gagal generate table');
            console.log(error);
        } finally {
            jQuery('#tableData').dataTable();
            jQuery('#wrap-loading').hide();

            bindCheckboxDs();
        }
    }
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>