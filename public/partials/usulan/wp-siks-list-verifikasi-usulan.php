<?php
$validate_user = $this->user_authorization('', $_GET['jenis']);
if ($validate_user['status'] === 'error') {
    die($validate_user['message']);
} else {
    echo "<script>console.log('Debug Objects: " . $validate_user['message'] . "' );</script>";
    $jenis_data = $validate_user['jenis_page'];
}
?>
<div class="container-md">
    <div class="m-4">
        <h1 class="text-center">Daftar Data Usulan Per Desa <?php echo $jenis_data; ?></h1>
        <div class="wrap-table">
            <table id="listDesaTable" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center align-middle w-50" colspan="3" rowspan="2">Kecamatan / Kelurahan / Desa</th>
                        <th class="text-center" colspan="4">Status</th>
                        <th class="text-center align-middle w-5" rowspan="2">Aksi</th>
                    </tr>
                    <tr>
                        <th class="text-center w-10 align-middle">Menunggu<br>Persetujuan</th>
                        <th class="text-center w-10 align-middle">Disetujui</th>
                        <th class="text-center w-10 align-middle">Ditolak</th>
                        <th class="text-center w-10 align-middle">Total</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        getTable()
    })

    function getTable() {
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            url: ajax.url,
            type: 'POST',
            data: {
                action: 'get_table_list_usulan',
                api_key: ajax.apikey,
                jenis_data: '<?php echo $jenis_data; ?>'
            },
            dataType: 'json',
            success: function(response) {
                jQuery('#wrap-loading').hide();
                console.log(response);
                if (response.status === 'success') {
                    jQuery('#listDesaTable tbody').html(response.data);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                jQuery('#wrap-loading').hide();
                alert('Terjadi kesalahan saat memuat tabel!');
            }
        });
    }

    function toDetailUrl(url) {
        window.open(url, '_blank');
    }
</script>