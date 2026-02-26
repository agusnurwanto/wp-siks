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
            AND active=1',
        $validate_user['desa'], $validate_user['kecamatan']
    ), 
ARRAY_A);
$default_location = $this->getSearchLocation($desa);
?>
<style type="text/css">
    .wrap-table { 
        overflow:auto; 
        max-height:100vh; 
        width:100%; 
    }
    #modal-rt-rw-overlay-p3 { 
        display:none; 
        position:fixed; 
        inset:0; 
        background:rgba(0,0,0,.55); 
        z-index:99999; 
        align-items:center; 
        justify-content:center; 
    }
    #modal-rt-rw-overlay-p3.active { 
        display:flex; 
    }
    #modal-rt-rw-p3 { 
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
    #modal-rt-rw-p3 h4 { 
        margin:0 0 18px; 
        font-size:18px; 
        font-weight:700; 
        color:#1a1a2e; 
    }
    #modal-rt-rw-p3 .modal-close { 
        position:absolute; 
        top:14px; 
        right:18px; 
        background:none; 
        border:none; 
        font-size:22px; 
        cursor:pointer; 
        color:#666; 
    }
    #modal-rt-rw-p3 .modal-close:hover { 
        color:#c0392b; 
    }
    #modal-nama-list-p3 { 
        max-height:180px; 
        overflow-y:auto; 
        border:1px solid #dee2e6; 
        border-radius:5px; 
        padding:8px 12px; 
        margin-bottom:18px; 
        background:#f8f9fa; 
    }
    #modal-nama-list-p3 p { 
        margin:3px 0; 
        font-size:13.5px; 
        color:#333; 
    }
    #notif-rt-rw-p3 { 
        display:none; 
        background:#fff3cd; 
        border:1px solid #ffc107; 
        color:#856404; 
        border-radius:5px; 
        padding:10px 14px; 
        margin-bottom:14px; 
        font-size:13.5px; 
    }
    .form-rt-rw-p3 { 
        display:flex; 
        gap:16px; 
        margin-bottom:20px; 
    }
    .form-rt-rw-p3 .form-group { 
        flex:1; 
    }
    .form-rt-rw-p3 label { 
        font-weight:600; 
        font-size:13px; 
        margin-bottom:4px; 
        display:block; 
    }
    .form-rt-rw-p3 input { 
        width:100%; 
        padding:7px 10px; 
        border:1px solid #ced4da; 
        border-radius:5px; 
        font-size:14px; 
    }
    .modal-actions-p3 { 
        display:flex; 
        gap:10px; 
        justify-content:flex-end; 
    }
    #toolbar-rt-rw-p3 { 
        margin-bottom:10px; 
    }
    #btn-tambah-rt-rw-p3 { 
        display:none; 
    }
</style>

