<?php
global $wpdb;
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
<div style="padding: 10px;margin:0 0 3rem 0;">
    <h1 class="text-center" style="margin:3rem;">Manajemen Data Hibah</h1>
    <div style="margin-bottom: 25px;">
        <button class="btn btn-primary" onclick="showModalTambahData();"><span class="dashicons dashicons-plus"></span> Tambah Data</button>
    </div>
    <table id="tableData" class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center" style="width: 6%;">Kode</th>
                <th class="text-center" style="width: 12%;">Penerima</th>
                <th class="text-center" style="width: 12%;">Nama dan NIK Ketua</th>
                <th class="text-center" style="width: 8%;">Provinsi</th>
                <th class="text-center" style="width: 8%;">Kabupaten/Kota</th>
                <th class="text-center" style="width: 8%;">Kecamatan</th>
                <th class="text-center" style="width: 8%;">Desa/Kelurahan</th>
                <th class="text-center" style="width: 12%;">Alamat</th>
                <th class="text-center" style="width: 8%;">Anggaran</th>
                <th class="text-center" style="width: 6%;">Status Realisasi</th>
                <th class="text-center" style="width: 6%;">No NPHD</th>
                <th class="text-center" style="width: 6%;">No SPM</th>
                <th class="text-center" style="width: 6%;">No SP2D</th>
                <th class="text-center" style="width: 10%;">Peruntukan</th>
                <th class="text-center" style="width: 6%;">Tahun Anggaran</th>
                <th class="text-center" style="width: 6%;">Jenis Data</th>
                <th class="text-center" style="width: 10%;">Keterangan</th>
                <th class="text-center" style="width: 6%;">Dibuat Pada</th>
                <th class="text-center" style="width: 6%;">Terakhir Diperbarui</th>
                <th class="text-center" style="width: 6%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
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
                        <option value="">Pilih Jenis Data</option>
                        <option value="Induk">Induk</option>
                        <option value="PAK">PAK</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="statusRealisasi">Status Realisasi</label>
                    <select class="form-control" aria-label="Pilih Status Realisasi" id="statusRealisasi" name="statusRealisasi">
                        <option value="">Pilih Status Realisasi</option>
                        <option value="Realisasi">Realisasi</option>
                        <option value="Tidak Realisasi">Tidak Realisasi</option>
                        <option value="Proses">Proses</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="anggaran">Anggaran</label>
                    <input type="number" name="anggaran" class="form-control" id="anggaran" placeholder="Masukkan Jumlah Anggaran">
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
                        <div class="form-group col-md-3">
                            <label for="kecamatan">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" id="kecamatan" placeholder="Masukkan Kecamatan">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="desaKel">Desa / Kelurahan</label>
                            <input type="text" name="desaKel" class="form-control" id="desaKel" placeholder="Masukkan Desa / Kelurahan">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="provinsi">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" id="provinsi" placeholder="Masukkan Provinsi">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kabKot">Kota / Kabupaten</label>
                            <input type="text" name="kabKot" class="form-control" id="kabKot" placeholder="Masukkan Kota / Kabupaten">
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
                "scrollX": true, // Enables horizontal scrolling
                "scrollY": '600px', // Enables vertical scrolling
                "scrollCollapse": true,
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
                        className: "text-left"
                    },
                    {
                        "data": 'nama_nik_ketua',
                        className: "text-left"
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
                        "data": 'desa_kelurahan',
                        className: "text-center"
                    },
                    {
                        "data": 'alamat',
                        className: "text-left"
                    },
                    {
                        "data": 'anggaran',
                        className: "text-right"
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
                        className: "text-left"
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
                        "data": 'keterangan',
                        className: "text-left"
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
                jQuery('#id_data').val(res.data.id);
                jQuery('#tahunAnggaran').val(res.data.tahun_anggaran);
                jQuery('#jenisData').val(res.data.jenis_data).trigger('change');
                jQuery('#statusRealisasi').val(res.data.status_realisasi).trigger('change');
                jQuery('#anggaran').val(res.data.anggaran).val(res.data.anggaran);
                jQuery('#penerima').val(res.data.penerima);
                jQuery('#nama_nik_ketua').val(res.data.nama_nik_ketua);
                jQuery('#provinsi').val(res.data.provinsi);
                jQuery('#kecamatan').val(res.data.kecamatan);
                jQuery('#alamat').val(res.data.alamat);
                jQuery('#kabKot').val(res.data.kabkot);
                jQuery('#desaKel').val(res.data.desa_kelurahan);
                jQuery('#nphd').val(res.data.no_nphd);
                jQuery('#spm').val(res.data.no_spm);
                jQuery('#sp2d').val(res.data.no_sp2d);
                jQuery('#tglNphd').val(res.data.tgl_nphd);
                jQuery('#tglSpm').val(res.data.tgl_spm);
                jQuery('#tglSp2d').val(res.data.tgl_sp2d);
                jQuery('#peruntukan').val(res.data.peruntukan);

                jQuery('#judulmodalTambahData').hide();
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
        jQuery('#anggaran').val('');
        jQuery('#jenisData').val('');
        jQuery('#statusRealisasi').val('');
        jQuery('#penerima').val('');
        jQuery('#nama_nik_ketua').val('');
        jQuery('#alamat').val('');
        jQuery('#kecamatan').val('');
        jQuery('#provinsi').val('');
        jQuery('#kabKot').val('');
        jQuery('#desaKel').val('');
        jQuery('#nphd').val('');
        jQuery('#spm').val('');
        jQuery('#sp2d').val('');
        jQuery('#tglNphd').val('');
        jQuery('#tglSpm').val('');
        jQuery('#tglSp2d').val('');
        jQuery('#peruntukan').val('');

        jQuery('#judulmodalTambahData').show();
        jQuery('#judulModalEdit').hide();
        jQuery('#modalTambahData').modal('show');
    }

    function submitData() {
        const validationRules = {
            'tahunAnggaran': 'Data Tahun Anggaran tidak boleh kosong!',
            'jenisData': 'Pilih Jenis Data!',
            'statusRealisasi': 'Pilih Status Realisasi!',
            'anggaran': 'Anggaran tidak boleh kosong!',
            'penerima': 'Data Penerima tidak boleh kosong!',
            'nama_nik_ketua': 'Nama dan NIK Ketua tidak boleh kosong!',
            'kecamatan': 'Data Kecamatan tidak boleh kosong!',
            'provinsi': 'Data Provinsi tidak boleh kosong!',
            'kabKot': 'Data Kabupaten / Kecamatan tidak boleh kosong!',
            'desaKel': 'Data Desa / Kelurahan tidak boleh kosong!',
            'alamat': 'Data Alamat tidak boleh kosong!',
            'nphd': 'No NPHD tidak boleh kosong!',
            'spm': 'No SPM tidak boleh kosong!',
            'sp2d': 'No SP2D tidak boleh kosong!',
            'tglNphd': 'Tanggal NPHD tidak boleh kosong!',
            'tglSpm': 'Tanggal SPM tidak boleh kosong!',
            'tglSp2d': 'Tanggal SP2D tidak boleh kosong!',
            'peruntukan': 'Peruntukan tidak boleh kosong!',
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