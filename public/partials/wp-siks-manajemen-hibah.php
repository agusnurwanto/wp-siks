<?php
global $wpdb;
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
    <h1 class="text-center" style="margin:3rem;">Manajemen Data Hibah</h1>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="showModalTambahData();"><span class="dashicons dashicons-plus"></span> Tambah Data</button>
    </div>
    <div class="wrap-table">
        <table id="tableData" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Kode</th>
                    <th class="text-center">Penerima</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Kecamatan</th>
                    <th class="text-center">Nama dan NIK Ketua</th>
                    <th class="text-center">Anggaran</th>
                    <th class="text-center">Status Realisasi</th>
                    <th class="text-center">No NPHD</th>
                    <th class="text-center">No SPM</th>
                    <th class="text-center">No SP2D</th>
                    <th class="text-center">Peruntukan</th>
                    <th class="text-center">Tahun Anggaran</th>
                    <th class="text-center">Jenis Data</th>
                    <th class="text-center">Dibuat Pada</th>
                    <th class="text-center">Terakhir Diperbarui</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade mt-4" id="modalTambahData" tabindex="-1" role="dialog" aria-labelledby="modalTambahData" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulmodalTambahData">Tambah Data Hibah</h5>
                <h5 class="modal-title" id="judulModalEdit">Edit Data Hibah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data">

                <div class="form-group">
                    <label for="tahunAnggaran">Tahun Anggaran</label>
                    <input type="number" name="tahunAnggaran" class="form-control" id="tahunAnggaran" placeholder="Masukkan Tahun Anggaran">
                </div>

                <div class="form-group">
                    <label for="jenisData">Jenis Data</label>
                    <select class="form-control" aria-label="Pilih Jenis Data" id="jenisData" name="jenisData">
                        <option selected>Pilih Jenis Data</option>
                        <option value="Induk">Induk</option>
                        <option value="PAK">PAK</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="statusRealisasi">Status Realisasi</label>
                    <select class="form-control" aria-label="Pilih Status Realisasi" id="jenisData" name="jenisData">
                        <option selected>Pilih Status Realisasi</option>
                        <option value="Realisasi">Realisasi</option>
                        <option value="Tidak Realisasi">Tidak Realisasi</option>
                        <option value="Proses">Proses</option>
                    </select>
                </div>

                <div class="card bg-light p-3 mb-3">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="penerima">Penerima</label>
                            <input type="text" name="penerima" class="form-control" id="penerima" placeholder="Masukkan Penerima">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nama_nik_ketua">Nama dan NIK Ketua</label>
                            <input type="text" name="nama_nik_ketua" class="form-control" id="nama_nik_ketua" placeholder="Masukkan Nama dan NIK Ketua">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukkan Alamat">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kecamatan">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" id="kecamatan" placeholder="Masukkan Kecamatan">
                        </div>
                    </div>
                </div>

                <div class="card bg-light p-3 mb-3">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="nphd">No NPHD</label>
                            <input type="text" name="nphd" class="form-control" id="nphd" placeholder="Masukkan NPHD">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="spm">No SPM</label>
                            <input type="text" name="spm" class="form-control" id="spm" placeholder="Masukkan SPM">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="sp2d">No SP2D</label>
                            <input type="text" name="sp2d" class="form-control" id="sp2d" placeholder="Masukkan SP2D">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="tglNphd">Tanggal NPHD</label>
                            <input type="date" name="tglNphd" class="form-control" id="tglNphd" placeholder="Masukkan Tanggal NPHD">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tglSpm">Tanggal SPM</label>
                            <input type="date" name="tglSpm" class="form-control" id="tglSpm" placeholder="Masukkan Tanggal SPM">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tglSp2d">Tanggal SP2D</label>
                            <input type="date" name="tglSp2d" class="form-control" id="tglSp2d" placeholder="Masukkan Tanggal SP2D">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="peruntukan">Peruntukan</label>
                    <textarea name="peruntukan" class="form-control" id="peruntukan"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="submit" onclick="submitData();" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function() {
        getDataTable();
    });

    function getDataTable() {
        if (typeof tableHibah === 'undefined') {
            window.tableHibah = jQuery('#tableData').on('preXhr.dt', function(e, settings, data) {
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
                        'action': 'get_datatable_data_hibah',
                        'api_key': ajax.apikey,
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
                        "data": 'kode',
                        className: "text-center"
                    },
                    {
                        "data": 'penerima',
                        className: "text-center"
                    },
                    {
                        "data": 'alamat',
                        className: "text-center"
                    },
                    {
                        "data": 'kecamatan',
                        className: "text-center"
                    },
                    {
                        "data": 'nama_nik_ketua',
                        className: "text-center"
                    },
                    {
                        "data": 'anggaran',
                        className: "text-center"
                    },
                    {
                        "data": 'status_realisasi',
                        className: "text-center"
                    },
                    {
                        "data": 'no_nphd',
                        className: "text-center"
                    },
                    {
                        "data": 'no_spm',
                        className: "text-center"
                    },
                    {
                        "data": 'no_sp2d',
                        className: "text-center"
                    },
                    {
                        "data": 'peruntukan',
                        className: "text-center"
                    },
                    {
                        "data": 'tahun_anggaran',
                        className: "text-center"
                    },
                    {
                        "data": 'jenis_data',
                        className: "text-center"
                    },
                    {
                        "data": 'create_at',
                        className: "text-center"
                    },
                    {
                        "data": 'update_at',
                        className: "text-center"
                    },
                    {
                        "data": 'aksi',
                        className: "text-center"
                    }
                ]
            });
        } else {
            tableHibah.draw();
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
                    'action': 'hapus_data_hibah_by_id',
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
                'action': 'get_data_hibah_by_id',
                'api_key': ajax.apikey,
                'id': _id,
            },
            success: function(res) {
                jQuery('#judulmodalTambahData').hide();
                jQuery('#id_data').val(res.data.id);
                jQuery('#tahunAnggaran').val(res.data.tahun_anggaran);
                jQuery('#jenisData').val(res.data.jenis_data).trigger('change').prop('selected', false);
                jQuery('#nama').val(res.data.nama);
                jQuery('#usia').val(res.data.usia);
                jQuery('#usia').val(res.data.usia);
                jQuery('#alamat').val(res.data.alamat);
                jQuery('#desaKel').val(res.data.desa_kel);
                jQuery('#kecamatan').val(res.data.kecamatan);

                jQuery('input[name="statusDtks"]').prop('checked', false);
                jQuery('input[name="statusPernikahan"]').prop('checked', false);
                jQuery('input[name="statusUsaha"]').prop('checked', false);
                switch (res.data.status_dtks) {
                    case 'Terdaftar':
                        jQuery('#terdaftar').prop('checked', true);
                        break;
                    case 'Tidak Terdaftar':
                        jQuery('#tidakTerdaftar').prop('checked', true);
                        break;
                    default:
                        jQuery('input[name="statusDtks"]').prop('checked', false);
                }
                switch (res.data.status_pernikahan) {
                    case 'Menikah':
                        jQuery('#menikah').prop('checked', true);
                        break;
                    case 'Belum Menikah':
                        jQuery('#belumMenikah').prop('checked', true);
                        break;
                    case 'Janda':
                        jQuery('#janda').prop('checked', true);
                        break;
                    default:
                        jQuery('input[name="statusPernikahan"]').prop('checked', false);
                }
                switch (res.data.mempunyai_usaha) {
                    case 'Ya':
                        jQuery('#ya').prop('checked', true);
                        break;
                    case 'Tidak':
                        jQuery('#tidak').prop('checked', true);
                        break;
                    default:
                        jQuery('input[name="statusUsaha"]').prop('checked', false);
                }
                jQuery('#keterangan').text(res.data.keterangan);

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
        jQuery('#id_data').val('');
        jQuery('#tahunAnggaran').val('');
        jQuery('#jenisData').val('');
        jQuery('#nama').val('');
        jQuery('#usia').val('');
        jQuery('#alamat').val('');
        jQuery('#desaKel').val('');
        jQuery('#kecamatan').val('');
        jQuery('input[name="statusDtks"]').prop('checked', false);
        jQuery('input[name="statusPernikahan"]').prop('checked', false);
        jQuery('input[name="statusUsaha"]').prop('checked', false);
        jQuery('#keterangan').text('');
        jQuery('#judulmodalTambahData').show();
        jQuery('#judulModalEdit').hide();
        jQuery('#modalTambahData').modal('show');
    }


    function submitData() {
        const validationRules = {
            'nama': 'Data Nama tidak boleh kosong!',
            'usia': 'Data Usia tidak boleh kosong!',
            'alamat': 'Data Alamat tidak boleh kosong!',
            'desaKel': 'Data Desa tidak boleh kosong!',
            'kecamatan': 'Data Kecamatan tidak boleh kosong!',
            'tahunAnggaran': 'Data Tahun Anggaran tidak boleh kosong!',
            'statusDtks': 'Pilih Status DTKS!',
            'statusPernikahan': 'Pilih Status Pernikahan!',
            'statusUsaha': 'Pilih Status Usaha!',
            'jenisData': 'Pilih Jenis Data!',
            'keterangan': 'Keterangan tidak boleh kosong!',
            // Tambahkan field lain jika diperlukan
        };

        const {
            error,
            data
        } = validateForm(validationRules);
        if (error) {
            return alert(error);
        }

        const id_data = jQuery('#id_data').val();

        const tempData = new FormData();
        tempData.append('action', 'tambah_data_hibah');
        tempData.append('api_key', ajax.apikey);
        tempData.append('id_data', id_data);

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
                if (res.status === 'success') {
                    jQuery('#modalTambahData').modal('hide');
                    getDataTable();
                }
            }
        });
    }
</script>