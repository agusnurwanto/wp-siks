<style type="text/css">
    .wrap-pesan{
        padding: 10px; 
        width: 100%; 
        margin-top: 35px;
    }
    .kategori .wrap-table{
        overflow: auto;
        max-height: 100vh; 
        width: 100%; 
    }
    .kategori h3{
        margin-top: 35px;
    }
</style>
<h1 class="text-center">Cek NIK (Nomor Induk Kependudukan)</h1><br>
<h2 class="text-center"><?php echo get_option("_crb_siks_prop"); ?><br><?php echo get_option("_crb_siks_kab"); ?></h2>
<form id="formid" onsubmit="return false;" style="width: 500px; margin: auto;" class="text-center">
    <div class="form-group">
        <label for="nik">Masukan NIK / KK / Nama</label>
        <div class="input-group">
            <input type="text" class="form-control" id="nik" placeholder="xxxxxxxxxxx">
            <div class="input-group-append">
                <span class="btn btn-primary" type="button" onclick="return false" id="cari" style="display: flex; align-items: center;">Cari Data</span>
            </div>
        </div>
    </div>
</form>
<div class="wrap-pesan">
    <div id="divp3ke" class="kategori">
    </div>
    <div id="divanakterlantar" class="kategori">
    </div>
    <div id="divbundakasih" class="kategori">
    </div>
    <div id="divdisabilitas" class="kategori">
    </div>
    <div id="divlansia" class="kategori">
    </div>
    <div id="divodgj" class="kategori">
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
                'api_key': '<?php echo get_option( SIKS_APIKEY ); ?>',
                'nik': nik
            },
            success: function(response) {

                if(response.status == 'error'){
                    alert(response.message);
                }else{
                    
                    let row_p3ke = '';
                    if(response.data.p3ke.length > 0){
                        response.data.p3ke.map(function(value, index){
                            row_p3ke +='<tr>';
                                row_p3ke +='<th scope="row">'+(index+1)+'</th>';
                                row_p3ke +='<td>'+value.kk+'</td>';
                                row_p3ke +='<td>'+value.nik+'</td>';
                                row_p3ke +='<td>'+value.nama+'</td>';
                                row_p3ke +='<td>'+value.provinsi+'</td>';
                                row_p3ke +='<td>'+value.kabkot+'</td>';
                                row_p3ke +='<td>'+value.kecamatan+'</td>';
                                row_p3ke +='<td>'+value.desa+'</td>';
                                row_p3ke +='<td>'+value.rt+'</td>';
                                row_p3ke +='<td>'+value.rw+'</td>';
                                row_p3ke +='<td>'+value.pekerjaan+'</td>';
                                row_p3ke +='<td>'+value.alamat+'</td>';
                                row_p3ke +='<td>'+value.tahun_anggaran+'</td>';
                                row_p3ke +='<td>'+value.update_at+'</td>';
                            row_p3ke +='</tr>';
                        })

                        jQuery('#divp3ke').html(
                            '<h3 class="text-center">Data P3KE</h3>'
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
                                            +'<th class="text-center">Update Terakhir</th>'
                                        +'</tr>'
                                    +'</thead>'
                                    +'<tbody>'
                                        +row_p3ke
                                    +'</tbody>'
                                +'</table>'
                            +'</div>');
                    }else{
                        jQuery('#divp3ke').html('');
                    }

                    let row_anak_terlantar = '';
                    if(response.data.anak_terlantar.length > 0){
                        response.data.anak_terlantar.map(function(value, index){
                            row_anak_terlantar +='<tr>';
                                row_anak_terlantar +='<th scope="row">'+(index+1)+'</th>';
                                row_anak_terlantar +='<td>'+value.kk+'</td>';
                                row_anak_terlantar +='<td>'+value.nik+'</td>';
                                row_anak_terlantar +='<td>'+value.nama+'</td>';
                                row_anak_terlantar +='<td>'+value.jenis_kelamin+'</td>';
                                row_anak_terlantar +='<td>'+value.tanggal_lahir+'</td>';
                                row_anak_terlantar +='<td>'+value.usia+'</td>';
                                row_anak_terlantar +='<td>'+value.pendidikan+'</td>';
                                row_anak_terlantar +='<td>'+value.alamat+'</td>';
                                row_anak_terlantar +='<td>'+value.provinsi+'</td>';
                                row_anak_terlantar +='<td>'+value.kabkot+'</td>';
                                row_anak_terlantar +='<td>'+value.kecamatan+'</td>';
                                row_anak_terlantar +='<td>'+value.desa_kelurahan+'</td>';
                                row_anak_terlantar +='<td>'+value.kelembagaan+'</td>';
                                row_anak_terlantar +='<td>'+value.tahun_anggaran+'</td>';
                                row_anak_terlantar +='<td>'+value.update_at+'</td>';
                            row_anak_terlantar +='</tr>';
                        })

                        jQuery('#divanakterlantar').html(
                            '<h3 class="text-center">Data Anak Terlantar</h3>'
                            +'<div class="wrap-table">'
                                +'<table class="table table-bordered">'
                                    +'<thead>'
                                        +'<tr>'
                                            +'<th class="text-center" style="width: 20px;">No</th>'
                                            +'<th class="text-center">No KK</th>'
                                            +'<th class="text-center">NIK</th>'
                                            +'<th class="text-center">Nama</th>'
                                            +'<th class="text-center">Jenis Kelamin</th>'
                                            +'<th class="text-center">Tanggal Lahir</th>'
                                            +'<th class="text-center">Usia</th>'
                                            +'<th class="text-center">Pendidikan</th>'
                                            +'<th class="text-center">Alamat</th>'
                                            +'<th class="text-center">Provinsi</th>'
                                            +'<th class="text-center">Kabupaten/Kota</th>'
                                            +'<th class="text-center">Kecamatan</th>'
                                            +'<th class="text-center">Desa/Kelurahan</th>'
                                            +'<th class="text-center">Kelembagaan</th>'
                                            +'<th class="text-center">Tahun Anggaran</th>'
                                            +'<th class="text-center">Update Terakhir</th>'
                                        +'</tr>'
                                    +'</thead>'
                                    +'<tbody>'
                                        +row_anak_terlantar
                                    +'</tbody>'
                                +'</table>'
                            +'</div>');
                    }else{
                        jQuery('#divanakterlantar').html('');
                    }

                    let row_disabilitas = '';
                    if(response.data.disabilitas.length > 0){
                        response.data.disabilitas.map(function(value, index){
                            row_disabilitas +='<tr>';
                                row_disabilitas +='<th scope="row">'+(index+1)+'</th>';
                                row_disabilitas +='<td>'+value.nik+'</td>';
                                row_disabilitas +='<td>'+value.nomor_kk+'</td>';
                                row_disabilitas +='<td>'+value.nama+'</td>';
                                row_disabilitas +='<td>'+value.gender+'</td>';
                                row_disabilitas +='<td>'+value.tempat_lahir+'</td>';
                                row_disabilitas +='<td>'+value.tanggal_lahir+'</td>';
                                row_disabilitas +='<td>'+value.status+'</td>';
                                row_disabilitas +='<td>'+value.dokumen_kewarganegaraan+'</td>';
                                row_disabilitas +='<td>'+value.provinsi+'</td>';
                                row_disabilitas +='<td>'+value.kabkot+'</td>';
                                row_disabilitas +='<td>'+value.kecamatan+'</td>';
                                row_disabilitas +='<td>'+value.desa+'</td>';
                                row_disabilitas +='<td>'+value.rt+'</td>';
                                row_disabilitas +='<td>'+value.rw+'</td>';
                                row_disabilitas +='<td>'+value.tahun_anggaran+'</td>';
                                row_disabilitas +='<td>'+value.update_at+'</td>';
                            row_disabilitas +='</tr>';
                        })

                        jQuery('#divdisabilitas').html(
                            '<h3 class="text-center">Data Disabilitas</h3>'
                            +'<div class="wrap-table">'
                                +'<table class="table table-bordered">'
                                    +'<thead>'
                                        +'<tr>'
                                            +'<th class="text-center" style="width: 20px;">No</th>'
                                            +'<th class="text-center">NIK</th>'
                                            +'<th class="text-center">No KK</th>'
                                            +'<th class="text-center">Nama</th>'
                                            +'<th class="text-center">Jenis Kelamin</th>'
                                            +'<th class="text-center">Tempat Lahir</th>'
                                            +'<th class="text-center">Tanggal Lahir</th>'
                                            +'<th class="text-center">Status</th>'
                                            +'<th class="text-center">Dokumen Kewarganegaraan</th>'
                                            +'<th class="text-center">Provinsi</th>'
                                            +'<th class="text-center">Kabupaten/Kota</th>'
                                            +'<th class="text-center">Kecamatan</th>'
                                            +'<th class="text-center">Desa/Kelurahan</th>'
                                            +'<th class="text-center">RT</th>'
                                            +'<th class="text-center">RW</th>'
                                            +'<th class="text-center">Tahun Anggaran</th>'
                                            +'<th class="text-center">Update Terakhir</th>'
                                        +'</tr>'
                                    +'</thead>'
                                    +'<tbody>'
                                        +row_disabilitas
                                    +'</tbody>'
                                +'</table>'
                            +'</div>');
                    }else{
                        jQuery('#divdisabilitas').html('');
                    }

                    let row_lansia = '';
                    if(response.data.lansia.length > 0){
                        response.data.lansia.map(function(value, index){
                            row_lansia +='<tr>';
                                row_lansia +='<th scope="row">'+(index+1)+'</th>';
                                row_lansia +='<td>'+value.nik+'</td>';
                                row_lansia +='<td>'+value.nama+'</td>';
                                row_lansia +='<td>'+value.alamat+'</td>';
                                row_lansia +='<td>'+value.desa+'</td>';
                                row_lansia +='<td>'+value.kecamatan+'</td>';
                                row_lansia +='<td>'+value.provinsi+'</td>';
                                row_lansia +='<td>'+value.kabkot+'</td>';
                                row_lansia +='<td>'+value.tanggal_lahir+'</td>';
                                row_lansia +='<td>'+value.usia+'</td>';
                                row_lansia +='<td>'+value.dokumen_kependudukan+'</td>';
                                row_lansia +='<td>'+value.status_tempat_tinggal+'</td>';
                                row_lansia +='<td>'+value.status_pemenuhan_kebutuhan+'</td>';
                                row_lansia +='<td>'+value.status_kehidupan_rumah_tangga+'</td>';
                                row_lansia +='<td>'+value.status_dtks+'</td>';
                                row_lansia +='<td>'+value.status_kepersertaan_program_bansos+'</td>';
                                row_lansia +='<td>'+value.tahun_anggaran+'</td>';
                                row_lansia +='<td>'+value.update_at+'</td>';
                            row_lansia +='</tr>';
                        })

                        jQuery('#divlansia').html(
                            '<h3 class="text-center">Data Lansia</h3>'
                            +'<div class="wrap-table">'
                                +'<table class="table table-bordered">'
                                    +'<thead>'
                                        +'<tr>'
                                            +'<th class="text-center" style="width: 20px;">No</th>'
                                            +'<th class="text-center">NIK</th>'
                                            +'<th class="text-center">Nama</th>'
                                            +'<th class="text-center">Alamat</th>'
                                            +'<th class="text-center">Desa</th>'
                                            +'<th class="text-center">Kecamatan</th>'
                                            +'<th class="text-center">Kabupaten/Kota</th>'
                                            +'<th class="text-center">Tahun Anggaran</th>'
                                            +'<th class="text-center">Tanggal Lahir</th>'
                                            +'<th class="text-center">Usia</th>'
                                            +'<th class="text-center">Dokumen Kependudukan</th>'
                                            +'<th class="text-center">Status Tempat Tinggal</th>'
                                            +'<th class="text-center">Status Pemenuhan Kebutuhan</th>'
                                            +'<th class="text-center">Status Kehidupan Rumah Tangga</th>'
                                            +'<th class="text-center">Status DTKS</th>'
                                            +'<th class="text-center">Status Kepersertaan Program Bansos</th>'
                                            +'<th class="text-center">Provinsi</th>'
                                            +'<th class="text-center">Update Terakhir</th>'
                                        +'</tr>'
                                    +'</thead>'
                                    +'<tbody>'
                                        +row_lansia
                                    +'</tbody>'
                                +'</table>'
                            +'</div>');
                    }else{
                        jQuery('#divlansia').html('');
                    }

                    let row_odgj = '';
                    if(response.data.odgj.length > 0){
                        response.data.odgj.map(function(value, index){
                            row_odgj +='<tr>';
                                row_odgj +='<th scope="row">'+(index+1)+'</th>';
                                row_odgj +='<td>'+value.kk+'</td>';
                                row_odgj +='<td>'+value.nik+'</td>';
                                row_odgj +='<td>'+value.nama+'</td>';
                                row_odgj +='<td>'+value.jenis_kelamin+'</td>';
                                row_odgj +='<td>'+value.usia+'</td>';
                                row_odgj +='<td>'+value.nama_ortu+'</td>';
                                row_odgj +='<td>'+value.rt+'</td>';
                                row_odgj +='<td>'+value.rw+'</td>';
                                row_odgj +='<td>'+value.desa+'</td>';
                                row_odgj +='<td>'+value.kecamatan+'</td>';
                                row_odgj +='<td>'+value.kabkot+'</td>';
                                row_odgj +='<td>'+value.provinsi+'</td>';
                                row_odgj +='<td>'+value.tahun_anggaran+'</td>';
                                row_odgj +='<td>'+value.update_at+'</td>';
                            row_odgj +='</tr>';
                        })

                        jQuery('#divodgj').html(
                            '<h3 class="text-center">Data Odgj</h3>'
                            +'<div class="wrap-table">'
                                +'<table class="table table-bordered">'
                                    +'<thead>'
                                        +'<tr>'
                                            +'<th class="text-center" style="width: 20px;">No</th>'
                                            +'<th class="text-center">No KK</th>'
                                            +'<th class="text-center">NIK</th>'
                                            +'<th class="text-center">Nama</th>'
                                            +'<th class="text-center">Jenis Kelamin</th>'
                                            +'<th class="text-center">Usia</th>'
                                            +'<th class="text-center">Nama Orang Tua</th>'
                                            +'<th class="text-center">RT</th>'
                                            +'<th class="text-center">RW</th>'
                                            +'<th class="text-center">Desa</th>'
                                            +'<th class="text-center">Kecamatan</th>'
                                            +'<th class="text-center">Kabupaten/Kota</th>'
                                            +'<th class="text-center">Provinsi</th>'
                                            +'<th class="text-center">Tahun Anggaran</th>'
                                            +'<th class="text-center">Update Terakhir</th>'
                                        +'</tr>'
                                    +'</thead>'
                                    +'<tbody>'
                                        +row_odgj
                                    +'</tbody>'
                                +'</table>'
                            +'</div>');
                    }else{
                        jQuery('#divodgj').html('');
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
                    jQuery('#wrap-loading').hide();
                }else{
                    jQuery('.kategori .wrap-table .table').dataTable();
                    jQuery('#wrap-loading').hide();
                }
            }
        });
    }

</script>

