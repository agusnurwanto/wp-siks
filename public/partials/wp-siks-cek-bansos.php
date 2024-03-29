<?php
$api_key = get_option(SIKS_APIKEY);
$login = false;
if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    if ($this->functions->user_has_role($current_user->ID, 'administrator')) {
        $login = true;
    }
}
$auto_login = get_option('_crb_siks_auto_login');
?>
<div class="modal fade" id="modal-captcha" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="text-center">
                    <div class="form-group">
                        <img id="captcha-img" src="" style="margin: 10px auto;"><br>
                        <label for="nik">Masukan Nilai Captcha</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="captcha" placeholder="xxxx">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="proses-captcha">Proses</button>
            </div>
        </div>
    </div>
</div>
<h1 class="text-center">Cek Data Terpadu Kesejahteraan Sosial (DTKS)</h1>
<form style="width: 500px; margin: auto;" class="text-center">
    <div class="form-group">
        <div class="g-recaptcha" data-sitekey="<?php echo get_option('_crb_siks_captcha_public'); ?>" style="margin: 10px auto; width: 300px;"></div>
    </div>
    <div class="form-group">
        <label for="nik">Masukan NIK</label>
        <div class="input-group">
            <input type="number" class="form-control" id="nik" placeholder="xxxxxxxxxxx">
            <div class="input-group-append">
                <span class="btn btn-primary" type="button" id="cari" style="display: flex; align-items: center;">Cari Data</span>
            </div>
        </div>
    </div>
</form>
<div style="padding: 10px; margin: auto; overflow: auto;" id="pesan">

