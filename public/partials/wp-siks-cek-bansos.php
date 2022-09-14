<?php
    $api_key = get_option( SIKS_APIKEY );
?>
<h1 class="text-center">Cek Bantuan Sosial</h1>
<form style="width: 500px; margin: auto;" class="text-center">
  <div class="form-group">
    <label for="nik">Masukan NIK</label>
    <div class="input-group">
        <input type="number" class="form-control" id="nik" placeholder="xxxxxxxxxxx">
        <div class="input-group-append">
            <span class="btn btn-primary" type="button" id="cari" style="display: flex; align-items: center;">Cari Data</span>
        </div>
    </div>
  </div>
</form>
<div style="padding: 10px; margin: auto;" id="pesan">

</div>
<div style="max-width: 1000px; margin: auto;">
    <h4>Keterangan:</h4>
    <ul>
        <li><b>BPNT</b> (Bantuan Pangan Non Tunai) adalah bantuan sosial pangan dalam bentuk non tunai dari pemerintah yang diberikan kepada KPM setiap bulannya. Penyaluran bansos BPNT melalui mekanisme akun elektronik yang digunakan hanya untuk membeli bahan pangan di pedagang bahan pangan/e-warong yang bekerjasama dengan bank.</li>
        <li><b>BST</b> (Bantuan Sosial Tunai) adalah merupakan bantuan berupa uang yang diberikan kepada keluarga miskin, tidak mampu, dan/atau rentan yang terkena dampak wabah Corona Virus Disease 2019 (Covid-19).</li>
        <li><b>PKH</b> (Program Keluarga Harapan) adalah program yang dibuat sebagai upaya percepatan penanggulangan kemiskinan. PKH membuka akses keluarga miskin terutama ibu hamil dan anak untuk memanfaatkan berbagai fasilitas layanan kesehatan (faskes) dan fasilitas layanan pendidikan (fasdik) yang tersedia di sekitar tempat tinggal mereka.</li>
        <li><b>PBI-JK</b> (Penerima Bantuan Iuran Jaminan Kesehatan) adalah peserta jaminan kesehatan yang tergolong fakir miskin dan orang tidak mampu yang iuran BPJS Kesehatannya dibayarkan oleh pemerintah.</li>
        <li><b>BLT-BBM</b> (Bantuan Langsung Tunai Bahan Bakar Minyak) adalah salah satu program jaring pengaman sosial yang diberikan sebagai upaya meringankan beban masyarakat akibat kenaikan harga bahan pokok kebutuhan hidup sehari-hari.</li>
    </ul>
</div>
<script type="text/javascript">
    jQuery('document').ready(function(){
        jQuery('#cari').on('click', function(e){
            e.preventDefault();
            var nik = jQuery('#nik').val();
            if(nik == ''){
                return alert('NIK harus diisi!');
            }
            jQuery('#wrap-loading').show();
            jQuery('#pesan').html('');
            jQuery.ajax({
                url: ajax.url,
                type: 'post',
                data: {
                    action: 'get_data_bansos',
                    nik: nik,
                    api_key: '<?php echo $api_key; ?>'
                },
                success: function(res){
                    if(res.status == 'error'){
                        alert(res.message);
                    }else if(!res.data){
                        alert('Data dengan nomor NIK '+nik+' tidak ditemukan!');
                    }else{
                        var data_all = '';
                        res.data.map(function(b, i){
                            data_all += ''
                                +'<tr>'
                                    +'<td class="text-center">'+(i+1)+'</td>'
                                    +'<td></td>'
                                    +'<td></td>'
                                +'</tr>';
                        });
                        var pesan = ''
                            +'<table class="table table-bordered">'
                                +'<thead>'
                                    +'<tr>'
                                        +'<th class="text-center" style="width: 20px;">No</th>'
                                        +'<th class="text-center">Nama</th>'
                                        +'<th class="text-center">Usia</th>'
                                    +'</tr>'
                                +'</thead>'
                                +'<tbody>'
                                    +data_all
                                +'</tbody>'
                            +'</table>'
                        jQuery('#pesan').html(pesan);
                    }
                    jQuery('#wrap-loading').hide();
                }
            });
        });
    });
</script>