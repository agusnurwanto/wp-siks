<?php
$api_key = get_option(SIKS_APIKEY);
$url = admin_url('admin-ajax.php');

?>
<style type="text/css">
    .wrap-table {
        overflow: auto;
        max-height: 100vh;
        width: 100%;
    }
</style>
<div style="padding: 10px;margin:0 0 3rem 0;">
    <h1 class="text-center" style="margin:3rem;">Manajemen Data P3KE</h1>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="tambah_data_p3ke();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableManajemenP3KE" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Kartu Keluarga</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa</th>
                    <th class="text-center">RT</th>
                    <th class="text-center">RW</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Pekerjaan</th>
                    <th class="text-center">Program</th>
                    <th class="text-center">Penghasilan</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Tahun Anggaran</th>
                    <th class="text-center" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade mt-4" id="modalTambahDataP3KE" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataP3KE" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataP3KE">Tambah Data P3KE </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data" placeholder=''>
                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" class="form-control" id="nik">
                </div>
                <div class="form-group">
                    <label>Kartu Keluarga</label>
                    <input type="text" class="form-control" id="kk">
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama">
                </div>
                <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" class="form-control" id="provinsi">
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <input type="text" class="form-control" id="kecamatan">
                </div>
                <div class="form-group">
                    <label>Kabupaten / Kota</label>
                    <input type="text" class="form-control" id="kabkot">
                </div>
                <div class="form-group">
                    <label>Desa</label>
                    <input type="text" class="form-control" id="desa">
                </div>
                <div class="form-group">
                    <label for='rt' style='display:inline-block'>RT</label>
                    <input type='text' id='rt' name="rt" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='rw' style='display:inline-block'>RW</label>
                    <input type='text' id='rw' name="rw" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='alamat' style='display:inline-block'>Alamat</label>
                    <input type='text' id='alamat' name="alamat" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='pekerjaan' style='display:inline-block'>Pekerjaan</label>
                    <input type='text' id='pekerjaan' name="pekerjaan" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='program' style='display:inline-block'>Program</label>
                    <input type='text' id='program' name="program" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='penghasilan' style='display:inline-block'>Penghasilan</label>
                    <input type='text' id='penghasilan' name="penghasilan" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='keterangan' style='display:inline-block'>Keterangan</label>
                    <input type='text' id='keterangan' name="keterangan" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label>Tahun Anggaran</label>
                    <input type="text" class="form-control" id="tahun_anggaran">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="submitDataP3KE(this);" class="btn btn-primary send_data">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function() {
    get_data_p3ke();
});

function get_data_p3ke() {
    if (typeof tableP3KE === 'undefined') {
        window.tableP3KE = jQuery('#tableManajemenP3KE').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: '<?php echo $url?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    'action': 'get_datatable_p3ke',
                    'api_key': '<?php echo $api_key ?>',
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
                    "data": 'nik',
                    className: "text-center"
                },
                {
                    "data": 'kk',
                    className: "text-center"
                },
                {
                    "data": 'nama',
                    className: "text-center"
                },
                {
                    "data": 'provinsi',
                    className: "text-center"
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
                    "data": 'desa',
                    className: "text-center"
                },
                {
                    "data": 'rt',
                    className: "text-center"
                },
                {
                    "data": 'rw',
                    className: "text-center"
                },
                {
                    "data": 'alamat',
                    className: "text-center"
                },
                {
                    "data": 'pekerjaan',
                    className: "text-center"
                },
                {
                    "data": 'program',
                    className: "text-center"
                },
                {
                    "data": 'penghasilan',
                    className: "text-center"
                },
                {
                    "data": 'keterangan',
                    className: "text-center"
                },
                {
                    "data": 'tahun_anggaran',
                    className: "text-center"
                },
                {
                    "data": 'aksi',
                    className: "text-center"
                },

            ]
        });
    } else {
        tableP3KE.draw();
    }
}

function hapus_data(id){
        let confirmDelete = confirm("Apakah anda yakin akan menghapus data ini?");
        if(confirmDelete){
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type:'post',
                data:{
                    'action' : 'hapus_data_p3ke_by_id',
                    'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
                    'id'     : id
                },
                dataType: 'json',
                success:function(response){
                    jQuery('#wrap-loading').hide();
                    if(response.status == 'success'){
                        get_data_p3ke(); 
                    }else{
                        alert(`GAGAL! \n${response.message}`);
                    }
                }
            });
        }
    }

