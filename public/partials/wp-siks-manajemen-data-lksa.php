<?php
$api_key = get_option(SIKS_APIKEY);
$url = admin_url('admin-ajax.php');
$center = $this->get_center();
$maps_all = $this->get_polygon();
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
    .wrap-table {
        overflow: auto;
        max-height: 100vh;
        width: 100%;
    }
</style>
<div style="padding: 10px;margin:0 0 3rem 0;">
    <h1 class="text-center" style="margin:3rem;">Manajemen Data LKSA</h1>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="tambah_data_lksa();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableManajemenLKSA" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Nama Lembaga</th>
                    <th class="text-center">Kabupaten/Kota</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Ketua Lembaga</th>
                    <th class="text-center">Nomor HP</th>
                    <th class="text-center">Akreditasi</th>
                    <th class="text-center">Anak Dalam LKSA</th>
                    <th class="text-center">Anak Luar LKSA</th>
                    <th class="text-center">Total Anak LKSA</th>
                    <th class="text-center">Lampiran</th>
                    <th class="text-center">Tahun Anggaran</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade mt-4" id="modalTambahDataLKSA" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataLKSALabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataLKSALabel">Tambah Data LKSA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data" placeholder=''>
                <div class="form-group">
                    <label>Tahun Anggaran</label>
                    <input type="text" class="form-control" id="tahun_anggaran" placeholder="Masukkan Tahun Anggaran">
                </div>
                <div class="form-group">
                    <label>Nama Lembaga</label>
                    <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Lembaga">
                </div>
                <div class="form-group">
                    <label>Kabupaten Kota</label>
                    <input type="text" class="form-control" id="kabkot" placeholder="Masukkan Kabupaten/Kota Lembaga">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control" id="alamat" placeholder="Masukkan Alamat Lembaga">
                </div>
                <div class="form-group">
                    <label>Ketua Lembaga</label>
                    <input type="text" class="form-control" id="ketua" placeholder="Masukkan Nama Ketua Lembaga">
                </div>
                <div class="form-group">
                    <label>Nomor HP/Telfon</label>
                    <input type="number" class="form-control" id="no_hp" placeholder="Masukkan Nomor HP/Telfon Lembaga">
                </div>
                <div class="form-group">
                    <label>Akreditasi Lembaga</label>
                    <input type="text" class="form-control" id="akreditasi" placeholder="Masukkan Akreditasi Lembaga">
                </div>
                <div class="form-group">
                    <label>Anak dalam LKSA</label>
                    <input type="number" class="form-control" id="anak_dalam_lksa" placeholder="Masukkan Jumlah Anak dalam LKSA">
                </div>
                <div class="form-group">
                    <label>Anak luar LKSA</label>
                    <input type="number" class="form-control" id="anak_luar_lksa" placeholder="Masukkan Jumlah Anak luar LKSA">
                </div>
                <div class="form-group">
                    <label>Total Anak LKSA</label>
                    <input type="number" class="form-control" id="total_anak" placeholder="Masukkan Total Jumlah Anak LKSA">
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Koordinat Latitude</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="latitude" name="latitude" placeholder="0" disabled>
                    </div>
                    <label class="col-md-2 col-form-label">Koordinat Longitude</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="longitude" name="longitude" placeholder="0" disabled>
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
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="submitDataLKSA(this);" class="btn btn-primary send_data">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script async defer src="<?php echo $this->get_siks_map_url(); ?>"></script>
<script>
    window.global_file_upload = "<?php echo SIKS_PLUGIN_URL . 'public/media/lksa/'; ?>";
    window.maps_all_siks = <?php echo json_encode($maps_all); ?>;
    window.maps_center_siks = <?php echo json_encode($center); ?>;
    jQuery(document).ready(function() {
        get_data_lksa();

        function hitungTotalAnak() {
            let dalamLksa = parseInt(jQuery('#anak_dalam_lksa').val()) || 0;
            let luarLksa = parseInt(jQuery('#anak_luar_lksa').val()) || 0;
            let total = dalamLksa + luarLksa;
            jQuery('#total_anak').val(total);
        }
        jQuery('#anak_dalam_lksa, #anak_luar_lksa').on('input', function() {
            hitungTotalAnak();
        });
        jQuery('#total_anak').prop('disabled', true);
    });

    function get_data_lksa() {
        if (typeof tableLKSA === 'undefined') {
            window.tableLKSA = jQuery('#tableManajemenLKSA').DataTable({
                "processing": true,
                "serverSide": true,
                "search": {
                    return: true
                },
                "ajax": {
                    url: '<?php echo $url ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'action': 'get_datatable_lksa',
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
                        "data": 'nama',
                        className: "text-center"
                    },
                    {
                        "data": 'kabkot',
                        className: "text-center"
                    },
                    {
                        "data": 'alamat',
                        className: "text-center"
                    },
                    {
                        "data": 'ketua',
                        className: "text-center"
                    },
                    {
                        "data": 'no_hp',
                        className: "text-center"
                    },
                    {
                        "data": 'akreditasi',
                        className: "text-center"
                    },
                    {
                        "data": 'anak_dalam_lksa',
                        className: "text-center"
                    },
                    {
                        "data": 'anak_luar_lksa',
                        className: "text-center"
                    },
                    {
                        "data": 'total_anak',
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
            tableLKSA.draw();
        }
    }

    function hapus_data(id) {
        let confirmDelete = confirm("Apakah anda yakin akan menghapus data ini?");
        if (confirmDelete) {
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'post',
                data: {
                    'action': 'hapus_data_lksa_by_id',
                    'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    jQuery('#wrap-loading').hide();
                    if (response.status == 'success') {
                        get_data_lksa();
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
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            dataType: 'json',
            data: {
                'action': 'get_data_lksa_by_id',
                'api_key': '<?php echo get_option(SIKS_APIKEY); ?>',
                'id': _id,
            },
            success: function(res) {
                if (res.status == 'success') {

                    // Lokasi Center Map
                    if (
                        !res.data.lat ||
                        !res.data.lng
                    ) {
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
                    jQuery('#tahun_anggaran').val(res.data.tahun_anggaran);
                    jQuery('#nama').val(res.data.nama);
                    jQuery('#kabkot').val(res.data.kabkot);
                    jQuery('#alamat').val(res.data.alamat);
                    jQuery('#ketua').val(res.data.ketua);
                    jQuery('#no_hp').val(res.data.no_hp);
                    jQuery('#akreditasi').val(res.data.akreditasi);
                    jQuery('#anak_dalam_lksa').val(res.data.anak_dalam_lksa);
                    jQuery('#anak_luar_lksa').val(res.data.anak_luar_lksa);
                    jQuery('#total_anak').val(res.data.total_anak);
                    jQuery('#latitude').val(res.data.lat);
                    jQuery('#longitude').val(res.data.lng);
                    jQuery('#lampiran').val('').show();
                    jQuery('#file_lampiran_existing').attr('href', global_file_upload + res.data.file_lampiran).html(res.data.file_lampiran).show();
                    jQuery('#modalTambahDataLKSA .send_data').show();
                    jQuery('#modalTambahDataLKSA').modal('show');
                } else {
                    alert(res.message);
                }
                jQuery('#wrap-loading').hide();
            }
        });
    }

    function tambah_data_lksa() {
        var lokasi_center = new google.maps.LatLng(maps_center_siks['lat'], maps_center_siks['lng']);

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
        jQuery('#tahun_anggaran').val('').show();
        jQuery('#nama').val('').show();
        jQuery('#kabkot').val('').show();
        jQuery('#alamat').val('').show();
        jQuery('#ketua').val('').show();
        jQuery('#no_hp').val('').show();
        jQuery('#akreditasi').val('').show();
        jQuery('#anak_dalam_lksa').val('');
        jQuery('#anak_luar_lksa').val('');
        jQuery('#total_anak').val('').show();
        jQuery('#lampiran').val('').show();
        jQuery('#file_lampiran_existing').hide();
        jQuery('#file_lampiran_existing').closest('.form-group').find('input').show();
        jQuery('#modalTambahDataLKSA').modal('show');
    }

    function submitDataLKSA() {
        var id_data = jQuery('#id_data').val();
        var nama = jQuery('#nama').val();
        if (nama == '') {
            return alert('Data Nama tidak boleh kosong!');
        }
        var ketua = jQuery('#ketua').val();
        if (ketua == '') {
            return alert('Data Ketua tidak boleh kosong!');
        }
        var akreditasi = jQuery('#akreditasi').val();
        if (akreditasi == '') {
            return alert('Data akreditasi tidak boleh kosong!');
        }
        var alamat = jQuery('#alamat').val();
        if (alamat == '') {
            return alert('Data alamat tidak boleh kosong!');
        }
        var kabkot = jQuery('#kabkot').val();
        if (kabkot == '') {
            return alert('Data Kabupaten / Kota tidak boleh kosong!');
        }
        var no_hp = jQuery('#no_hp').val();
        if (no_hp == '') {
            return alert('Data No HP tidak boleh kosong!');
        }
        var anak_dalam_lksa = jQuery('#anak_dalam_lksa').val();
        if (anak_dalam_lksa == '') {
            return alert('Data Dalam Lksa tidak boleh kosong!');
        }
        var anak_luar_lksa = jQuery('#anak_luar_lksa').val();
        if (anak_luar_lksa == '') {
            return alert('Data Luar Lksa tidak boleh kosong!');
        }
        var total_anak = jQuery('#total_anak').val();
        if (total_anak == '') {
            return alert('Data Total Anak tidak boleh kosong!');
        }
        var tahun_anggaran = jQuery('#tahun_anggaran').val();
        if (tahun_anggaran == '') {
            return alert('Data Tahun Anggaran tidak boleh kosong!');
        }
        var lampiran = jQuery('#lampiran')[0].files[0];
        // if (id_data == '') {
        //     if (typeof lampiran == 'undefined') {
        //         return alert('Upload file lampiran dulu!');
        //     }
        // }

        let tempData = new FormData();
        tempData.append('action', 'tambah_data_lksa');
        tempData.append('api_key', '<?php echo get_option(SIKS_APIKEY); ?>');
        tempData.append('id_data', id_data);
        tempData.append('nama', nama);
        tempData.append('tahun_anggaran', tahun_anggaran);
        tempData.append('kabkot', kabkot);
        tempData.append('alamat', alamat);
        tempData.append('ketua', ketua);
        tempData.append('no_hp', no_hp);
        tempData.append('akreditasi', akreditasi);
        tempData.append('anak_dalam_lksa', anak_dalam_lksa);
        tempData.append('anak_luar_lksa', anak_luar_lksa);
        // tempData.append('total_anak', total_anak);
        tempData.append('lat', jQuery('input[name="latitude"]').val());
        tempData.append('lng', jQuery('input[name="longitude"]').val());

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
                    jQuery('#modalTambahDataLKSA').modal('hide');
                    get_data_lksa();
                }
                jQuery('#wrap-loading').hide();
            }
        });
    }
</script>