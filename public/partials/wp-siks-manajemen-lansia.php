<?php echo "test";
?>
<h1 class="text-center">Manajemen Data Lansia</h1>
<script>
jQuery(document).ready(function() {
    getDataTables();
});

function getDataTables() {
    if (typeof dataTableInstance === 'undefined') {
        window.dataTableInstance = jQuery('#new_table_element').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: 'URL_ENDPOINT', 
                type: 'post',
                dataType: 'json',
                data: {
                    'action': 'get_data_from_server', 
                    'api_key': 'YOUR_API_KEY', 
                    'year': 'YEAR_VALUE', 
                    'department_id': 'DEPARTMENT_ID' 
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
                    "data": 'year',
                    className: "text-center"
                },
                {
                    "data": 'district',
                    className: "text-center"
                },
                
            ]
        });
    } else {
        dataTableInstance.draw();
    }
}
</script>