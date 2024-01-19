<?php
$api_key = get_option(SIKS_APIKEY);
$url = admin_url('admin-ajax.php');
$nama_desa = null;

if (empty($nama_desa) && is_user_logged_in()) {
    $nama_desa = $_GET['desa'];
} else {
    die('error, coba login ulang');
}
?>
<style type="text/css">
    .wrap-table {
        overflow: auto;
        max-height: 100vh;
        width: 100%;
    }
</style>
<div style="padding: 10px;margin:0 0 3rem 0;">
    <h1 class="text-center" style="margin:3rem;">Data Gepeng Per Desa <?= $nama_desa ?></h1>
    <div class="wrap-table">
        <table id="tableGepengPerDesa" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
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
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        getDataTables();
    });

    function getDataTables() {
        if (typeof tableGepeng === 'undefined') {
            window.tableGepeng = jQuery('#tableGepengPerDesa').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: '<?= $url ?>',,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'action': 'get_data_Gepeng',
                        'api_key': '<?php echo $api_key ?>',
                        'desa': '<?= $nama_desa ?>',
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

                ]
            });
        } else {
            tableGepeng.draw();
        }
    }