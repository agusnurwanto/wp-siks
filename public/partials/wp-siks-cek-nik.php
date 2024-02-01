<style type="text/css">
    .wrap-pesan{
        padding: 10px; 
        width: 100%; 
        margin-top: 35px;
    }
    .isi-pesan .wrap-table{
        overflow: auto;
        max-height: 100vh; 
        width: 100%; 
    }
    .isi-pesan h3{
        margin-top: 35px;
    }
</style>
<h1 class="text-center">Cek NIK (Nomor Induk Kependudukan)</h1><br>
<h2 class="text-center"><?php echo get_option("_crb_prov_satset"); ?><br><?php echo get_option("_crb_kab_satset"); ?></h2>
<form id="formid" onsubmit="return false;" style="width: 500px; margin: auto;" class="text-center">
    <div class="form-group">
        <label for="nik">Masukan NIK / Nama</label>
        <div class="input-group">
            <input type="text" class="form-control" id="nik" placeholder="xxxxxxxxxxx">
            <div class="input-group-append">
                <span class="btn btn-primary" type="button" onclick="return false" id="cari" style="display: flex; align-items: center;">Cari Data</span>
            </div>
        </div>
    </div>
</form>
<div class="wrap-pesan">
    <div id="pesan" class="isi-pesan">
    </div>
    <div id="pesan1" class="isi-pesan">
    </div>
    <div id="pesan2" class="isi-pesan">
    </div>
    <div id="pesan3" class="isi-pesan">
    </div>
    <div id="pesan4" class="isi-pesan">
    </div>
    <div id="pesan5" class="isi-pesan">
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery("#cari").click(function(){
            cari_nik_siks(jQuery('#nik').val());
        });
        jQuery("#nik").keyup(function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                jQuery("#cari").click();
            }
        });
    })

    function cari_nik_siks(nik) {
        if(nik.length < 3){
            return alert("Minimal 3 karakter!");
        }
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            dataType: 'json',
            data:{
                'action': 'cari_nik_siks',
                'api_key': '<?php echo get_option( SATSET_APIKEY ); ?>',
                'nik': nik
            },
            success: function(response) {
                console.log(response);
                if(response.status == 'error'){
                    alert(response.message);
                }else{
                    let html = '';
                    if(response.data.p3ke.length > 0){
                        response.data.p3ke.map(function(value, index){
                            html +='<tr>';
                                html +='<th scope="row">'+(index+1)+'</th>';
                                html +='<td>'+value.kk+'</td>';
                                html +='<td>'+value.nik+'</td>';
                                html +='<td>'+value.nama+'</td>';
                                html +='<td>'+value.provinsi+'</td>';
                                html +='<td>'+value.kabkot+'</td>';
                                html +='<td>'+value.kecamatan+'</td>';
                                html +='<td>'+value.desa+'</td>';
                                html +='<td>'+value.rt+'</td>';
                                html +='<td>'+value.rw+'</td>';
                                html +='<td>'+value.pekerjaan+'</td>';
                                html +='<td>'+value.alamat+'</td>';
                                html +='<td>'+value.tahun_anggaran+'</td>';
                            html +='</tr>';
                        })
                        var pesan = ''
                            +'<h3 class="text-center">Data P3KE</h3>'
                            +'<div class="wrap-table">'
                                +'<table class="table table-bordered">'
                                    +'<thead>'
                                        +'<tr>'
                                            +'<th class="text-center" style="width: 20px;">No</th>'
                                            +'<th class="text-center">No KK</th>'
                                            +'<th class="text-center">NIK</th>'
                                            +'<th class="text-center">Nama</th>'
                                            +'<th class="text-center">Provinsi</th>'
                                            +'<th class="text-center">Kabupaten/Kota</th>'
                                            +'<th class="text-center">Kecamatan</th>'
                                            +'<th class="text-center">Desa</th>'
                                            +'<th class="text-center">RT</th>'
                                            +'<th class="text-center">RW</th>'
                                            +'<th class="text-center">Pekerjaan</th>'
                                            +'<th class="text-center">Alamat</th>'
                                            +'<th class="text-center">Tahun Anggaran</th>'
                                        +'</tr>'
                                    +'</thead>'
                                    +'<tbody>'
                                        +html
                                    +'</tbody>'
                                +'</table>'
                            +'</div>';
                        jQuery('#pesan').html(pesan);
                    }else{
                        jQuery('#pesan').html('');
                    }
                }
                
                if(
                    response.data.p3ke.length == 0 && 
                    response.data.anak_terlantar.length == 0 && 
                    response.data.bunda_kasih.length == 0 && 
                    response.data.disabilitas.length == 0 && 
                    response.data.lansia.length == 0 && 
                    response.data.odgj.length == 0
                ){
                    alert('Data tidak ditemukan!');
                }else{
                    jQuery('.isi-pesan .wrap-table .table').dataTable();
                }
                jQuery('#wrap-loading').hide();
            }
        });
    }

</script>

