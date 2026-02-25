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
    #modal-rt-rw-overlay-bk { 
        display:none; 
        position:fixed; 
        inset:0; 
        background:rgba(0,0,0,.55); 
        z-index:99999; 
        align-items:center; 
        justify-content:center; 
    }
    #modal-rt-rw-overlay-bk.active { 
        display:flex; 
    }
    #modal-rt-rw-bk { 
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
    #modal-rt-rw-bk h4 { 
        margin:0 0 18px; 
        font-size:18px; 
        font-weight:700; 
        color:#1a1a2e; 
    }
    #modal-rt-rw-bk .modal-close { 
        position:absolute; 
        top:14px; 
        right:18px; 
        background:none; 
        border:none; 
        font-size:22px; 
        cursor:pointer; 
        color:#666; 
    }
    #modal-rt-rw-bk .modal-close:hover { 
        color:#c0392b; 
    }
    #modal-nama-list-bk { 
        max-height:180px; 
        overflow-y:auto; 
        border:1px solid #dee2e6; 
        border-radius:5px; 
        padding:8px 12px; 
        margin-bottom:18px; 
        background:#f8f9fa; 
    }
    #modal-nama-list-bk p { 
        margin:3px 0; 
        font-size:13.5px; 
        color:#333; 
    }
    #notif-rt-rw-bk { 
        display:none; 
        background:#fff3cd; 
        border:1px solid #ffc107; 
        color:#856404; 
        border-radius:5px; 
        padding:10px 14px; 
        margin-bottom:14px; 
        font-size:13.5px; 
    }
    .form-rt-rw-bk { 
        display:flex; 
        gap:16px; 
        margin-bottom:20px; 
    }
    .form-rt-rw-bk .form-group { 
        flex:1; 
    }
    .form-rt-rw-bk label { 
        font-weight:600; 
        font-size:13px; 
        margin-bottom:4px; 
        display:block; 
    }
    .form-rt-rw-bk input { 
        width:100%; 
        padding:7px 10px; 
        border:1px solid #ced4da; 
        border-radius:5px; 
        font-size:14px; 
    }
    .modal-actions-bk { 
        display:flex; 
        gap:10px; 
        justify-content:flex-end; 
    }
    #toolbar-rt-rw-bk { 
        margin-bottom:10px; 
    }
    #btn-tambah-rt-rw-bk { 
        display:none; 
    }
    .hint-rtrw { 
        font-size:11px; 
        color:#888; 
        margin-top:3px; 
    }
</style>

<h1 class="text-center">Peta Sebaran Penerima Bansos Bunda Kasih<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>
<div style="width:95%; margin:0 auto; min-height:90vh; padding-bottom:75px;">
    <div id="map-canvas-siks" style="width:100%; height:400px;"></div>
    <div style="padding:10px; margin:0 0 3rem 0;">
        <h1 class="text-center" style="margin:3rem;">Data Penerima Bansos Bunda Kasih<br>DESA <?php echo strtoupper($validate_user['desa']); ?> <?php if ($is_rt_role): ?>RT <?php echo $input['rt']; ?> RW <?php echo $input['rw']; ?><?php endif; ?></h1>

        <?php if (!$is_rt_role): ?>
            <div id="toolbar-rt-rw-bk">
                <button id="btn-tambah-rt-rw-bk" class="btn btn-primary">
                    <i class="dashicons dashicons-edit" style="vertical-align:middle;"></i>
                    Tambah RT RW
                </button>
            </div>
        <?php endif; ?>

        <div class="wrap-table">
            <table id="tableBundaKasihPerDesa" cellpadding="2" cellspacing="0" class="table table-bordered"
                   style="font-family:'Open Sans',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; border-collapse:collapse; width:100%; overflow-wrap:break-word;">
                <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" id="check-all-bk" title="Pilih Semua"></th>
                        <th class="text-center">Aksi</th>
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
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-rt-rw-overlay-bk">
    <div id="modal-rt-rw-bk">
        <button class="modal-close" id="btn-modal-close-bk">&times;</button>
        <h4>Tambah / Edit RT &amp; RW — Bunda Kasih</h4>
        <p style="font-size:13px;color:#555;margin-bottom:4px;"><strong>Data yang dipilih:</strong></p>
        <div id="modal-nama-list-bk"></div>
        <p style="font-size:12px;color:#6c757d;margin-bottom:12px;">
            ⓘ Data akan disimpan sebagai satu kolom <code>rt_rw</code> dengan format <strong>RT/RW</strong>. Contoh: <em>01/02</em>
        </p>
        <div class="form-rt-rw-bk">
            <div class="form-group">
                <label for="input-rt-bk">RT</label>
                <input type="text" id="input-rt-bk" placeholder="Contoh: 001" maxlength="10">
            </div>
            <div class="form-group">
                <label for="input-rw-bk">RW</label>
                <input type="text" id="input-rw-bk" placeholder="Contoh: 002" maxlength="10">
            </div>
        </div>
        <div class="modal-actions-bk">
            <button class="btn btn-secondary" id="btn-modal-cancel-bk">Batal</button>
            <button class="btn btn-primary"   id="btn-modal-save-bk">Simpan</button>
        </div>
    </div>
</div>

