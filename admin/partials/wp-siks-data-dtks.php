<style type="text/css">
    .wrap-table{
        overflow: auto;
        max-height: 100vh; 
        width: 100%; 
    }
</style>
<div class="cetak">
    <div style="padding: 10px;margin:0 0 3rem 0;">
        <input type="hidden" value="<?php echo get_option( '_crb_api_key_extension' ); ?>" id="api_key">
        <h1 class="text-center" style="margin:3rem;">Manajemen Data DTKS</h1>
        <div class="wrap-table">
        <table id="management_data_table" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">No KK</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa/Kelurahan</th>
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
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>          
</div>

<script type="text/javascript">
	jQuery(document).ready(function(){
	    getDtks().then(function(){
            jQuery("#search_filter_action").select2();
        });
	});

    function getDtks(){
        return new Promise(function(resolve, reject){

            var dataDtks = jQuery('#management_data_table').DataTable({
                
                "searchDelay": 500,
                "processing": true,
                "serverSide": true,
                "stateSave": false,
                "ajax": {
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'post',
                    dataType: 'json',
                    data:{
                        'action': 'get_data_dtks_siks',
                        'api_key': '<?php echo get_option( SIKS_APIKEY ); ?>',
                    }
                },

                initComplete: function (settings, json) {
                    let html_filter = ""
                    +"<div class='row col-lg-12'>"
                        +"<div class='col-lg-12'>"
                            +"<button class='btn btn-sm btn-success' onclick='exportExcel()'>Export Excel</button>&nbsp;"
                            +"<select name='filter_status' class='ml-3 bulk-action' id='search_filter_action' style='width: 20%'>"
                                +"<option value='-'>Pilih Kriteria</option>"
                            +"</select>"
                        +"</div>"
                    +"</div>";
                    jQuery("#management_data_table").before(html_filter);

                    kriteria = [{'kk_kosong': 'KK Kosong'}, {'nik_kosong': 'NIK Kosong'}];
                    for (var key in kriteria) {
                        var obj = kriteria[key];
                        for (var prop in obj) {
                            if (obj.hasOwnProperty(prop)) {
                                jQuery('#search_filter_action').append('<option value="' + prop + '">' + obj[prop] + '</option>');
                            }
                        }
                    }
                    
                    jQuery('#search_filter_action').on('change', function () {
                        var option = jQuery(this).val();
                        switch(option){
                            case 'kk_kosong':
                                dataDtks.column(2).search('');
                                dataDtks.column(1).search(option).draw();
                                break;

                            case 'nik_kosong':
                                dataDtks.column(1).search('');
                                dataDtks.column(2).search(option).draw();
                                break;
                        }
                    });
                },

                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                order: [[1, 'asc']],
                "columns": [
                    {
                        "data": null
                    },
                    {
                        "data": 'Nama',
                        className: "text-left"
                    },
                    {
                        "data": 'NIK',
                        className: "text-center"
                    },
                    {
                        "data": 'NOKK',
                        className: "text-center"
                    },
                    {
                        "data": 'Alamat',
                        className: "text-left"
                    },
                    {
                        "data": 'provinsi',
                        className: "text-left"
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
                        "data": 'ATENSI',
                        className: "text-center"
                    },
                    {
                        "data": 'BLT',
                        className: "text-center"
                    },
                    {
                        "data": 'BLT_BBM',
                        className: "text-center"
                    },
                    {
                        "data": 'BNPT_PPKM',
                        className: "text-center"
                    },
                    {
                        "data": 'BPNT',
                        className: "text-center"
                    },
                    {
                        "data": 'BST',
                        className: "text-center"
                    },
                    {
                        "data": 'FIRST_SK',
                        className: "text-center"
                    },
                    {
                        "data": 'PBI',
                        className: "text-center"
                    },
                    {
                        "data": 'PENA',
                        className: "text-center"
                    },
                    {
                        "data": 'PERMAKANAN',
                        className: "text-center"
                    },
                    {
                        "data": 'RUTILAHU',
                        className: "text-center"
                    },
                    {
                        "data": 'SEMBAKO_ADAPTIF',
                        className: "text-center"
                    },
                    {
                        "data": 'YAPI',
                        className: "text-center"
                    },
                    {
                        "data": 'PKH',
                        className: "text-center"
                    },
                ],
                "columnDefs":[
                    {
                        targets: 0,
                        orderable: false,
                        render: function(data, type, row, meta){
                            return meta.row + meta.settings._iDisplayStart + 1 + ".";
                        }
                    }
                ],
                "drawCallback": function(){
                    resolve();
                }
            });
        });
    }

    function exportExcel(){
        let kriteria = jQuery('#search_filter_action').val();
        console.log(kriteria);
    }
</script>