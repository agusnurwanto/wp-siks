<?php
$api_key = get_option(SIKS_APIKEY);
$url = admin_url('admin-ajax.php');
$center = $this->get_center();
$maps_all = $this->get_polygon();

?>
<style type="text/css">
    .wrap-table {
        overflow: auto;
        max-height: 100vh;
        width: 100%;
    }
</style>
<div style="padding: 10px;margin:0 0 3rem 0;">
    <h1 class="text-center" style="margin:3rem;">Manajemen Data Disabilitas</h1>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="tambah_data_disabilitas();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableManajemenDisabilitas" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Nomor Kartu Keluarga</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Kabupaten / Kota</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Desa</th>
                    <th class="text-center">RT</th>
                    <th class="text-center">RW</th>
                    <th class="text-center">Tempat Lahir</th>
                    <th class="text-center">Tanggal Lahir</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Dokumen Kewarganegaraan</th>
                    <th class="text-center">No Handphone</th>
                    <th class="text-center">Pendidikan Terakhir</th>
                    <th class="text-center">Nama Sekolah</th>
                    <th class="text-center">Keterangan Lulus</th>
                    <th class="text-center">jenis disabilitas</th>
                    <th class="text-center">Keterangan Disabilitas</th>
                    <th class="text-center">Sebab Disabilitas</th>
                    <th class="text-center">Diagnosa Medis</th>
                    <th class="text-center">Penyakit Lain</th>
                    <th class="text-center">Tempat Pengobatan</th>
                    <th class="text-center">Perawat</th>
                    <th class="text-center">Aktivitas</th>
                    <th class="text-center">Aktivitas Bantuan</th>
                    <th class="text-center">Perlu Bantu</th>
                    <th class="text-center">Alat Bantu</th>
                    <th class="text-center">Alat yang Dimiliki</th>
                    <th class="text-center">Kondisi Alat</th>
                    <th class="text-center">Jaminan Kesehatan</th>
                    <th class="text-center">Cara Menggunakan Jamkes</th>
                    <th class="text-center">Jaminan Sosial</th>
                    <th class="text-center">Pekerjaan</th>
                    <th class="text-center">Lokasi Bekerja</th>
                    <th class="text-center">Alasan Tidak Bekerja</th>
                    <th class="text-center">Pendapatan Bulan</th>
                    <th class="text-center">Pengeluaran Bulan</th>
                    <th class="text-center">Pendapatan Lain</th>
                    <th class="text-center">Minat Kerja</th>
                    <th class="text-center">Keterampilan</th>
                    <th class="text-center">Pelatihan yang Diikuti</th>
                    <th class="text-center">Pelatihan yang Diminat</th>
                    <th class="text-center">Status Rumah</th>
                    <th class="text-center">Lantai</th>
                    <th class="text-center">Kamar Mandi</th>
                    <th class="text-center">WC</th>
                    <th class="text-center">Akses ke Lingkungan</th>
                    <th class="text-center">Dinding</th>
                    <th class="text-center">Sarana Air</th>
                    <th class="text-center">Penerangan</th>
                    <th class="text-center">Desa PAUD</th>
                    <th class="text-center">TK di Desa</th>
                    <th class="text-center">Kecamatan SLB</th>
                    <th class="text-center">SD Menerima ABK</th>
                    <th class="text-center">SMP Menerima ABK</th>
                    <th class="text-center">Jumlah Posyandu</th>
                    <th class="text-center">Kader Posyandu</th>
                    <th class="text-center">Layanan Kesehatan</th>
                    <th class="text-center">Sosialitas ke Tetangga</th>
                    <th class="text-center">Keterlibatan Berorganisasi</th>
                    <th class="text-center">Kegiatan Kemasyarakatan</th>
                    <th class="text-center">Keterlibatan Musrembang</th>
                    <th class="text-center">Alat Bantu Bantuan</th>
                    <th class="text-center">Asal Alat Bantu</th>
                    <th class="text-center">Tahun Pemberian</th>
                    <th class="text-center">Bantuan UEP</th>
                    <th class="text-center">Asal UEP</th>
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Lainnya</th>
                    <th class="text-center">Rehabilitas</th>
                    <th class="text-center">Lokasi Rehabilitas</th>
                    <th class="text-center">Tahun Rehabilitas</th>
                    <th class="text-center">Keahlian Khusus</th>
                    <th class="text-center">Prestasi</th>
                    <th class="text-center">Nama Perawat Wali</th>
                    <th class="text-center">Hubungan Dengan PD</th>
                    <th class="text-center">Nomor Handphone PD</th>
                    <th class="text-center">Kelayakan</th>
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
<div class="modal fade mt-4" id="modalTambahDataDisabilitas" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataDisabilitasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataDisabilitasLabel">Tambah Data Disabilitas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data" placeholder=''>
                <div class="form-group">
                    <label>Tahun Anggaran</label>
                    <input type="text" class="form-control" id="tahun_anggaran">
                </div>
                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" class="form-control" id="nik">
                </div>
                <div class="form-group">
                    <label>Nomor Kartu Keluarga</label>
                    <input type="text" class="form-control" id="nomor_kk">
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
                    <label>RT</label>
                    <input type="text" class="form-control" id="rt">
                </div>
                <div class="form-group">
                    <label>RW</label>
                    <input type="text" class="form-control" id="rw">
                </div>
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="text" class="form-control" id="tanggal_lahir">
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <input type="text" class="form-control" id="gender">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" id="status">
                </div>
                    <div class="form-group">
                    <label>Dokumen Kewarganegaraan</label>
                    <input type="text" class="form-control" id="dokumen_kewarganegaraan">
                </div>
                <div class="form-group">
                    <label>No Handphone</label>
                    <input type="text" class="form-control" id="no_hp">
                </div> 
                <div class="form-group">
                    <label>Pendidikan Terakhir</label>
                    <input type="text" class="form-control" id="pendidikan_terakhir">
                </div> 
                <div class="form-group">
                    <label>Nama Sekolah</label>
                    <input type="text" class="form-control" id="nama_sekolah">
                </div>
                <div class="form-group">
                    <label>Keterangan Lulus</label>
                    <input type="text" class="form-control" id="keterangan_lulus">
                </div>
                <div class="form-group">
                    <label>jenis disabilitas</label>
                    <input type="text" class="form-control" id="jenis_disabilitas">
                </div>                   
                <div class="form-group">
                    <label>Keterangan Disabilitas</label>
                    <input type="text" class="form-control" id="keterangan_disabilitas">
                </div>
                <div class="form-group">
                    <label>Sebab Disabilitas</label>
                    <input type="text" class="form-control" id="sebab_disabilitas">
                </div>
                <div class="form-group">
                    <label>Diagnosa Medis</label>
                    <input type="text" class="form-control" id="diagnosa_medis">
                </div>
                <div class="form-group">
                    <label>Penyakit Lain</label>
                    <input type="text" class="form-control" id="penyakit_lain">
                </div>
                <div class="form-group">
                    <label>Tempat Pengobatan</label>
                    <input type="text" class="form-control" id="tempat_pengobatan">
                </div>
                <div class="form-group">
                    <label>Perawat</label>
                    <input type="text" class="form-control" id="perawat">
                </div>
                <div class="form-group">
                    <label>Aktivitas</label>
                    <input type="text" class="form-control" id="aktivitas">
                </div>
                <div class="form-group">
                    <label>Aktivitas Bantuan</label>
                    <input type="text" class="form-control" id="aktivitas_bantuan">
                </div>
                <div class="form-group">
                    <label>Perlu Bantu</label>
                    <input type="text" class="form-control" id="perlu_bantu">
                </div>
                <div class="form-group">
                    <label>Alat Bantu</label>
                    <input type="text" class="form-control" id="alat_bantu">
                </div>
                <div class="form-group">
                    <label>Alat yang Dimiliki</label>
                    <input type="text" class="form-control" id="alat_yang_dimiliki">
                </div>
                <div class="form-group">
                    <label>Kondisi Alat</label>
                    <input type="text" class="form-control" id="kondisi_alat">
                </div>
                <div class="form-group">
                    <label>Jaminan Kesehatan</label>
                    <input type="text" class="form-control" id="jaminan_kesehatan">
                </div>
                <div class="form-group">
                    <label>Cara Menggunakan Jamkes</label>
                    <input type="text" class="form-control" id="cara_menggunakan_jamkes">
                </div>
                <div class="form-group">
                    <label>Jaminan Sosial</label>
                    <input type="text" class="form-control" id="jaminan_sosial">
                </div>
                <div class="form-group">
                    <label>Pekerjaan</label>
                    <input type="text" class="form-control" id="pekerjaan">
                </div>
                <div class="form-group">
                    <label>Lokasi Bekerja</label>
                    <input type="text" class="form-control" id="lokasi_bekerja">
                </div>
                <div class="form-group">
                    <label>Alasan Tidak Bekerja</label>
                    <input type="text" class="form-control" id="alasan_tidak_bekerja">
                </div>
                <div class="form-group">
                    <label>Pendapatan Bulan</label>
                    <input type="text" class="form-control" id="pendapatan_bulan">
                </div>
                <div class="form-group">
                    <label>Pengeluaran Bulan</label>
                    <input type="text" class="form-control" id="pengeluaran_bulan">
                </div>
                <div class="form-group">
                    <label>Pendapatan Lain</label>
                    <input type="text" class="form-control" id="pendapatan_lain">
                </div>
                <div class="form-group">
                    <label>Minat Kerja</label>
                    <input type="text" class="form-control" id="minat_kerja">
                </div>
                <div class="form-group">
                    <label>Keterampilan</label>
                    <input type="text" class="form-control" id="keterampilan">
                </div>
                <div class="form-group">
                    <label>Pelatihan yang Diikuti</label>
                    <input type="text" class="form-control" id="pelatihan_yang_diikuti">
                </div>
                <div class="form-group">
                    <label>Pelatihan yang Diminat</label>
                    <input type="text" class="form-control" id="pelatihan_yang_diminat">
                </div>
                <div class="form-group">
                    <label>Status Rumah</label>
                    <input type="text" class="form-control" id="status_rumah">
                </div>
                <div class="form-group">
                    <label>Lantai</label>
                    <input type="text" class="form-control" id="lantai">
                </div>
                <div class="form-group">
                    <label>Kamar Mandi</label>
                    <input type="text" class="form-control" id="kamar_mandi">
                </div>
                <div class="form-group">
                    <label>WC</label>
                    <input type="text" class="form-control" id="wc">
                </div>
                <div class="form-group">
                    <label>Akses ke Lingkungan</label>
                    <input type="text" class="form-control" id="akses_ke_lingkungan">
                </div>
                <div class="form-group">
                    <label>Dinding</label>
                    <input type="text" class="form-control" id="dinding">
                </div>
                <div class="form-group">
                    <label>Sarana Air</label>
                    <input type="text" class="form-control" id="sarana_air">
                </div>
                <div class="form-group">
                    <label>Penerangan</label>
                    <input type="text" class="form-control" id="penerangan">
                </div>
                <div class="form-group">
                    <label>Desa Paud</label>
                    <input type="text" class="form-control" id="desa_paud">
                </div>
                <div class="form-group">
                    <label>TK di Desa</label>
                    <input type="text" class="form-control" id="tk_di_desa">
                </div>
                <div class="form-group">
                    <label>Kecamatan SLB</label>
                    <input type="text" class="form-control" id="kecamatan_slb">
                </div>
                <div class="form-group">
                    <label>SD Menerima ABK</label>
                    <input type="text" class="form-control" id="sd_menerima_abk">
                </div>
                <div class="form-group">
                    <label>SMP Menerima ABK</label>
                    <input type="text" class="form-control" id="smp_menerima_abk">
                </div>
                <div class="form-group">
                    <label>Jumlah Posyandu</label>
                    <input type="text" class="form-control" id="jumlah_posyandu">
                </div>
                <div class="form-group">
                    <label>Kader Posyandu</label>
                    <input type="text" class="form-control" id="kader_posyandu">
                </div>
                <div class="form-group">
                    <label>Layanan Kesehatan</label>
                    <input type="text" class="form-control" id="layanan_kesehatan">
                </div>
                <div class="form-group">
                    <label>Sosialitas ke Tetangga</label>
                    <input type="text" class="form-control" id="sosialitas_ke_tetangga">
                </div>
                <div class="form-group">
                    <label>Keterlibatan Berorganisasi</label>
                    <input type="text" class="form-control" id="keterlibatan_berorganisasi">
                </div>
                <div class="form-group">
                    <label>Kegiatan Kemasyarakatan</label>
                    <input type="text" class="form-control" id="kegiatan_kemasyarakatan">
                </div>
                <div class="form-group">
                    <label>Keterlibatan Musrembang</label>
                    <input type="text" class="form-control" id="keterlibatan_musrembang">
                </div>
                <div class="form-group">
                    <label>Alat Bantu Bantuan</label>
                    <input type="text" class="form-control" id="alat_bantu_bantuan">
                </div>
                <div class="form-group">
                    <label>Asal Alat Bantu</label>
                    <input type="text" class="form-control" id="asal_alat_bantu">
                </div>
                <div class="form-group">
                    <label>Tahun Pemberian</label>
                    <input type="text" class="form-control" id="tahun_pemberian">
                </div>
                <div class="form-group">
                    <label>Bantuan UEP</label>
                    <input type="text" class="form-control" id="bantuan_uep">
                </div>
                <div class="form-group">
                    <label>Asal UEP</label>
                    <input type="text" class="form-control" id="asal_uep">
                </div>
                <div class="form-group">
                    <label>Tahun</label>
                    <input type="text" class="form-control" id="tahun">
                </div>
                <div class="form-group">
                    <label>Lainnya</label>
                    <input type="text" class="form-control" id="lainnya">
                </div>
                <div class="form-group">
                    <label>Rehabilitas</label>
                    <input type="text" class="form-control" id="rehabilitas">
                </div>
                <div class="form-group">
                    <label>Lokasi Rehabilitas</label>
                    <input type="text" class="form-control" id="lokasi_rehabilitas">
                </div>
                <div class="form-group">
                    <label>Tahun Rehabilitas</label>
                    <input type="text" class="form-control" id="tahun_rehabilitas">
                </div>
                <div class="form-group">
                    <label>Keahlian Khusus</label>
                    <input type="text" class="form-control" id="keahlian_khusus">
                </div>
                <div class="form-group">
                    <label>Prestasi</label>
                    <input type="text" class="form-control" id="prestasi">
                </div>
                <div class="form-group">
                    <label>Nama Perawat Wali</label>
                    <input type="text" class="form-control" id="nama_perawat_wali">
                </div>
                <div class="form-group">
                    <label>Hubungan Dengan PD</label>
                    <input type="text" class="form-control" id="hubungan_dengan_pd">
                </div>
                <div class="form-group">
                    <label>Nomor Handphone PD</label>
                    <input type="text" class="form-control" id="nomor_hp">
                </div>
                <div class="form-group">
                    <label>Kelayakan</label>
                    <input type="text" class="form-control" id="kelayakan">
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Koordinat Latitude</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="latitude" placeholder="0" disabled>
                    </div>
                    <label class="col-md-2 col-form-label">Koordinat Longitude</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="longitude" placeholder="0" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Map</label>
                    <div class="col-md-10">
                        <div style="height:600px; width: 100%;" id="map-canvas-siks"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Lampiran</label>
                    <input type="file" name="file" class="form-control-file" id="lampiran" accept="application/pdf, .png, .jpg, .jpeg">
                    <div style="padding-top: 10px; padding-bottom: 10px;"><a id="file_lampiran_existing"></a></div>
                </div>
                <div><small>Upload file maksimal 1 Mb, berformat .pdf .png .jpg .jpeg</small></div>
                <div class="modal-footer">
                    <button type="submit" onclick="submitDataDisabilitas(this);" class="btn btn-primary send_data">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function() {
    get_data_disabilitas();
        window.global_file_upload = "<?php echo SIKS_PLUGIN_URL . 'public/media/disabilitas/'; ?>";
});
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;

