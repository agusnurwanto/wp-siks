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
    <h1 class="text-center" style="margin:3rem;">Manajemen Data Lansia</h1>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="tambah_data_lansia();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableManajemenLansia" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Tanggal Lahir</th>
                    <th class="text-center">Usia</th>
                    <th class="text-center">Dokumen Kependudukan</th>
                    <th class="text-center">Status Tempat Tinggal</th>
                    <th class="text-center">Status Pemenuhan Kebutuhan</th>
                    <th class="text-center">Status Kehidupan Rumah Tangga</th>
                    <th class="text-center">Status DTKS</th>
                    <th class="text-center">Status Kepersertaan Program Bansos</th>
                    <th class="text-center">Rekomendasi Pendata Lama</th>
                    <th class="text-center">Keterangan Lainnya Lama</th>
                    <th class="text-center">Rekomendasi Pendata</th>
                    <th class="text-center">Keterangan Lainnya</th>
                    <th class="text-center">Lampiran</th>
                    <th class="text-center">Tahun Anggaran</th>
                    <th class="text-center" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade mt-4" id="modalTambahDataLansia" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataLansiaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataLansiaLabel">Tambah Data Lansia</h5>
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
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama">
                </div>
                <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" class="form-control" id="provinsi">
                </div>
                <div class="form-group">
                    <label>Kabupaten / Kota</label>
                    <input type="text" class="form-control" id="kabkot">
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <input type="text" class="form-control" id="kecamatan">
                </div>
                <div class="form-group">
                    <label>Desa</label>
                    <input type="text" class="form-control" id="desa">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control" id="alamat">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="text" class="form-control" id="tanggal_lahir">
                </div>
                <div class="form-group">
                    <label>Usia</label>
                    <input type="text" class="form-control" id="usia">
                </div>
                <div class="form-group">
                    <label for='dokumen_kependudukan' style='display:inline-block'>Dokumen Kependudukan</label>
                    <input type='text' id='dokumen_kependudukan' name="dokumen_kependudukan" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='status_tempat_tinggal' style='display:inline-block'>Status Tempat Tinggal</label>
                    <input type="text" id='status_tempat_tinggal' name="status_tempat_tinggal" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='status_pemenuhan_kebutuhan' style='display:inline-block'>Status Pemenuhan Kebutuhan</label>
                    <input type="text" id='status_pemenuhan_kebutuhan' name="status_pemenuhan_kebutuhan" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='status_kehidupan_rumah_tangga' style='display:inline-block'>Status Kehidupan Rumah Tangga</label>
                    <input type="text" id='status_kehidupan_rumah_tangga' name="status_kehidupan_rumah_tangga" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='status_dtks' style='display:inline-block'>Status DTKS</label>
                    <input type="text" id='status_dtks' name="status_dtks" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='status_kepersertaan_program_bansos' style='display:inline-block'>Status Kepersertaan Program Bansos</label>
                    <input type="text" id='status_kepersertaan_program_bansos' name="status_kepersertaan_program_bansos" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='rekomendasi_pendata_lama' style='display:inline-block'>Rekomendasi Pendata Lama</label>
                    <input type="text" id='rekomendasi_pendata_lama' name="rekomendasi_pendata_lama" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='keterangan_lainnya_lama' style='display:inline-block'>Keterangan Lainnya Lama</label>
                    <input type="text" id='keterangan_lainnya_lama' name="keterangan_lainnya_lama" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='rekomendasi_pendata' style='display:inline-block'>Rekomendasi Pendata</label>
                    <input type="text" id='rekomendasi_pendata' name="rekomendasi_pendata" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='keterangan_lainnya' style='display:inline-block'>Keterangan Lainnya </label>
                    <input type="text" id='keterangan_lainnya' name="keterangan_lainnya" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label>Tahun Anggaran</label>
                    <input type="text" class="form-control" id="tahun_anggaran">
                </div>
                <div class="form-group">
                    <label for="">Lampiran</label>
                    <input type="file" name="file" class="form-control-file" id="lampiran" accept="application/pdf, .png, .jpg, .jpeg">
                    <div style="padding-top: 10px; padding-bottom: 10px;"><a id="file_lampiran_existing"></a></div>
                </div>
                <div><small>Upload file maksimal 1 Mb, berformat .pdf .png .jpg .jpeg</small></div>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="submitDataLansia(this);" class="btn btn-primary send_data">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function() {
    get_data_lansia();
        window.global_file_upload = "<?php echo SIKS_PLUGIN_URL . 'public/media/lansia/'; ?>";
});

