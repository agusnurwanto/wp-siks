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
    <h1 class="text-center" style="margin:3rem;">Manajemen Data Anak Terlantar</h1>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="tambah_data_anak_terlantar();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableManajemenAnakTerlantar" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Nama</th>
                    <th class="text-center">No KK</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">Tanggal Lahir</th>
                    <th class="text-center">Usia</th>
                    <th class="text-center">Pendidikan</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten/Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa/Kelurahan</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade mt-4" id="modalTambahDataAnakTerlantar" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataAnakTerlantarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataAnakTerlantarLabel">Tambah Data Anak Terlantar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Tahun Anggaran</label>
                    <input type="text" class="form-control" id="tahun_anggaran">
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama">
                </div>
                <div class="form-group">
                    <label>Nomor Kartu Keluarga</label>
                    <input type="text" class="form-control" id="kk">
                </div>
                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" class="form-control" id="nik">
                </div>
                <div class="form-group" id="status_jk">
                    <label for="jenis_kelamin">Jenis Kelamin</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_laki" value="L">
                        <label class="form-check-label" for="jenis_laki">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_perempuan" value="P">
                        <label class="form-check-label" for="jenis_perempuan">Perempuan</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="text" class="form-control" id="tanggal_Lahir">
                </div>
                <div class="form-group">
                    <label>Usia</label>
                    <input type="text" class="form-control" id="usia">
                </div>
                <div class="form-group">
                    <label>Pendidikan</label>
                    <input type="text" class="form-control" id="pendidikan">
                </div>
                <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" class="form-control" id="provinsi">
                </div>
                <div class="form-group">
                    <label>Kabupaten/Kota</label>
                    <input type="text" class="form-control" id="kabkot">
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <input type="text" class="form-control" id="kecamatan">
                </div>
                <div class="form-group">
                    <label>Desa/Kelurahan</label>
                    <input type="text" class="form-control" id="desa_kelurahan">
                </div>
                <div class="form-group" id="status_kelembagaan">
                    <label>Status Lembaga</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status_lembaga" id="status_in" value="1">
                        <label class="form-check-label" for="status_in">Dalam Lembaga</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status_lembaga" id="status_out" value="0">
                        <label class="form-check-label" for="status_out">Luar Lembaga</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="submitDataAnakTerlantar(this);" class="btn btn-primary send_data">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        get_data_anak_terlantar();
    });

    function get_data_anak_terlantar() {
        if (typeof tableAnakTerlantar === 'undefined') {
            window.tableAnakTerlantar = jQuery('#tableManajemenAnakTerlantar').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: '<?php echo $url?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'action': 'get_datatable_anak_terlantar',
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
                        "data": 'kk',
                        className: "text-center"
                    },
                    {
                        "data": 'nik',
                        className: "text-center"
                    },
                    {
                        "data": 'jenis_kelamin',
                        className: "text-center"
                    },
                    {
                        "data": 'tanggal_lahir',
                        className: "text-center"
                    },
                    {
                        "data": 'usia',
                        className: "text-center"
                    },
                    {
                        "data": 'pendidikan',
                        className: "text-center"
                    },
                    {
                        "data": 'provinsi',
                        className: "text-center"
                    },
                    {
                        "data": 'kabkot',
                        className: "text-center"
                    },
                    {
                        "data": 'kecamatan',
                        className: "text-center"
                    },
                    {
                        "data": 'desa_kelurahan',
                        className: "text-center"
                    },
                    {
                        "data": 'aksi',
                        className: "text-center"
                    },

                ]
            });
        } else {
            tableAnakTerlantar.draw();
        }
    }

    function tambah_data_anak_terlantar() {
        jQuery('#tahun_anggaran').val('').show()
        jQuery('#nama').val('').show()
        jQuery('#kk').val('').show()
        jQuery('#nik').val('').show()
        jQuery('#status_jk').val('').show()
        jQuery('#tanggal_Lahir').val('').show()
        jQuery('#usia').val('').show()
        jQuery('#pendidikan').val('').show()
        jQuery('#usia').val('').show()
        jQuery('#provinsi').val('').show()
        jQuery('#kabkot').val('').show()
        jQuery('#kecamatan').val('').show()
        jQuery('#desa_kelurahan').val('').show()
        jQuery('#modalTambahDataAnakTerlantar').modal('show');
    }
</script>