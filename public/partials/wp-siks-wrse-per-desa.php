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
        WHERE desa=%s 
            AND kecamatan=%s 
            AND active=1
    ', $validate_user['desa'], $validate_user['kecamatan']),
    ARRAY_A
);
$default_location = $this->getSearchLocation($desa);
?>

<style type="text/css">
    #modal-rt-rw-overlay-wr { 
        display:none; 
        position:fixed; 
        inset:0; 
        background:rgba(0,0,0,.55); 
        z-index:99999; 
        align-items:center; 
        justify-content:center; 
    }
    #modal-rt-rw-overlay-wr.active { 
        display:flex; 
    }
    #modal-rt-rw-wr { 
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
    #modal-rt-rw-wr h4 { 
        margin:0 0 18px; 
        font-size:18px; 
        font-weight:700; 
        color:#1a1a2e; 
    }
    #modal-rt-rw-wr .modal-close { 
        position:absolute; 
        top:14px; 
        right:18px; 
        background:none; 
        border:none; 
        font-size:22px; 
        cursor:pointer; 
        color:#666; 
    }
    #modal-rt-rw-wr .modal-close:hover { 
        color:#c0392b; 
    }
    #modal-nama-list-wr { 
        max-height:180px; 
        overflow-y:auto; 
        border:1px solid #dee2e6; 
        border-radius:5px; 
        padding:8px 12px; 
        margin-bottom:18px; 
        background:#f8f9fa; 
    }
    #modal-nama-list-wr p { 
        margin:3px 0; 
        font-size:13.5px; 
        color:#333; 
    }
    #notif-rt-rw-wr { 
        display:none; 
        background:#fff3cd; 
        border:1px solid #ffc107; 
        color:#856404; 
        border-radius:5px; 
        padding:10px 14px; 
        margin-bottom:14px; 
        font-size:13.5px; 
    }
    .form-rt-rw-wr { 
        display:flex; 
        gap:16px; 
        margin-bottom:20px; 
    }
    .form-rt-rw-wr .form-group { 
        flex:1; 
    }
    .form-rt-rw-wr label { 
        font-weight:600; 
        font-size:13px; 
        margin-bottom:4px; 
        display:block; 
    }
    .form-rt-rw-wr input { 
        width:100%; 
        padding:7px 10px; 
        border:1px solid #ced4da; 
        border-radius:5px; 
        font-size:14px; 
    }
    .modal-actions-wr { 
        display:flex; 
        gap:10px; 
        justify-content:flex-end; 
    }
    #toolbar-rt-rw-wr { 
        margin-bottom:10px; 
    }
    #btn-tambah-rt-rw-wr { 
        display:none; 
    }
</style>

<h1 class="text-center">Peta Sebaran WRSE<br>( Wanita Rawan Sosial Ekonomi )<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>

<div style="padding:10px; margin:0 0 3rem 0;">
    <div id="map-canvas-siks" style="width:100%; height:400px;"></div>
    <h1 class="text-center" style="margin:3rem;">Data WRSE<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>

    <?php if (!$is_rt_role): ?>
        <div id="toolbar-rt-rw-wr">
            <button id="btn-tambah-rt-rw-ls" class="btn btn-primary">
                <i class="dashicons dashicons-edit" style="vertical-align:middle;"></i>
                Tambah RT RW
            </button>
        </div>
    <?php endif; ?>

    <table id="tableData" class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center"><input type="checkbox" id="check-all-wr" title="Pilih Semua"></th>
                <th class="text-center">Aksi</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Usia</th>
                <th class="text-center">Provinsi</th>
                <th class="text-center">Kota / Kabupaten</th>
                <th class="text-center">Kecamatan</th>
                <th class="text-center">Desa / Kelurahan</th>
                <th class="text-center">RT</th>
                <th class="text-center">RW</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Status DTKS</th>
                <th class="text-center">Status Pernikahan</th>
                <th class="text-center">Mempunyai Usaha</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Tahun Anggaran</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div id="modal-rt-rw-overlay-wr">
    <div id="modal-rt-rw-wr">
        <button class="modal-close" id="btn-modal-close-wr">&times;</button>
        <h4>Tambah / Edit RT &amp; RW — WRSE</h4>
        <p style="font-size:13px;color:#555;margin-bottom:8px;"><strong>Data yang dipilih:</strong></p>
        <div id="modal-nama-list-wr"></div>
        <div id="notif-rt-rw-wr">RT atau RW tidak sesuai, silahkan cek ulang!</div>
        <div class="form-rt-rw-wr">
            <div class="form-group">
                <label for="input-rt-wr">RT</label>
                <input type="text" id="input-rt-wr" placeholder="Contoh: 01" maxlength="10">
            </div>
            <div class="form-group">
                <label for="input-rw-wr">RW</label>
                <input type="text" id="input-rw-wr" placeholder="Contoh: 02" maxlength="10">
            </div>
        </div>
        <div class="modal-actions-wr">
            <button class="btn btn-secondary" id="btn-modal-cancel-wr">Batal</button>
            <button class="btn btn-primary" id="btn-modal-save-wr">Simpan</button>
        </div>
    </div>
