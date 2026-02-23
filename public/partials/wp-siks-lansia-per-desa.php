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
    .wrap-table { 
        overflow:auto; 
        max-height:100vh; 
        width:100%; 
    }
    #modal-rt-rw-overlay-ls { 
        display:none; 
        position:fixed; 
        inset:0; 
        background:rgba(0,0,0,.55); 
        z-index:99999; 
        align-items:center; 
        justify-content:center; 
    }
    #modal-rt-rw-overlay-ls.active { 
        display:flex; 
    }
    #modal-rt-rw-ls { 
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
    #modal-rt-rw-ls h4 { 
        margin:0 0 18px; 
        font-size:18px; 
        font-weight:700; 
        color:#1a1a2e; 
    }
    #modal-rt-rw-ls .modal-close { 
        position:absolute; 
        top:14px; 
        right:18px; 
        background:none; 
        border:none; 
        font-size:22px; 
        cursor:pointer; 
        color:#666; 
    }
    #modal-rt-rw-ls .modal-close:hover { 
        color:#c0392b; 
    }
    #modal-nama-list-ls { 
        max-height:180px; 
        overflow-y:auto; 
        border:1px solid #dee2e6; 
        border-radius:5px; 
        padding:8px 12px; 
        margin-bottom:18px; 
        background:#f8f9fa; 
    }
    #modal-nama-list-ls p { 
        margin:3px 0; 
        font-size:13.5px; 
        color:#333; 
    }
    #notif-rt-rw-ls { 
        display:none; 
        background:#fff3cd; 
        border:1px solid #ffc107; 
        color:#856404; 
        border-radius:5px; 
        padding:10px 14px; 
        margin-bottom:14px; 
        font-size:13.5px; 
    }
    .form-rt-rw-ls { 
        display:flex; 
        gap:16px; 
        margin-bottom:20px; 
    }
    .form-rt-rw-ls .form-group { 
        flex:1; 
    }
    .form-rt-rw-ls label { 
        font-weight:600; 
        font-size:13px; 
        margin-bottom:4px; 
        display:block; 
    }
    .form-rt-rw-ls input { 
        width:100%; 
        padding:7px 10px; 
        border:1px solid #ced4da; 
        border-radius:5px; 
        font-size:14px; 
    }
    .modal-actions-ls { 
        display:flex; 
        gap:10px; 
        justify-content:flex-end; 
    }
    #toolbar-rt-rw-ls { 
        margin-bottom:10px; 
    }
    #btn-tambah-rt-rw-ls { 
        display:none; 
    }
</style>

<h1 class="text-center">Peta Sebaran Lansia<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>

<div style="width:95%; margin:0 auto; min-height:90vh; padding-bottom:75px;">
    <div id="map-canvas-siks" style="width:100%; height:400px;"></div>
    <div style="padding:10px; margin:0 0 3rem 0;">
        <h1 class="text-center" style="margin:3rem;">Data Lansia<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>

        <?php if (!$is_rt_role): ?>
        <div id="toolbar-rt-rw-wr">
            <button id="btn-tambah-rt-rw-ls" class="btn btn-primary">
                <i class="dashicons dashicons-edit" style="vertical-align:middle;"></i>
                Tambah RT RW
            </button>
        </div>
        <?php endif; ?>

        <div class="wrap-table">
            <table id="tableLansiaPerDesa" cellpadding="2" cellspacing="0" class="table table-bordered"
                   style="font-family:'Open Sans',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; border-collapse:collapse; width:100%; overflow-wrap:break-word;">
                <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" id="check-all-ls" title="Pilih Semua"></th>
                        <th class="text-center">Aksi</th>
                        <th class="text-center">NIK</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Provinsi</th>
                        <th class="text-center">Kabupaten / Kota</th>
                        <th class="text-center">Kecamatan</th>
                        <th class="text-center">Desa</th>
                        <th class="text-center">RT</th>
                        <th class="text-center">RW</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Tanggal Lahir</th>
                        <th class="text-center">Usia</th>
                        <th class="text-center">Dokumen Kependudukan</th>
                        <th class="text-center">Status Tempat Tinggal</th>
                        <th class="text-center">Status Pemenuhan Kebutuhan</th>
                        <th class="text-center">Status Kehidupan Rumah Tangga</th>
                        <th class="text-center">Status DTKS</th>
                        <th class="text-center">Status Kepersertaan Program Bansos</th>
                        <th class="text-center">Rekomendasi Pendata Lama</th>
                        <th class="text-center">Keterangan Lainnya Lama</th>
                        <th class="text-center">Rekomendasi Pendata</th>
                        <th class="text-center">Keterangan Lainnya</th>
                        <th class="text-center">Lampiran</th>
                        <th class="text-center">Tahun Anggaran</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-rt-rw-overlay-ls">
    <div id="modal-rt-rw-ls">
        <button class="modal-close" id="btn-modal-close-ls">&times;</button>
        <h4>Tambah / Edit RT &amp; RW — Lansia</h4>
        <p style="font-size:13px;color:#555;margin-bottom:8px;"><strong>Data yang dipilih:</strong></p>
        <div id="modal-nama-list-ls"></div>
        <div class="form-rt-rw-ls">
            <div class="form-group">
                <label for="input-rt-ls">RT</label>
                <input type="text" id="input-rt-ls" placeholder="Contoh: 01" maxlength="10">
            </div>
            <div class="form-group">
                <label for="input-rw-ls">RW</label>
                <input type="text" id="input-rw-ls" placeholder="Contoh: 02" maxlength="10">
            </div>
        </div>
        <div class="modal-actions-ls">
            <button class="btn btn-secondary" id="btn-modal-cancel-ls">Batal</button>
            <button class="btn btn-primary" id="btn-modal-save-ls">Simpan</button>
        </div>
    </div>
