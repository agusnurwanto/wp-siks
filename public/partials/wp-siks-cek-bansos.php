<h1 class="text-center">Cek Bantuan Sosial</h1>
<form style="width: 500px; margin: auto;" class="text-center">
  <div class="form-group">
    <label for="nik">Masukan NIK</label>
    <div class="input-group">
        <input type="text" class="form-control" id="nik" placeholder="xxxxxxxxxxx">
        <div class="input-group-append">
            <span class="btn btn-primary" type="button" id="cari" style="display: flex; align-items: center;">Cari Data</span>
        </div>
    </div>
  </div>
</form>
<script type="text/javascript">
    jQuery('document').ready(function(){
        jQuery('#cari').on('click', function(e){
            e.preventDefault();
            var nik = jQuery('#nik').val();
            if(nik == ''){
                return alert('NIK harus diisi!');
            }
            jQuery('#wrap-loading').show();
        });
    });
</script>