function edit_data(_id){
    jQuery('#wrap-loading').show();
    jQuery.ajax({
        method: 'post',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        dataType: 'json',
        data:{
            'action': 'get_data_p3ke_by_id',
            'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
            'id': _id,
        },
        success: function(res){
            if(res.status == 'success'){
                jQuery('#id_data').val(res.data.id);
                jQuery('#nama').val(res.data.nama);
                jQuery('#kecamatan').val(res.data.kecamatan);
                jQuery('#desa').val(res.data.desa);
                jQuery('#provinsi').val(res.data.provinsi);
                jQuery('#nik').val(res.data.nik);
                jQuery('#kabkot').val(res.data.kabkot);
                jQuery('#kk').val(res.data.kk);
                jQuery('#rt').val(res.data.rt);
                jQuery('#rw').val(res.data.rw);
                jQuery('#alamat').val(res.data.alamat);
                jQuery('#pekerjaan').val(res.data.pekerjaan);
                jQuery('#program').val(res.data.program);
                jQuery('#penghasilan').val(res.data.penghasilan);
                jQuery('#keterangan').val(res.data.keterangan);
                jQuery('#tahun_anggaran').val(res.data.tahun_anggaran);
                jQuery('#modalTambahDataP3KE .send_data').show();
                jQuery('#modalTambahDataP3KE').modal('show');
            }else{
                alert(res.message);
            }
            jQuery('#wrap-loading').hide();
        }
    });
}

function tambah_data_p3ke() {
    jQuery('#nama').val('').show();
    jQuery('#provinsi').val('').show();
    jQuery('#desa').val('').show();
    jQuery('#kecamatan').val('').show();
    jQuery('#nik').val('').show();
    jQuery('#kabkot').val('').show();
    jQuery('#kk').val('').show();
    jQuery('#rt').val('').show();
    jQuery('#rw').val('').show();
    jQuery('#alamat').val('').show();
    jQuery('#program').val('').show();
    jQuery('#pekerjaan').val('').show();
    jQuery('#penghasilan').val('').show();
    jQuery('#keterangan').val('').show();
    jQuery('#tahun_anggaran').val('').show()
    jQuery('#modalTambahDataP3KE').modal('show');
}

function submitDataP3KE(){
    var id_data = jQuery('#id_data').val();
    var nama = jQuery('#nama').val();
    if(nama == ''){
        return alert('Data Nama tidak boleh kosong!');
    }
    var nik = jQuery('#nik').val();
    if(nik == ''){
        return alert('Data NIK tidak boleh kosong!');
    }
    var kabkot = jQuery('#kabkot').val();
    if(kabkot == ''){
        return alert('Data Kabupaten / Kota tidak boleh kosong!');
    }
    var kecamatan = jQuery('#kecamatan').val();
    if(kecamatan == ''){
        return alert('Data Kecamatan tidak boleh kosong!');
    }
    var desa = jQuery('#desa').val();
    if(desa == ''){
        return alert('Data Desa tidak boleh kosong!');
    }
    var provinsi = jQuery('#provinsi').val();
    if(provinsi == ''){
        return alert('Data Provinsi tidak boleh kosong!');
    }
    var kk = jQuery('#kk').val();
    if(kk == ''){
        return alert('Data Kartu Keluarga tidak boleh kosong!');
    }
    var rt = jQuery('#rt').val();
    if(rt == ''){
        return alert('Data RT tidak boleh kosong!');
    }
    var rw = jQuery('#rw').val();
    if(rw == ''){
        return alert('Data RW tidak boleh kosong!');
    }
    var alamat = jQuery('#alamat').val();
    if(alamat == ''){
        return alert('Data Alamat tidak boleh kosong!');
    }
    var pekerjaan = jQuery('#pekerjaan').val();
    if(pekerjaan == ''){
        return alert('Data Pekerjaan tidak boleh kosong!');
    }
    var program = jQuery('#program').val();
    if(program == ''){
        return alert('Data Program tidak boleh kosong!');
    }
    var penghasilan = jQuery('#penghasilan').val();
    if(penghasilan == ''){
        return alert('Data Penghasilan tidak boleh kosong!');
    }
    var keterangan = jQuery('#keterangan').val();
    if(keterangan == ''){
        return alert('Data Keterangan tidak boleh kosong!');
    }
    var tahun_anggaran = jQuery('#tahun_anggaran').val();
    if(tahun_anggaran == ''){
        return alert('Data Tahun Anggaran tidak boleh kosong!');
    }

    jQuery('#wrap-loading').show();
    jQuery.ajax({
        method: 'post',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        dataType: 'json',
        data:{
            'action': 'tambah_data_p3ke',
            'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
            'id_data': id_data,
            'nama': nama,
            'nik': nik,
            'kabkot': kabkot,
            'kecamatan': kecamatan,
            'desa': desa,
            'provinsi': provinsi,
            'kk': kk,
            'rt': rt,
            'rw': rw,
            'alamat': alamat,
            'pekerjaan': pekerjaan,
            'program': program,
            'penghasilan': penghasilan,
            'keterangan': keterangan,
            'tahun_anggaran': tahun_anggaran,
        },
        success: function(res){
            alert(res.message);
            jQuery('#modalTambahDataP3KE').modal('hide');
            if(res.status == 'success'){
                get_data_p3ke();
                jQuery('#wrap-loading').hide();
            }
        }
    });
}
</script>