function get_data_disabilitas() {
    if (typeof tableDisabilitas === 'undefined') {
        window.tableDisabilitas = jQuery('#tableManajemenDisabilitas').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: '<?php echo $url?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    'action': 'get_datatable_disabilitas',
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
                    "data": 'nomor_kk',
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
                    "data": 'tempat_lahir',
                    className: "text-center"
                },
                {
                    "data": 'tanggal_lahir',
                    className: "text-center"
                },
                {
                    "data": 'gender',
                    className: "text-center"
                },
                {
                    "data": 'status',
                    className: "text-center"
                },
                {
                    "data": 'dokumen_kewarganegaraan',
                    className: "text-center"
                },
                {
                    "data": 'no_hp',
                    className: "text-center"
                },
                {
                    "data": 'pendidikan_terakhir',
                    className: "text-center"
                },
                {
                    "data": 'nama_sekolah',
                    className: "text-center"
                },
                {
                    "data": 'keterangan_lulus',
                    className: "text-center"
                },
                {
                    "data": 'jenis_disabilitas',
                    className: "text-center"
                },
                {
                    "data": 'keterangan_disabilitas',
                    className: "text-center"
                },
                {
                    "data": 'sebab_disabilitas',
                    className: "text-center"
                },
                {
                    "data": 'diagnosa_medis',
                    className: "text-center"
                },
                {
                    "data": 'penyakit_lain',
                    className: "text-center"
                },
                {
                    "data": 'tempat_pengobatan',
                    className: "text-center"
                },
                {
                    "data": 'perawat',
                    className: "text-center"
                },
                {
                    "data": 'aktivitas',
                    className: "text-center"
                },
                {
                    "data": 'aktivitas_bantuan',
                    className: "text-center"
                },
                {
                    "data": 'perlu_bantu',
                    className: "text-center"
                },
                {
                    "data": 'alat_bantu',
                    className: "text-center"
                },
                {
                    "data": 'alat_yang_dimiliki',
                    className: "text-center"
                },
                {
                    "data": 'kondisi_alat',
                    className: "text-center"
                },
                {
                    "data": 'jaminan_kesehatan',
                    className: "text-center"
                },
                {
                    "data": 'cara_menggunakan_jamkes',
                    className: "text-center"
                },
                {
                    "data": 'jaminan_sosial',
                    className: "text-center"
                },
                {
                    "data": 'pekerjaan',
                    className: "text-center"
                },
                {
                    "data": 'lokasi_bekerja',
                    className: "text-center"
                },
                {
                    "data": 'alasan_tidak_bekerja',
                    className: "text-center"
                },
                {
                    "data": 'pendapatan_bulan',
                    className: "text-center"
                },
                {
                    "data": 'pengeluaran_bulan',
                    className: "text-center"
                },
                {
                    "data": 'pendapatan_lain',
                    className: "text-center"
                },
                {
                    "data": 'minat_kerja',
                    className: "text-center"
                },
                {
                    "data": 'keterampilan',
                    className: "text-center"
                },
                {
                    "data": 'pelatihan_yang_diikuti',
                    className: "text-center"
                },
                {
                    "data": 'pelatihan_yang_diminat',
                    className: "text-center"
                },
                {
                    "data": 'status_rumah',
                    className: "text-center"
                },
                {
                    "data": 'lantai',
                    className: "text-center"
                },
                {
                    "data": 'kamar_mandi',
                    className: "text-center"
                },
                {
                    "data": 'wc',
                    className: "text-center"
                },
                {
                    "data": 'akses_ke_lingkungan',
                    className: "text-center"
                },
                {
                    "data": 'dinding',
                    className: "text-center"
                },
                {
                    "data": 'sarana_air',
                    className: "text-center"
                },
                {
                    "data": 'penerangan',
                    className: "text-center"
                },
                {
                    "data": 'desa_paud',
                    className: "text-center"
                },
                {
                    "data": 'tk_di_desa',
                    className: "text-center"
                },
                {
                    "data": 'kecamatan_slb',
                    className: "text-center"
                },
                {
                    "data": 'sd_menerima_abk',
                    className: "text-center"
                },
                {
                    "data": 'smp_menerima_abk',
                    className: "text-center"
                },
                {
                    "data": 'jumlah_posyandu',
                    className: "text-center"
                },
                {
                    "data": 'kader_posyandu',
                    className: "text-center"
                },
                {
                    "data": 'layanan_kesehatan',
                    className: "text-center"
                },
                {
                    "data": 'sosialitas_ke_tetangga',
                    className: "text-center"
                },
                {
                    "data": 'keterlibatan_berorganisasi',
                    className: "text-center"
                },
                {
                    "data": 'kegiatan_kemasyarakatan',
                    className: "text-center"
                },
                {
                    "data": 'keterlibatan_musrembang',
                    className: "text-center"
                },
                {
                    "data": 'alat_bantu_bantuan',
                    className: "text-center"
                },
                {
                    "data": 'asal_alat_bantu',
                    className: "text-center"
                },
                {
                    "data": 'tahun_pemberian',
                    className: "text-center"
                },
                {
                    "data": 'bantuan_uep',
                    className: "text-center"
                },
                {
                    "data": 'asal_uep',
                    className: "text-center"
                },
                {
                    "data": 'tahun',
                    className: "text-center"
                },
                {
                    "data": 'lainnya',
                    className: "text-center"
                },
                {
                    "data": 'rehabilitas',
                    className: "text-center"
                },
                {
                    "data": 'lokasi_rehabilitas',
                    className: "text-center"
                },
                {
                    "data": 'tahun_rehabilitas',
                    className: "text-center"
                },
                {
                    "data": 'keahlian_khusus',
                    className: "text-center"
                },
                {
                    "data": 'prestasi',
                    className: "text-center"
                },
                {
                    "data": 'nama_perawat_wali',
                    className: "text-center"
                },
                {
                    "data": 'hubungan_dengan_pd',
                    className: "text-center"
                },
                {
                    "data": 'nomor_hp',
                    className: "text-center"
                },
                {
                    "data": 'kelayakan',
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
        tableDisabilitas.draw();
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
                    'action' : 'hapus_data_disabilitas_by_id',
                    'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
                    'id'     : id
                },
                dataType: 'json',
                success:function(response){
                    jQuery('#wrap-loading').hide();
                    if(response.status == 'success'){
                        get_data_disabilitas(); 
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
            'action': 'get_data_disabilitas_by_id',
            'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
            'id': _id,
        },
        success: function(res){
            if(res.status == 'success'){
                jQuery('#id_data').val(res.data.id);
                jQuery('#nik').val(res.data.nik);
                jQuery('#nomor_kk').val(res.data.nomor_kk);
                jQuery('#nama').val(res.data.nama);
                jQuery('#provinsi').val(res.data.provinsi);
                jQuery('#kabkot').val(res.data.kabkot);
                jQuery('#kecamatan').val(res.data.kecamatan);
                jQuery('#desa').val(res.data.desa);
                jQuery('#rt').val(res.data.rt);
                jQuery('#rw').val(res.data.rw);
                jQuery('#tempat_lahir').val(res.data.tempat_lahir);
                jQuery('#tanggal_lahir').val(res.data.tanggal_lahir);
                jQuery('#gender').val(res.data.gender);
                jQuery('#status').val(res.data.status);
                jQuery('#dokumen_kewarganegaraan').val(res.data.dokumen_kewarganegaraan);
                jQuery('#no_hp').val(res.data.no_hp);
                jQuery('#pendidikan_terakhir').val(res.data.pendidikan_terakhir);
                jQuery('#nama_sekolah').val(res.data.nama_sekolah);
                jQuery('#keterangan_lulus').val(res.data.keterangan_lulus);
                jQuery('#jenis_disabilitas').val(res.data.jenis_disabilitas);
                jQuery('#keterangan_disabilitas').val(res.data.keterangan_disabilitas);
                jQuery('#sebab_disabilitas').val(res.data.sebab_disabilitas);
                jQuery('#diagnosa_medis').val(res.data.diagnosa_medis);
                jQuery('#penyakit_lain').val(res.data.penyakit_lain);
                jQuery('#tempat_pengobatan').val(res.data.tempat_pengobatan);
                jQuery('#perawat').val(res.data.perawat);
                jQuery('#aktivitas').val(res.data.aktivitas);
                jQuery('#aktivitas_bantuan').val(res.data.aktivitas_bantuan);
                jQuery('#perlu_bantu').val(res.data.perlu_bantu);
                jQuery('#alat_bantu').val(res.data.alat_bantu);
                jQuery('#alat_yang_dimiliki').val(res.data.alat_yang_dimiliki);
                jQuery('#kondisi_alat').val(res.data.kondisi_alat);
                jQuery('#jaminan_kesehatan').val(res.data.jaminan_kesehatan);
                jQuery('#cara_menggunakan_jamkes').val(res.data.cara_menggunakan_jamkes);
                jQuery('#jaminan_sosial').val(res.data.jaminan_sosial);
                jQuery('#pekerjaan').val(res.data.pekerjaan);
                jQuery('#lokasi_bekerja').val(res.data.lokasi_bekerja);
                jQuery('#alasan_tidak_bekerja').val(res.data.alasan_tidak_bekerja);
                jQuery('#pendapatan_bulan').val(res.data.pendapatan_bulan);
                jQuery('#pengeluaran_bulan').val(res.data.pengeluaran_bulan);
                jQuery('#pendapatan_lain').val(res.data.pendapatan_lain);
                jQuery('#minat_kerja').val(res.data.minat_kerja);
                jQuery('#keterampilan').val(res.data.keterampilan);
                jQuery('#pelatihan_yang_diikuti').val(res.data.pelatihan_yang_diikuti);
                jQuery('#pelatihan_yang_diminat').val(res.data.pelatihan_yang_diminat);
                jQuery('#status_rumah').val(res.data.status_rumah);
                jQuery('#lantai').val(res.data.lantai);
                jQuery('#kamar_mandi').val(res.data.kamar_mandi);
                jQuery('#wc').val(res.data.wc);
                jQuery('#akses_ke_lingkungan').val(res.data.akses_ke_lingkungan);
                jQuery('#dinding').val(res.data.dinding);
                jQuery('#sarana_air').val(res.data.sarana_air);
                jQuery('#penerangan').val(res.data.penerangan);
                jQuery('#desa_paud').val(res.data.desa_paud);
                jQuery('#tk_di_desa').val(res.data.tk_di_desa);
                jQuery('#kecamatan_slb').val(res.data.kecamatan_slb);
                jQuery('#sd_menerima_abk').val(res.data.sd_menerima_abk);
                jQuery('#smp_menerima_abk').val(res.data.smp_menerima_abk);
                jQuery('#jumlah_posyandu').val(res.data.jumlah_posyandu);
                jQuery('#kader_posyandu').val(res.data.kader_posyandu);
                jQuery('#layanan_kesehatan').val(res.data.layanan_kesehatan);
                jQuery('#sosialitas_ke_tetangga').val(res.data.sosialitas_ke_tetangga);
                jQuery('#keterlibatan_berorganisasi').val(res.data.keterlibatan_berorganisasi);
                jQuery('#kegiatan_kemasyarakatan').val(res.data.kegiatan_kemasyarakatan);
                jQuery('#keterlibatan_musrembang').val(res.data.keterlibatan_musrembang);
                jQuery('#alat_bantu_bantuan').val(res.data.alat_bantu_bantuan);
                jQuery('#asal_alat_bantu').val(res.data.asal_alat_bantu);
                jQuery('#tahun_pemberian').val(res.data.tahun_pemberian);
                jQuery('#bantuan_uep').val(res.data.bantuan_uep);
                jQuery('#asal_uep').val(res.data.asal_uep);
                jQuery('#tahun').val(res.data.tahun);
                jQuery('#lainnya').val(res.data.lainnya);
                jQuery('#rehabilitas').val(res.data.rehabilitas);
                jQuery('#lokasi_rehabilitas').val(res.data.lokasi_rehabilitas);
                jQuery('#tahun_rehabilitas').val(res.data.tahun_rehabilitas);
                jQuery('#keahlian_khusus').val(res.data.keahlian_khusus);
                jQuery('#prestasi').val(res.data.prestasi);
                jQuery('#nama_perawat_wali').val(res.data.nama_perawat_wali);
                jQuery('#hubungan_dengan_pd').val(res.data.hubungan_dengan_pd);
                jQuery('#nomor_hp').val(res.data.nomor_hp);
                jQuery('#kelayakan').val(res.data.kelayakan);
                jQuery('#tahun_anggaran').val(res.data.tahun_anggaran);
                jQuery('#file_lampiran_existing').attr('href', global_file_upload + res.data.file_lampiran).html(res.data.file_lampiran);
                jQuery('#lampiran').val('').show();
                jQuery('#modalTambahDataDisabilitas .send_data').show();
                jQuery('#modalTambahDataDisabilitas').modal('show');
            }else{
                alert(res.message);
            }
            jQuery('#wrap-loading').hide();
        }
    });
}

