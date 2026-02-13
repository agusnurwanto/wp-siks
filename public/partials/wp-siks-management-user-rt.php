<?php
global $wpdb;
if (!defined('WPINC')) {
    die;
}
$input = shortcode_atts(array(
    'id_desa' => ''
), $atts);
if (empty($input['id_desa'])) {
    die('id_desa kosong');
}
$url = admin_url('admin-ajax.php');
$nama_desa = $wpdb->get_var($wpdb->prepare('
    SELECT 
        nama
    FROM data_alamat_siks
    WHERE id_desa = %d
      AND id_desa IS NOT NULL
      AND active = 1
', $input['id_desa']));
?>
<style>
    .bulk-action {
        padding: .45rem;
        border-color: #eaeaea;
        vertical-align: middle;
    }
    .setting-perubahan {
        transition: all 0.3s ease;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<div class="cetak">
    <div style="padding: 10px;margin:0 0 3rem 0;">
        <input type="hidden" value="<?php echo get_option(SIKS_APIKEY); ?>" id="api_key">
        <input type="hidden" value="<?php echo $input['id_desa']; ?>" id="id_desa">
        <h1 class="text-center" style="margin:3rem;">Halaman User RT / RW <br>Desa <?php echo $nama_desa; ?></h1>
        <div style="margin-bottom: 25px;">
            <button class="btn btn-primary" onclick="tambah_data_user();">Tambah User</button>
        </div>
        <table id="data_user_table" cellpadding="2" cellspacing="0" class="table table-bordered">
            <thead id="data_header">
                <tr>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">RT / RW</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">No Hp</th>
                    <th class="text-center">Username</th>
                    <th class="text-center" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="data_body">
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade mt-4" id="modalTambahUser" tabindex="-1" role="dialog" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahUserLabel">Tambah User RT / RW</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_id" value="">
                <div class="form-group">
                    <label for='nama'>Nama <span class="text-danger">*</span></label>
                    <input type='text' id='nama' class='form-control' placeholder='Input Nama'>
                </div>
                <div class="form-group">
                    <label for='alamat'>Alamat <span class="text-danger">*</span></label>
                    <textarea id='alamat' class='form-control' rows="3" placeholder='Input Alamat'></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for='rt'>RT <span class="text-danger">*</span></label>
                            <input type='number' id='rt' class='form-control' placeholder='Input RT'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for='rw'>RW <span class="text-danger">*</span></label>
                            <input type='number' id='rw' class='form-control' placeholder='Input RW'>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for='email'>Email <span class="text-danger">*</span></label>
                    <input type='email' id='email' class='form-control' placeholder='Input Email'>
                </div>
                <div class="form-group">
                    <label for='no_hp'>No HP <span class="text-danger">*</span></label>
                    <input type='number' id='no_hp' class='form-control' placeholder='Input No HP'>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary submitBtn" onclick="submitTambahUserForm()">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    jQuery(document).ready(function() {
        get_data_user_rt_rw();
    });

    /** get data user */
    function get_data_user_rt_rw() {
        jQuery("#wrap-loading").show();
        globalThis.userTable = jQuery('#data_user_table').DataTable({
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "ajax": {
                url: '<?php echo $url ?>',
                type: "post",
                data: {
                    'action': "get_data_user_rt_rw",
                    'api_key': jQuery("#api_key").val(),
                    'id_desa': jQuery("#id_desa").val()
                }
            },
            "initComplete": function(settings, json) {
                jQuery("#wrap-loading").hide();
            },
            "columns": [
                {
                    "data": "nama",
                    className: "text-left"
                },
                {
                    "data": "alamat",
                    className: "text-left"
                },
                {
                    "data": "rt_rw",
                    className: "text-center"
                },
                {
                    "data": "emailteks",
                    className: "text-left"
                },
                {
                    "data": "no_hp",
                    className: "text-center"
                },
                {
                    "data": "username",
                    className: "text-center"
                },
                {
                    "data": "aksi",
                    className: "text-center"
                }
            ]
        });
    }

    /** show modal tambah user */
    function tambah_data_user() {
        jQuery("#modalTambahUser .modal-title").html("Tambah User RT / RW");
        jQuery("#modalTambahUser .submitBtn")
            .attr("onclick", 'submitTambahUserForm()')
            .attr("disabled", false)
            .text("Simpan");
        
        jQuery('#edit_id').val('');
        jQuery('#nama').val('');
        jQuery('#alamat').val('');
        jQuery('#rt').val('').prop('disabled', false);
        jQuery('#rw').val('').prop('disabled', false);
        jQuery('#email').val('');
        jQuery('#no_hp').val('');
        
        jQuery('#modalTambahUser').modal('show');
    }

    /** Submit tambah/edit user */
    function submitTambahUserForm() {
        jQuery("#wrap-loading").show();
        
        let edit_id = jQuery('#edit_id').val();
        let nama = jQuery('#nama').val().trim();
        let alamat = jQuery('#alamat').val().trim();
        let rt = jQuery('#rt').val().trim();
        let rw = jQuery('#rw').val().trim();
        let email = jQuery('#email').val().trim();
        let no_hp = jQuery('#no_hp').val().trim();

        if (!nama || !alamat || !rt || !rw || !email || !no_hp) {
            jQuery("#wrap-loading").hide();
            alert("Semua data wajib diisi!");
            return false;
        }
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            jQuery("#wrap-loading").hide();
            alert("Format email tidak valid!");
            return false;
        }

        jQuery.ajax({
            url: '<?php echo $url ?>',
            type: 'post',
            dataType: 'json',
            data: {
                'action': 'submit_user_rt_rw',
                'api_key': jQuery("#api_key").val(),
                'id_desa': jQuery("#id_desa").val(),
                'id': edit_id,
                'nama': nama,
                'alamat': alamat,
                'rt': rt,
                'rw': rw,
                'email': email,
                'no_hp': no_hp,
                'nama_desa': '<?php echo $nama_desa; ?>'
            },
            beforeSend: function() {
                jQuery('.submitBtn').attr('disabled', 'disabled');
            },
            success: function(response) {
                jQuery('.submitBtn').removeAttr('disabled');
                jQuery('#wrap-loading').hide();
                
                if (response.status == 'success') {
                    alert(response.message);
                    jQuery('#modalTambahUser').modal('hide');
                    userTable.ajax.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                jQuery('.submitBtn').removeAttr('disabled');
                jQuery('#wrap-loading').hide();
                alert('Terjadi kesalahan: ' + error);
            }
        });
    }

    /** edit data user */
    function edit_data_user(id) {
        jQuery("#wrap-loading").show();
        jQuery.ajax({
            url: '<?php echo $url ?>',
            type: "post",
            data: {
                'action': "get_data_user_rt_rw_by_id",
                'api_key': jQuery("#api_key").val(),
                'id': id
            },
            dataType: "json",
            success: function(response) {
                jQuery("#wrap-loading").hide();
                
                if (response.status == 'success') {
                    let data = response.data;
                    
                    jQuery('#edit_id').val(data.id);
                    jQuery('#nama').val(data.nama);
                    jQuery('#alamat').val(data.alamat);
                    jQuery('#rt').val(data.rt).prop('disabled', true);
                    jQuery('#rw').val(data.rw).prop('disabled', true);
                    jQuery('#email').val(data.emailteks);
                    jQuery('#no_hp').val(data.no_hp);
                    
                    jQuery("#modalTambahUser .modal-title").html("Edit User RT / RW");
                    jQuery("#modalTambahUser .submitBtn")
                        .attr("onclick", 'submitTambahUserForm()')
                        .attr("disabled", false)
                        .text("Update");
                    
                    jQuery('#modalTambahUser').modal('show');
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                jQuery("#wrap-loading").hide();
                alert('Terjadi kesalahan: ' + error);
            }
        });
    }

    /** hapus data user */
    function hapus_data_user(id) {
        let confirmDelete = confirm("Apakah anda yakin akan menghapus user ini?");
        if (confirmDelete) {
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: '<?php echo $url ?>',
                type: 'post',
                data: {
                    'action': 'delete_user_rt_rw',
                    'api_key': jQuery("#api_key").val(),
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    jQuery('#wrap-loading').hide();
                    
                    if (response.status == 'success') {
                        alert(response.message);
                        userTable.ajax.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    jQuery('#wrap-loading').hide();
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        }
    }
</script>