</div>

<script>
    window.maps_all_siks    = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;

    var selectedRowsWr = [];

    function updateToolbarWr() {
        jQuery('#btn-tambah-rt-rw-wr').toggle(selectedRowsWr.length > 0);
    }

    function openModalWr() {
        var html = '';
        selectedRowsWr.forEach(function(r) { html += '<p>&#9656; ' + r.Nama + '</p>'; });
        jQuery('#modal-nama-list-wr').html(html);

        var rtValues = [...new Set(selectedRowsWr.map(function(r){ return (r.rt||'').trim(); }))];
        var rwValues = [...new Set(selectedRowsWr.map(function(r){ return (r.rw||'').trim(); }))];
        var allMatch = rtValues.length === 1 && rwValues.length === 1;

        if (!allMatch) {
            jQuery('#notif-rt-rw-wr').show();
            jQuery('#input-rt-wr, #input-rw-wr').val('').prop('disabled', true);
            jQuery('#btn-modal-save-wr').prop('disabled', true);
        } else {
            jQuery('#notif-rt-rw-wr').hide();
            jQuery('#input-rt-wr').val(rtValues[0]).prop('disabled', false);
            jQuery('#input-rw-wr').val(rwValues[0]).prop('disabled', false);
            jQuery('#btn-modal-save-wr').prop('disabled', false);
        }
        jQuery('#modal-rt-rw-overlay-wr').addClass('active');
    }

    function closeModalWr() {
        jQuery('#modal-rt-rw-overlay-wr').removeClass('active');
        jQuery('#input-rt-wr, #input-rw-wr').val('');
    }

    jQuery(document).ready(function() {
        getDataTable();
        cari_alamat_siks('<?php echo $default_location; ?>');

        jQuery('#check-all-wr').on('change', function() {
            jQuery('#tableData tbody input.row-check-wr')
                .prop('checked', jQuery(this).is(':checked')).trigger('change');
        });

        jQuery('#btn-tambah-rt-rw-wr').on('click', function() {
            if (selectedRowsWr.length > 0) openModalWr();
        });

        jQuery('#btn-modal-close-wr, #btn-modal-cancel-wr').on('click', closeModalWr);
        jQuery('#modal-rt-rw-overlay-wr').on('click', function(e) {
            if (e.target === this) closeModalWr();
        });

        jQuery('#btn-modal-save-wr').on('click', function() {
            var rt = jQuery('#input-rt-wr').val().trim();
            var rw = jQuery('#input-rw-wr').val().trim();
            if (rt === '' || rw === '') { alert('RT dan RW tidak boleh kosong!'); return; }

            var postData = {
                action:  'update_rt_rw_siks',
                api_key: ajax.apikey,
                tipe:    'wrse',
                rt:      rt,
                rw:      rw
            };
            selectedRowsWr.forEach(function(r, i) { postData['ids[' + i + ']'] = r.id; });

            jQuery.ajax({
                url: ajax.url, type: 'POST', dataType: 'json', data: postData,
                beforeSend: function() {
                    jQuery('#wrap-loading').show();
                    jQuery('#btn-modal-save-wr').prop('disabled', true).text('Menyimpan…');
                },
                success: function(res) {
                    jQuery('#wrap-loading').hide();
                    if (res && res.status) {
                        closeModalWr();
                        selectedRowsWr = [];
                        updateToolbarWr();
                        jQuery('#check-all-wr').prop('checked', false);
                        window.tableWrse.ajax.reload(null, false);
                        alert('RT & RW berhasil diperbarui!');
                    } else {
                        alert('Gagal: ' + (res.message || 'Terjadi kesalahan'));
                    }
                },
                error: function() { jQuery('#wrap-loading').hide(); alert('Terjadi kesalahan koneksi.'); },
                complete: function() { jQuery('#btn-modal-save-wr').prop('disabled', false).text('Simpan'); }
            });
        });
    });

    function getDataTable() {
        if (typeof tableWrse === 'undefined') {
            window.tableWrse = jQuery('#tableData')
                .on('preXhr.dt', function() { jQuery('#wrap-loading').show(); })
                .DataTable({
                    processing: true, serverSide: true,
                    scrollX: true, scrollY: '600px', scrollCollapse: true,
                    search: { return: true },
                    ajax: {
                        url: ajax.url, type: 'POST', dataType: 'json',
                        data: {
                            action:    'get_datatable_data_wrse',
                            api_key:   ajax.apikey,
                            rt: '<?php echo esc_js($input['rt']); ?>',
                            rw: '<?php echo esc_js($input['rw']); ?>',
                            desa:      '<?php echo $validate_user['desa']; ?>',
                            kecamatan: '<?php echo $validate_user['kecamatan']; ?>',
                        }
                    },
                    lengthMenu: [[20, 50, 100, -1], [20, 50, 100, 'All']],
                    order: [],
                    drawCallback: function(settings) {
                        var api = this.api();
                        api.rows({ page: 'current' }).data().map(function(b) {
                            if (b.lat && b.lng) {
                                var data = b.aksi.split(", true, '")[1].split("')")[0];
                                setCenterSiks(b.lat, b.lng, true, data, true);
                            }
                        });
                        jQuery('#wrap-loading').hide();
                        jQuery('#tableData tbody')
                            .off('change', 'input.row-check-wr')
                            .on('change', 'input.row-check-wr', function() {
                                var cb   = jQuery(this);
                                var id   = String(cb.data('id'));
                                var nama = cb.data('nama');
                                var rt   = String(cb.data('rt') || '');
                                var rw   = String(cb.data('rw') || '');
                                if (cb.is(':checked')) {
                                    if (!selectedRowsWr.find(function(r){ return r.id === id; })) {
                                        selectedRowsWr.push({ id: id, Nama: nama, rt: rt, rw: rw });
                                    }
                                } else {
                                    selectedRowsWr = selectedRowsWr.filter(function(r){ return r.id !== id; });
                                    jQuery('#check-all-wr').prop('checked', false);
                                }
                                updateToolbarWr();
                            });
                    },
                    columns: [
                        {
                            data: 'id', orderable: false, searchable: false,
                            render: function(data, type, row) {
                                var id   = String(data || '');
                                var nama = (row.nama || '').replace(/"/g, '&quot;');
                                var rt   = (row.rt   || '').replace(/"/g, '&quot;');
                                var rw   = (row.rw   || '').replace(/"/g, '&quot;');
                                return '<input type="checkbox" class="row-check-wr"' +
                                       ' data-id="' + id + '" data-nama="' + nama + '"' +
                                       ' data-rt="'  + rt  + '" data-rw="'  + rw  + '">';
                            }
                        },
                        { 
                            data: 'aksi',             
                            className: 'text-center' 
                        },
                        { 
                            data: 'nama',             
                            className: 'text-left' 
                        },
                        { 
                            data: 'usia',             
                            className: 'text-center' 
                        },
                        { 
                            data: 'provinsi',         
                            className: 'text-center' 
                        },
                        { 
                            data: 'kabkot',           
                            className: 'text-center' 
                        },
                        { 
                            data: 'kecamatan',        
                            className: 'text-center' 
                        },
                        { 
                            data: 'desa_kelurahan',   
                            className: 'text-center' 
                        },
                        { 
                            data: 'rt',               
                            className: 'text-center' 
                        },
                        { 
                            data: 'rw',               
                            className: 'text-center' 
                        },
                        { 
                            data: 'alamat',           
                            className: 'text-left' 
                        },
                        { 
                            data: 'status_dtks',      
                            className: 'text-center' 
                        },
                        { 
                            data: 'status_pernikahan',
                            className: 'text-center' 
                        },
                        { 
                            data: 'mempunyai_usaha',  
                            className: 'text-center' 
                        },
                        { 
                            data: 'keterangan',       
                            className: 'text-left' 
                        },
                        { 
                            data: 'tahun_anggaran',   
                            className: 'text-center' 
                        }
                    ]
                });
        } else {
            window.tableWrse.draw();
        }
    }
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>