function tambah_data_disabilitas() {
    jQuery('#nama').val('').show();
    jQuery('#gender').val('').show();
    jQuery('#tempat_lahir').val('').show();
    jQuery('#tanggal_lahir').val('').show();
    jQuery('#status').val('').show();
    jQuery('#dokumen_kewarganegaraan').val('').show();
    jQuery('#nik').val('').show();
    jQuery('#nomor_kk').val('').show();
    jQuery('#rt').val('').show();
    jQuery('#rw').val('').show();
    jQuery('#desa').val('').show();
    jQuery('#provinsi').val('').show();
    jQuery('#kabkot').val('').show();
    jQuery('#kecamatan').val('').show();
    jQuery('#no_hp').val('').show();
    jQuery('#pendidikan_terakhir').val('').show();
    jQuery('#nama_sekolah').val('').show();
    jQuery('#keterangan_lulus').val('').show();
    jQuery('#jenis_disabilitas').val('').show();
    jQuery('#keterangan_disabilitas').val('').show();
    jQuery('#sebab_disabilitas').val('').show();
    jQuery('#diagnosa_medis').val('').show();
    jQuery('#penyakit_lain').val('').show();
    jQuery('#tempat_pengobatan').val('').show();
    jQuery('#perawat').val('').show();
    jQuery('#aktivitas').val('').show();
    jQuery('#aktivitas_bantuan').val('').show();
    jQuery('#perlu_bantu').val('').show();
    jQuery('#alat_bantu').val('').show();
    jQuery('#alat_yang_dimiliki').val('').show();
    jQuery('#kondisi_alat').val('').show();
    jQuery('#jaminan_kesehatan').val('').show();
    jQuery('#cara_menggunakan_jamkes').val('').show();
    jQuery('#jaminan_sosial').val('').show();
    jQuery('#pekerjaan').val('').show();
    jQuery('#lokasi_bekerja').val('').show();
    jQuery('#alasan_tidak_bekerja').val('').show();
    jQuery('#pendapatan_bulan').val('').show();
    jQuery('#pengeluaran_bulan').val('').show();
    jQuery('#pendapatan_lain').val('').show();
    jQuery('#minat_kerja').val('').show();
    jQuery('#keterampilan').val('').show();
    jQuery('#pelatihan_yang_diikuti').val('').show();
    jQuery('#pelatihan_yang_diminat').val('').show();
    jQuery('#status_rumah').val('').show();
    jQuery('#lantai').val('').show();
    jQuery('#kamar_mandi').val('').show();
    jQuery('#wc').val('').show();
    jQuery('#akses_ke_lingkungan').val('').show();
    jQuery('#dinding').val('').show();
    jQuery('#sarana_air').val('').show();
    jQuery('#penerangan').val('').show();
    jQuery('#desa_paud').val('').show();
    jQuery('#tk_di_desa').val('').show();
    jQuery('#kecamatan_slb').val('').show();
    jQuery('#sd_menerima_abk').val('').show();
    jQuery('#smp_menerima_abk').val('').show();
    jQuery('#jumlah_posyandu').val('').show();
    jQuery('#kader_posyandu').val('').show();
    jQuery('#layanan_kesehatan').val('').show();
    jQuery('#sosialitas_ke_tetangga').val('').show();
    jQuery('#keterlibatan_berorganisasi').val('').show();
    jQuery('#kegiatan_kemasyarakatan').val('').show();
    jQuery('#keterlibatan_musrembang').val('').show();
    jQuery('#alat_bantu_bantuan').val('').show();
    jQuery('#asal_alat_bantu').val('').show();
    jQuery('#tahun_pemberian').val('').show();
    jQuery('#bantuan_uep').val('').show();
    jQuery('#asal_uep').val('').show();
    jQuery('#tahun').val('').show();
    jQuery('#lainnya').val('').show();
    jQuery('#rehabilitas').val('').show();
    jQuery('#lokasi_rehabilitas').val('').show();
    jQuery('#tahun_rehabilitas').val('').show();
    jQuery('#keahlian_khusus').val('').show();
    jQuery('#prestasi').val('').show();
    jQuery('#nama_perawat_wali').val('').show();
    jQuery('#hubungan_dengan_pd').val('').show();
    jQuery('#nomor_hp').val('').show();
    jQuery('#kelayakan').val('').show();
    jQuery('#tahun_anggaran').val('').show();
    jQuery('#lampiran').html('');

    jQuery('#file_lampiran_existing').hide();
    jQuery('#file_lampiran_existing').closest('.form-group').find('input').show();
    jQuery('#modalTambahDataDisabilitas').modal('show');
}

