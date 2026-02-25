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
            AND active=1
        ', $validate_user['desa'], $validate_user['kecamatan']
    ), ARRAY_A
);
$default_location = $this->getSearchLocation($desa);
?>
<style type="text/css">
    .wrap-table { 
        overflow:auto; 
        max-height:100vh; 
        width:100%; 
    }
    #modal-rt-rw-overlay-db { 
        display:none; 
        position:fixed; 
        inset:0; 
        background:rgba(0,0,0,.55); 
        z-index:99999; 
        align-items:center; 
        justify-content:center; 
    }
    #modal-rt-rw-overlay-db.active { 
        display:flex; 
    }
    #modal-rt-rw-db { 
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
    #modal-rt-rw-db h4 { 
        margin:0 0 18px; 
        font-size:18px; 
        font-weight:700; 
        color:#1a1a2e; 
    }
    #modal-rt-rw-db .modal-close { 
        position:absolute; 
        top:14px; 
        right:18px; 
        background:none; 
        border:none; 
        font-size:22px; 
        cursor:pointer; 
        color:#666; 
    }
    #modal-rt-rw-db .modal-close:hover { 
        color:#c0392b; 
    }
    #modal-nama-list-db { 
        max-height:180px; 
        overflow-y:auto; 
        border:1px solid #dee2e6; 
        border-radius:5px; 
        padding:8px 12px; 
        margin-bottom:18px; 
        background:#f8f9fa; 
    }
    #modal-nama-list-db p { 
        margin:3px 0; 
        font-size:13.5px; 
        color:#333; 
    }
    #notif-rt-rw-db { 
        display:none; 
        background:#fff3cd; 
        border:1px solid #ffc107; 
        color:#856404; 
        border-radius:5px; 
        padding:10px 14px; 
        margin-bottom:14px; 
        font-size:13.5px; 
    }
    .form-rt-rw-db { 
        display:flex; 
        gap:16px; 
        margin-bottom:20px; 
    }
    .form-rt-rw-db .form-group { 
        flex:1; 
    }
    .form-rt-rw-db label { 
        font-weight:600; 
        font-size:13px; 
        margin-bottom:4px; 
        display:block; 
    }
    .form-rt-rw-db input { 
        width:100%; 
        padding:7px 10px; 
        border:1px solid #ced4da; 
        border-radius:5px; 
        font-size:14px; 
    }
    .modal-actions-db { 
        display:flex; 
        gap:10px; 
        justify-content:flex-end; 
    }
    #toolbar-rt-rw-db { 
        margin-bottom:10px; 
    }
    #btn-tambah-rt-rw-db { 
        display:none; 
    }
</style>