function get_data_lansia() {
    if (typeof tableLansia === 'undefined') {
        window.tableLansia = jQuery('#tableManajemenLansia').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: '<?php echo $url?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    'action': 'get_datatable_lansia',
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
                    "data": 'desa',
                    className: "text-center"
                },
                {
                    "data": 'kecamatan',
                    className: "text-center"
                },
                {
                    "data": 'alamat',
                    className: "text-center"
                },
                {
                    "data": 'tanggal_lahir',
                    className: "text-center"
                },
                {
                    "data": 'usia',
                    className: "text-center"
                },
                {
                    "data": 'dokumen_kependudukan',
                    className: "text-center"
                },
                {
                    "data": 'status_tempat_tinggal',
                    className: "text-center"
                },
                {
                    "data": 'status_pemenuhan_kebutuhan',
                    className: "text-center"
                },
                {
                    "data": 'status_kehidupan_rumah_tangga',
                    className: "text-center"
                },
                {
                    "data": 'status_dtks',
                    className: "text-center"
                },
                {
                    "data": 'status_kepersertaan_program_bansos',
                    className: "text-center"
                },
                {
                    "data": 'rekomendasi_pendata_lama',
                    className: "text-center"
                },
                {
                    "data": 'keterangan_lainnya_lama',
                    className: "text-center"
                },
                {
                    "data": 'rekomendasi_pendata',
                    className: "text-center"
                },
                {
                    "data": 'keterangan_lainnya',
                    className: "text-center"
                },
                {
                    "data": 'file_lampiran',
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
        tableLansia.draw();
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
                    'action' : 'hapus_data_lansia_by_id',
                    'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
                    'id'     : id
                },
                dataType: 'json',
                success:function(response){
                    jQuery('#wrap-loading').hide();
                    if(response.status == 'success'){
                        get_data_lansia(); 
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
            'action': 'get_data_lansia_by_id',
            'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
            'id': _id,
        },
        success: function(res){
            if(res.status == 'success'){
                jQuery('#id_data').val(res.data.id);
                jQuery('#nama').val(res.data.nama);
                jQuery('#nik').val(res.data.nik);
                jQuery('#provinsi').val(res.data.provinsi);
                jQuery('#kabkot').val(res.data.kabkot);
                jQuery('#kecamatan').val(res.data.kecamatan);
                jQuery('#desa').val(res.data.desa);
                jQuery('#alamat').val(res.data.alamat);
                jQuery('#tanggal_lahir').val(res.data.tanggal_lahir);
                jQuery('#usia').val(res.data.usia);
                jQuery('#dokumen_kependudukan').val(res.data.dokumen_kependudukan);
                jQuery('#status_tempat_tinggal').val(res.data.status_tempat_tinggal);
                jQuery('#status_pemenuhan_kebutuhan').val(res.data.status_pemenuhan_kebutuhan);
                jQuery('#status_kehidupan_rumah_tangga').val(res.data.status_kehidupan_rumah_tangga);
                jQuery('#status_kepersertaan_program_bansos').val(res.data.status_kepersertaan_program_bansos);
                jQuery('#status_dtks').val(res.data.status_dtks);
                jQuery('#rekomendasi_pendata_lama').val(res.data.rekomendasi_pendata_lama);
                jQuery('#keterangan_lainnya_lama').val(res.data.keterangan_lainnya_lama);
                jQuery('#rekomendasi_pendata').val(res.data.rekomendasi_pendata);
                jQuery('#keterangan_lainnya').val(res.data.keterangan_lainnya);
                jQuery('#tahun_anggaran').val(res.data.tahun_anggaran);
                jQuery('#file_lampiran_existing').attr('href', global_file_upload + res.data.file_lampiran).html(res.data.file_lampiran);
                jQuery('#lampiran').val('').show();
                jQuery('#modalTambahDataLansia .send_data').show();
                jQuery('#modalTambahDataLansia').modal('show');
            }else{
                alert(res.message);
            }
            jQuery('#wrap-loading').hide();
        }
    });
}

