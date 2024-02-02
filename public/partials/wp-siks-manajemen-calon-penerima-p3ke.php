<?php
global $wpdb;
$api_key = get_option(SIKS_APIKEY);
$url = admin_url('admin-ajax.php');

$terdaftar = $wpdb->get_row('
    SELECT COUNT(data_calon_p3ke_siks.id) as jml 
    FROM `data_calon_p3ke_siks`
    INNER JOIN data_p3ke_siks
        ON data_p3ke_siks.nik=data_calon_p3ke_siks.nik_kk
        AND data_p3ke_siks.active=1
    WHERE data_calon_p3ke_siks.active=1', ARRAY_A);

$calon_terdaftar = $wpdb->get_row('
    SELECT COUNT(id) as jml 
    FROM `data_calon_p3ke_siks`
    WHERE active=1', ARRAY_A);

$jumlah_terdaftar = $terdaftar['jml'];
$jumlah_calon_terdaftar = $calon_terdaftar['jml'];
$jumlah_tidak_terdaftar = $calon_terdaftar['jml'] - $terdaftar['jml'];
?>
<style type="text/css">
    .wrap-table {
        overflow: auto;
        max-height: 100vh;
        width: 100%;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<div style="padding: 10px;margin:0 0 3rem 0;">
    <h1 class="text-center" style="margin:3rem;">Manajemen Data Calon Penerima P3KE</h1>
    <h2 class="text-center">Total Calon Penerima P3KE <?php echo number_format($jumlah_calon_terdaftar); ?> Orang</h2>
    <h2 class="text-center">Jumlah Terdaftar P3KE <?php echo number_format($jumlah_terdaftar); ?> Orang</h2>
    <h2 class="text-center">Jumlah Belum Terdaftar P3KE <?php echo number_format($jumlah_tidak_terdaftar); ?> Orang</h2>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="tambah_data_calon_p3ke();"><i class="dashicons dashicons-plus"></i>Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableManajemenCalonPenerimaCalonP3KE" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Status P3KE</th>
                    <th class="text-center">NIK KK</th>
                    <th class="text-center">NIK PKK</th>
                    <th class="text-center">Nama KK</th>
                    <th class="text-center">Nama PKK</th>
                    <th class="text-center">Nama Anak</th>
                    <th class="text-center">NIK Anak</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Nama RT</th>
                    <th class="text-center">Nama RW</th>
                    <th class="text-center">Desa/Kelurahan</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Kab/Kot</th>
                    <th class="text-center">District</th>
                    <th class="text-center">Sumber</th>
                    <th class="text-center">Desil P3KE</th>
                    <th class="text-center">Latitude</th>
                    <th class="text-center">Longitude</th>
                    <th class="text-center">Tahun Anggaran</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade mt-4" id="modalTambahDataCalonP3KE" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataCalonP3KE" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulModalTambahDataCalonP3KE">Tambah Data Calon P3KE</h5>
                <h5 class="modal-title" id="judulModalEditDataCalonP3KE">Edit Data Calon P3KE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data" placeholder=''>
                <div class="form-group">
                    <label>Tahun Anggaran</label>
                    <input type="number" class="form-control" id="tahun_anggaran" placeholder="Masukkan Tahun Anggaran">
                </div>
                <div class="form-group">
                    <label>NIK KK</label>
                    <input type="number" class="form-control" min="16" max="16" id="nik_kk" placeholder="Masukkan NIK KK">
                </div>
                <div class="form-group">
                    <label>NIK PKK</label>
                    <input type="number" class="form-control" min="16" max="16" id="nik_pkk" placeholder="Masukkan NIK PKK">
                </div>
                <div class="form-group">
                    <label>Nama KK</label>
                    <input type="text" class="form-control" id="nama_kk" placeholder="Masukkan Nama KK">
                </div>
                <div class="form-group">
                    <label>Nama PKK</label>
                    <input type="text" class="form-control" id="nama_pkk" placeholder="Masukkan Nama PKK">
                </div>
                <div class="form-group">
                    <label>Nama Anak</label>
                    <input type="text" class="form-control" id="nama_anak" placeholder="Masukkan Nama Anak">
                </div>
                <div class="form-group">
                    <label>NIK Anak</label>
                    <input type="number" class="form-control" min="16" max="16" id="nik_anak" placeholder="Masukkan NIK Anak">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control" id="alamat" placeholder="Masukkan Alamat">
                </div>
                <div class="form-group">
                    <label>Nama RT</label>
                    <input type="text" class="form-control" id="nama_rt" placeholder="Masukkan Nama RT">
                </div>
                <div class="form-group">
                    <label>Nama RW</label>
                    <input type="text" class="form-control" id="nama_rw" placeholder="Masukkan Nama RW">
                </div>
                <div class="form-group">
                    <label>Desa/Kelurahan</label>
                    <input type="text" class="form-control" id="desa_kelurahan" placeholder="Masukkan Desa/Kelurahan">
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <input type="text" class="form-control" id="kecamatan" placeholder="Masukkan Kecamatan">
                </div>
                <div class="form-group">
                    <label>Kabupaten/Kota</label>
                    <input type="text" class="form-control" id="kabkot" placeholder="Masukkan Kab/Kot">
                </div>
                <div class="form-group">
                    <label>District</label>
                    <input type="text" class="form-control" id="district" placeholder="Masukkan District">
                </div>
                <div class="form-group">
                    <label>Sumber</label>
                    <input type="text" class="form-control" id="sumber" placeholder="Masukkan Sumber">
                </div>
                <div class="form-group">
                    <label>Desil P3KE</label>
                    <input type="text" class="form-control" id="desil_p3ke" placeholder="Masukkan Desil P3KE">
                </div>
                <div class="form-group">
                    <label>Latitude</label>
                    <input type="text" class="form-control" id="lat" placeholder="Masukkan Latitude">
                </div>
                <div class="form-group">
                    <label>Longitude</label>
                    <input type="text" class="form-control" id="lng" placeholder="Masukkan Longitude">
                </div>
                <div class="modal-footer">
                    <button type="submit" onclick="submitDataCalonP3KE(this);" class="btn btn-primary send_data">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function() {
            get_data_calon_p3ke();
        });

        function get_data_calon_p3ke() {
            if (typeof tableCalonP3KE === 'undefined') {
                window.tableCalonP3KE = jQuery('#tableManajemenCalonPenerimaCalonP3KE').on('preXhr.dt', function(e, settings, data) {
                    jQuery("#wrap-loading").show();
                }).DataTable({
                    "processing": true,
                    "serverSide": true,
                    "search": {
                        return: true
                    },
                    "ajax": {
                        url: '<?php echo $url; ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'action': 'get_datatable_calon_p3ke',
                            'api_key': '<?php echo $api_key; ?>',
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
                            "data": 'status_p3ke',
                            className: "text-center"
                        }, {
                            "data": 'nik_kk',
                            className: "text-center"
                        },
                        {
                            "data": 'nik_pkk',
                            className: "text-center"
                        },
                        {
                            "data": 'nama_kk',
                            className: "text-center"
                        },
                        {
                            "data": 'nama_pkk',
                            className: "text-center"
                        },
                        {
                            "data": 'nama_anak',
                            className: "text-center"
                        },
                        {
                            "data": 'nik_anak',
                            className: "text-center"
                        },
                        {
                            "data": 'alamat',
                            className: "text-center"
                        },
                        {
                            "data": 'nama_rt',
                            className: "text-center"
                        },
                        {
                            "data": 'nama_rw',
                            className: "text-center"
                        },
                        {
                            "data": 'desa_kelurahan',
                            className: "text-center"
                        },
                        {
                            "data": 'kecamatan',
                            className: "text-center"
                        },
                        {
                            "data": 'kabkot',
                            className: "text-center"
                        },
                        {
                            "data": 'district',
                            className: "text-center"
                        },
                        {
                            "data": 'sumber',
                            className: "text-center"
                        },
                        {
                            "data": 'desil_p3ke',
                            className: "text-center"
                        },
                        {
                            "data": 'lat',
                            className: "text-center"
                        },
                        {
                            "data": 'lng',
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
                tableCalonP3KE.draw();
            }
        }

        function hapus_data(id) {
            let confirmDelete = confirm("Apakah anda yakin akan menghapus data ini?");
            if (confirmDelete) {
                jQuery('#wrap-loading').show();
                jQuery.ajax({
                    url: '<?php echo $url; ?>',
                    type: 'post',
                    data: {
                        'action': 'hapus_data_calon_p3ke_by_id',
                        'api_key': '<?php echo $api_key; ?>',
                        'id': id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            alert("Berhasil Hapus Data!");
                            get_data_calon_p3ke();
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
                url: '<?php echo $url; ?>',
                dataType: 'JSON',
                data: {
                    'action': 'get_data_calon_p3ke_by_id',
                    'api_key': '<?php echo $api_key; ?>',
                    'id': _id,
                },
                success: function(res) {
                    jQuery('#judulModalEditDataCalonP3KE').show();
                    jQuery('#judulModalTambahDataCalonP3KE').hide();
                    jQuery('#id_data').val(res.data.id);
                    jQuery('#nik_kk').val(res.data.nik_kk);
                    jQuery('#nik_pkk').val(res.data.nik_pkk);
                    jQuery('#nama_kk').val(res.data.nama_kk);
                    jQuery('#nama_pkk').val(res.data.nama_pkk);
                    jQuery('#nama_anak').val(res.data.nama_anak);
                    jQuery('#nik_anak').val(res.data.nik_anak);
                    jQuery('#alamat').val(res.data.alamat);
                    jQuery('#nama_rt').val(res.data.nama_rt);
                    jQuery('#nama_rw').val(res.data.nama_rw);
                    jQuery('#desa_kelurahan').val(res.data.desa_kelurahan);
                    jQuery('#kecamatan').val(res.data.kecamatan);
                    jQuery('#kabkot').val(res.data.kabkot);
                    jQuery('#district').val(res.data.district);
                    jQuery('#sumber').val(res.data.sumber);
                    jQuery('#desil_p3ke').val(res.data.desil_p3ke);
                    jQuery('#lat').val(res.data.lat);
                    jQuery('#lng').val(res.data.lng);
                    jQuery('#tahun_anggaran').val(res.data.tahun_anggaran);
                    jQuery('#modalTambahDataCalonP3KE').modal('show');
                    jQuery('#wrap-loading').hide();
                },
                error: function() {
                    jQuery('#wrap-loading').hide();
                }
            });
        }

        function tambah_data_calon_p3ke() {
            jQuery('#nik_kk').val('').show();
            jQuery('#nik_pkk').val('').show();
            jQuery('#nama_kk').val('').show();
            jQuery('#nama_pkk').val('').show();
            jQuery('#nama_anak').val('').show();
            jQuery('#nik_anak').val('').show();
            jQuery('#alamat').val('').show();
            jQuery('#nama_rt').val('').show();
            jQuery('#nama_rw').val('').show();
            jQuery('#desa_kelurahan').val('').show();
            jQuery('#kecamatan').val('').show();
            jQuery('#kabkot').val('').show();
            jQuery('#district').val('').show();
            jQuery('#sumber').val('').show();
            jQuery('#desil_p3ke').val('').show();
            jQuery('#lat').val('').show();
            jQuery('#lng').val('').show();
            jQuery('#tahun_anggaran').val('').show();
            jQuery('#judulModalEditDataCalonP3KE').hide();
            jQuery('#judulModalTambahDataCalonP3KE').show();
            jQuery('#modalTambahDataCalonP3KE').modal('show');
        }

        function submitDataCalonP3KE(that) {
            let nik_kk = jQuery('#nik_kk').val().toString();;
            if (nik_kk === '') {
                return alert('Data NIK KK tidak boleh kosong!');
                if (nik_kk.length > 16) {
                    alert("Input KK maksimal 16 digit");
                    return;
                }
            }
            let nik_pkk = jQuery('#nik_pkk').val().toString();;
            if (nik_pkk === '') {
                return alert('Data NIK PKK tidak boleh kosong!');
                if (nik_pkk.length > 16) {
                    alert("Input KK maksimal 16 digit");
                    return;
                }
            }
            let nama_kk = jQuery('#nama_kk').val();
            if (nama_kk === '') {
                return alert('Data Nama KK tidak boleh kosong!');
            }
            let nama_pkk = jQuery('#nama_pkk').val();
            if (nama_pkk === '') {
                return alert('Data Nama PKK tidak boleh kosong!');
            }
            let nama_anak = jQuery('#nama_anak').val();
            if (nama_anak === '') {
                return alert('Data Nama Anak tidak boleh kosong!');
                if (nik_anak.length > 16) {
                    alert("Input KK maksimal 16 digit");
                    return;
                }
            }
            let nik_anak = jQuery('#nik_anak').val();
            if (nik_anak === '') {
                return alert('Data NIK Anak tidak boleh kosong!');
            }
            let alamat = jQuery('#alamat').val();
            if (alamat === '') {
                return alert('Data Alamat tidak boleh kosong!');
            }
            let desa = jQuery('#desa_kelurahan').val();
            if (desa === '') {
                return alert('Data Desa tidak boleh kosong!');
            }
            let nama_rt = jQuery('#nama_rt').val();
            if (nama_rt === '') {
                return alert('Data Nama RT tidak boleh kosong!');
            }
            let nama_rw = jQuery('#nama_rw').val();
            if (nama_rw === '') {
                return alert('Data Nama RW tidak boleh kosong!');
            }
            let tahun_anggaran = jQuery('#tahun_anggaran').val();
            if (tahun_anggaran === '') {
                return alert('Data Tahun Anggaran tidak boleh kosong!');
            }

            let id_data = jQuery('#id_data').val();
            let kabkot = jQuery('#kabkot').val();
            let kecamatan = jQuery('#kecamatan').val();
            let lat = jQuery('#lat').val();
            let lng = jQuery('#lng').val();
            let district = jQuery('#district').val();
            let sumber = jQuery('#sumber').val();
            let desil_p3ke = jQuery('#desil_p3ke').val();

            let tempData = new FormData();
            tempData.append('action', 'tambah_data_calon_p3ke');
            tempData.append('api_key', '<?php echo get_option(SIKS_APIKEY); ?>');
            tempData.append('id_data', id_data);
            tempData.append('nik_kk', nik_kk);
            tempData.append('nik_pkk', nik_pkk);
            tempData.append('nama_kk', nama_kk);
            tempData.append('nama_pkk', nama_pkk);
            tempData.append('nama_anak', nama_anak);
            tempData.append('nik_anak', nik_anak);
            tempData.append('alamat', alamat);
            tempData.append('nama_rt', nama_rt);
            tempData.append('nama_rw', nama_rw);
            tempData.append('desa_kelurahan', desa);
            tempData.append('kecamatan', kecamatan);
            tempData.append('kabkot', kabkot);
            tempData.append('district', district);
            tempData.append('sumber', sumber);
            tempData.append('desil_p3ke', desil_p3ke);
            tempData.append('lat', lat);
            tempData.append('lng', lng);
            tempData.append('tahun_anggaran', tahun_anggaran);

            jQuery('#wrap-loading').show();

            jQuery.ajax({
                method: 'post',
                url: '<?php echo $url; ?>',
                dataType: 'json',
                data: tempData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(res) {
                    alert(res.message);
                    if (res.status == 'success') {
                        jQuery('#modalTambahDataCalonP3KE').modal('hide');
                        get_data_calon_p3ke();
                    }
                }
            });
        }
    </script>