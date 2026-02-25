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
$center = $this->get_center();
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

    #modal-rt-rw-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.55);
        z-index: 99999;
        align-items: center;
        justify-content: center;
    }
    #modal-rt-rw-overlay.active {
        display: flex;
    }
    #modal-rt-rw {
        background: #fff;
        border-radius: 8px;
        padding: 28px 32px;
        width: 100%;
        max-width: 640px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 8px 32px rgba(0,0,0,.22);
        position: relative;
    }
    #modal-rt-rw h4 {
        margin: 0 0 18px;
        font-size: 18px;
        font-weight: 700;
        color: #1a1a2e;
    }
    #modal-rt-rw .modal-close {
        position: absolute;
        top: 14px; right: 18px;
        background: none; border: none;
        font-size: 22px; cursor: pointer;
        color: #666; line-height: 1;
    }
    #modal-rt-rw .modal-close:hover { color: #c0392b; }

    #modal-nama-list {
        max-height: 180px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 8px 12px;
        margin-bottom: 18px;
        background: #f8f9fa;
    }
    #modal-nama-list p {
        margin: 3px 0;
        font-size: 13.5px;
        color: #333;
    }

    #notif-rt-rw {
        display: none;
        background: #fff3cd;
        border: 1px solid #ffc107;
        color: #856404;
        border-radius: 5px;
        padding: 10px 14px;
        margin-bottom: 14px;
        font-size: 13.5px;
    }

    .form-rt-rw {
        display: flex;
        gap: 16px;
        margin-bottom: 20px;
    }
    .form-rt-rw .form-group {
        flex: 1;
    }
    .form-rt-rw label {
        font-weight: 600;
        font-size: 13px;
        margin-bottom: 4px;
        display: block;
    }
    .form-rt-rw input {
        width: 100%;
        padding: 7px 10px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        font-size: 14px;
    }

    .modal-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    #toolbar-rt-rw {
        margin-bottom: 10px;
    }
    #btn-tambah-rt-rw {
        display: none;
    }

    #tableData th:first-child,
    #tableData td:first-child {
        width: 36px;
        text-align: center;
    }
    #tableData th:nth-child(2),
    #tableData td:nth-child(2) {
        width: 48px;
        text-align: center;
    }
</style>

<h1 class="text-center">
    Peta Sebaran DTKS<br>
    ( Data Terpadu Kesejahteraan Sosial )<br>
    DESA <?php echo strtoupper($validate_user['desa']); ?>
</h1>

<div style="padding:10px;margin:0 0 3rem 0;">
    <div id="map-canvas-siks" style="width:100%;height:400px;"></div>

    <h1 class="text-center" style="margin:3rem;">
        Data DTKS<br>DESA <?php echo strtoupper($validate_user['desa']); ?> <?php if ($is_rt_role): ?>RT <?php echo $input['rt']; ?> RW <?php echo $input['rw']; ?><?php endif; ?>
    </h1>

    <?php if (!$is_rt_role): ?>
        <div id="toolbar-rt-rw">
            <button id="btn-tambah-rt-rw" class="btn btn-primary">
                <i class="dashicons dashicons-edit" style="vertical-align:middle;"></i>
                Tambah RT RW
            </button>
        </div>
    <?php endif; ?>

    <div class="wrap-table">
        <table id="tableData" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">
                        <input type="checkbox" id="check-all" title="Pilih Semua">
                    </th>
                    <th class="text-center">No.</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">No KK</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa/Kelurahan</th>
                    <th class="text-center">RT</th>
                    <th class="text-center">RW</th>
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
                    <th class='text-center'>UPDATE TERAKHIR</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="modal-rt-rw-overlay">
    <div id="modal-rt-rw">
        <button class="modal-close" id="btn-modal-close">&times;</button>
        <h4>Tambah / Edit RT &amp; RW</h4>

        <p style="font-size:13px;color:#555;margin-bottom:8px;">
            <strong>Data yang dipilih:</strong>
        </p>
        <div id="modal-nama-list"></div>

        <div class="form-rt-rw">
            <div class="form-group">
                <label for="input-rt">RT</label>
                <input type="text" id="input-rt" placeholder="Contoh: 01" maxlength="10">
            </div>
            <div class="form-group">
                <label for="input-rw">RW</label>
                <input type="text" id="input-rw" placeholder="Contoh: 02" maxlength="10">
            </div>
        </div>

        <div class="modal-actions">
            <button class="btn btn-secondary" id="btn-modal-cancel">Batal</button>
            <button class="btn btn-primary" id="btn-modal-save">Simpan</button>
        </div>
    </div>
</div>