function tambah_data_lansia() {
    jQuery('#nik').val('').show();
    jQuery('#nama').val('').show();
    jQuery('#provinsi').val('').show();
    jQuery('#kabkot').val('').show();
    jQuery('#desa').val('').show();
    jQuery('#kecamatan').val('').show();
    jQuery('#alamat').val('').show();
    jQuery('#tanggal_lahir').val('').show();
    jQuery('#usia').val('').show();
    jQuery('#dokumen_kependudukan').val('').show();
    jQuery('#status_tempat_tinggal').val('').show();
    jQuery('#status_pemenuhan_kebutuhan').val('').show();
    jQuery('#status_kehidupan_rumah_tangga').val('').show();
    jQuery('#status_kepersertaan_program_bansos').val('').show();
    jQuery('#status_dtks').val('').show();
    jQuery('#rekomendasi_pendata_lama').val('').show();
    jQuery('#keterangan_lainnya_lama').val('').show();
    jQuery('#rekomendasi_pendata').val('').show();
    jQuery('#keterangan_lainnya').val('').show();
    jQuery('#tahun_anggaran').val('').show();
    jQuery('#lampiran').val('').show();
    jQuery('#file_lampiran_existing').hide();
    jQuery('#file_lampiran_existing').closest('.form-group').find('input').show();
    jQuery('#modalTambahDataLansia').modal('show');
}

