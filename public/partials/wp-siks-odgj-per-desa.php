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
$maps_all = $this->get_polygon();
$center   = $this->get_center();
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
        SELECT 
            * 
        FROM data_batas_desa_siks 
        WHERE desa=%s 
            AND kecamatan=%s 
            AND active=1
    ', $validate_user['desa'], $validate_user['kecamatan']), 
ARRAY_A);
$default_location = $this->getSearchLocation($desa);
?>
<style type="text/css">
    #modal-rt-rw-overlay-og { 
        display:none; 
        position:fixed; 
        inset:0; 
        background:rgba(0,0,0,.55); 
        z-index:99999; 
        align-items:center; 
        justify-content:center; 
    }
    #modal-rt-rw-overlay-og.active { 
        display:flex; 
    }
    #modal-rt-rw-og { 
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
    #modal-rt-rw-og h4 { 
        margin:0 0 18px; 
        font-size:18px; 
        font-weight:700; 
        color:#1a1a2e; 
    }
    #modal-rt-rw-og .modal-close { 
        position:absolute; 
        top:14px; 
        right:18px; 
        background:none; 
        border:none; 
        font-size:22px; 
        cursor:pointer; 
        color:#666; 
    }
    #modal-rt-rw-og .modal-close:hover { 
        color:#c0392b; 
    }
    #modal-nama-list-og { 
        max-height:180px; 
        overflow-y:auto; 
        border:1px solid #dee2e6; 
        border-radius:5px; 
        padding:8px 12px; 
        margin-bottom:18px; 
        background:#f8f9fa; 
    }
    #modal-nama-list-og p { 
        margin:3px 0; 
        font-size:13.5px; 
        color:#333; 
    }
    #notif-rt-rw-og { 
        display:none; 
        background:#fff3cd; 
        border:1px solid #ffc107; 
        color:#856404; 
        border-radius:5px; 
        padding:10px 14px; 
        margin-bottom:14px; 
        font-size:13.5px; 
    }
    .form-rt-rw-og { 
        display:flex; 
        gap:16px; 
        margin-bottom:20px; 
    }
    .form-rt-rw-og .form-group { 
        flex:1; 
    }
    .form-rt-rw-og label { 
        font-weight:600; 
        font-size:13px; 
        margin-bottom:4px; 
        display:block; 
    }
    .form-rt-rw-og input { 
        width:100%; 
        padding:7px 10px; 
        border:1px solid #ced4da; 
        border-radius:5px; 
        font-size:14px; 
    }
    .modal-actions-og { 
        display:flex; 
        gap:10px; 
        justify-content:flex-end; 
    }
    #toolbar-rt-rw-og { 
        margin-bottom:10px; 
    }
    #btn-tambah-rt-rw-og { 
        display:none; 
    }
    .wrap-table { 
        overflow:auto; 
        max-height:100vh; 
        width:100%; 
    }
</style>

<h1 class="text-center">Peta Sebaran ODGJ<br>( Orang Dengan Gangguan Jiwa )<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>
<div style="padding:10px; margin:0 0 3rem 0;">
    <div id="map-canvas-siks" style="width:100%; height:400px;"></div>
    <h1 class="text-center" style="margin:3rem;">Data ODGJ<br>DESA <?php echo strtoupper($validate_user['desa']); ?> <?php if ($is_rt_role): ?>RT <?php echo $input['rt']; ?> RW <?php echo $input['rw']; ?><?php endif; ?></h1>

    <?php if (!$is_rt_role): ?>
        <div id="toolbar-rt-rw-og">
            <button id="btn-tambah-rt-rw-og" class="btn btn-primary">
                <i class="dashicons dashicons-edit" style="vertical-align:middle;"></i>
                Tambah RT RW
            </button>
        </div>
    <?php endif; ?>

    <div class="wrap-table m-4">
        <table id="tableData" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center"><input type="checkbox" id="check-all-og" title="Pilih Semua"></th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Kartu Keluarga</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa</th>
                    <th class="text-center">RT</th>
                    <th class="text-center">RW</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">Usia</th>
                    <th class="text-center">Nama Orangtua</th>
                    <th class="text-center">Pengobatan</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Lampiran</th>
                    <th class="text-center">Tahun Anggaran</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="modal-rt-rw-overlay-og">
    <div id="modal-rt-rw-og">
        <button class="modal-close" id="btn-modal-close-og">&times;</button>
        <h4>Tambah / Edit RT &amp; RW — ODGJ</h4>
        <p style="font-size:13px;color:#555;margin-bottom:8px;"><strong>Data yang dipilih:</strong></p>
        <div id="modal-nama-list-og"></div>
        <div class="form-rt-rw-og">
            <div class="form-group"><label for="input-rt-og">RT</label><input type="text" id="input-rt-og" placeholder="Contoh: 001" maxlength="10"></div>
            <div class="form-group"><label for="input-rw-og">RW</label><input type="text" id="input-rw-og" placeholder="Contoh: 002" maxlength="10"></div>
        </div>
        <div class="modal-actions-og">
            <button class="btn btn-secondary" id="btn-modal-cancel-og">Batal</button>
            <button class="btn btn-primary"   id="btn-modal-save-og">Simpan</button>
        </div>
    </div>