<script>
    window.maps_all_siks   = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;

    var dataDtks;
    var selectedRows = []; 
    function updateToolbar() {
        if (selectedRows.length > 0) {
            jQuery('#btn-tambah-rt-rw').show();
        } else {
            jQuery('#btn-tambah-rt-rw').hide();
        }
    }

    function openModal() {
        var html = '';
        selectedRows.forEach(function(r) {
            html += '<p>&#9656; ' + r.Nama + '</p>';
        });
        jQuery('#modal-nama-list').html(html);

        var rtValues  = [...new Set(selectedRows.map(r => (r.rt  || '').trim()))];
        var rwValues  = [...new Set(selectedRows.map(r => (r.rw  || '').trim()))];
        jQuery('#modal-rt-rw-overlay').addClass('active');
    }

    function closeModal() {
        jQuery('#modal-rt-rw-overlay').removeClass('active');
        jQuery('#input-rt').val('');
        jQuery('#input-rw').val('');
    }

    jQuery(document).ready(function() {
        getDataTable().then(function() {
            jQuery("#search_filter_action").select2();
        });
        cari_alamat_siks('<?php echo $default_location; ?>');

        jQuery('#check-all').on('change', function() {
            var checked = jQuery(this).is(':checked');
            jQuery('#tableData tbody input.row-check').each(function() {
                jQuery(this).prop('checked', checked).trigger('change');
            });
        });

        jQuery('#btn-tambah-rt-rw').on('click', function() {
            if (selectedRows.length === 0) return;
            openModal();
        });

        jQuery('#btn-modal-close, #btn-modal-cancel').on('click', closeModal);
        jQuery('#modal-rt-rw-overlay').on('click', function(e) {
            if (e.target === this) closeModal();
        });

        jQuery('#btn-modal-save').on('click', function() {
            var rt = jQuery('#input-rt').val().trim();
            var rw = jQuery('#input-rw').val().trim();

            if (rt === '' || rw === '') {
                alert('RT dan RW tidak boleh kosong!');
                return;
            }

            var ids = selectedRows.map(r => r.id);

            jQuery.ajax({
                url:      ajax.url,
                type:     'POST',
                dataType: 'json',
                data: {
                    action:  'update_rt_rw_siks',
                    api_key: ajax.apikey,
                    tipe: 'dtks',
                    ids:     ids,
                    rt:      rt,
                    rw:      rw
                },
                beforeSend: function() {
                    jQuery("#wrap-loading").show();
                    jQuery('#btn-modal-save').prop('disabled', true).text('Menyimpan…');
                },
                success: function(res) {
                    jQuery("#wrap-loading").hide();
                    if (res && res.status) {
                        closeModal();
                        selectedRows = [];
                        updateToolbar();
                        jQuery('#check-all').prop('checked', false);
                        dataDtks.ajax.reload(null, false);
                        alert('RT & RW berhasil diperbarui!');
                    } else {
                        alert('Gagal menyimpan: ' + (res.message || 'Terjadi kesalahan'));
                    }
                },
                error: function() {
                    jQuery("#wrap-loading").hide();
                    alert('Terjadi kesalahan koneksi.');
                },
                complete: function() {
                    jQuery('#btn-modal-save').prop('disabled', false).text('Simpan');
                }
            });
        });
    });

    function getDataTable() {
        jQuery("#wrap-loading").show();
        return new Promise(function(resolve, reject) {
            dataDtks = jQuery('#tableData').DataTable({
                searchDelay: 500,
                processing:  true,
                serverSide:  true,
                stateSave:   false,
                ajax: {
                    url:      ajax.url,
                    type:     'post',
                    dataType: 'json',
                    data: {
                        action:    'get_data_dtks_siks',
                        api_key:   ajax.apikey,
                        rt: '<?php echo esc_js($input['rt']); ?>',
                        rw: '<?php echo esc_js($input['rw']); ?>',
                        desa:      '<?php echo $validate_user['desa']; ?>',
                        kecamatan: '<?php echo $validate_user['kecamatan']; ?>',
                    }
                },
                dom: 'Blfrtip',
                buttons: [{
                    extend:    'excel',
                    titleAttr: 'Excel',
                    text:      'Download Excel',
                    className: 'btn btn-success',
                    action: function(e, dt, button, config) {
                        var data = {
                            action:  'export_excel_data_dtks_siks',
                            api_key: ajax.apikey
                        };
                        if (jQuery("#search_filter_action").val() !== '' && jQuery("#search_filter_action").val() !== '-') {
                            data.filter_kriteria = jQuery("#search_filter_action").val();
                        }
                        if (dataDtks.search() !== '') {
                            data.search_value = dataDtks.search();
                        }
                        jQuery.ajax({
                            method:'post',
                            url: ajax.url,
                            cache: false,
                            xhrFields: { 
                                responseType: 'blob' 
                            },
                            data: data,
                            beforeSend: function() { jQuery("#wrap-loading").show(); },
                            success: function(response) {
                                jQuery("#wrap-loading").hide();
                                var link = document.createElement('a');
                                link.href = window.URL.createObjectURL(response);
                                link.download = 'Export Data DTKS';
                                link.click();
                            }
                        });
                    }
                }],
                initComplete: function(settings, json) {
                    jQuery("#wrap-loading").hide();

                    var html_filter =
                        "<div class='row col-lg-12'>" +
                        "<div class='col-lg-12'>" +
                        "<select name='filter_status' class='ml-3 bulk-action' id='search_filter_action' style='width:20%'>" +
                        "<option value='-'>Pilih Kriteria</option>" +
                        "</select>&nbsp;" +
                        "</div></div>";
                    jQuery("#tableData").before(html_filter);

                    var kriteria = [
                        { 
                            kk_kosong: 'KK Kosong' 
                        },
                        { 
                            nik_kosong: 'NIK Kosong' 
                        },
                        { 
                            nik_atau_kk_kosong:'NIK atau KK Kosong' 
                        }
                    ];
                    kriteria.forEach(function(obj) {
                        for (var prop in obj) {
                            jQuery('#search_filter_action').append('<option value="' + prop + '">' + obj[prop] + '</option>');
                        }
                    });

                    jQuery('#search_filter_action').on('change', function() {
                        var option = jQuery(this).val();
                        switch (option) {
                            case 'kk_kosong':
                            case 'nik_atau_kk_kosong':
                                dataDtks.column(3).search('');
                                dataDtks.column(2).search(option).draw();
                                break;
                            case 'nik_kosong':
                                dataDtks.column(2).search('');
                                dataDtks.column(3).search(option).draw();
                                break;
                        }
                    });
                },
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, 'All']],
                order: [[2, 'asc']],
                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            var id   = row.id   || '';
                            var nama = (row.Nama || '').replace(/'/g, "\\'");
                            var rt   = (row.rt   || '').replace(/'/g, "\\'");
                            var rw   = (row.rw   || '').replace(/'/g, "\\'");
                            return '<input type="checkbox" class="row-check"' + ' data-id="'   + id   + '"' + ' data-nama="' + nama + '"' + ' data-rt="'   + rt   + '"' + ' data-rw="'   + rw   + '">';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1 + '.';
                        }
                    },
                    { 
                        data: 'Nama',            
                        className: 'text-left' 
                    },
                    { 
                        data: 'NIK',             
                        className: 'text-center' 
                    },
                    { 
                        data: 'NOKK',            
                        className: 'text-center' 
                    },
                    { 
                        data: 'Alamat',          
                        className: 'text-left' 
                    },
                    { 
                        data: 'provinsi',        
                        className: 'text-left' 
                    },
                    { 
                        data: 'kabupaten',       
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
                        data: 'ATENSI',          
                        className: 'text-center' 
                    },
                    { 
                        data: 'BLT',             
                        className: 'text-center' 
                    },
                    { 
                        data: 'BLT_BBM',         
                        className: 'text-center' 
                    },
                    { 
                        data: 'BNPT_PPKM',       
                        className: 'text-center' 
                    },
                    { 
                        data: 'BPNT',            
                        className: 'text-center' 
                    },
                    { 
                        data: 'BST',             
                        className: 'text-center' 
                    },
                    { 
                        data: 'FIRST_SK',        
                        className: 'text-center' 
                    },
                    { 
                        data: 'PBI',             
                        className: 'text-center' 
                    },
                    { 
                        data: 'PENA',            
                        className: 'text-center' 
                    },
                    { 
                        data: 'PERMAKANAN',      
                        className: 'text-center' 
                    },
                    { 
                        data: 'RUTILAHU',        
                        className: 'text-center' 
                    },
                    { 
                        data: 'SEMBAKO_ADAPTIF', 
                        className: 'text-center' 
                    },
                    { 
                        data: 'YAPI',            
                        className: 'text-center' 
                    },
                    { 
                        data: 'PKH',             
                        className: 'text-center' 
                    },
                    { 
                        data: 'update_at',       
                        className: 'text-center' 
                    },
                ],
                drawCallback: function() {
                    resolve();

                    jQuery('#tableData tbody').off('change', 'input.row-check')
                        .on('change', 'input.row-check', function() {
                            var cb   = jQuery(this);
                            var id   = cb.data('id');
                            var nama = cb.data('nama');
                            var rt   = cb.data('rt');
                            var rw   = cb.data('rw');

                            if (cb.is(':checked')) {
                                if (!selectedRows.find(r => r.id === id)) {
                                    selectedRows.push({ 
                                        id: id, 
                                        Nama: nama, 
                                        rt: rt, 
                                        rw: rw 
                                    });
                                }
                            } else {
                                selectedRows = selectedRows.filter(r => r.id !== id);
                                jQuery('#check-all').prop('checked', false);
                            }
                            updateToolbar();
                        });
                }
            });
        });
    }
</script>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>