<h1 class="text-center">Peta Sebaran P3KE<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>
<div style="width:95%; margin:0 auto; min-height:90vh; padding-bottom:75px;">
    <div id="map-canvas-siks" style="width:100%; height:400px;"></div>
    <div style="padding:10px; margin:0 0 3rem 0;">
        <h1 class="text-center" style="margin:3rem;">Data P3KE<br>DESA <?php echo strtoupper($validate_user['desa']); ?> <?php if ($is_rt_role): ?>RT <?php echo $input['rt']; ?> RW <?php echo $input['rw']; ?><?php endif; ?></h1>
        <?php if (!$is_rt_role): ?>
            <div id="toolbar-rt-rw-p3">
                <button id="btn-tambah-rt-rw-p3" class="btn btn-primary">
                    <i class="dashicons dashicons-edit" style="vertical-align:middle;"></i>
                    Tambah RT RW
                </button>
            </div>
        <?php endif; ?>
        <div class="wrap-table">
            <table id="tableP3kePerDesa" cellpadding="2" cellspacing="0" class="table table-bordered"
                   style="font-family:'Open Sans',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; border-collapse:collapse; width:100%; overflow-wrap:break-word;">
                <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" id="check-all-p3" title="Pilih Semua"></th>
                        <th class="text-center">Aksi</th>
                        <th class="text-center">NIK</th>
                        <th class="text-center">Kartu Keluarga</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Provinsi</th>
                        <th class="text-center">Kabupaten / Kota</th>
                        <th class="text-center">Kecamatan</th>
                        <th class="text-center">Desa</th>
                        <th class="text-center">RT</th>
                        <th class="text-center">RW</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Pekerjaan</th>
                        <th class="text-center">Program</th>
                        <th class="text-center">Penghasilan</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Lampiran</th>
                        <th class="text-center">Tahun Anggaran</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-rt-rw-overlay-p3">
    <div id="modal-rt-rw-p3">
        <button class="modal-close" id="btn-modal-close-p3">&times;</button>
        <h4>Tambah / Edit RT &amp; RW — P3KE</h4>
        <p style="font-size:13px;color:#555;margin-bottom:8px;"><strong>Data yang dipilih:</strong></p>
        <div id="modal-nama-list-p3"></div>
        <div class="form-rt-rw-p3">
            <div class="form-group"><label for="input-rt-p3">RT</label><input type="number" id="input-rt-p3" placeholder="Contoh: 01" maxlength="10"></div>
            <div class="form-group"><label for="input-rw-p3">RW</label><input type="number" id="input-rw-p3" placeholder="Contoh: 02" maxlength="10"></div>
        </div>
        <div class="modal-actions-p3">
            <button class="btn btn-secondary" id="btn-modal-cancel-p3">Batal</button>
            <button class="btn btn-primary"   id="btn-modal-save-p3">Simpan</button>
        </div>
    </div>
</div>

