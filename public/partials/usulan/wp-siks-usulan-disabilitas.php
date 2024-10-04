<?php
$input = shortcode_atts(array(
    'id_desa' => ''
), $atts);
if (empty($input['id_desa'])) {
    die('id_desa kosong');
}

$validate_user = $this->user_authorization($input['id_desa']);
if ($validate_user['status'] === 'error') {
    die($validate_user['message']);
} else {
    echo "<script>console.log('Debug Objects: " . $validate_user['message'] . "' );</script>";
}
global $wpdb;
$center = $this->get_center();
$maps_all = $this->get_polygon();

// auto input alamat
$provinsi  = get_option(SIKS_PROV);
$kabkot    = get_option(SIKS_KABKOT);

$get_desa_kel  = $wpdb->get_row(
    $wpdb->prepare('
        SELECT 
            is_kel,
            nama
        FROM data_alamat_siks
        WHERE id_desa = %d
          AND active = 1
    ', $input['id_desa']),
    ARRAY_A
);

if ($get_desa_kel['is_kel'] == 1) {
    $nama_desa_kelurahan = 'Kelurahan ' . $get_desa_kel['nama'];
} else {
    $nama_desa_kelurahan = 'Desa ' . $get_desa_kel['nama'];
}

foreach ($maps_all as $i => $desa) {
    $html = '
        <table>
    ';
    foreach ($desa['data'] as $k => $v) {
        $html .= '
            <tr>
                <td><b>' . $k . '</b></td>
                <td>' . $v . '</td></a>
            </tr>
        ';
    }
    $html .= '</table>';
    $maps_all[$i]['html'] = $html;
}

?>
<style type="text/css">
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<div class="pb-4 mb-5">
    <h1 class="text-center my-4">Data Usulan Penderita Disabilitas</h1>
    <h2 class="text-center my-4"><?php echo strtoupper($nama_desa_kelurahan); ?></h2>
    <?php if ($validate_user['roles'] === 'desa'): ?>
        <div class="m-4">
            <button class="btn btn-primary" onclick="showModalTambahData();">
                <span class="dashicons dashicons-plus"></span> Tambah Data
            </button>
        </div>
    <?php endif; ?>
</div>
<div class="wrap-table m-4">
    <table id="tableData">
        <thead>
            <tr>
                <th class="text-center">Status Verifikasi</th>
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
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="modalTambahData" tabindex="-1" role="dialog" aria-labelledby="modalTambahData" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulmodalTambahData">Tambah Data Usulan Disabilitas</h5>
                <h5 class="modal-title" id="judulmodalEdit">Edit Usulan Disabilitas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data">

                <!-- Informasi Pribadi Section -->
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Informasi Pribadi</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tahun Anggaran</label>
                            <input type="text" class="form-control" id="tahunAnggaran" name="tahunAnggaran">
                        </div>
                        <div class="form-group">
                            <label>Dokumen Kewarganegaraan</label>
                            <input type="text" class="form-control" id="dokumenKewarganegaraan" name="dokumenKewarganegaraan">
                        </div>
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik">
                        </div>
                        <div class="form-group">
                            <label>Nomor Kartu Keluarga</label>
                            <input type="text" class="form-control" id="nomorKK" name="nomorKK">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                    </div>
                </div>

                <!-- Alamat Section -->
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Alamat</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Provinsi</label>
                                <input type="text" class="form-control" id="provinsi" name="provinsi" value="<?php echo $provinsi; ?>" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Kabupaten / Kota</label>
                                <input type="text" class="form-control" id="kabkot" name="kabkot" value="<?php echo $kabkot; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?php echo strtoupper($validate_user['kecamatan']); ?>" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Desa</label>
                                <input type="text" class="form-control" id="desa" name="desa" value="<?php echo strtoupper($validate_user['desa']); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>RT</label>
                                <input type="text" class="form-control" id="rt" name="rt">
                            </div>
                            <div class="form-group col-md-6">
                                <label>RW</label>
                                <input type="text" class="form-control" id="rw" name="rw">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Pribadi Section -->
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Data Pribadi</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempatLahir" name="tempatLahir">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Gender</label>
                                <input type="text" class="form-control" id="gender" name="gender">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <input type="text" class="form-control" id="status" name="status">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>No Handphone</label>
                                <input type="text" class="form-control" id="noHp" name="noHp">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Pendidikan Terakhir</label>
                                <input type="text" class="form-control" id="pendidikanTerakhir" name="pendidikanTerakhir">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama Sekolah</label>
                                <input type="text" class="form-control" id="namaSekolah" name="namaSekolah">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Keterangan Lulus</label>
                                <input type="text" class="form-control" id="keteranganLulus" name="keteranganLulus">
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Informasi Disabilitas Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Informasi Disabilitas</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Disabilitas</label>
                                    <input type="text" class="form-control" id="jenisDisabilitas" name="jenisDisabilitas">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Keterangan Disabilitas</label>
                                    <input type="text" class="form-control" id="keteranganDisabilitas" name="keteranganDisabilitas">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sebab Disabilitas</label>
                                    <input type="text" class="form-control" id="sebabDisabilitas" name="sebabDisabilitas">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Diagnosa Medis</label>
                                    <input type="text" class="form-control" id="diagnosaMedis" name="diagnosaMedis">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Penyakit Lain</label>
                                    <input type="text" class="form-control" id="penyakitLain" name="penyakitLain">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tempat Pengobatan</label>
                                    <input type="text" class="form-control" id="tempatPengobatan" name="tempatPengobatan">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Perawat</label>
                                    <input type="text" class="form-control" id="perawat" name="perawat">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aktivitas dan Alat Bantu Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Aktivitas dan Alat Bantu</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Aktivitas</label>
                                    <input type="text" class="form-control" id="aktivitas" name="aktivitas">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Aktivitas Bantuan</label>
                                    <input type="text" class="form-control" id="aktivitasBantuan" name="aktivitasBantuan">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Perlu Bantu</label>
                                    <input type="text" class="form-control" id="perluBantu" name="perluBantu">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Alat Bantu</label>
                                    <input type="text" class="form-control" id="alatBantu" name="alatBantu">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Alat yang Dimiliki</label>
                                    <input type="text" class="form-control" id="alatYangDimiliki" name="alatYangDimiliki">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kondisi Alat</label>
                                    <input type="text" class="form-control" id="kondisiAlat" name="kondisiAlat">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jamkes Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Jaminan Kesehatan dan Sosial</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jaminan Kesehatan</label>
                                    <input type="text" class="form-control" id="jaminanKesehatan" name="jaminanKesehatan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cara Menggunakan Jamkes</label>
                                    <input type="text" class="form-control" id="caraMenggunakanJamkes" name="caraMenggunakanJamkes">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jaminan Sosial</label>
                                    <input type="text" class="form-control" id="jaminanSosial" name="jaminanSosial">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Pekerjaan Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Pekerjaan</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lokasiBekerja">Lokasi Bekerja</label>
                                    <input type="text" class="form-control" id="lokasiBekerja" name="lokasiBekerja">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alasanTidakBekerja">Alasan Tidak Bekerja</label>
                                    <input type="text" class="form-control" id="alasanTidakBekerja" name="alasanTidakBekerja">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pendapatanBulan">Pendapatan Bulan</label>
                                    <input type="text" class="form-control" id="pendapatanBulan" name="pendapatanBulan">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pengeluaranBulan">Pengeluaran Bulan</label>
                                    <input type="text" class="form-control" id="pengeluaranBulan" name="pengeluaranBulan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pendapatanLain">Pendapatan Lain</label>
                                    <input type="text" class="form-control" id="pendapatanLain" name="pendapatanLain">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="minatKerja">Minat Kerja</label>
                                    <input type="text" class="form-control" id="minatKerja" name="minatKerja">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keterampilan">Keterampilan</label>
                                    <input type="text" class="form-control" id="keterampilan" name="keterampilan">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pelatihanYangDiikuti">Pelatihan yang Diikuti</label>
                                    <input type="text" class="form-control" id="pelatihanYangDiikuti" name="pelatihanYangDiikuti">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pelatihanYangDiminat">Pelatihan yang Diminat</label>
                                    <input type="text" class="form-control" id="pelatihanYangDiminat" name="pelatihanYangDiminat">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Rumah Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Status Rumah</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="statusRumah">Status Rumah</label>
                                    <input type="text" class="form-control" id="statusRumah" name="statusRumah">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lantai">Lantai</label>
                                    <input type="text" class="form-control" id="lantai" name="lantai">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kamarMandi">Kamar Mandi</label>
                                    <input type="text" class="form-control" id="kamarMandi" name="kamarMandi">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wc">WC</label>
                                    <input type="text" class="form-control" id="wc" name="wc">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="aksesKeLingkungan">Akses ke Lingkungan</label>
                                    <input type="text" class="form-control" id="aksesKeLingkungan" name="aksesKeLingkungan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dinding">Dinding</label>
                                    <input type="text" class="form-control" id="dinding" name="dinding">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="saranaAir">Sarana Air</label>
                                    <input type="text" class="form-control" id="saranaAir" name="saranaAir">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="penerangan">Penerangan</label>
                                    <input type="text" class="form-control" id="penerangan" name="penerangan">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendidikan Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Pendidikan</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desaPaud">Desa Paud</label>
                                    <input type="text" class="form-control" id="desaPaud" name="desaPaud">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tkDiDesa">TK di Desa</label>
                                    <input type="text" class="form-control" id="tkDiDesa" name="tkDiDesa">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kecamatanSlb">Kecamatan SLB</label>
                                    <input type="text" class="form-control" id="kecamatanSlb" name="kecamatanSlb">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sdMenerimaAbk">SD Menerima ABK</label>
                                    <input type="text" class="form-control" id="sdMenerimaAbk" name="sdMenerimaAbk">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="smpMenerimaAbk">SMP Menerima ABK</label>
                                    <input type="text" class="form-control" id="smpMenerimaAbk" name="smpMenerimaAbk">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Layanan Kesehatan Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Layanan Kesehatan</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="layananKesehatan">Layanan Kesehatan</label>
                                    <input type="text" class="form-control" id="layananKesehatan" name="layananKesehatan">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jumlahPosyandu">Jumlah Posyandu</label>
                                    <input type="text" class="form-control" id="jumlahPosyandu" name="jumlahPosyandu">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="kaderPosyandu">Kader Posyandu</label>
                                    <input type="text" class="form-control" id="kaderPosyandu" name="kaderPosyandu">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Kegiatan Sosial PD Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Kegiatan Sosial PD</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sosialitasKeTetangga">Sosialitas ke Tetangga</label>
                                    <input type="text" class="form-control" id="sosialitasKeTetangga" name="sosialitasKeTetangga">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keterlibatanBerorganisasi">Keterlibatan Berorganisasi</label>
                                    <input type="text" class="form-control" id="keterlibatanBerorganisasi" name="keterlibatanBerorganisasi">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kegiatanKemasyarakatan">Kegiatan Kemasyarakatan</label>
                                    <input type="text" class="form-control" id="kegiatanKemasyarakatan" name="kegiatanKemasyarakatan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keterlibatanMusrembang">Keterlibatan Musrembang</label>
                                    <input type="text" class="form-control" id="keterlibatanMusrembang" name="keterlibatanMusrembang">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alat Bantu PD Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Alat Bantu PD</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="alatBantuBantuan">Alat Bantu Bantuan</label>
                                    <input type="text" class="form-control" id="alatBantuBantuan" name="alatBantuBantuan">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="asalAlatBantu">Asal Alat Bantu</label>
                                    <input type="text" class="form-control" id="asalAlatBantu" name="asalAlatBantu">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="tahunPemberian">Tahun Pemberian</label>
                                    <input type="text" class="form-control" id="tahunPemberian" name="tahunPemberian">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bantuanUep">Bantuan UEP</label>
                                    <input type="text" class="form-control" id="bantuanUep" name="bantuanUep">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="asalUep">Asal UEP</label>
                                    <input type="text" class="form-control" id="asalUep" name="asalUep">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tahunUep">Tahun UEP</label>
                                    <input type="text" class="form-control" id="tahunUep" name="tahunUep">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Lainnya</label>
                            <textarea class="form-control" id="lainnyaUep" name="lainnyaUep"></textarea>
                        </div>
                    </div>
                </div>

                <!--rehabilitasi Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Rehabilitasi PD</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Rehabilitas</label>
                                    <input type="text" class="form-control" id="rehabilitas" name="rehabilitas">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Lokasi Rehabilitas</label>
                                    <input type="text" class="form-control" id="lokasiRehabilitas" name="lokasiRehabilitas">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tahun Rehabilitas</label>
                                    <input type="text" class="form-control" id="tahunRehabilitas" name="tahunRehabilitas">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--prestasi Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Prestasi dan Keahlian PD</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Keahlian Khusus</label>
                                    <input type="text" class="form-control" id="keahlianKhusus" name="keahlianKhusus">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Prestasi</label>
                                    <input type="text" class="form-control" id="prestasi" name="prestasi">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- kontak wali Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Kontak Wali dan Hubungan dengan PD</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Perawat Wali</label>
                                    <input type="text" class="form-control" id="namaPerawatWali" name="namaPerawatWali">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hubungan Dengan PD</label>
                                    <input type="text" class="form-control" id="hubunganDenganPD" name="hubunganDenganPD">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Handphone PD</label>
                                    <input type="text" class="form-control" id="nomorHpPd" name="nomorHpPd">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kelayakan</label>
                                    <input type="text" class="form-control" id="kelayakan" name="kelayakan">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Koordinat Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Koordinat dan Peta</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="latitude">Koordinat Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="0" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="longitude">Koordinat Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" placeholder="0" disabled>
                            </div>
                        </div>
                        <div class="form-row mt-4">
                            <div class="col-md-12">
                                <label for="map-canvas-siks">Map</label>
                                <div style="height:600px; width: 100%;" id="map-canvas-siks"></div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Lampiran Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <strong>Lampiran</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Lampiran</label>
                            <input type="file" name="file" class="form-control-file" id="lampiran" accept="application/pdf, .png, .jpg, .jpeg">
                            <div style="padding-top: 10px; padding-bottom: 10px;"><a id="file_lampiran_existing"></a></div>
                        </div>
                        <div>
                            <small>Upload file maksimal 1 Mb, berformat .pdf .png .jpg .jpeg</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" onclick="submitData()" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
        </form>
    </div>
</div>


<!-- Modal Verifikasi -->
<div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formVerifikasi">
                    <input type="hidden" name="idDataVerifikasi" id="idDataVerifikasi" value="">
                    <div class="mb-3">
                        <label for="verifikasiStatus" class="form-label">Status Verifikasi</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="verifikasiStatus" id="statusTerima" value="2">
                                <label class="form-check-label" for="statusTerima">Terima</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="verifikasiStatus" id="statusTolak" value="3">
                                <label class="form-check-label" for="statusTolak">Tolak</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="keteranganVerifikasi" class="form-label">Keterangan Verifikasi</label>
                        <textarea class="form-control" id="keteranganVerifikasi" name="keteranganVerifikasi" rows="3" placeholder="diterima/ditolak karena ..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitVerifikasi()">Simpan</button>
            </div>
        </div>
    </div>
</div>


<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>
<script>
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    window.id_desa = <?php echo json_encode($input['id_desa']); ?>;
    window.global_file_upload = "<?php echo SIKS_PLUGIN_URL . 'public/media/disabilitas/'; ?>";
    jQuery(document).ready(function() {
        getDataTable();
    });

    function getDataTable() {
        if (typeof tableWrse === 'undefined') {
            window.tableWrse = jQuery('#tableData').on('preXhr.dt', function(e, settings, data) {
                jQuery("#wrap-loading").show();
            }).DataTable({
                "processing": true,
                "serverSide": true,
                "search": {
                    return: true
                },
                "ajax": {
                    url: ajax.url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'action': 'get_datatable_data_usulan_disabilitas',
                        'api_key': ajax.apikey,
                        'id_desa': id_desa
                    }
                },
                lengthMenu: [
                    [20, 50, 100, -1],
                    [20, 50, 100, "All"]
                ],
                order: [],
                "drawCallback": function(settings) {
                    jQuery("#wrap-loading").hide();
                },
                "columns": [{
                        "data": 'status_data',
                        className: "text-center"
                    },
                    {
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
                    }
                ]
            });
        } else {
            tableWrse.draw();
        }
    }

    function hapus_data(id) {
        let confirmDelete = confirm("Apakah anda yakin akan menghapus data ini?");
        if (confirmDelete) {
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: ajax.url,
                type: 'post',
                data: {
                    'action': 'hapus_data_usulan_disabilitas_by_id',
                    'api_key': ajax.apikey,
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        alert("Berhasil Hapus Data!");
                        getDataTable();
                    } else {
                        alert(`GAGAL! \n${response.message}`);
                    }
                }
            });
        }
    }


    function edit_data(_id) {
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: ajax.url,
            dataType: 'JSON',
            data: {
                'action': 'get_data_usulan_disabilitas_by_id',
                'api_key': ajax.apikey,
                'id': _id,
            },
            success: function(res) {
                // Lokasi Center Map
                if (!res.data.lat || !res.data.lng) {
                    var lokasi_center = new google.maps.LatLng(maps_center_siks['lat'], maps_center_siks['lng']);
                } else {
                    var lokasi_center = new google.maps.LatLng(res.data.lat, res.data.lng);
                }

                if (typeof evm != 'undefined') {
                    evm.setMap(null);
                }

                // Menampilkan Marker
                window.evm = new google.maps.Marker({
                    position: lokasi_center,
                    map,
                    draggable: true,
                    title: 'Lokasi Map'
                });

                window.infoWindow = new google.maps.InfoWindow({
                    content: JSON.stringify(res.data)
                });

                google.maps.event.addListener(evm, 'click', function(event) {
                    infoWindow.setPosition(event.latLng);
                    infoWindow.open(map);
                });

                google.maps.event.addListener(evm, 'mouseup', function(event) {
                    jQuery('input[name="latitude"]').val(event.latLng.lat());
                    jQuery('input[name="longitude"]').val(event.latLng.lng());
                });

                jQuery('#id_data').val(res.data.id);

                jQuery('#tahunAnggaran').val(res.data.tahun_anggaran);
                jQuery('#dokumenKewarganegaraan').val(res.data.dokumen_kewarganegaraan);
                jQuery('#nik').val(res.data.nik);
                jQuery('#nomorKK').val(res.data.nomor_kk);
                jQuery('#nama').val(res.data.nama);
                jQuery('#rt').val(res.data.rt);
                jQuery('#rw').val(res.data.rw);
                jQuery('#tempatLahir').val(res.data.tempat_lahir);
                jQuery('#tanggalLahir').val(res.data.tanggal_lahir);
                jQuery('#gender').val(res.data.gender);
                jQuery('#status').val(res.data.status);
                jQuery('#noHp').val(res.data.no_hp);
                jQuery('#pendidikanTerakhir').val(res.data.pendidikan_terakhir);
                jQuery('#namaSekolah').val(res.data.nama_sekolah);
                jQuery('#keteranganLulus').val(res.data.keterangan_lulus);
                jQuery('#jenisDisabilitas').val(res.data.jenis_disabilitas);
                jQuery('#keteranganDisabilitas').val(res.data.keterangan_disabilitas);
                jQuery('#sebabDisabilitas').val(res.data.sebab_disabilitas);
                jQuery('#diagnosaMedis').val(res.data.diagnosa_medis);
                jQuery('#penyakitLain').val(res.data.penyakit_lain);
                jQuery('#tempatPengobatan').val(res.data.tempat_pengobatan);
                jQuery('#perawat').val(res.data.perawat);
                jQuery('#aktivitas').val(res.data.aktivitas);
                jQuery('#aktivitasBantuan').val(res.data.aktivitas_bantuan);
                jQuery('#perluBantu').val(res.data.perlu_bantu);
                jQuery('#alatBantu').val(res.data.alat_bantu);
                jQuery('#alatYangDimiliki').val(res.data.alat_yang_dimiliki);
                jQuery('#kondisiAlat').val(res.data.kondisi_alat);
                jQuery('#jaminanKesehatan').val(res.data.jaminan_kesehatan);
                jQuery('#caraMenggunakanJamkes').val(res.data.cara_menggunakan_jamkes);
                jQuery('#jaminanSosial').val(res.data.jaminan_sosial);
                jQuery('#pekerjaan').val(res.data.pekerjaan);
                jQuery('#lokasiBekerja').val(res.data.lokasi_bekerja);
                jQuery('#alasanTidakBekerja').val(res.data.alasan_tidak_bekerja);
                jQuery('#pendapatanBulan').val(res.data.pendapatan_bulan);
                jQuery('#pengeluaranBulan').val(res.data.pengeluaran_bulan);
                jQuery('#pendapatanLain').val(res.data.pendapatan_lain);
                jQuery('#minatKerja').val(res.data.minat_kerja);
                jQuery('#keterampilan').val(res.data.keterampilan);
                jQuery('#pelatihanYangDiikuti').val(res.data.pelatihan_yang_diikuti);
                jQuery('#pelatihanYangDiminat').val(res.data.pelatihan_yang_diminat);
                jQuery('#statusRumah').val(res.data.status_rumah);
                jQuery('#lantai').val(res.data.lantai);
                jQuery('#kamarMandi').val(res.data.kamar_mandi);
                jQuery('#wc').val(res.data.wc);
                jQuery('#aksesKeLingkungan').val(res.data.akses_ke_lingkungan);
                jQuery('#dinding').val(res.data.dinding);
                jQuery('#saranaAir').val(res.data.sarana_air);
                jQuery('#penerangan').val(res.data.penerangan);
                jQuery('#desaPaud').val(res.data.desa_paud);
                jQuery('#tkDiDesa').val(res.data.tk_di_desa);
                jQuery('#kecamatanSlb').val(res.data.kecamatan_slb);
                jQuery('#sdMenerimaAbk').val(res.data.sd_menerima_abk);
                jQuery('#smpMenerimaAbk').val(res.data.smp_menerima_abk);
                jQuery('#jumlahPosyandu').val(res.data.jumlah_posyandu);
                jQuery('#kaderPosyandu').val(res.data.kader_posyandu);
                jQuery('#layananKesehatan').val(res.data.layanan_kesehatan);
                jQuery('#sosialitasKeTetangga').val(res.data.sosialitas_ke_tetangga);
                jQuery('#keterlibatanBerorganisasi').val(res.data.keterlibatan_berorganisasi);
                jQuery('#kegiatanKemasyarakatan').val(res.data.kegiatan_kemasyarakatan);
                jQuery('#keterlibatanMusrembang').val(res.data.keterlibatan_musrembang);
                jQuery('#alatBantuBantuan').val(res.data.alat_bantu_bantuan);
                jQuery('#asalAlatBantu').val(res.data.asal_alat_bantu);
                jQuery('#tahunPemberian').val(res.data.tahun_pemberian);
                jQuery('#bantuanUep').val(res.data.bantuan_uep);
                jQuery('#asalUep').val(res.data.asal_uep);
                jQuery('#lainnyaUep').val(res.data.lainnya);
                jQuery('#tahunUep').val(res.data.tahun);
                jQuery('#tahun').val(res.data.tahun);
                jQuery('#lainnya').val(res.data.lainnya);
                jQuery('#rehabilitas').val(res.data.rehabilitas);
                jQuery('#lokasiRehabilitas').val(res.data.lokasi_rehabilitas);
                jQuery('#tahunRehabilitas').val(res.data.tahun_rehabilitas);
                jQuery('#keahlianKhusus').val(res.data.keahlian_khusus);
                jQuery('#prestasi').val(res.data.prestasi);
                jQuery('#namaPerawatWali').val(res.data.nama_perawat_wali);
                jQuery('#hubunganDenganPD').val(res.data.hubungan_dengan_pd);
                jQuery('#nomorHp').val(res.data.nomor_hp);
                jQuery('#kelayakan').val(res.data.kelayakan);
                jQuery('#latitude').val(res.data.lat);
                jQuery('#longitude').val(res.data.lng);
                jQuery('#nomorHpPd').val(res.data.nomor_hp);

                jQuery('#lampiran').val('').show();
                jQuery('#file_lampiran_existing').attr('href', global_file_upload + res.data.file_lampiran).html(res.data.file_lampiran).show();

                jQuery('#judulModalEdit').show();
                jQuery('#judulmodalTambahData').hide();
                jQuery('#modalTambahData').modal('show');
                jQuery('#wrap-loading').hide();
            },
            error: function() {
                jQuery('#wrap-loading').hide();
            }
        });
    }

    function showModalTambahData() {
        let lokasi_center = new google.maps.LatLng(maps_center_siks['lat'], maps_center_siks['lng']);

        if (typeof evm != 'undefined') {
            evm.setMap(null);
        }

        // Menampilkan Marker
        window.evm = new google.maps.Marker({
            position: lokasi_center,
            map,
            draggable: true,
            title: 'Lokasi Map'
        });

        google.maps.event.addListener(evm, 'mouseup', function(event) {
            jQuery('input[name="latitude"]').val(event.latLng.lat());
            jQuery('input[name="longitude"]').val(event.latLng.lng());
        });

        jQuery('#longitude').val(maps_center_siks['lng']).show();
        jQuery('#latitude').val(maps_center_siks['lat']).show();

        jQuery('#id_data').val('');

        const inputIds = [
            'tahunAnggaran', 'dokumenKewarganegaraan', 'nik', 'nomorKK', 'nama', 'rt', 'rw',
            'tempatLahir', 'tanggalLahir', 'gender', 'status', 'noHp',
            'pendidikanTerakhir', 'namaSekolah', 'keteranganLulus',
            'jenisDisabilitas', 'keteranganDisabilitas', 'sebabDisabilitas',
            'diagnosaMedis', 'penyakitLain', 'tempatPengobatan', 'perawat',
            'aktivitas', 'aktivitasBantuan', 'perluBantu', 'alatBantu',
            'alatYangDimiliki', 'kondisiAlat', 'jaminanKesehatan',
            'caraMenggunakanJamkes', 'jaminanSosial', 'pekerjaan',
            'lokasiBekerja','alasanTidakBekerja','pendapatanBulan','pengeluaranBulan',
            'pendapatanLain','minatKerja','keterampilan','pelatihanYangDiikuti', 'pelatihanYangDiminat', 'statusRumah',
            'lantai', 'kamarMandi', 'wc', 'aksesKeLingkungan', 'dinding',
            'saranaAir', 'penerangan', 'desaPaud', 'tkDiDesa',
            'kecamatanSlb', 'sdMenerimaAbk', 'smpMenerimaAbk', 'jumlahPosyandu',
            'kaderPosyandu', 'sosialitasKeTetangga', 'keterlibatanBerorganisasi', 'layananKesehatan',
            'kegiatanKemasyarakatan', 'keterlibatanMusrembang', 'alatBantuBantuan',
            'asalAlatBantu', 'asalUep', 'tahunPemberian', 'bantuanUep', 'tahunUep', 'lainnyaUep',
            'rehabilitas', 'lokasiRehabilitas', 'tahunRehabilitas',
            'keahlianKhusus', 'prestasi', 'namaPerawatWali', 'hubunganDenganPD',
            'nomorHpPd', 'kelayakan', 'latitude', 'longitude'
        ];

        // Clear all input fields
        inputIds.forEach(id => {
            jQuery('#' + id).val('');
        });

        jQuery('#file_lampiran_existing').hide();
        jQuery('#file_lampiran_existing').closest('.form-group').find('input').show();

        jQuery('#judulModalEdit').hide();
        jQuery('#judulmodalTambahData').show();
        jQuery('#modalTambahData').modal('show');
    }

    function showModalVerifikasi(id) {
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: ajax.url,
            dataType: 'JSON',
            data: {
                'action': 'get_status_verifikasi_usulan',
                'api_key': ajax.apikey,
                'id': id,
                'jenis_data': 'disabilitas'
            },
            success: function(res) {
                jQuery('#idDataVerifikasi').val(res.data.id);
                jQuery('#keteranganVerifikasi').text(res.data.keterangan_verifikasi);
                jQuery('input[name="verifikasiStatus"]').prop('checked', false);
                if (res.data.status_data) {
                    switch (res.data.status_data) {
                        case '1':
                            jQuery('input[name="verifikasiStatus"]').prop('checked', false);
                            break;
                        case '2':
                            jQuery('#statusTerima').prop('checked', true);
                            break;
                        case '3':
                            jQuery('#statusTolak').prop('checked', true);
                            break;
                    }
                }
                jQuery('#wrap-loading').hide();
                jQuery('#verifikasiModal').modal('show');
            },
            error: function(e) {
                alert(e.message);
                jQuery('#wrap-loading').hide();
            }
        });
    }

    function submitVerifikasi() {
        const validationRules = {
            'idDataVerifikasi': 'id kosong!',
            'verifikasiStatus': 'Status verifikasi tidak boleh kosong!',
            'keteranganVerifikasi': 'Keterangan verifikasi tidak boleh kosong!',
            // Tambahkan field lain jika diperlukan
        };

        const {
            error,
            data
        } = validateForm(validationRules);
        if (error) {
            return alert(error);
        }

        const tempData = new FormData();
        tempData.append('action', 'submit_verifikasi_usulan');
        tempData.append('api_key', ajax.apikey);
        tempData.append('jenis_data', 'disabilitas');

        for (const [key, value] of Object.entries(data)) {
            tempData.append(key, value);
        }
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: ajax.url,
            dataType: 'JSON',
            data: tempData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(res) {
                alert(res.message);
                jQuery('#wrap-loading').hide();
                jQuery('#verifikasiModal').modal('hide');
                getDataTable();
            },
            error: function(e) {
                alert(e.message);
                jQuery('#wrap-loading').hide();
            }
        });
    }

    function submitUsulan(id) {
        let confirmSubmitUsulan = confirm("Apakah anda yakin akan mensubmit data ini?");
        if (confirmSubmitUsulan) {
            const tempData = new FormData();
            tempData.append('action', 'submit_usulan');
            tempData.append('api_key', ajax.apikey);
            tempData.append('idDataVerifikasi', id);
            tempData.append('jenis_data', 'disabilitas');

            jQuery('#wrap-loading').show();
            jQuery.ajax({
                method: 'post',
                url: ajax.url,
                dataType: 'JSON',
                data: tempData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(res) {
                    alert(res.message);
                    jQuery('#wrap-loading').hide();
                    jQuery('#verifikasiModal').modal('hide');
                    getDataTable();
                },
                error: function(e) {
                    alert(e.message);
                    jQuery('#wrap-loading').hide();
                }
            });
        }
    }

    function submitData() {
        const validationRules = {
            'tahunAnggaran': 'Tahun Anggaran tidak boleh kosong!',
            'dokumenKewarganegaraan': 'Dokumen Kewarganegaraan tidak boleh kosong!',
            'nik': 'NIK tidak boleh kosong!',
            'nomorKK': 'Nomor Kartu Keluarga tidak boleh kosong!',
            'nama': 'Nama tidak boleh kosong!',
            'rt': 'RT tidak boleh kosong!',
            'rw': 'RW tidak boleh kosong!',
            'tempatLahir': 'Tempat Lahir tidak boleh kosong!',
            'tanggalLahir': 'Tanggal Lahir tidak boleh kosong!',
            'gender': 'Gender tidak boleh kosong!',
            'status': 'Status tidak boleh kosong!',
            'noHp': 'Nomor HP tidak boleh kosong!',
            'pendidikanTerakhir': 'Pendidikan Terakhir tidak boleh kosong!',
            'namaSekolah': 'Nama Sekolah tidak boleh kosong!',
            'keteranganLulus': 'Keterangan Lulus tidak boleh kosong!',
            'jenisDisabilitas': 'Jenis Disabilitas tidak boleh kosong!',
            'keteranganDisabilitas': 'Keterangan Disabilitas tidak boleh kosong!',
            'sebabDisabilitas': 'Sebab Disabilitas tidak boleh kosong!',
            'diagnosaMedis': 'Diagnosa Medis tidak boleh kosong!',
            'penyakitLain': 'Penyakit Lain tidak boleh kosong!',
            'tempatPengobatan': 'Tempat Pengobatan tidak boleh kosong!',
            'perawat': 'Perawat tidak boleh kosong!',
            'aktivitas': 'Aktivitas tidak boleh kosong!',
            'aktivitasBantuan': 'Aktivitas Bantuan tidak boleh kosong!',
            'perluBantu': 'Perlu Bantu tidak boleh kosong!',
            'alatBantu': 'Alat Bantu tidak boleh kosong!',
            'alatYangDimiliki': 'Alat yang Dimiliki tidak boleh kosong!',
            'kondisiAlat': 'Kondisi Alat tidak boleh kosong!',
            'jaminanKesehatan': 'Jaminan Kesehatan tidak boleh kosong!',
            'caraMenggunakanJamkes': 'Cara Menggunakan Jamkes tidak boleh kosong!',
            'jaminanSosial': 'Jaminan Sosial tidak boleh kosong!',
            'pelatihanYangDiikuti': 'Pelatihan yang Diikuti tidak boleh kosong!',
            'pelatihanYangDiminat': 'Pelatihan yang Diminat tidak boleh kosong!',
            'statusRumah': 'Status Rumah tidak boleh kosong!',
            'lantai': 'Jumlah Lantai tidak boleh kosong!',
            'kamarMandi': 'Jumlah Kamar Mandi tidak boleh kosong!',
            'wc': 'WC tidak boleh kosong!',
            'aksesKeLingkungan': 'Akses ke Lingkungan tidak boleh kosong!',
            'dinding': 'Dinding tidak boleh kosong!',
            'saranaAir': 'Sarana Air tidak boleh kosong!',
            'penerangan': 'Penerangan tidak boleh kosong!',
            'desaPaud': 'Desa PAUD tidak boleh kosong!',
            'tkDiDesa': 'TK di Desa tidak boleh kosong!',
            'kecamatanSlb': 'Kecamatan SLB tidak boleh kosong!',
            'sdMenerimaAbk': 'SD Menerima ABK tidak boleh kosong!',
            'smpMenerimaAbk': 'SMP Menerima ABK tidak boleh kosong!',
            'jumlahPosyandu': 'Jumlah Posyandu tidak boleh kosong!',
            'kaderPosyandu': 'Kader Posyandu tidak boleh kosong!',
            'sosialitasKeTetangga': 'Sosialitas ke Tetangga tidak boleh kosong!',
            'keterlibatanBerorganisasi': 'Keterlibatan Berorganisasi tidak boleh kosong!',
            'kegiatanKemasyarakatan': 'Kegiatan Kemasyarakatan tidak boleh kosong!',
            'keterlibatanMusrembang': 'Keterlibatan Musrembang tidak boleh kosong!',
            'alatBantuBantuan': 'Alat Bantu Bantuan tidak boleh kosong!',
            'asalAlatBantu': 'Asal Alat Bantu tidak boleh kosong!',
            'tahunPemberian': 'Tahun Pemberian tidak boleh kosong!',
            'bantuanUep': 'Bantuan UEP tidak boleh kosong!',
            'rehabilitas': 'Rehabilitas tidak boleh kosong!',
            'lokasiRehabilitas': 'Lokasi Rehabilitas tidak boleh kosong!',
            'tahunRehabilitas': 'Tahun Rehabilitas tidak boleh kosong!',
            'keahlianKhusus': 'Keahlian Khusus tidak boleh kosong!',
            'prestasi': 'Prestasi tidak boleh kosong!',
            'namaPerawatWali': 'Nama Perawat Wali tidak boleh kosong!',
            'hubunganDenganPD': 'Hubungan dengan Penerima Disabilitas tidak boleh kosong!',
            'nomorHpPd': 'Nomor HP Penerima Disabilitas tidak boleh kosong!',
            'kelayakan': 'Kelayakan tidak boleh kosong!',
            'latitude': 'Latitude tidak boleh kosong!',
            'longitude': 'Longitude tidak boleh kosong!',
            'pekerjaan' : 'Pekerjaan tidak boleh kosong',
            'lokasiBekerja' : 'lokasi bekerja tidak boleh kosong',
            'alasanTidakBekerja' : 'Alasan Tidak Bekerja tidak boleh kosong',
            'pendapatanBulan' : 'Pendapatan Bulanan tidak boleh kosong',
            'pengeluaranBulan' : 'Pengeluaran Bulanan tidak boleh kosong',
            'pendapatanLain' : 'Pendapatan Lain tidak boleh kosong',
            'minatKerja' : 'Minat Kerja tidak boleh kosong',
            'keterampilan' : 'Keterampilan tidak boleh kosong',
            'lainnyaUep' : 'Lainnya UEP tidak boleh kosong',
            'tahunUep' : 'Tahun UEP tidak boleh kosong',
            'asalUep' : 'Asal UEP tidak boleh kosong',
            'layananKesehatan' : 'Layanan Kesehatan tidak boleh kosong'
        };

        const {
            error,
            data
        } = validateForm(validationRules);
        if (error) {
            return alert(error);
        }

        const id_data = jQuery('#id_data').val();

        const lampiran = jQuery('#lampiran')[0].files[0];
        if (id_data == '') {
            if (typeof lampiran == 'undefined') {
                return alert('Upload file lampiran dulu!');
            }
        }

        const tempData = new FormData();
        tempData.append('action', 'tambah_data_usulan_disabilitas');
        tempData.append('api_key', ajax.apikey);
        tempData.append('id_data', id_data);
        tempData.append('id_desa', id_desa);

        if (typeof lampiran != 'undefined') {
            tempData.append('lampiran', lampiran);
        }

        for (const [key, value] of Object.entries(data)) {
            tempData.append(key, value);
        }

        jQuery('#wrap-loading').show();

        jQuery.ajax({
            method: 'post',
            url: ajax.url,
            dataType: 'json',
            data: tempData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(res) {
                alert(res.message);
                jQuery('#wrap-loading').hide();
                if (res.status === 'success') {
                    jQuery('#modalTambahData').modal('hide');
                    getDataTable();
                }
            }
        });
    }
</script>