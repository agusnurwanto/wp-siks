<?php
$api_key = get_option(SIKS_APIKEY);
$url = admin_url('admin-ajax.php');

?>
<style type="text/css">
    .wrap-table {
        overflow: auto;
        max-height: 100vh;
        width: 100%;
    }
</style>
<div style="padding: 10px;margin:0 0 3rem 0;">
    <h1 class="text-center" style="margin:3rem;">Manajemen Data Lembaga Kesejahteraan Sosial Anak (LKSA)</h1>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="tambahDataLksa();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableManajemenLksa" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">NIK</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade mt-4" id="modalTambahDataLksa" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataLksaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataLksaLabel">Tambah Data Lksa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data" placeholder=''>
                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" class="form-control" id="nik">
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" onclick="submitDataLksa(this);" class="btn btn-primary send_data">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        get_data_Lksa();
    });

    function get_data_Lksa() {
        if (typeof tableLksa === 'undefined') {
            window.tableLksa = jQuery('#tableManajemenLksa').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: '<?php echo $url ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'action': '',
                        'api_key': '<?php echo $api_key ?>',
                    }
                },
                lengthMenu: [
                    [20, 50, 100, -1],
                    [20, 50, 100, "All"]
                ],
                order: [
                    [0, 'asc']
                ],
                "drawCallback": function(settings) {
                    jQuery("#wraploading").hide();
                },
                "columns": [{
                        "data": 'nik',
                        className: "text-center"
                    },
                    {
                        "data": 'nama',
                        className: "text-center"
                    },
                ]
            });
        } else {
            tableLksa.draw();
        }
    }

    function hapus_data(id) {
        let confirmDelete = confirm("Apakah anda yakin akan menghapus data ini?");
        if (confirmDelete) {
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: '<?php echo $url ?>',
                type: 'post',
                data: {
                    'action': '',
                    'api_key': '<?php echo $api_key ?>',
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    jQuery('#wrap-loading').hide();
                    if (response.status == 'success') {
                        get_data_Lksa();
                    } else {
                        alert(`GAGAL! \n${response.message}`);
                    }
                }
            });
        }
    }

    function edit_data(_id) {
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: '<?php echo $url; ?>',
            dataType: 'json',
            data: {
                'action': '',
                'api_key': '<?php echo $api_key; ?>',
                'id': _id,
            },
            success: function(res) {
                if (res.status == 'success') {
                    jQuery('#id_data').val(res.data.id);
                } else {
                    alert(res.message);
                }
                jQuery('#wrap-loading').hide();
            }
        });
    }

    function tambahDataLksa() {
        jQuery('#nik').val('').show();
    }

    function submitDataLksa() {
        var id_data = jQuery('#id_data').val();
        var nama = jQuery('#nama').val();
        if (nama == '') {
            return alert('Data Nama tidak boleh kosong!');
        }
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: '<?php echo $url; ?>',
            dataType: 'json',
            data: {
                'action': '',
                'api_key': '<?php echo $api_key; ?>',
            },
            success: function(res) {
                alert(res.message);
                jQuery('#modalTambahDataLksa').modal('hide');
                if (res.status == 'success') {
                    get_data_Lksa();
                    jQuery('#wrap-loading').hide();
                }
            }
        });
    }
</script>