jQuery(document).ready(function () {
    var loading = ''
        + '<div id="wrap-loading">'
        + '<div class="lds-hourglass"></div>'
        + '<div id="persen-loading"></div>'
        + '</div>';
    if (jQuery('#wrap-loading').length == 0) {
        jQuery('body').prepend(loading);
    }
});

function cari_alamat_siks(text) {
    if (text) {
        var alamat = text;
    } else {
        var alamat = jQuery('#cari-alamat-siks-input').val();
    }
    if (typeof google == 'undefined') {
        return setTimeout(function () {
            cari_alamat_siks(text);
        }, 1000)
    }
    geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'address': alamat }, function (results, status) {
        if (status == 'OK') {
            console.log('results', results);
            map.setCenter(results[0].geometry.location);
            map.setZoom(15);
            jQuery([document.documentElement, document.body]).animate({
                scrollTop: jQuery("#map-canvas-siks").offset().top
            }, 500);
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

function setCenterSiks(lng, ltd, maker = false, data, noCenter = false) {
    var lokasi_aset = new google.maps.LatLng(lng, ltd);

    // center lokasi
    if (!noCenter) {
        map.setCenter(lokasi_aset);
        map.setZoom(15);
        jQuery([document.documentElement, document.body]).animate({
            scrollTop: jQuery("#map-canvas-siks").offset().top
        }, 500);
    }

    // menampilkan maker
    if (maker) {
        if (typeof evm == 'undefined') {
            window.evm = {};
        }
        if (typeof data == 'object') {
            data = JSON.stringify(data);
        }
        if (typeof evm[data] != 'undefined') {
            evm[data].setMap(null);
        }
        // Menampilkan Marker
        evm[data] = new google.maps.Marker({
            position: lokasi_aset,
            map,
            draggable: false,
            title: 'Lokasi Map'
        });

        if (typeof infoWindow == 'undefined') {
            window.infoWindow = {};
        }
        infoWindow[data] = new google.maps.InfoWindow({
            content: data
        });

        google.maps.event.addListener(evm[data], 'click', function (event) {
            infoWindow[data].setPosition(event.latLng);
            infoWindow[data].open(map);
        });
    }
}

function validateForm(fields) {
    const formData = {};

    for (const [name, message] of Object.entries(fields)) {
        const $field = jQuery(`[name="${name}"]`);

        if ($field.is(':radio')) {
            const checkedValue = jQuery(`[name="${name}"]:checked`).val();
            if (!checkedValue) {
                return { error: message };
            }
            formData[name] = checkedValue;
        } else if ($field.is(':checkbox')) {
            const isChecked = $field.is(':checked');
            if (!isChecked) {
                return { error: message };
            }
            formData[name] = isChecked;
        } else if ($field.is('select') || $field.is('textarea') || $field.is(':input')) {
            const value = $field.val().trim();
            if (value === '') {
                return { error: message };
            }
            formData[name] = value;
        }
    }

    return { error: null, data: formData };
}

jQuery(document).ready(function () {
    var search = ''
        + '<div class="input-group" style="margin-bottom: 5px; display: block;">'
        + '<div class="input-group-prepend">'
        + '<input class="form-control" id="cari-alamat-siks-input" type="text" placeholder="Kotak pencarian alamat">'
        + '<button class="btn btn-success" id="cari-alamat-siks" type="button"><i class="dashicons dashicons-search"></i></button>'
        + '</div>'
        + '</div>';
    jQuery("#map-canvas-siks").before(search);
    jQuery("#cari-alamat-siks").on('click', function () {
        cari_alamat_siks();
    });
    jQuery("#cari-alamat-siks-input").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            cari_alamat_siks();
        }
    });
});