<h1 class="text-center">Peta Sebaran Disabilitas<br>DESA <?php echo strtoupper($validate_user['desa']); ?></h1>
<div style="width:95%; margin:0 auto; min-height:90vh; padding-bottom:75px;">
    <div id="map-canvas-siks" style="width:100%; height:400px;"></div>
    <h1 class="text-center" style="margin:3rem;">Tabel Data Disabilitas Desa <?php echo strtoupper($validate_user['desa']); ?> <?php if ($is_rt_role): ?>RT <?php echo $input['rt']; ?> RW <?php echo $input['rw']; ?><?php endif; ?></h1>

    <?php if (!$is_rt_role): ?>
        <div id="toolbar-rt-rw-db">
            <button id="btn-tambah-rt-rw-db" class="btn btn-primary">
                <i class="dashicons dashicons-edit" style="vertical-align:middle;"></i>
                Tambah RT RW
            </button>
        </div>
    <?php endif; ?>

    <div class="wrap-table">
        <table id="tableDisabilitasPerDesa" cellpadding="2" cellspacing="0" class="table table-bordered"
               style="font-family:'Open Sans',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; border-collapse:collapse; width:100%; overflow-wrap:break-word;">
            <thead>
                <tr>
                    <th class="text-center"><input type="checkbox" id="check-all-db" title="Pilih Semua"></th>
                    <th class="text-center">Aksi</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Nomor Kartu Keluarga</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa</th>
                    <th class="text-center">RT</th>
                    <th class="text-center">RW</th>
                    <th class="text-center">Tempat Lahir</th>
                    <th class="text-center">Tanggal Lahir</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Dokumen Kewarganegaraan</th>
                    <th class="text-center">No Handphone</th>
                    <th class="text-center">Pendidikan Terakhir</th>
                    <th class="text-center">Nama Sekolah</th>
                    <th class="text-center">Keterangan Lulus</th>
                    <th class="text-center">Jenis Disabilitas</th>
                    <th class="text-center">Keterangan Disabilitas</th>
                    <th class="text-center">Sebab Disabilitas</th>
                    <th class="text-center">Diagnosa Medis</th>
                    <th class="text-center">Penyakit Lain</th>
                    <th class="text-center">Tempat Pengobatan</th>
                    <th class="text-center">Perawat</th>
                    <th class="text-center">Aktivitas</th>
                    <th class="text-center">Aktivitas Bantuan</th>
                    <th class="text-center">Perlu Bantu</th>
                    <th class="text-center">Alat Bantu</th>
                    <th class="text-center">Alat yang Dimiliki</th>
                    <th class="text-center">Kondisi Alat</th>
                    <th class="text-center">Jaminan Kesehatan</th>
                    <th class="text-center">Cara Menggunakan Jamkes</th>
                    <th class="text-center">Jaminan Sosial</th>
                    <th class="text-center">Pekerjaan</th>
                    <th class="text-center">Lokasi Bekerja</th>
                    <th class="text-center">Alasan Tidak Bekerja</th>
                    <th class="text-center">Pendapatan Bulan</th>
                    <th class="text-center">Pengeluaran Bulan</th>
                    <th class="text-center">Pendapatan Lain</th>
                    <th class="text-center">Minat Kerja</th>
                    <th class="text-center">Keterampilan</th>
                    <th class="text-center">Pelatihan yang Diikuti</th>
                    <th class="text-center">Pelatihan yang Diminat</th>
                    <th class="text-center">Status Rumah</th>
                    <th class="text-center">Lantai</th>
                    <th class="text-center">Kamar Mandi</th>
                    <th class="text-center">WC</th>
                    <th class="text-center">Akses ke Lingkungan</th>
                    <th class="text-center">Dinding</th>
                    <th class="text-center">Sarana Air</th>
                    <th class="text-center">Penerangan</th>
                    <th class="text-center">Desa PAUD</th>
                    <th class="text-center">TK di Desa</th>
                    <th class="text-center">Kecamatan SLB</th>
                    <th class="text-center">SD Menerima ABK</th>
                    <th class="text-center">SMP Menerima ABK</th>
                    <th class="text-center">Jumlah Posyandu</th>
                    <th class="text-center">Kader Posyandu</th>
                    <th class="text-center">Layanan Kesehatan</th>
                    <th class="text-center">Sosialitas ke Tetangga</th>
                    <th class="text-center">Keterlibatan Berorganisasi</th>
                    <th class="text-center">Kegiatan Kemasyarakatan</th>
                    <th class="text-center">Keterlibatan Musrembang</th>
                    <th class="text-center">Alat Bantu Bantuan</th>
                    <th class="text-center">Asal Alat Bantu</th>
                    <th class="text-center">Tahun Pemberian</th>
                    <th class="text-center">Bantuan UEP</th>
                    <th class="text-center">Asal UEP</th>
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Lainnya</th>
                    <th class="text-center">Rehabilitas</th>
                    <th class="text-center">Lokasi Rehabilitas</th>
                    <th class="text-center">Tahun Rehabilitas</th>
                    <th class="text-center">Keahlian Khusus</th>
                    <th class="text-center">Prestasi</th>
                    <th class="text-center">Nama Perawat Wali</th>
                    <th class="text-center">Hubungan Dengan PD</th>
                    <th class="text-center">Nomor Handphone PD</th>
                    <th class="text-center">Kelayakan</th>
                    <th class="text-center">Lampiran</th>
                    <th class="text-center">Tahun Anggaran</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="modal-rt-rw-overlay-db">
    <div id="modal-rt-rw-db">
        <button class="modal-close" id="btn-modal-close-db">&times;</button>
        <h4>Tambah / Edit RT &amp; RW — Disabilitas</h4>
        <p style="font-size:13px;color:#555;margin-bottom:8px;"><strong>Data yang dipilih:</strong></p>
        <div id="modal-nama-list-db"></div>
        <div class="form-rt-rw-db">
            <div class="form-group"><label for="input-rt-db">RT</label><input type="text" id="input-rt-db" placeholder="Contoh: 001" maxlength="10"></div>
            <div class="form-group"><label for="input-rw-db">RW</label><input type="text" id="input-rw-db" placeholder="Contoh: 002" maxlength="10"></div>
        </div>
        <div class="modal-actions-db">
            <button class="btn btn-secondary" id="btn-modal-cancel-db">Batal</button>
            <button class="btn btn-primary"   id="btn-modal-save-db">Simpan</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.maps_all_siks    = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;

    var selectedRowsDb = [];

    function updateToolbarDb() { 
        jQuery('#btn-tambah-rt-rw-db').toggle(selectedRowsDb.length > 0); 
    }

    function openModalDb() {
        var html = '';
        selectedRowsDb.forEach(function(r) { html += '<p>&#9656; ' + r.Nama + '</p>'; });
        jQuery('#modal-nama-list-db').html(html);
        var rtVals = [...new Set(selectedRowsDb.map(function(r){ 
            return (r.rt||'').trim(); 
        }))];
        var rwVals = [...new Set(selectedRowsDb.map(function(r){ 
            return (r.rw||'').trim(); 
        }))];
        jQuery('#modal-rt-rw-overlay-db').addClass('active');
    }

    function closeModalDb() {
        jQuery('#modal-rt-rw-overlay-db').removeClass('active');
        jQuery('#input-rt-db, #input-rw-db').val('');
    }

    jQuery(document).ready(function() {
        get_datatable_disabilitas_per_desa();
        cari_alamat_siks('<?php echo $default_location; ?>');

        jQuery('#check-all-db').on('change', function() {
            jQuery('#tableDisabilitasPerDesa tbody input.row-check-db').prop('checked', jQuery(this).is(':checked')).trigger('change');
        });
        jQuery('#btn-tambah-rt-rw-db').on('click', function() { 
            if (selectedRowsDb.length > 0) openModalDb(); 
        });
        jQuery('#btn-modal-close-db, #btn-modal-cancel-db').on('click', closeModalDb);
        jQuery('#modal-rt-rw-overlay-db').on('click', function(e) { 
            if (e.target === this) closeModalDb(); 
        });

        jQuery('#btn-modal-save-db').on('click', function() {
            var rt = jQuery('#input-rt-db').val().trim();
            var rw = jQuery('#input-rw-db').val().trim();
            if (!rt || !rw) { alert('RT dan RW tidak boleh kosong!'); return; }
            var postData = { 
                action: 'update_rt_rw_siks', 
                api_key: ajax.apikey, 
                tipe: 'disabilitas', 
                rt: rt, 
                rw: rw 
            };
            selectedRowsDb.forEach(function(r, i) { 
                postData['ids[' + i + ']'] = r.id; 
            });
            jQuery.ajax({                
                url: ajax.url, 
                type: 'POST', 
                dataType: 'json', 
                data: postData,
                beforeSend: function() { 
                    jQuery('#wrap-loading').show(); 
                    jQuery('#btn-modal-save-db').prop('disabled', true).text('Menyimpan…'); 
                },
                success: function(res) {
                    jQuery('#wrap-loading').hide();
                    if (res && res.status) {
                        closeModalDb(); selectedRowsDb = []; updateToolbarDb();
                        jQuery('#check-all-db').prop('checked', false);
                        window.tableDisabilitas.ajax.reload(null, false);
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
                    jQuery('#btn-modal-save-db').prop('disabled', false).text('Simpan'); 
                }
            });
        });
    });

    function get_datatable_disabilitas_per_desa() {
        if (typeof tableDisabilitas === 'undefined') {
            window.tableDisabilitas = jQuery('#tableDisabilitasPerDesa')
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
                            action: 'get_datatable_disabilitas', 
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
                        jQuery('#tableDisabilitasPerDesa tbody').off('change','input.row-check-db').on('change','input.row-check-db', function() {
                            var cb = jQuery(this), 
                            id = String(cb.data('id')), 
                            nama = cb.data('nama');
                            var rt = String(cb.data('rt')||''), 
                            rw = String(cb.data('rw')||'');
                            if (cb.is(':checked')) {
                                if (!selectedRowsDb.find(function(r){ 
                                    return r.id===id; 
                                })) selectedRowsDb.push({
                                    id:id,
                                    Nama:nama,
                                    rt:rt,
                                    rw:rw
                                });
                            } else {
                                selectedRowsDb = selectedRowsDb.filter(function(r){ 
                                    return r.id!==id; 
                                });
                                jQuery('#check-all-db').prop('checked', false);
                            }
                            updateToolbarDb();
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
                                return '<input type="checkbox" class="row-check-db" data-id="'+id+'" data-nama="'+nama+'" data-rt="'+rt+'" data-rw="'+rw+'">';
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
                            data:'nomor_kk',                  
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
                            data:'tempat_lahir',              
                            className:'text-center' 
                        },
                        { 
                            data:'tanggal_lahir',             
                            className:'text-center' 
                        },
                        { 
                            data:'gender',                    
                            className:'text-center' 
                        },
                        { 
                            data:'status',                    
                            className:'text-center' 
                        },
                        { 
                            data:'dokumen_kewarganegaraan',   
                            className:'text-center' 
                        },
                        { 
                            data:'no_hp',                     
                            className:'text-center' 
                        },
                        { 
                            data:'pendidikan_terakhir',       
                            className:'text-center' 
                        },
                        { 
                            data:'nama_sekolah',              
                            className:'text-center' 
                        },
                        { 
                            data:'keterangan_lulus',          
                            className:'text-center' 
                        },
                        { 
                            data:'jenis_disabilitas',         
                            className:'text-center' 
                        },
                        { 
                            data:'keterangan_disabilitas',    
                            className:'text-center' 
                        },
                        { 
                            data:'sebab_disabilitas',         
                            className:'text-center' 
                        },
                        { 
                            data:'diagnosa_medis',            
                            className:'text-center' 
                        },
                        { 
                            data:'penyakit_lain',             
                            className:'text-center' 
                        },
                        { 
                            data:'tempat_pengobatan',         
                            className:'text-center' 
                        },
                        { 
                            data:'perawat',                   
                            className:'text-center' 
                        },
                        { 
                            data:'aktivitas',                 
                            className:'text-center' 
                        },
                        { 
                            data:'aktivitas_bantuan',         
                            className:'text-center' 
                        },
                        { 
                            data:'perlu_bantu',               
                            className:'text-center' 
                        },
                        { 
                            data:'alat_bantu',                
                            className:'text-center' 
                        },
                        { 
                            data:'alat_yang_dimiliki',        
                            className:'text-center' 
                        },
                        { 
                            data:'kondisi_alat',              
                            className:'text-center' 
                        },
                        { 
                            data:'jaminan_kesehatan',         
                            className:'text-center' 
                        },
                        { 
                            data:'cara_menggunakan_jamkes',   
                            className:'text-center' 
                        },
                        { 
                            data:'jaminan_sosial',            
                            className:'text-center' 
                        },
                        { 
                            data:'pekerjaan',                 
                            className:'text-center' 
                        },
                        { 
                            data:'lokasi_bekerja',            
                            className:'text-center' 
                        },
                        { 
                            data:'alasan_tidak_bekerja',      
                            className:'text-center' 
                        },
                        { 
                            data:'pendapatan_bulan',          
                            className:'text-center' 
                        },
                        { 
                            data:'pengeluaran_bulan',         
                            className:'text-center' 
                        },
                        { 
                            data:'pendapatan_lain',           
                            className:'text-center' 
                        },
                        { 
                            data:'minat_kerja',               
                            className:'text-center' 
                        },
                        { 
                            data:'keterampilan',              
                            className:'text-center' 
                        },
                        { 
                            data:'pelatihan_yang_diikuti',    
                            className:'text-center' 
                        },
                        { 
                            data:'pelatihan_yang_diminat',    
                            className:'text-center' 
                        },
                        { 
                            data:'status_rumah',              
                            className:'text-center' 
                        },
                        { 
                            data:'lantai',                    
                            className:'text-center' 
                        },
                        { 
                            data:'kamar_mandi',               
                            className:'text-center' 
                        },
                        { 
                            data:'wc',                        
                            className:'text-center' 
                        },
                        { 
                            data:'akses_ke_lingkungan',       
                            className:'text-center' 
                        },
                        { 
                            data:'dinding',                   
                            className:'text-center' 
                        },
                        { 
                            data:'sarana_air',                
                            className:'text-center' 
                        },
                        { 
                            data:'penerangan',                
                            className:'text-center' 
                        },
                        { 
                            data:'desa_paud',                 
                            className:'text-center' 
                        },
                        { 
                            data:'tk_di_desa',                
                            className:'text-center' 
                        },
                        { 
                            data:'kecamatan_slb',             
                            className:'text-center' 
                        },
                        { 
                            data:'sd_menerima_abk',           
                            className:'text-center' 
                        },
                        { 
                            data:'smp_menerima_abk',          
                            className:'text-center' 
                        },
                        { 
                            data:'jumlah_posyandu',           
                            className:'text-center' 
                        },
                        { 
                            data:'kader_posyandu',            
                            className:'text-center' 
                        },
                        { 
                            data:'layanan_kesehatan',         
                            className:'text-center' 
                        },
                        { 
                            data:'sosialitas_ke_tetangga',    
                            className:'text-center' 
                        },
                        { 
                            data:'keterlibatan_berorganisasi',
                            className:'text-center' 
                        },
                        { 
                            data:'kegiatan_kemasyarakatan',   
                            className:'text-center' 
                        },
                        { 
                            data:'keterlibatan_musrembang',   
                            className:'text-center' 
                        },
                        { 
                            data:'alat_bantu_bantuan',        
                            className:'text-center' 
                        },
                        { 
                            data:'asal_alat_bantu',           
                            className:'text-center' 
                        },
                        { 
                            data:'tahun_pemberian',           
                            className:'text-center' 
                        },
                        { 
                            data:'bantuan_uep',               
                            className:'text-center' 
                        },
                        { 
                            data:'asal_uep',                  
                            className:'text-center' 
                        },
                        { 
                            data:'tahun',                     
                            className:'text-center' 
                        },
                        { 
                            data:'lainnya',                   
                            className:'text-center' 
                        },
                        { 
                            data:'rehabilitas',               
                            className:'text-center' 
                        },
                        { 
                            data:'lokasi_rehabilitas',        
                            className:'text-center' 
                        },
                        { 
                            data:'tahun_rehabilitas',         
                            className:'text-center' 
                        },
                        { 
                            data:'keahlian_khusus',           
                            className:'text-center' 
                        },
                        { 
                            data:'prestasi',                  
                            className:'text-center' 
                        },
                        { 
                            data:'nama_perawat_wali',         
                            className:'text-center' 
                        },
                        { 
                            data:'hubungan_dengan_pd',        
                            className:'text-center' 
                        },
                        { 
                            data:'nomor_hp',                  
                            className:'text-center' 
                        },
                        { 
                            data:'kelayakan',                 
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
            window.tableDisabilitas.draw(); 
        }
    }
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>