</div>

<script>
    window.maps_all_siks    = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;

    var selectedRowsLs = [];

    function updateToolbarLs() {
        jQuery('#btn-tambah-rt-rw-ls').toggle(selectedRowsLs.length > 0);
    }

    function openModalLs() {
        var html = '';
        selectedRowsLs.forEach(function(r) { html += '<p>&#9656; ' + r.Nama + '</p>'; });
        jQuery('#modal-nama-list-ls').html(html);

        var rtValues = [...new Set(selectedRowsLs.map(function(r){ return (r.rt||'').trim(); }))];
        var rwValues = [...new Set(selectedRowsLs.map(function(r){ return (r.rw||'').trim(); }))];
        jQuery('#modal-rt-rw-overlay-ls').addClass('active');
    }

    function closeModalLs() {
        jQuery('#modal-rt-rw-overlay-ls').removeClass('active');
        jQuery('#input-rt-ls, #input-rw-ls').val('');
    }

    jQuery(document).ready(function() {
        get_data_lansia();
        cari_alamat_siks('<?php echo $default_location; ?>');

        jQuery('#check-all-ls').on('change', function() {
            jQuery('#tableLansiaPerDesa tbody input.row-check-ls')
                .prop('checked', jQuery(this).is(':checked')).trigger('change');
        });

        jQuery('#btn-tambah-rt-rw-ls').on('click', function() {
            if (selectedRowsLs.length > 0) openModalLs();
        });

        jQuery('#btn-modal-close-ls, #btn-modal-cancel-ls').on('click', closeModalLs);
        jQuery('#modal-rt-rw-overlay-ls').on('click', function(e) {
            if (e.target === this) closeModalLs();
        });

        jQuery('#btn-modal-save-ls').on('click', function() {
            var rt = jQuery('#input-rt-ls').val().trim();
            var rw = jQuery('#input-rw-ls').val().trim();
            if (rt === '' || rw === '') { alert('RT dan RW tidak boleh kosong!'); return; }

            var postData = {
                action:  'update_rt_rw_siks',
                api_key: ajax.apikey,
                tipe:    'lansia',
                rt:      rt,
                rw:      rw
            };
            selectedRowsLs.forEach(function(r, i) { postData['ids[' + i + ']'] = r.id; });

            jQuery.ajax({
                url: ajax.url, type: 'POST', dataType: 'json', data: postData,
                beforeSend: function() {
                    jQuery('#wrap-loading').show();
                    jQuery('#btn-modal-save-ls').prop('disabled', true).text('Menyimpan…');
                },
                success: function(res) {
                    jQuery('#wrap-loading').hide();
                    if (res && res.status) {
                        closeModalLs();
                        selectedRowsLs = [];
                        updateToolbarLs();
                        jQuery('#check-all-ls').prop('checked', false);
                        window.tableLansia.ajax.reload(null, false);
                        alert('RT & RW berhasil diperbarui!');
                    } else {
                        alert('Gagal: ' + (res.message || 'Terjadi kesalahan'));
                    }
                },
                error: function() { jQuery('#wrap-loading').hide(); alert('Terjadi kesalahan koneksi.'); },
                complete: function() { jQuery('#btn-modal-save-ls').prop('disabled', false).text('Simpan'); }
            });
        });
    });

    function get_data_lansia() {
        if (typeof tableLansia === 'undefined') {
            window.tableLansia = jQuery('#tableLansiaPerDesa')
                .on('preXhr.dt', function() { jQuery('#wrap-loading').show(); })
                .DataTable({
                    processing: true, serverSide: true,
                    search: { return: true },
                    ajax: {
                        url: ajax.url, type: 'POST', dataType: 'json',
                        data: {
                            action:    'get_datatable_lansia',
                            api_key:   ajax.apikey,
                            rt: '<?php echo esc_js($input['rt']); ?>',
                            rw: '<?php echo esc_js($input['rw']); ?>',
                            desa:      '<?php echo $validate_user['desa']; ?>',
                            kecamatan: '<?php echo $validate_user['kecamatan']; ?>',
                        }
                    },
                    lengthMenu: [[20, 50, 100, -1], [20, 50, 100, 'All']],
                    order: [[1, 'asc']],
                    drawCallback: function(settings) {
                        var api = this.api();
                        api.rows({ page: 'current' }).data().map(function(b) {
                            if (b.lat && b.lng) {
                                var data = b.aksi.split(", true, '")[1].split("')")[0];
                                setCenterSiks(b.lat, b.lng, true, data, true);
                            }
                        });
                        jQuery('#wrap-loading').hide();
                        jQuery('#tableLansiaPerDesa tbody')
                            .off('change', 'input.row-check-ls')
                            .on('change', 'input.row-check-ls', function() {
                                var cb   = jQuery(this);
                                var id   = String(cb.data('id'));
                                var nama = cb.data('nama');
                                var rt   = String(cb.data('rt') || '');
                                var rw   = String(cb.data('rw') || '');
                                if (cb.is(':checked')) {
                                    if (!selectedRowsLs.find(function(r){ return r.id === id; })) {
                                        selectedRowsLs.push({ id: id, Nama: nama, rt: rt, rw: rw });
                                    }
                                } else {
                                    selectedRowsLs = selectedRowsLs.filter(function(r){ return r.id !== id; });
                                    jQuery('#check-all-ls').prop('checked', false);
                                }
                                updateToolbarLs();
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
                                return '<input type="checkbox" class="row-check-ls"' +
                                       ' data-id="' + id + '" data-nama="' + nama + '"' +
                                       ' data-rt="'  + rt  + '" data-rw="'  + rw  + '">';
                            }
                        },
                        { 
                            data: 'aksi',                              
                            className: 'text-center' 
                        },
                        { 
                            data: 'nik',                               
                            className: 'text-center' 
                        },
                        { 
                            data: 'nama',                              
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
                            data: 'desa',                              
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
                            className: 'text-center' 
                        },
                        { 
                            data: 'tanggal_lahir',                     
                            className: 'text-center' 
                        },
                        { 
                            data: 'usia',                              
                            className: 'text-center' 
                        },
                        { 
                            data: 'dokumen_kependudukan',              
                            className: 'text-center' 
                        },
                        { 
                            data: 'status_tempat_tinggal',             
                            className: 'text-center' 
                        },
                        { 
                            data: 'status_pemenuhan_kebutuhan',        
                            className: 'text-center' 
                        },
                        { 
                            data: 'status_kehidupan_rumah_tangga',     
                            className: 'text-center' 
                        },
                        { 
                            data: 'status_dtks',                       
                            className: 'text-center' 
                        },
                        { 
                            data: 'status_kepersertaan_program_bansos',
                            className: 'text-center' 
                        },
                        { 
                            data: 'rekomendasi_pendata_lama',          
                            className: 'text-center' 
                        },
                        { 
                            data: 'keterangan_lainnya_lama',           
                            className: 'text-center' 
                        },
                        { 
                            data: 'rekomendasi_pendata',               
                            className: 'text-center' 
                        },
                        { 
                            data: 'keterangan_lainnya',                
                            className: 'text-center' 
                        },
                        { 
                            data: 'file_lampiran',                     
                            className: 'text-center' 
                        },
                        { 
                            data: 'tahun_anggaran',                    
                            className: 'text-center' 
                        }
                    ]
                });
        } else {
            window.tableLansia.draw();
        }
    }
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>