function initMapSiks() {
    // Lokasi Center Map
    var lokasi_aset = new google.maps.LatLng(maps_center_siks['lat'], maps_center_siks['lng']);
    // Setting Map
    var mapOptions = {
        zoom: 13,
        center: lokasi_aset,
        mapTypeId: google.maps.MapTypeId.HYBRID
    };
    // Membuat Map
    window.map = new google.maps.Map(document.getElementById("map-canvas-siks"), mapOptions);
    window.chartWindow = {};
    window.chartRenderWindow = {};
    window.chartWindowDtks = {};
    window.chartRenderWindowDtks = {};
    window.infoWindow = {};

    // Membuat Shape
    maps_all_siks.map(function (data, i) {
        // console.log(data.coor);
        data.coor.map(function (coor, ii) {
            var bidang1 = new google.maps.Polygon({
                map: map,
                paths: coor,
                strokeColor: data.color,
                strokeOpacity: 0.5,
                strokeWeight: 2,
                fillColor: data.color,
                fillOpacity: 0.3
            });
            var index = data.index;
            chartWindow[index] = data.chart;
            chartWindowDtks[index] = data.chart_dtks;

            // Menampilkan Informasi Data
            var contentString = data.html;
            infoWindow[index] = new google.maps.InfoWindow({
                content: contentString
            });
            google.maps.event.addListener(bidang1, 'click', function (event) {
                infoWindow[index].setPosition(event.latLng);
                infoWindow[index].open(map);

                var id = "chart-" + index;
                if (!chartRenderWindow[id]) {
                    // menampilkan chart
                    setTimeout(function () {
                        if (!chartWindow[index]) {
                            return;
                        }

                        console.log('index, chartWindow[index]', index, chartWindow[index]);
                        chartRenderWindow[id] = new Chart(document.getElementById(id).getContext('2d'), {
                            type: "pie",
                            data: {
                                labels: chartWindow[index].label,
                                datasets: [
                                    {
                                        label: "",
                                        data: chartWindow[index].data,
                                        backgroundColor: chartWindow[index].color
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            font: {
                                                size: 16
                                            }
                                        }
                                    },
                                    tooltip: {
                                        bodyFont: {
                                            size: 16
                                        },
                                        backgroundColor: "rgba(0, 0, 0, 0.8)",
                                        boxPadding: 5
                                    },
                                    datalabels: {
                                        formatter: (value, ctx) => {
                                            let sum = 0;
                                            let dataArr = ctx.chart.data.datasets[0].data;
                                            dataArr.map(data => {
                                                sum += data;
                                            });
                                            let percentage = ((value / sum) * 100).toFixed(2) + "%";
                                            console.log('percentage, dataArr', value, percentage, dataArr);
                                            return percentage;
                                        },
                                        color: '#000',
                                    }
                                }
                            },
                            plugins: [ChartDataLabels]
                        });
                    }, 500);
                } else {
                    chartRenderWindow[id].update();
                }

                var id_dtks = "chart-dtks-" + index;
                if (!chartRenderWindowDtks[id_dtks]) {
                    // menampilkan chart
                    setTimeout(function () {
                        if (!chartWindowDtks[index]) {
                            return;
                        }

                        console.log('index, chartWindowDtks[index]', index, chartWindowDtks[index]);
                        chartRenderWindowDtks[id_dtks] = new Chart(document.getElementById(id_dtks).getContext('2d'), {
                            type: "pie",
                            data: {
                                labels: chartWindowDtks[index].label,
                                datasets: [
                                    {
                                        label: "",
                                        data: chartWindowDtks[index].data,
                                        backgroundColor: chartWindowDtks[index].color
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            font: {
                                                size: 16
                                            }
                                        }
                                    },
                                    tooltip: {
                                        bodyFont: {
                                            size: 16
                                        },
                                        backgroundColor: "rgba(0, 0, 0, 0.8)",
                                        boxPadding: 5
                                    },
                                    datalabels: {
                                        formatter: (value, ctx) => {
                                            let sum = 0;
                                            let dataArr = ctx.chart.data.datasets[0].data;
                                            dataArr.map(data => {
                                                sum += data;
                                            });
                                            let percentage = ((value / sum) * 100).toFixed(2) + "%";
                                            console.log('percentage, dataArr', value, percentage, dataArr);
                                            return percentage;
                                        },
                                        color: '#000',
                                    }
                                }
                            },
                            plugins: [ChartDataLabels]
                        });
                    }, 500);
                } else {
                    chartRenderWindowDtks[id_dtks].update();
                }
            });
        });
    })

    function editDataDesaKel() {
        const validationRules = {
            'desaKelRadio': 'Data status desa / kelurahan tidak boleh kosong!',
            'newName': 'Nama baru tidak boleh kosong!'
            // Tambahkan field lain jika diperlukan
        };

        const {
            error,
            data
        } = validateForm(validationRules);
        if (error) {
            return alert(error);
        }

        const id_data = jQuery('#id_data_desa').val();

        const tempData = new FormData();
        tempData.append('action', 'edit_data_desa_kel');
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
                    jQuery('#settingModal').modal('hide');
                    menu_siks();
                }
            }
        });
    }
}