function submitDataLansia(){
    var id_data = jQuery('#id_data').val();
    var nama = jQuery('#nama').val();
    if(nama == ''){
        return alert('Data Nama tidak boleh kosong!');
    }
    var nik = jQuery('#nik').val();
    if(nik == ''){
        return alert('Data NIK tidak boleh kosong!');
    }
    var tanggal_lahir = jQuery('#tanggal_lahir').val();
    if(tanggal_lahir == ''){
        return alert('Data Tanggal Lahir tidak boleh kosong!');
    }
    var provinsi = jQuery('#provinsi').val();
    if(provinsi == ''){
        return alert('Data Provinsi tidak boleh kosong!');
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
    var alamat = jQuery('#alamat').val();
    if(alamat == ''){
        return alert('Data Alamat tidak boleh kosong!');
    }
    var usia = jQuery('#usia').val();
    if(usia == ''){
        return alert('Data Usia tidak boleh kosong!');
    }
    var dokumen_kependudukan = jQuery('#dokumen_kependudukan').val();
    if(dokumen_kependudukan == ''){
        return alert('Data Dokumen Kependudukan tidak boleh kosong!');
    }
    var status_tempat_tinggal = jQuery('#status_tempat_tinggal').val();
    if(status_tempat_tinggal == ''){
        return alert('Data status Tempat Tinggal tidak boleh kosong!');
    }
    var status_pemenuhan_kebutuhan = jQuery('#status_pemenuhan_kebutuhan').val();
    if(status_pemenuhan_kebutuhan == ''){
        return alert('Data status Pemenuhan Kebutuhan tidak boleh kosong!');
    }
    var status_kehidupan_rumah_tangga = jQuery('#status_kehidupan_rumah_tangga').val();
    if(status_kehidupan_rumah_tangga == ''){
        return alert('Data status Kehidupan Rumah Tangga tidak boleh kosong!');
    }
    var status_dtks = jQuery('#status_dtks').val();
    if(status_dtks == ''){
        return alert('Data status DTKS tidak boleh kosong!');
    }
    var status_kepersertaan_program_bansos = jQuery('#status_kepersertaan_program_bansos').val();
    if(status_kepersertaan_program_bansos == ''){
        return alert('Data status Kepersertaan Program Bansos tidak boleh kosong!');
    }
    var rekomendasi_pendata_lama = jQuery('#rekomendasi_pendata_lama').val();
    if(rekomendasi_pendata_lama == ''){
        return alert('Data rekomendasi Pendata Lama tidak boleh kosong!');
    }
    var rekomendasi_pendata = jQuery('#rekomendasi_pendata').val();
    if(rekomendasi_pendata == ''){
        return alert('Data rekomendasi Pendata tidak boleh kosong!');
    }
    var keterangan_lainnya_lama = jQuery('#keterangan_lainnya_lama').val();
    if(keterangan_lainnya_lama == ''){
        return alert('Data keterangan Lainnya Lama tidak boleh kosong!');
    }
    var keterangan_lainnya = jQuery('#keterangan_lainnya').val();
    if(keterangan_lainnya == ''){
        return alert('Data keterangan Lainnya tidak boleh kosong!');
    }
    var tahun_anggaran = jQuery('#tahun_anggaran').val();
    if(tahun_anggaran == ''){
        return alert('Data Tahun Anggaran tidak boleh kosong!');
    }
    var lampiran = jQuery('#lampiran')[0].files[0];
    if (id_data == '') {
        if (typeof lampiran == 'undefined') {
            return alert('Upload file lampiran dulu!');
        }
    }
    
    let tempData = new FormData();
        tempData.append('action', 'tambah_data_lansia');
        tempData.append('api_key', '<?php echo get_option(SIKS_APIKEY); ?>');
        tempData.append('id_data', id_data);
        tempData.append('nama', nama);
        tempData.append('nik', nik);
        tempData.append('tanggal_lahir', tanggal_lahir);
        tempData.append('provinsi', provinsi);
        tempData.append('kabkot', kabkot);
        tempData.append('kecamatan', kecamatan);
        tempData.append('desa', desa);
        tempData.append('alamat', alamat);
        tempData.append('usia', usia);
        tempData.append('dokumen_kependudukan', dokumen_kependudukan);
        tempData.append('status_kehidupan_rumah_tangga', status_kehidupan_rumah_tangga);
        tempData.append('status_dtks', status_dtks);
        tempData.append('status_kepersertaan_program_bansos', status_kepersertaan_program_bansos);
        tempData.append('keterangan_lainnya_lama', keterangan_lainnya_lama);
        tempData.append('rekomendasi_pendata', rekomendasi_pendata);
        tempData.append('keterangan_lainnya', keterangan_lainnya);
        tempData.append('status_tempat_tinggal', status_tempat_tinggal);
        tempData.append('status_pemenuhan_kebutuhan', status_pemenuhan_kebutuhan);
        tempData.append('rekomendasi_pendata_lama', rekomendasi_pendata_lama);
        tempData.append('tahun_anggaran', tahun_anggaran);
   
    if (typeof lampiran != 'undefined') {
            tempData.append('lampiran', lampiran);
    }
    tempData.append('lampiran', lampiran);

    jQuery('#wrap-loading').show();
    jQuery.ajax({
        method: 'post',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        dataType: 'json',
        data: tempData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(res) {
            alert(res.message);
            if (res.status == 'success') {
                jQuery('#modalTambahDataLansia').modal('hide');
                get_data_lansia();
            }   
            jQuery('#wrap-loading').hide();
        }
    });
}
</script>