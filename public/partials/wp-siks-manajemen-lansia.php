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
    <h1 class="text-center" style="margin:3rem;">Manajemen Data Lansia</h1>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="tambah_data_lansia();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableManajemenLansia" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Desa</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Tanggal Lahir</th>
                    <th class="text-center">Usia</th>
                    <th class="text-center">Tahun Anggaran</th>
                    <th class="text-center" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade mt-4" id="modalTambahDataLansia" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataLansiaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataLansiaLabel">Tambah Data Lansia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control" id="alamat">
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <input type="text" class="form-control" id="kecamatan">
                </div>
                <div class="form-group">
                    <label>Desa</label>
                    <input type="text" class="form-control" id="desa">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="text" class="form-control" id="tanggalLahir">
                </div>
                <div class="form-group">
                    <label>Usia</label>
                    <input type="text" class="form-control" id="usia">
                </div>
                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" class="form-control" id="nik">
                </div>
                <div class="form-group">
                    <label>Tahun Anggaran</label>
                    <input type="text" class="form-control" id="tahunAnggaran">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="submitDataLansia(this);" class="btn btn-primary send_data">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        getDataTables();
    });

    function getDataTables() {
        if (typeof tableLansia === 'undefined') {
            window.tableLansia = jQuery('#tableManajemenLansia').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: '<?php echo $url?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'action': 'get_data_lansia',
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
                        "data": 'alamat',
                        className: "text-center"
                    },
                    {
                        "data": 'desa',
                        className: "text-center"
                    },
                    {
                        "data": 'kecamatan',
                        className: "text-center"
                    },
                    {
                        "data": 'nik',
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
                        "data": 'tahun_anggaran',
                        className: "text-center"
                    },
                    {
                        "data": 'aksi',
                        className: "text-center"
                    },

                ]
            });
        } else {
            tableLansia.draw();
        }
    }

    function tambah_data_lansia() {
        jQuery('#nama').val('').show()
        jQuery('#alamat').val('').show()
        jQuery('#desa').val('').show()
        jQuery('#kecamatan').val('').show()
        jQuery('#nik').val('').show()
        jQuery('#tanggalLahir').val('').show()
        jQuery('#usia').val('').show()
        jQuery('#tahunAnggaran').val('').show()
        jQuery('#modalTambahDataLansia').modal('show');
    }
</script>