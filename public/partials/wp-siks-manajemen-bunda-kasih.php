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
    <h1 class="text-center" style="margin:3rem;">Manajemen Data Bunda Kasih</h1>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="tambah_data_bunda_kasih();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableManajemenBundaKasih" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Kartu Keluarga</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa</th>>
                    <th class="text-center">RT / RW</th>>
                    <th class="text-center">Tahun Anggaran</th>
                    <th class="text-center" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade mt-4" id="modalTambahDataBundaKasih" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataBundaKasihLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataBundaKasihLabel">Tambah Data Bunda Kasih</h5>
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
                    <label for='rt_rw' style='display:inline-block'>RT / RW</label>
                    <input type='text' id='rt_rw' name="rt_rw" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label>Tahun Anggaran</label>
                    <input type="text" class="form-control" id="tahun_anggaran">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="submitDataBundaKasih(this);" class="btn btn-primary send_data">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function() {
    get_data_bunda_kasih();
});

function get_data_bunda_kasih() {
    if (typeof tableBundaKasih === 'undefined') {
        window.tableBundaKasih = jQuery('#tableManajemenBundaKasih').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: '<?php echo $url?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    'action': 'get_datatable_bunda_kasih',
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
                    "data": 'rt_rw',
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
        tableBundaKasih.draw();
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
                    'action' : 'hapus_data_bunda_kasih_by_id',
                    'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
                    'id'     : id
                },
                dataType: 'json',
                success:function(response){
                    jQuery('#wrap-loading').hide();
                    if(response.status == 'success'){
                        get_data_bunda_kasih(); 
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
            'action': 'get_data_bunda_kasih_by_id',
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
                jQuery('#rt_rw').val(res.data.rt_rw);
                jQuery('#tahun_anggaran').val(res.data.tahun_anggaran);
                jQuery('#modalTambahDataBundaKasih .send_data').show();
                jQuery('#modalTambahDataBundaKasih').modal('show');
            }else{
                alert(res.message);
            }
            jQuery('#wrap-loading').hide();
        }
    });
}

function tambah_data_bunda_kasih() {
    jQuery('#nama').val('').show();
    jQuery('#provinsi').val('').show();
    jQuery('#desa').val('').show();
    jQuery('#kecamatan').val('').show();
    jQuery('#nik').val('').show();
    jQuery('#kabkot').val('').show();
    jQuery('#kk').val('').show();
    jQuery('#rt_rw').val('').show();
    jQuery('#tahun_anggaran').val('').show()
    jQuery('#modalTambahDataBundaKasih').modal('show');
}

function submitDataBundaKasih(){
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
    var rt_rw = jQuery('#rt_rw').val();
    if(rt_rw == ''){
        return alert('Data RT / RW tidak boleh kosong!');
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
            'action': 'tambah_data_bunda_kasih',
            'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
            'id_data': id_data,
            'nama': nama,
            'nik': nik,
            'kabkot': kabkot,
            'kecamatan': kecamatan,
            'desa': desa,
            'provinsi': provinsi,
            'kk': kk,
            'rt_rw': rt_rw,
            'tahun_anggaran': tahun_anggaran,
        },
        success: function(res){
            alert(res.message);
            jQuery('#modalTambahDataBundaKasih').modal('hide');
            if(res.status == 'success'){
                get_data_bunda_kasih();
                jQuery('#wrap-loading').hide();
            }
        }
    });
}
</script>