</div>
<div style="max-width: 1000px; margin: auto;">
    <h4>Keterangan:</h4>
    <ul>
        <li><b>BPNT</b> (Bantuan Pangan Non Tunai) adalah bantuan sosial pangan dalam bentuk non tunai dari pemerintah yang diberikan kepada KPM setiap bulannya. Penyaluran bansos BPNT melalui mekanisme akun elektronik yang digunakan hanya untuk membeli bahan pangan di pedagang bahan pangan/e-warong yang bekerjasama dengan bank.</li>
        <li><b>BST</b> (Bantuan Sosial Tunai) adalah merupakan bantuan berupa uang yang diberikan kepada keluarga miskin, tidak mampu, dan/atau rentan yang terkena dampak wabah Corona Virus Disease 2019 (Covid-19).</li>
        <li><b>PKH</b> (Program Keluarga Harapan) adalah program yang dibuat sebagai upaya percepatan penanggulangan kemiskinan. PKH membuka akses keluarga miskin terutama ibu hamil dan anak untuk memanfaatkan berbagai fasilitas layanan kesehatan (faskes) dan fasilitas layanan pendidikan (fasdik) yang tersedia di sekitar tempat tinggal mereka.</li>
        <li><b>PBI-JK</b> (Penerima Bantuan Iuran Jaminan Kesehatan) adalah peserta jaminan kesehatan yang tergolong fakir miskin dan orang tidak mampu yang iuran BPJS Kesehatannya dibayarkan oleh pemerintah.</li>
        <li><b>BPNT PPKM</b> (Bantuan Pangan Non Tunai Pemberlakuan Pembatasan Kegiatan Masyarakat)</li>
        <li><b>BLT</b> (Bantuan Langsung Tunai)</li>
        <li><b>BLT-BBM</b> (Bantuan Langsung Tunai Bahan Bakar Minyak) adalah salah satu program jaring pengaman sosial yang diberikan sebagai upaya meringankan beban masyarakat akibat kenaikan harga bahan pokok kebutuhan hidup sehari-hari.</li>
        <li><b>RUTILAHU</b> (Rehabilitasi Sosial Rumah Tidak Layak Huni) adalah salah satu kegiatan penanganan fakir miskin yang diselenggarakan Kementerian Sosial dengan tujuan untuk meningkatkan kualitas tempat tinggal fakir miskin melalui perbaikan/rehabilitasi kondisi rumah tidak layak huni dengan prioritas atap, lantai, dan dinding serta fasilitas MCK.</li>
    </ul>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
    window.key = '<?php echo get_option('_crb_siks_key'); ?>';
    jQuery('document').ready(function() {
        jQuery('#proses-captcha').on('click', function(e) {
            e.preventDefault();
            var captcha = jQuery('#captcha').val();
            if (captcha == '') {
                return alert('Captcha harus diisi!');
            }
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: ajax.url,
                type: 'post',
                dataType: "json",
                data: {
                    action: 'proses_captcha',
                    captcha: captcha,
                    api_key: '<?php echo $api_key; ?>'
                },
                success: function(res) {
                    console.log(res);
                    setTimeout(function() {
                        jQuery('#modal-captcha').modal('hide');
                        jQuery('#wrap-loading').hide();
                        alert('Harap ulangi lagi!');
                    }, 5000);
                }
            });
        });
        jQuery('#cari').on('click', function(e) {
            e.preventDefault();
            var captcha = jQuery('textarea[name="g-recaptcha-response"]').val();
            if (captcha == '') {
                return alert('Captcha harus dichecklist!');
            }
            var nik = jQuery('#nik').val();
            if (nik == '') {
                return alert('NIK harus diisi!');
            }
            jQuery('#wrap-loading').show();
            jQuery('#pesan').html('');
            var param_encrypt_asli = '<?php echo $auto_login; ?>';
            var data = {
                "no_prop": "<?php echo get_option('_crb_siks_prop'); ?>",
                "no_kab": "<?php echo get_option('_crb_siks_kab'); ?>",
                "no_kec": "",
                "no_kel": "",
                "is_disabilitas": "",
                "filter_meninggal": "0",
                "filter_gis": "",
                "page": "0",
                "per_page": "10",
                "nokk": "",
                "nik": nik,
                "psnoka": "",
                "nama": ""
            };
            if (param_encrypt_asli == 1) {
                var param_encrypt = en(JSON.stringify(data));
            }
            new Promise(function(resolve, reduce) {
                if (param_encrypt_asli != 1) {
                    var data = {
                        action: 'get_data_bansos',
                        nik: nik,
                        'g-recaptcha-response': captcha
                    };
                } else {
                    var data = {
                        action: 'get_data_bansos',
                        data: param_encrypt,
                        'g-recaptcha-response': captcha
                    };
                }
                jQuery.ajax({
                    url: ajax.url,
                    type: 'post',
                    dataType: "json",
                    data: data,
                    success: function(res) {
                        resolve(res);
                    }
                });
            }).then(function(res) {
                grecaptcha.reset();
                <?php if ($login == true) : ?>
                    console.log(res);
                <?php endif; ?>
                if (res.status == 'error') {
                    jQuery('#wrap-loading').hide();
                    return alert(res.message);
                }

                if (param_encrypt_asli == 1) {
                    var new_data = JSON.parse(de(res.data));
                    <?php if ($login == true) : ?>
                        console.log('new_data', new_data);
                    <?php endif; ?>
                    if (!new_data.success) {
                        alert("Maaf ada kendala server dengan kode 111. Harap hubungi Admin!");
                        console.log(new_data.message);
                        <?php if (get_option('_crb_siks_auto_login') == '1') : ?>
                            jQuery.ajax({
                                url: ajax.url,
                                type: 'post',
                                dataType: "json",
                                data: {
                                    action: 'send_message',
                                    api_key: '<?php echo $api_key; ?>'
                                },
                                success: function(res) {
                                    console.log(res);
                                    setTimeout(function() {
                                        jQuery.ajax({
                                            url: ajax.url,
                                            type: 'post',
                                            dataType: "json",
                                            data: {
                                                action: 'get_captcha',
                                                api_key: '<?php echo $api_key; ?>'
                                            },
                                            success: function(res) {
                                                console.log(res);
                                                if (res.captcha != '') {
                                                    jQuery('#captcha-img').attr('src', res.captcha);
                                                    jQuery('#modal-captcha').modal('show');
                                                }
                                                jQuery('#wrap-loading').hide();
                                            }
                                        });
                                    }, 10000);
                                }
                            });
                        <?php else : ?>
                            jQuery('#wrap-loading').hide();
                        <?php endif; ?>
                        return;
                    }
                    res.data = new_data.data.data;
                }

                if (res.data.length == 0) {
                    alert('Data dengan nomor NIK ' + nik + ' tidak ditemukan!');
                } else {
                    var data_all = '';
                    <?php if ($login == false) : ?>
                        res.data.map(function(b, i) {
                            data_all += '' +
                                '<tr>' +
                                '<td class="text-center">' + (i + 1) + '</td>' +
                                '<td class="text-center">' + b.update_at + '</td>' +
                                '<td class="text-center">' + b.NOKK + '</td>' +
                                '<td class="text-center">' + b.NIK + '</td>' +
                                '<td class="text-center">' + b.Nama + '</td>' +
                                '<td class="text-center">' + b.Alamat + '</td>' +
                                '<td class="text-center">' + b.FIRST_SK + '</td>' +
                                '<td class="text-center">' + b.padankan_at + '</td>' +
                                '<td class="text-center">' + b.BPNT + '</td>' +
                                '<td class="text-center">' + b.PKH + '</td>' +
                                '<td class="text-center">' + b.PBI + '</td>' +
                                '<td class="text-center">' + b.BLT + '</td>' +
                                '<td class="text-center">' + b.BLT_BBM + '</td>' +
                                '<td class="text-center">' + b.keterangan_meninggal + '</td>' +
                                '<td class="text-center">' + b.keterangan_disabilitas + '</td>' +
                                '</tr>';
                        });
                        var pesan = '' +
                            '<table class="table table-bordered" style="width: 3000px;">' +
                            '<thead>' +
                            '<tr>' +
                            '<th class="text-center" style="width: 20px;">No</th>' +
                            '<th class="text-center">Waktu Update Data</th>' +
                            '<th class="text-center">No KK</th>' +
                            '<th class="text-center">NIK</th>' +
                            '<th class="text-center">Nama</th>' +
                            '<th class="text-center">Alamat</th>' +
                            '<th class="text-center">Masuk SK DTKS Pertama</th>' +
                            '<th class="text-center">Terakhir Padan Capil</th>' +
                            '<th class="text-center">BPNT</th>' +
                            '<th class="text-center">PKH</th>' +
                            '<th class="text-center">PBI</th>' +
                            '<th class="text-center">BLT</th>' +
                            '<th class="text-center">BLT BBM</th>' +
                            '<th class="text-center">Keterangan Meninggal</th>' +
                            '<th class="text-center">Keterangan Disabilitas</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>' +
                            data_all +
                            '</tbody>' +
                            '</table>';
                    <?php else : ?>
                        res.data.map(function(b, i) {
                            data_all += '' +
                                '<tr>' +
                                '<td class="text-center">' + (i + 1) + '</td>' +
                                '<td class="text-center">' + b.update_at + '</td>' +
                                '<td class="text-center">' + b.NOKK + '</td>' +
                                '<td class="text-center">' + b.NIK + '</td>' +
                                '<td class="text-center">' + b.Nama + '</td>' +
                                '<td class="text-center">' + b.Alamat + '</td>' +
                                '<td class="text-center">' + b.FIRST_SK + '</td>' +
                                '<td class="text-center">' + b.padankan_at + '</td>' +
                                '<td class="text-center">' + b.BPNT + '</td>' +
                                '<td class="text-center">' + b.BST + '</td>' +
                                '<td class="text-center">' + b.PKH + '</td>' +
                                '<td class="text-center">' + b.PBI + '</td>' +
                                '<td class="text-center">' + b.BNPT_PPKM + '</td>' +
                                '<td class="text-center">' + b.BLT + '</td>' +
                                '<td class="text-center">' + b.BLT_BBM + '</td>' +
                                '<td class="text-center">' + b.RUTILAHU + '</td>' +
                                '<td class="text-center">' + b.keterangan_meninggal + '</td>' +
                                '<td class="text-center">' + b.keterangan_disabilitas + '</td>' +
                                '</tr>';
                        });
                        var pesan = '' +
                            '<table class="table table-bordered" style="width: 3000px;">' +
                            '<thead>' +
                            '<tr>' +
                            '<th class="text-center" style="width: 20px;">No</th>' +
                            '<th class="text-center">Waktu Update Data</th>' +
                            '<th class="text-center">No KK</th>' +
                            '<th class="text-center">NIK</th>' +
                            '<th class="text-center">Nama</th>' +
                            '<th class="text-center">Alamat</th>' +
                            '<th class="text-center">Masuk SK DTKS Pertama</th>' +
                            '<th class="text-center">Terakhir Padan Capil</th>' +
                            '<th class="text-center">BPNT</th>' +
                            '<th class="text-center">BST</th>' +
                            '<th class="text-center">PKH</th>' +
                            '<th class="text-center">PBI</th>' +
                            '<th class="text-center">BPNT PPKM</th>' +
                            '<th class="text-center">BLT</th>' +
                            '<th class="text-center">BLT BBM</th>' +
                            '<th class="text-center">RUTILAHU</th>' +
                            '<th class="text-center">Keterangan Meninggal</th>' +
                            '<th class="text-center">Keterangan Disabilitas</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>' +
                            data_all +
                            '</tbody>' +
                            '</table>';
                    <?php endif; ?>
                    jQuery('#pesan').html(pesan);
                }
                jQuery('#wrap-loading').hide();
            });
        });
    });

    function en(e) {
        var t = CryptoJS.lib.WordArray.random(16),
            r = CryptoJS.enc.Base64.parse(key),
            u = {
                iv: t,
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.Pkcs7
            },
            a = CryptoJS.AES.encrypt(e, r, u);
        a = a.toString();
        var n = {
            iv: t = CryptoJS.enc.Base64.stringify(t),
            value: a,
            mac: CryptoJS.HmacSHA256(t + a, r).toString()
        };
        return n = JSON.stringify(n),
            n = CryptoJS.enc.Utf8.parse(n),
            CryptoJS.enc.Base64.stringify(n);
    }

    function de(e) {
        var t,
            r = null === (t = key) ? void 0 : t.toString(),
            u = atob(e),
            a = JSON.parse(u),
            n = CryptoJS.enc.Base64.parse(a.iv),
            c = a.value,
            l = CryptoJS.enc.Base64.parse(r || "");
        return CryptoJS.AES.decrypt(c, l, {
            iv: n
        }).toString(CryptoJS.enc.Utf8);
    }
</script>