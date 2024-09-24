<?php
$jenis_data = $_GET['jenis'];
?>
<div class="container-md">
    <div class="cetak">
        <div style="padding: 10px;margin:0 0 3rem 0;">
            <h1 class="text-center">Daftar Data Usulan Per Desa <?php echo $jenis_data; ?></h1>
            <div class="wrap-table">
                <table id="listDesaTable" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="3">Kecamatan / Kelurahan / Desa</th>
                            <th class="text-center">Jumlah Usulan</th>
                            <th class="text-center">Jumlah Disetujui</th>
                            <th class="text-center">Jumlah Jumlah Ditolak</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
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
                console.error(xhr.responseText);
                alert('Terjadi kesalahan saat memuat tabel!');
            }
        });
    }

    function toDetailUrl(url) {
        window.open(url, '_blank');
    }
</script>