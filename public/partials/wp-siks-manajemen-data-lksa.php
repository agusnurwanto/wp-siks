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

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
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
                    <th class="text-center">Nama Lembaga</th>
                    <th class="text-center">Kabupaten/Kota</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Ketua Lembaga</th>
                    <th class="text-center">Nomor HP</th>
                    <th class="text-center">Akreditasi</th>
                    <th class="text-center">Anak Dalam LKSA</th>
                    <th class="text-center">Anak Luar LKSA</th>
                    <th class="text-center">Total Anak LKSA</th>
                    <th class="text-center">Aksi</th>
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
                <h5 class="modal-title" id="modalTambahDataLksaLabel">Tambah Data LKSA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data">
                <div class="form-group">
                    <label>Tahun Anggaran</label>
                    <input type="text" class="form-control" id="tahun_anggaran" placeholder="Masukkan Tahun Anggaran">
                </div>
                <div class="form-group">
                    <label>Nama Lembaga</label>
                    <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Lembaga">
                </div>
                <div class="form-group">
                    <label>Kabupaten Kota</label>
                    <input type="text" class="form-control" id="kabkot" placeholder="Masukkan Kabupaten/Kota Lembaga">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control" id="alamat" placeholder="Masukkan Alamat Lembaga">
                </div>
                <div class="form-group">
                    <label>Ketua Lembaga</label>
                    <input type="text" class="form-control" id="ketua" placeholder="Masukkan Nama Ketua Lembaga">
                </div>
                <div class="form-group">
                    <label>Nomor HP/Telfon</label>
                    <input type="number" class="form-control" id="no_hp" placeholder="Masukkan Nomor HP/Telfon Lembaga">
                </div>
                <div class="form-group">
                    <label>Akreditasi Lembaga</label>
                    <input type="text" class="form-control" id="akreditasi" placeholder="Masukkan Akreditasi Lembaga">
                </div>
                <div class="form-group">
                    <label>Anak dalam LKSA</label>
                    <input type="number" class="form-control" id="dalam_lksa" placeholder="Masukkan Jumlah Anak dalam LKSA">
                </div>
                <div class="form-group">
                    <label>Anak luar LKSA</label>
                    <input type="number" class="form-control" id="luar_lksa" placeholder="Masukkan Jumlah Anak luar LKSA">
                </div>
                <div class="form-group">
                    <label>Total Anak LKSA</label>
                    <input type="number" class="form-control" id="total_anak" placeholder="Masukkan Total Jumlah Anak LKSA">
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
        get_datatable_lksa();

        function hitungTotalAnak() {
            let dalamLksa = parseInt(jQuery('#dalam_lksa').val()) || 0;
            let luarLksa = parseInt(jQuery('#luar_lksa').val()) || 0;
            let total = dalamLksa + luarLksa;
            jQuery('#total_anak').val(total);
        }
        jQuery('#dalam_lksa, #luar_lksa').on('input', function() {
            hitungTotalAnak();
        });
        jQuery('#total_anak').prop('disabled', true);
    });

    function get_datatable_lksa() {
        if (typeof tableLksa === 'undefined') {
            window.tableLksa = jQuery('#tableManajemenLksa').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: '<?php echo $url ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'action': 'get_datatable_lksa',
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
                        "data": 'nama',
                        className: "text-center"
                    },
                    {
                        "data": 'kabkot',
                        className: "text-center"
                    },
                    {
                        "data": 'alamat',
                        className: "text-center"
                    },
                    {
                        "data": 'ketua',
                        className: "text-center"
                    },
                    {
                        "data": 'no_hp',
                        className: "text-center"
                    },
                    {
                        "data": 'akreditasi',
                        className: "text-center"
                    },
                    {
                        "data": 'anak_dalam_lksa',
                        className: "text-center"
                    },
                    {
                        "data": 'anak_luar_lksa',
                        className: "text-center"
                    },
                    {
                        "data": 'total_anak',
                        className: "text-center"
                    },
                    {
                        "data": 'aksi',
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
                    'action': 'hapus_lksa_by_id',
                    'api_key': '<?php echo $api_key ?>',
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    jQuery('#wrap-loading').hide();
                    if (response.status == 'success') {
                        alert("Berhasil Hapus Data!");
                        get_datatable_lksa();
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
                'action': 'get_lksa_by_id',
                'api_key': '<?php echo $api_key; ?>',
                'id': _id,
            },
            success: function(res) {
                if (res.status == 'success') {
                    jQuery('#id_data').val(res.data.id);
                    jQuery('#tahun_anggaran').val(res.data.tahun_anggaran);
                    jQuery('#nama').val(res.data.nama);
                    jQuery('#kabkot').val(res.data.kabkot);
                    jQuery('#alamat').val(res.data.alamat);
                    jQuery('#ketua').val(res.data.ketua);
                    jQuery('#no_hp').val(res.data.no_hp);
                    jQuery('#akreditasi').val(res.data.akreditasi);
                    jQuery('#dalam_lksa').val(res.data.anak_dalam_lksa);
                    jQuery('#luar_lksa').val(res.data.anak_luar_lksa);
                    jQuery('#total_anak').val(res.data.total_anak);
                    jQuery('#modalTambahDataLksa').modal('show');
                } else {
                    alert(res.message);
                }
                jQuery('#wrap-loading').hide();
            }
        });
    }

    function tambahDataLksa() {
        jQuery('#tahun_anggaran').val('').show();
        jQuery('#nama').val('').show();
        jQuery('#kabkot').val('').show();
        jQuery('#alamat').val('').show();
        jQuery('#ketua').val('').show();
        jQuery('#no_hp').val('').show();
        jQuery('#akreditasi').val('').show();
        jQuery('#dalam_lksa').val('').show();
        jQuery('#luar_lksa').val('').show();
        jQuery('#total_anak').val('').show();
        jQuery('#modalTambahDataLksa').modal('show');
    }

    function submitDataLksa(that) {
        let id_data = jQuery('#id_data').val();
        let nama = jQuery('#nama').val();
        let tahun_anggaran = jQuery('#tahun_anggaran').val();
        let kabkot = jQuery('#kabkot').val();
        let alamat = jQuery('#alamat').val();
        let ketua = jQuery('#ketua').val();
        let no_hp = jQuery('#no_hp').val();
        let akreditasi = jQuery('#akreditasi').val();
        let dalam_lksa = jQuery('#dalam_lksa').val();
        let luar_lksa = jQuery('#luar_lksa').val();
        let total_anak = jQuery('#total_anak').val();

        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: '<?php echo $url; ?>',
            dataType: 'json',
            data: {
                'action': 'tambah_data_lksa',
                'api_key': '<?php echo $api_key; ?>',
                'id': id_data,
                'nama': nama,
                'tahun_anggaran': tahun_anggaran,
                'kabkot': kabkot,
                'alamat': alamat,
                'ketua': ketua,
                'no_hp': no_hp,
                'akreditasi': akreditasi,
                'dalam_lksa': dalam_lksa,
                'luar_lksa': luar_lksa,
                'total_anak': total_anak
            },
            success: function(res) {
                alert(res.message);
                jQuery('#modalTambahDataLksa').modal('hide');
                if (res.status == 'success') {
                    get_datatable_lksa();
                    jQuery('#wrap-loading').hide();
                }
            }
        });
    }
</script>