</div>

<script>
    window.maps_all_siks    = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;

    var selectedRowsOg = [];

    function updateToolbarOg() { 
        jQuery('#btn-tambah-rt-rw-og').toggle(selectedRowsOg.length > 0); 
    }

    function openModalOg() {
        var html = '';
        selectedRowsOg.forEach(function(r) { 
            html += '<p>&#9656; ' + r.Nama + '</p>'; 
        });
        jQuery('#modal-nama-list-og').html(html);
        var rtVals = [...new Set(selectedRowsOg.map(function(r){ 
            return (r.rt||'').trim(); 
        }))];
        var rwVals = [...new Set(selectedRowsOg.map(function(r){ 
            return (r.rw||'').trim(); 
        }))];
        jQuery('#modal-rt-rw-overlay-og').addClass('active');
    }

    function closeModalOg() {
        jQuery('#modal-rt-rw-overlay-og').removeClass('active');
        jQuery('#input-rt-og, #input-rw-og').val('');
    }

    jQuery(document).ready(function() {
        getDataTable();
        cari_alamat_siks('<?php echo $default_location; ?>');

        jQuery('#check-all-og').on('change', function() {
            jQuery('#tableData tbody input.row-check-og').prop('checked', jQuery(this).is(':checked')).trigger('change');
        });
        jQuery('#btn-tambah-rt-rw-og').on('click', function() { 
            if (selectedRowsOg.length > 0) openModalOg(); 
        });
        jQuery('#btn-modal-close-og, #btn-modal-cancel-og').on('click', closeModalOg);
        jQuery('#modal-rt-rw-overlay-og').on('click', function(e) { 
            if (e.target === this) closeModalOg(); 
        });

        jQuery('#btn-modal-save-og').on('click', function() {
            var rt = jQuery('#input-rt-og').val().trim();
            var rw = jQuery('#input-rw-og').val().trim();
            if (!rt || !rw) { 
                alert('RT dan RW tidak boleh kosong!'); 
                return; 
            }
            var postData = { 
                action: 'update_rt_rw_siks', 
                api_key: ajax.apikey, 
                tipe: 'odgj', 
                rt: rt, rw: rw 
            };
            selectedRowsOg.forEach(function(r, i) { 
                postData['ids[' + i + ']'] = r.id; 
            });
            jQuery.ajax({
                url: ajax.url, 
                type: 'POST', 
                dataType: 'json', 
                data: postData,
                beforeSend: function() { 
                    jQuery('#wrap-loading').show(); 
                    jQuery('#btn-modal-save-og').prop('disabled', true).text('Menyimpan…'); 
                },
                success: function(res) {
                    jQuery('#wrap-loading').hide();
                    if (res && res.status) {
                        closeModalOg(); selectedRowsOg = []; updateToolbarOg();
                        jQuery('#check-all-og').prop('checked', false);
                        window.tableOdgj.ajax.reload(null, false);
                        alert('RT & RW berhasil diperbarui!');
                    } else { 
                        alert('Gagal: ' + (res.message || 'Terjadi kesalahan')); 
                    }
                },
                error: function() { 
                    jQuery('#wrap-loading').hide(); 
                    alert('Terjadi kesalahan koneksi.'); 
                },
                complete: function() { 
                    jQuery('#btn-modal-save-og').prop('disabled', false).text('Simpan'); 
                }
            });
        });
    });

    function getDataTable() {
        if (typeof tableOdgj === 'undefined') {
            window.tableOdgj = jQuery('#tableData')
                .on('preXhr.dt', function() { 
                    jQuery('#wrap-loading').show(); 
                })
                .DataTable({
                    processing: true, 
                    serverSide: true, 
                    search: { 
                        return: true },
                    ajax: {
                        url: ajax.url, 
                        type: 'POST', 
                        dataType: 'json',
                        data: { 
                            action: 'get_datatable_odgj', 
                            api_key: ajax.apikey,
                            rt: '<?php echo esc_js($input['rt']); ?>',
                            rw: '<?php echo esc_js($input['rw']); ?>', 
                            desa: '<?php echo $validate_user['desa']; ?>', 
                            kecamatan: '<?php echo $validate_user['kecamatan']; ?>' 
                        }
                    },
                    lengthMenu: [[20,50,100,-1],[20,50,100,'All']], order: [],
                    drawCallback: function() {
                        jQuery('#wrap-loading').hide();
                        jQuery('#tableData tbody').off('change','input.row-check-og').on('change','input.row-check-og', function() {
                            var cb = jQuery(this), 
                            id = String(cb.data('id')), 
                            nama = cb.data('nama');
                            var rt = String(cb.data('rt')||''), 
                            rw = String(cb.data('rw')||'');
                            if (cb.is(':checked')) {
                                if (!selectedRowsOg.find(function(r){ 
                                    return r.id===id; 
                                })) selectedRowsOg.push({
                                    id:id,
                                    Nama:nama,
                                    rt:rt,
                                    rw:rw
                                });
                            } else {
                                selectedRowsOg = selectedRowsOg.filter(function(r){ 
                                    return r.id!==id; 
                                });
                                jQuery('#check-all-og').prop('checked', false);
                            }
                            updateToolbarOg();
                        });
                    },
                    columns: [
                        { 
                            data:'id', 
                            orderable:false, 
                            searchable:false, 
                            render:function(data,type,row){
                                var id=String(data||''), nama=(row.nama||'').replace(/"/g,'&quot;');
                                var rt=(row.rt||'').replace(/"/g,'&quot;'), rw=(row.rw||'').replace(/"/g,'&quot;');
                                return '<input type="checkbox" class="row-check-og" data-id="'+id+'" data-nama="'+nama+'" data-rt="'+rt+'" data-rw="'+rw+'">';
                            }
                        },
                        { 
                            data:'nik',           
                            className:'text-center' 
                        },
                        { 
                            data:'kk',            
                            className:'text-center' 
                        },
                        { 
                            data:'nama',          
                            className:'text-left' 
                        },
                        { 
                            data:'provinsi',      
                            className:'text-center' 
                        },
                        { 
                            data:'kabkot',        
                            className:'text-center' 
                        },
                        { 
                            data:'kecamatan',     
                            className:'text-center' 
                        },
                        { 
                            data:'desa',          
                            className:'text-center' 
                        },
                        { 
                            data:'rt',            
                            className:'text-center' 
                        },
                        { 
                            data:'rw',            
                            className:'text-center' 
                        },
                        { 
                            data:'jenis_kelamin', 
                            className:'text-center' 
                        },
                        { 
                            data:'usia',          
                            className:'text-center' 
                        },
                        { 
                            data:'nama_ortu',     
                            className:'text-left' 
                        },
                        { 
                            data:'pengobatan',    
                            className:'text-left' 
                        },
                        { 
                            data:'keterangan',    
                            className:'text-left' 
                        },
                        { 
                            data:'file_lampiran', 
                            className:'text-center' 
                        },
                        { 
                            data:'tahun_anggaran',
                            className:'text-center' 
                        },
                        { 
                            data:'aksi',          
                            className:'text-center' 
                        }
                    ]
                });
        } else { 
            window.tableOdgj.draw(); 
        }
    }
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>