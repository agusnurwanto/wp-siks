function relayAjax(options, retries=20, delay=5000, timeout=9000000){
    options.timeout = timeout;
    options.cache = false;
    jQuery.ajax(options)
    .fail(function(jqXHR, exception){
        // console.log('jqXHR, exception', jqXHR, exception);
        if(
            jqXHR.status != '0' 
            && jqXHR.status != '503'
            && jqXHR.status != '500'
        ){
            if(jqXHR.responseJSON){
                options.success(jqXHR.responseJSON);
            }else{
                options.success(jqXHR.responseText);
            }
        }else if (retries > 0) {
            console.log('Koneksi error. Coba lagi '+retries, options);
            var new_delay = Math.random() * (delay/1000);
            setTimeout(function(){ 
                relayAjax(options, --retries, delay, timeout);
            }, new_delay * 1000);
        } else {
            alert('Capek. Sudah dicoba berkali-kali error terus. Maaf, berhenti mencoba.');
        }
    });
}

function sql_migrate_siks(){
	jQuery('#wrap-loading').show();
	jQuery.ajax({
		url: ajaxurl,
      	type: "post",
      	data: {
      		"action": "sql_migrate_siks"
      	},
      	dataType: "json",
      	success: function(data){
			jQuery('#wrap-loading').hide();
			return alert(data.message);
		},
		error: function(e) {
			console.log(e);
			return alert(data.message);
		}
	});
}

function filePickedSiks(oEvent) {
    jQuery('#wrap-loading').show();
    // Get The File From The Input
    var oFile = oEvent.target.files[0];
    var sFilename = oFile.name;
    // Create A File Reader HTML5
    var reader = new FileReader();

    reader.onload = function(e) {
        var data = e.target.result;
        var workbook = XLSX.read(data, {
            type: 'binary'
        });

        var cek_sheet_name = false;
        workbook.SheetNames.forEach(function(sheetName) {
            // Here is your object
            if(sheetName == 'data'){
                cek_sheet_name = true;
                var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                var data = [];
                XL_row_object.map(function(b, i){
                    for(i in b){
                        b[i] = b[i].toString().replace(/(\r\n|\n|\r)/g, " ").trim();
                    }
                    data.push(b);
                });
                var json_object = JSON.stringify(data);
                jQuery('#data-excel').val(json_object);
                jQuery('#wrap-loading').hide();
            }
        });
        setTimeout(function(){
            if(false == cek_sheet_name){
                jQuery('#data-excel').val('');
                alert('Sheet dengan nama "data" tidak ditemukan!');
                jQuery('#wrap-loading').hide();
            }
        }, 2000);
    };

    reader.onerror = function(ex) {
      console.log(ex);
    };

    reader.readAsBinaryString(oFile);
}

function import_excel_lansia(){
    import_excel('import_excel_lansia', 'Success import data Lansia dari excel!');
}

function import_excel_disabilitas(action = '', message = ''){
    import_excel('import_excel_disabilitas', 'Success import data Disabilitas dari excel!');
}

function import_excel_bunda_kasih(action = '', message = ''){
    import_excel('import_excel_bunda_kasih', 'Success import data Bunda Kasih dari excel!');
}

function import_excel_anak_terlantar(action = '', message = ''){
    var jenis_import = jQuery('input[name="carbon_fields_compact_input[_crb_jenis_anak_terlantar]"]:checked').val();
    if(jenis_import == ''){
        return alert('Jenis data belum dipilih!');
    }
    import_excel(jenis_import, 'Success import data dari excel!');
}

function import_excel(action = '', message = ''){
    if(action == ''){
        alert('Action tidak diketahui!');
    }else{
        var data = jQuery('#data-excel').val();
        if(!data){
            return alert('Excel Data can not empty!');
        }else{
            var update_active = prompt("Apakah anda mau menonaktifkan data sebelumnya? ketik 1 jika iya dan kosongkan saja jika tidak.");

            if(update_active == null){
                return false;
            }

            data = JSON.parse(data);
            jQuery('#wrap-loading').show();

            var data_all = [];
            var data_sementara = [];
            var max = 100;
            data.map(function(b, i){
                data_sementara.push(b);
                if(data_sementara.length%max == 0){
                    data_all.push(data_sementara);
                    data_sementara = [];
                }
            });
            if(data_sementara.length > 0){
                data_all.push(data_sementara);
            }
            var page = 0;
            var last = data_all.length - 1;
            data_all.reduce(function(sequence, nextData){
                return sequence.then(function(current_data){
                    return new Promise(function(resolve_reduce, reject_reduce){
                        page++;
                        relayAjax({
                            url: ajaxurl,
                            type: 'post',
                            data: {
                                action: action,
                                data: current_data,
                                page: page,
                                update_active: update_active
                            },
                            success: function(res){
                                resolve_reduce(nextData);
                            },
                            error: function(e){
                                console.log('Error import excel', e);
                            }
                        });
                    })
                    .catch(function(e){
                        console.log(e);
                        return Promise.resolve(nextData);
                    });
                })
                .catch(function(e){
                    console.log(e);
                    return Promise.resolve(nextData);
                });
            }, Promise.resolve(data_all[last]))
            .then(function(data_last){
                jQuery('#wrap-loading').hide();
                alert(message);
            })
            .catch(function(e){
                console.log(e);
                jQuery('#wrap-loading').hide();
                alert('Error!');
            });
        }
    }
}

jQuery(document).ready(function(){
    window.options_skpd = {};
    var loading = ''
        +'<div id="wrap-loading">'
            +'<div class="lds-hourglass"></div>'
            +'<div id="persen-loading"></div>'
        +'</div>';
    if(jQuery('#wrap-loading').length == 0){
        jQuery('body').prepend(loading);
    }
});