function submitDataDisabilitas(that) {
var id_data = jQuery('#id_data').val();
var nama = jQuery('#nama').val();
if(nama == ''){
    return alert('Data Nama tidak boleh kosong!');
}
var gender = jQuery('#gender').val();
if(gender == ''){
    return alert('Data Gender tidak boleh kosong!');
}
var tempat_lahir = jQuery('#tempat_lahir').val();
if(tempat_lahir == ''){
    return alert('Data Tempat Lahir tidak boleh kosong!');
}
var tanggal_lahir = jQuery('#tanggal_lahir').val();
if(tanggal_lahir == ''){
    return alert('Data Tanggal Lahir tidak boleh kosong!');
}
var status = jQuery('#status').val();
if(status == ''){
    return alert('Data Status tidak boleh kosong!');
}
var dokumen_kewarganegaraan = jQuery('#dokumen_kewarganegaraan').val();
if(dokumen_kewarganegaraan == ''){
    return alert('Data Dokumen Kewarganegaraan tidak boleh kosong!');
}
var nik = jQuery('#nik').val();
if(nik == ''){
    return alert('Data NIK tidak boleh kosong!');
}
var nomor_kk = jQuery('#nomor_kk').val();
if(nomor_kk == ''){
    return alert('Data Nomor Kartu Keluarga tidak boleh kosong!');
}
var rt = jQuery('#rt').val();
if(rt == ''){
    return alert('Data RT tidak boleh kosong!');
}
var rw = jQuery('#rw').val();
if(rw == ''){
    return alert('Data RW tidak boleh kosong!');
}
var desa = jQuery('#desa').val();
if(desa == ''){
    return alert('Data Desa tidak boleh kosong!');
}
var kecamatan = jQuery('#kecamatan').val();
if(kecamatan == ''){
    return alert('Data Kecamatan tidak boleh kosong!');
}
var kabkot = jQuery('#kabkot').val();
if(kabkot == ''){
    return alert('Data Kabupaten / Kota tidak boleh kosong!');
}
var provinsi = jQuery('#provinsi').val();
if(provinsi == ''){
    return alert('Data Provinsi tidak boleh kosong!');
}
var no_hp = jQuery('#no_hp').val();
if(no_hp == ''){
    return alert('Data No Handphone tidak boleh kosong!');
}
var pendidikan_terakhir = jQuery('#pendidikan_terakhir').val();
if(pendidikan_terakhir == ''){
    return alert('Data Pendidikan Terakhir tidak boleh kosong!');
}
var nama_sekolah = jQuery('#nama_sekolah').val();
if(nama_sekolah == ''){
    return alert('Data Nama Sekolah tidak boleh kosong!');
}
var keterangan_lulus = jQuery('#keterangan_lulus').val();
if(keterangan_lulus == ''){
    return alert('Data Keterangan Lulus tidak boleh kosong!');
}
var jenis_disabilitas = jQuery('#jenis_disabilitas').val();
if(jenis_disabilitas == ''){
    return alert('Data jenis disabilitas tidak boleh kosong!');
}
var keterangan_disabilitas = jQuery('#keterangan_disabilitas').val();
if(keterangan_disabilitas == ''){
    return alert('Data Keterangan Disabilitas tidak boleh kosong!');
}
var sebab_disabilitas = jQuery('#sebab_disabilitas').val();
if(sebab_disabilitas == ''){
    return alert('Data Sebab Disabilitas tidak boleh kosong!');
}
var diagnosa_medis = jQuery('#diagnosa_medis').val();
if(diagnosa_medis == ''){
    return alert('Data Diagnosa Medis tidak boleh kosong!');
}
var penyakit_lain = jQuery('#penyakit_lain').val();
if(penyakit_lain == ''){
    return alert('Data Penyakit Lain tidak boleh kosong!');
}
var tempat_pengobatan = jQuery('#tempat_pengobatan').val();
if(tempat_pengobatan == ''){
    return alert('Data Tempat Pengobatan tidak boleh kosong!');
}
var perawat = jQuery('#perawat').val();
if(perawat == ''){
    return alert('Data Perawat tidak boleh kosong!');
}
var aktivitas = jQuery('#aktivitas').val();
if(aktivitas == ''){
    return alert('Data Aktivitas tidak boleh kosong!');
}
var aktivitas_bantuan = jQuery('#aktivitas_bantuan').val();
if(aktivitas_bantuan == ''){
    return alert('Data Aktivitas Bantuan tidak boleh kosong!');
}
var perlu_bantu = jQuery('#perlu_bantu').val();
if(perlu_bantu == ''){
    return alert('Data Perlu Bantu tidak boleh kosong!');
}
var alat_bantu = jQuery('#alat_bantu').val();
if(alat_bantu == ''){
    return alert('Data Alat Bantu tidak boleh kosong!');
}
var alat_yang_dimiliki = jQuery('#alat_yang_dimiliki').val();
if(alat_yang_dimiliki == ''){
    return alert('Data Alat yang Dimiliki tidak boleh kosong!');
}
var kondisi_alat = jQuery('#kondisi_alat').val();
if(kondisi_alat == ''){
    return alert('Data Kondisi Alat tidak boleh kosong!');
}
var jaminan_kesehatan = jQuery('#jaminan_kesehatan').val();
if(jaminan_kesehatan == ''){
    return alert('Data Jaminan Kesehatan tidak boleh kosong!');
}
var cara_menggunakan_jamkes = jQuery('#cara_menggunakan_jamkes').val();
if(cara_menggunakan_jamkes == ''){
    return alert('Data Cara Menggunakan Jamkes tidak boleh kosong!');
}
var jaminan_sosial = jQuery('#jaminan_sosial').val();
if(jaminan_sosial == ''){
    return alert('Data Jaminan Sosial tidak boleh kosong!');
}
var pekerjaan = jQuery('#pekerjaan').val();
if(pekerjaan == ''){
    return alert('Data Pekerjaan tidak boleh kosong!');
}
var lokasi_bekerja = jQuery('#lokasi_bekerja').val();
if(lokasi_bekerja == ''){
    return alert('Data Lokasi Bekerja tidak boleh kosong!');
}
var alasan_tidak_bekerja = jQuery('#alasan_tidak_bekerja').val();
if(alasan_tidak_bekerja == ''){
    return alert('Data Alasan Tidak Bekerja tidak boleh kosong!');
}
var pendapatan_bulan = jQuery('#pendapatan_bulan').val();
if(pendapatan_bulan == ''){
    return alert('Data Pendapatan Bulan tidak boleh kosong!');
}
var pengeluaran_bulan = jQuery('#pengeluaran_bulan').val();
if(pengeluaran_bulan == ''){
    return alert('Data Pengeluaran Bulan tidak boleh kosong!');
}
var pendapatan_lain = jQuery('#pendapatan_lain').val();
if(pendapatan_lain == ''){
    return alert('Data Pendapatan Lain tidak boleh kosong!');
}
var minat_kerja = jQuery('#minat_kerja').val();
if(minat_kerja == ''){
    return alert('Data Minat Kerja tidak boleh kosong!');
}
var keterampilan = jQuery('#keterampilan').val();
if(keterampilan == ''){
    return alert('Data Keterampilan tidak boleh kosong!');
}
var pelatihan_yang_diikuti = jQuery('#pelatihan_yang_diikuti').val();
if(pelatihan_yang_diikuti == ''){
    return alert('Data Pelatihan yang Diikuti tidak boleh kosong!');
}
var pelatihan_yang_diminat = jQuery('#pelatihan_yang_diminat').val();
if(pelatihan_yang_diminat == ''){
    return alert('Data Pelatihan yang Diminat tidak boleh kosong!');
}
var status_rumah = jQuery('#status_rumah').val();
if(status_rumah == ''){
    return alert('Data Status Rumah tidak boleh kosong!');
}
var lantai = jQuery('#lantai').val();
if(lantai == ''){
    return alert('Data Lantai tidak boleh kosong!');
}
var kamar_mandi = jQuery('#kamar_mandi').val();
if(kamar_mandi == ''){
    return alert('Data Kamar Mandi tidak boleh kosong!');
}
var wc = jQuery('#wc').val();
if(wc == ''){
    return alert('Data WC tidak boleh kosong!');
}
var akses_ke_lingkungan = jQuery('#akses_ke_lingkungan').val();
if(akses_ke_lingkungan == ''){
    return alert('Data Akses ke Lingkungan tidak boleh kosong!');
}
var dinding = jQuery('#dinding').val();
if(dinding == ''){
    return alert('Data Dinding tidak boleh kosong!');
}
var sarana_air = jQuery('#sarana_air').val();
if(sarana_air == ''){
    return alert('Data Sarana Air tidak boleh kosong!');
}
var penerangan = jQuery('#penerangan').val();
if(penerangan == ''){
    return alert('Data Penerangan tidak boleh kosong!');
}
var desa_paud = jQuery('#desa_paud').val();
if(desa_paud == ''){
    return alert('Data Desa PAUD tidak boleh kosong!');
}
var tk_di_desa = jQuery('#tk_di_desa').val();
if(tk_di_desa == ''){
    return alert('Data TK di Desa tidak boleh kosong!');
}
var kecamatan_slb = jQuery('#kecamatan_slb').val();
if(kecamatan_slb == ''){
    return alert('Data Kecamatan SLB tidak boleh kosong!');
}
var sd_menerima_abk = jQuery('#sd_menerima_abk').val();
if(sd_menerima_abk == ''){
    return alert('Data SD Menerima ABK tidak boleh kosong!');
}
var smp_menerima_abk = jQuery('#smp_menerima_abk').val();
if(smp_menerima_abk == ''){
    return alert('Data SMP Menerima ABK tidak boleh kosong!');
}
var jumlah_posyandu = jQuery('#jumlah_posyandu').val();
if(jumlah_posyandu == ''){
    return alert('Data Jumlah Posyandu tidak boleh kosong!');
}
var kader_posyandu = jQuery('#kader_posyandu').val();
if(kader_posyandu == ''){
    return alert('Data Kader Posyandu tidak boleh kosong!');
}
var layanan_kesehatan = jQuery('#layanan_kesehatan').val();
if(layanan_kesehatan == ''){
    return alert('Data Layanan Kesehatan tidak boleh kosong!');
}
var sosialitas_ke_tetangga = jQuery('#sosialitas_ke_tetangga').val();
if(sosialitas_ke_tetangga == ''){
    return alert('Data Sosialitas ke Tetangga tidak boleh kosong!');
}
var keterlibatan_berorganisasi = jQuery('#keterlibatan_berorganisasi').val();
if(keterlibatan_berorganisasi == ''){
    return alert('Data Keterlibatan Berorganisasi tidak boleh kosong!');
}
var kegiatan_kemasyarakatan = jQuery('#kegiatan_kemasyarakatan').val();
if(kegiatan_kemasyarakatan == ''){
    return alert('Data Kegiatan Kemasyarakatan tidak boleh kosong!');
}
var keterlibatan_musrembang = jQuery('#keterlibatan_musrembang').val();
if(keterlibatan_musrembang == ''){
    return alert('Data Keterlibatan Musrembang tidak boleh kosong!');
}
var alat_bantu_bantuan = jQuery('#alat_bantu_bantuan').val();
if(alat_bantu_bantuan == ''){
    return alert('Data Alat Bantu Bantuan tidak boleh kosong!');
}
var asal_alat_bantu = jQuery('#asal_alat_bantu').val();
if(asal_alat_bantu == ''){
    return alert('Data Asal Alat Bantu tidak boleh kosong!');
}
var tahun_pemberian = jQuery('#tahun_pemberian').val();
if(tahun_pemberian == ''){
    return alert('Data Tahun Pemberian tidak boleh kosong!');
}
var bantuan_uep = jQuery('#bantuan_uep').val();
if(bantuan_uep == ''){
    return alert('Data Bantuan UEP tidak boleh kosong!');
}
var asal_uep = jQuery('#asal_uep').val();
if(asal_uep == ''){
    return alert('Data Asal UEP tidak boleh kosong!');
}
var tahun = jQuery('#tahun').val();
if(tahun == ''){
    return alert('Data Tahun tidak boleh kosong!');
}
var lainnya = jQuery('#lainnya').val();
if(lainnya == ''){
    return alert('Data Lainnya tidak boleh kosong!');
}
var rehabilitas = jQuery('#rehabilitas').val();
if(rehabilitas == ''){
    return alert('Data Rehabilitas tidak boleh kosong!');
}
var lokasi_rehabilitas = jQuery('#lokasi_rehabilitas').val();
if(lokasi_rehabilitas == ''){
    return alert('Data Lokasi Rehabilitas tidak boleh kosong!');
}
var tahun_rehabilitas = jQuery('#tahun_rehabilitas').val();
if(tahun_rehabilitas == ''){
    return alert('Data Tahun Rehabilitas tidak boleh kosong!');
}
var keahlian_khusus = jQuery('#keahlian_khusus').val();
if(keahlian_khusus == ''){
    return alert('Data Keahlian Khusus tidak boleh kosong!');
}
var prestasi = jQuery('#prestasi').val();
if(prestasi == ''){
    return alert('Data Prestasi tidak boleh kosong!');
}
var nama_perawat_wali = jQuery('#nama_perawat_wali').val();
if(nama_perawat_wali == ''){
    return alert('Data Nama Perawat Wali tidak boleh kosong!');
}
var hubungan_dengan_pd = jQuery('#hubungan_dengan_pd').val();
if(hubungan_dengan_pd == ''){
    return alert('Data Hubungan Dengan PD tidak boleh kosong!');
}
var nomor_hp = jQuery('#nomor_hp').val();
if(nomor_hp == ''){
    return alert('Data Nomor Handphone PD tidak boleh kosong!');
}
var kelayakan = jQuery('#kelayakan').val();
if(kelayakan == ''){
    return alert('Data Kelayakan tidak boleh kosong!');
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
    tempData.append('action', 'tambah_data_disabilitas');
    tempData.append('api_key', '<?php echo get_option(SIKS_APIKEY); ?>');
    tempData.append('id_data', id_data);
    tempData.append('nama', nama);
    tempData.append('gender', gender);
    tempData.append('tempat_lahir', tempat_lahir);
    tempData.append('tanggal_lahir', tanggal_lahir);
    tempData.append('status', status);
    tempData.append('dokumen_kewarganegaraan', dokumen_kewarganegaraan);
    tempData.append('nik', nik);
    tempData.append('nomor_kk', nomor_kk);
    tempData.append('rt', rt);
    tempData.append('rw', rw);
    tempData.append('desa', desa);
    tempData.append('kecamatan', kecamatan);
    tempData.append('kabkot', kabkot);
    tempData.append('provinsi', provinsi);
    tempData.append('no_hp', no_hp);
    tempData.append('pendidikan_terakhir', pendidikan_terakhir);
    tempData.append('nama_sekolah', nama_sekolah);
    tempData.append('keterangan_lulus', keterangan_lulus);
    tempData.append('jenis_disabilitas', jenis_disabilitas);
    tempData.append('keterangan_disabilitas', keterangan_disabilitas);
    tempData.append('sebab_disabilitas', sebab_disabilitas);
    tempData.append('diagnosa_medis', diagnosa_medis);
    tempData.append('penyakit_lain', penyakit_lain);
    tempData.append('tempat_pengobatan', tempat_pengobatan);
    tempData.append('perawat', perawat);
    tempData.append('aktivitas', aktivitas);
    tempData.append('aktivitas_bantuan', aktivitas_bantuan);
    tempData.append('perlu_bantu', perlu_bantu);
    tempData.append('alat_bantu', alat_bantu);
    tempData.append('alat_yang_dimiliki', alat_yang_dimiliki);
    tempData.append('kondisi_alat', kondisi_alat);
    tempData.append('jaminan_kesehatan', jaminan_kesehatan);
    tempData.append('cara_menggunakan_jamkes', cara_menggunakan_jamkes);
    tempData.append('jaminan_sosial', jaminan_sosial);
    tempData.append('pekerjaan', pekerjaan);
    tempData.append('lokasi_bekerja', lokasi_bekerja);
    tempData.append('alasan_tidak_bekerja', alasan_tidak_bekerja);
    tempData.append('pendapatan_bulan', pendapatan_bulan);
    tempData.append('pengeluaran_bulan', pengeluaran_bulan);
    tempData.append('pendapatan_lain', pendapatan_lain);
    tempData.append('minat_kerja', minat_kerja);
    tempData.append('keterampilan', keterampilan);
    tempData.append('pelatihan_yang_diikuti', pelatihan_yang_diikuti);
    tempData.append('pelatihan_yang_diminat', pelatihan_yang_diminat);
    tempData.append('status_rumah', status_rumah);
    tempData.append('lantai', lantai);
    tempData.append('kamar_mandi', kamar_mandi);
    tempData.append('wc', wc);
    tempData.append('akses_ke_lingkungan', akses_ke_lingkungan);
    tempData.append('dinding', dinding);
    tempData.append('sarana_air', sarana_air);
    tempData.append('penerangan', penerangan);
    tempData.append('desa_paud', desa_paud);
    tempData.append('tk_di_desa', tk_di_desa);
    tempData.append('kecamatan_slb', kecamatan_slb);
    tempData.append('sd_menerima_abk', sd_menerima_abk);
    tempData.append('smp_menerima_abk', smp_menerima_abk);
    tempData.append('jumlah_posyandu', jumlah_posyandu);
    tempData.append('kader_posyandu', kader_posyandu);
    tempData.append('layanan_kesehatan', layanan_kesehatan);
    tempData.append('sosialitas_ke_tetangga', sosialitas_ke_tetangga);
    tempData.append('keterlibatan_berorganisasi', keterlibatan_berorganisasi);
    tempData.append('kegiatan_kemasyarakatan', kegiatan_kemasyarakatan);
    tempData.append('keterlibatan_musrembang', keterlibatan_musrembang);
    tempData.append('alat_bantu_bantuan', alat_bantu_bantuan);
    tempData.append('asal_alat_bantu', asal_alat_bantu);
    tempData.append('tahun_pemberian', tahun_pemberian);
    tempData.append('bantuan_uep', bantuan_uep);
    tempData.append('asal_uep', asal_uep);
    tempData.append('tahun', tahun);
    tempData.append('lainnya', lainnya);
    tempData.append('rehabilitas', rehabilitas);
    tempData.append('lokasi_rehabilitas', lokasi_rehabilitas);
    tempData.append('tahun_rehabilitas', tahun_rehabilitas);
    tempData.append('keahlian_khusus', keahlian_khusus);
    tempData.append('prestasi', prestasi);
    tempData.append('nama_perawat_wali', nama_perawat_wali);
    tempData.append('hubungan_dengan_pd', hubungan_dengan_pd);
    tempData.append('nomor_hp', nomor_hp);
    tempData.append('kelayakan', kelayakan);
    tempData.append('tahun_anggaran', tahun_anggaran);
    // "latitude": jQuery('input[name="latitude"]').val();
    // "longitude": jQuery('input[name="longitude"]').val();

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
                jQuery('#modalTambahDataDisabilitas').modal('hide');
                get_data_disabilitas();
            }   
            jQuery('#wrap-loading').hide();
        }
    });
}
</script>