<script>
    window.maps_all_siks    = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;

    var selectedRowsBk = [];

    function updateToolbarBk() { jQuery('#btn-tambah-rt-rw-bk').toggle(selectedRowsBk.length > 0); }

    function parseRtRwBk(rt_rw) {
        var parts = (rt_rw || '').split('/');
        return { 
            rt: (parts[0] || '').trim(), 
            rw: (parts[1] || '').trim() 
        };
    }

    function openModalBk() {
        var html = '';
        selectedRowsBk.forEach(function(r) { 
            html += '<p>&#9656; ' + r.Nama + '</p>'; 
        });
        jQuery('#modal-nama-list-bk').html(html);

        var rtRwVals = [...new Set(selectedRowsBk.map(function(r){ 
            return (r.rt_rw||'').trim(); 
        }))];
        jQuery('#input-rt-bk, #input-rw-bk').val('');
        jQuery('#modal-rt-rw-overlay-bk').addClass('active');
    }

    function closeModalBk() {
        jQuery('#modal-rt-rw-overlay-bk').removeClass('active');
        jQuery('#input-rt-bk, #input-rw-bk').val('');
    }

    jQuery(document).ready(function() {
        get_data_bunda_kasih();
        cari_alamat_siks('<?php echo $default_location; ?>');

        jQuery('#check-all-bk').on('change', function() {
            jQuery('#tableBundaKasihPerDesa tbody input.row-check-bk').prop('checked', jQuery(this).is(':checked')).trigger('change');
        });
        jQuery('#btn-tambah-rt-rw-bk').on('click', function() { 
            if (selectedRowsBk.length > 0) openModalBk(); 
        });
        jQuery('#btn-modal-close-bk, #btn-modal-cancel-bk').on('click', closeModalBk);
        jQuery('#modal-rt-rw-overlay-bk').on('click', function(e) { 
            if (e.target === this) closeModalBk(); 
        });

        jQuery('#btn-modal-save-bk').on('click', function() {
            var rt = jQuery('#input-rt-bk').val().trim();
            var rw = jQuery('#input-rw-bk').val().trim();
            if (!rt || !rw) { 
                alert('RT dan RW tidak boleh kosong!'); return; 
            }

            var postData = {
                action:  'update_rt_rw_siks',
                api_key: ajax.apikey,
                tipe:    'bunda_kasih',
                rt:      rt,
                rw:      rw
            };
            selectedRowsBk.forEach(function(r, i) { 
                postData['ids[' + i + ']'] = r.id; 
            });

            jQuery.ajax({
                url: ajax.url, 
                type: 'POST', 
                dataType: 'json', 
                data: postData,
                beforeSend: function() { 
                    jQuery('#wrap-loading').show(); 
                    jQuery('#btn-modal-save-bk').prop('disabled', true).text('Menyimpan…'); 
                },
                success: function(res) {
                    jQuery('#wrap-loading').hide();
                    if (res && res.status) {
                        closeModalBk(); selectedRowsBk = []; updateToolbarBk();
                        jQuery('#check-all-bk').prop('checked', false);
                        window.tableBundaKasih.ajax.reload(null, false);
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
                    jQuery('#btn-modal-save-bk').prop('disabled', false).text('Simpan'); 
                }
            });
        });
    });

    function get_data_bunda_kasih() {
        if (typeof tableBundaKasih === 'undefined') {
            window.tableBundaKasih = jQuery('#tableBundaKasihPerDesa')
                .on('preXhr.dt', function() { 
                    jQuery('#wrap-loading').show(); 
                })
                .DataTable({
                    processing: true, 
                    serverSide: true, 
                    search: { 
                        return: true 
                    },
                    ajax: {
                        url: ajax.url, 
                        type: 'POST', 
                        dataType: 'json',
                        data: { 
                            action: 'get_datatable_bunda_kasih', 
                            api_key: ajax.apikey,
                            rt: '<?php echo esc_js($input['rt']); ?>',
                            rw: '<?php echo esc_js($input['rw']); ?>', 
                            desa: '<?php echo $validate_user['desa']; ?>', 
                            kecamatan: '<?php echo $validate_user['kecamatan']; ?>' 
                        }
                    },
                    lengthMenu: [[20,50,100,-1],[20,50,100,'All']], order: [[1,'asc']],
                    drawCallback: function(settings) {
                        var api = this.api();
                        api.rows({ 
                            page:'current' 
                        }).data().map(function(b) {
                            if (b.lat && b.lng) {
                                var data = b.aksi.split(", true, '")[1].split("')")[0];
                                setCenterSiks(
                                    b.lat, 
                                    b.lng, true, 
                                    data, true
                                );
                            }
                        });
                        jQuery('#wrap-loading').hide();

                        jQuery('#tableBundaKasihPerDesa tbody').off('change','input.row-check-bk').on('change','input.row-check-bk', function() {
                            var cb = jQuery(this);
                            var id    = String(cb.data('id'));
                            var nama  = cb.data('nama');
                            var rt_rw = String(cb.data('rtrw') || '');
                            if (cb.is(':checked')) {
                                if (!selectedRowsBk.find(function(r){ 
                                    return r.id===id; 
                                })) {
                                    selectedRowsBk.push({ 
                                    id: id, 
                                    Nama: nama, 
                                    rt_rw: rt_rw 
                                });}
                            } else {
                                selectedRowsBk = selectedRowsBk.filter(function(r){ 
                                    return r.id!==id; 
                                });
                                jQuery('#check-all-bk').prop('checked', false);
                            }
                            updateToolbarBk();
                        });
                    },
                    columns: [
                        { 
                            data:'id', 
                            orderable:false, 
                            searchable:false, 
                            render:function(data,type,row){
                                var id    = String(data||'');
                                var nama  = (row.nama  ||'').replace(/"/g,'&quot;');
                                var rt_rw = (row.rt_rw ||'').replace(/"/g,'&quot;');
                                return '<input type="checkbox" class="row-check-bk"' + ' data-id="'+id+'" data-nama="'+nama+'" data-rtrw="'+rt_rw+'">';
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
                            data:'rt_rw',         
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
            window.tableBundaKasih.draw(); 
        }
    }
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>