<script>
    window.maps_all_siks    = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;

    var selectedRowsP3 = [];

    function updateToolbarP3() { 
        jQuery('#btn-tambah-rt-rw-p3').toggle(selectedRowsP3.length > 0); 
    }

    function openModalP3() {
        var html = '';
        selectedRowsP3.forEach(function(r) { 
            html += '<p>&#9656; ' + r.Nama + '</p>'; 
        });
        jQuery('#modal-nama-list-p3').html(html);
        var rtVals = [...new Set(selectedRowsP3.map(function(r){ 
            return (r.rt||'').trim(); 
        }))];
        var rwVals = [...new Set(selectedRowsP3.map(function(r){ 
            return (r.rw||'').trim(); 
        }))];
        var rtMatch   = rtVals.length === 1;
        var rwMatch   = rwVals.length === 1;
        var allMatch  = rtMatch && rwMatch;

        if (!allMatch) {
            jQuery('#input-rt').val('');
            jQuery('#input-rw').val('');
            jQuery('#btn-modal-save');
        } else {
            jQuery('#input-rt').val(rtVals[0]);
            jQuery('#input-rw').val(rwVals[0]);
            jQuery('#btn-modal-save');
        }
        jQuery('#modal-rt-rw-overlay-p3').addClass('active');
    }

    function closeModalP3() {
        jQuery('#modal-rt-rw-overlay-p3').removeClass('active');
        jQuery('#input-rt-p3, #input-rw-p3').val('');
    }

    jQuery(document).ready(function() {
        get_data_p3ke_per_desa();
        cari_alamat_siks('<?php echo $default_location; ?>');

        jQuery('#check-all-p3').on('change', function() {
            jQuery('#tableP3kePerDesa tbody input.row-check-p3').prop('checked', jQuery(this).is(':checked')).trigger('change');
        });
        jQuery('#btn-tambah-rt-rw-p3').on('click', function() { 
            if (selectedRowsP3.length > 0) openModalP3(); 
        });
        jQuery('#btn-modal-close-p3, #btn-modal-cancel-p3').on('click', closeModalP3);
        jQuery('#modal-rt-rw-overlay-p3').on('click', function(e) { 
            if (e.target === this) closeModalP3(); 
        });

        jQuery('#btn-modal-save-p3').on('click', function() {
            var rt = jQuery('#input-rt-p3').val().trim();
            var rw = jQuery('#input-rw-p3').val().trim();
            if (!rt || !rw) { 
                alert('RT dan RW tidak boleh kosong!'); return; 
            }
            var postData = { 
                action: 'update_rt_rw_siks', 
                api_key: ajax.apikey, 
                tipe: 'p3ke', 
                rt: rt, 
                rw: rw 
            };
            selectedRowsP3.forEach(function(r, i) { 
                postData['ids[' + i + ']'] = r.id; 
            });
            jQuery.ajax({
                url: ajax.url, 
                type: 'POST', 
                dataType: 'json', 
                data: postData,
                beforeSend: function() { 
                    jQuery('#wrap-loading').show(); 
                    jQuery('#btn-modal-save-p3').prop('disabled', true).text('Menyimpan…'); 
                },
                success: function(res) {
                    jQuery('#wrap-loading').hide();
                    if (res && res.status) {
                        closeModalP3(); selectedRowsP3 = []; updateToolbarP3();
                        jQuery('#check-all-p3').prop('checked', false);
                        window.tableP3KE.ajax.reload(null, false);
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
                    jQuery('#btn-modal-save-p3').prop('disabled', false).text('Simpan'); 
                }
            });
        });
    });

    function get_data_p3ke_per_desa() {
        if (typeof tableP3KE === 'undefined') {
            window.tableP3KE = jQuery('#tableP3kePerDesa')
                .on('preXhr.dt', function() { 
                    jQuery('#wrap-loading').show(); 
                })
                .DataTable({
                    processing: true, 
                    serverSide: true, 
                    search: { return: true },
                    ajax: {
                        url: ajax.url, 
                        type: 'POST', 
                        dataType: 'json',
                        data: { 
                            action: 'get_datatable_p3ke', 
                            api_key: ajax.apikey,
                            rt: '<?php echo esc_js($input['rt']); ?>',
                            rw: '<?php echo esc_js($input['rw']); ?>', 
                            desa: '<?php echo $validate_user['desa']; ?>', 
                            kecamatan: '<?php echo $validate_user['kecamatan']; ?>' 
                        }
                    },
                    lengthMenu: [[20,50,100,-1],[20,50,100,'All']], order: [[1,'asc']],
                    drawCallback: function() {
                        jQuery('#wrap-loading').hide();
                        jQuery('#tableP3kePerDesa tbody').off('change','input.row-check-p3').on('change','input.row-check-p3', function() {
                            var cb = jQuery(this), 
                            id = String(cb.data('id')), 
                            nama = cb.data('nama');
                            var rt = String(cb.data('rt')||''), 
                            rw = String(cb.data('rw')||'');
                            if (cb.is(':checked')) {
                                if (!selectedRowsP3.find(function(r){ 
                                    return r.id===id; 
                                })) selectedRowsP3.push({
                                    id:id,
                                    Nama:nama,
                                    rt:rt,
                                    rw:rw
                                });
                            } else {
                                selectedRowsP3 = selectedRowsP3.filter(function(r){ 
                                    return r.id!==id; 
                                });
                                jQuery('#check-all-p3').prop('checked', false);
                            }
                            updateToolbarP3();
                        });
                    },
                    columns: [
                        { 
                            data:'id', 
                            orderable:false, 
                            searchable:false, 
                            render:function(data,type,row){
                                var id=String(data||''), 
                                nama=(row.nama||'').replace(/"/g,'&quot;');
                                var rt=(row.rt||'').replace(/"/g,'&quot;'), 
                                rw=(row.rw||'').replace(/"/g,'&quot;');
                                return '<input type="checkbox" class="row-check-p3" data-id="'+id+'" data-nama="'+nama+'" data-rt="'+rt+'" data-rw="'+rw+'">';
                            }
                        },
                        { 
                            data:'aksi',          
                            className:'text-center' 
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
                            className:'text-center' 
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
                            data:'alamat',        
                            className:'text-center' 
                        },
                        { 
                            data:'pekerjaan',     
                            className:'text-center' 
                        },
                        { 
                            data:'program',       
                            className:'text-center' 
                        },
                        { 
                            data:'penghasilan',   
                            className:'text-center' 
                        },
                        { 
                            data:'keterangan',    
                            className:'text-center' 
                        },
                        { 
                            data:'file_lampiran', 
                            className:'text-center' 
                        },
                        { 
                            data:'tahun_anggaran',
                            className:'text-center' 
                        }
                    ]
                });
        } else { 
            window.tableP3KE.draw(); 
        }
    }
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>