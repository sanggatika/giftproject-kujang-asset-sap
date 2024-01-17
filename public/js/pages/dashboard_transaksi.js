"use strict";
var data_decrpty = null;

const currencyFormatter = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
});

const formatNumber = (number)=>{
    return number.toLocaleString('id-ID');
}

var form_filter_tahun = '2023';

function arrayTanggal()
{
    var tanggal = [];
    var i;
    for(i = 21; i >= 0; i--)
    {
        var days = i; // Days you want to subtract
        var date = new Date();
        var last = new Date(date.getTime() - (days * 24 * 60 * 60 * 1000));
        
        var day = last.getDate();
        var tmp_day = day;
        if(parseInt(day) < 10)
        {
            tmp_day = "0"+day;
        }
        
        var month = last.getMonth()+1;
        var tmp_mont = month;
        if(parseInt(month) < 10)
        {
            tmp_mont = "0"+month;
        }

        var year=last.getFullYear();

        var date = year+"-"+tmp_mont+"-"+tmp_day

        tanggal.push(date);
    }
    return tanggal;
}

// Tampungan Data
var chartList = [];
var tmp_statistik_tr_penjualan = null;
var tmp_statistik_tr_keuangan_pengeluaran = null;

function get_dataMasterDash()
{
    $.ajax({
        url: BaseURL + "/dash/data/master",
        async:false,
        data: {
            form_filter_tahun, 
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            // $('.dataContenDashboard').hide();
            // $('.loaderConten').show();
        },
        success: function (data) {
            // console.log(data);
            if(data.status == true)
            {
                // Line 01 - Jumlah Jenis Barang
                $("#data_line1_jumlah_barang_jenis").html(data.data['ms_barang_jenis'].length);

                // Line 01 - Jumlah Barang
                $("#data_line1_jumlah_barang").html(data.data['ms_barang'].length);

                // Line 01 - Jumlah Supplier
                $("#data_line1_jumlah_supplier").html(data.data['ms_supplier'].length);

                // Line 01 - Jumlah Cutomer
                $("#data_line1_jumlah_customer").html(data.data['ms_customer'].length);

            }else{                
                Swal.fire({
                    text: data.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                return false;
            }
        },
        error: function () {
            Swal.fire({
                text: "Data Tidak Terkirim, Hubungi Administrator !!",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
            return false;
        }
    });
}

function get_dataTrPurchases()
{
    $.ajax({
        url: BaseURL + "/dash/data/transaksi/purchases",
        async:false,
        data: {
            form_filter_tahun, 
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            // $('.dataContenDashboard').hide();
            // $('.loaderConten').show();
        },
        success: function (data) {
            // console.log(data);
            if(data.status == true)
            {
                // Line 02 - Transaksi Purchases
                $("#data_line2_trpurchases_harian").html(data.data['count_tr_purchases_harian'] + " | Rp. " + data.data['jumlah_tr_purchases_harian']);
                $("#data_line2_trpurchases_total").html(data.data['count_tr_purchases'] + " Purchases");
                $("#data_line2_trpurchases_estimasi").html("Rp. " + data.data['jumlah_tr_purchases']);
                $("#data_line2_trpurchases_barang").html(data.data['count_tr_purchasesdetail_barang'] + " Barang");
                $("#data_line2_trpurchases_barang_unit").html(data.data['unit_tr_purchasesdetail_barang'] + " Unit");
                
                $("#data_line2_trinventory_setharga").html(data.data['count_tr_purchasesdetail_barang_notset_inventory'] + " Barang");
                
                $("#loaderconten_line2_trpurchases").hide();
                $('#conten_line2_trpurchases_harian').show();
                $('#conten_line2_trpurchases_total').show();
                $('#conten_line2_trpurchases_estimasi').show();
                $('#conten_line2_trpurchases_barang').show();
                $('#conten_line2_trpurchases_barang_unit').show();

            }else{                
                Swal.fire({
                    text: data.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                return false;
            }
        },
        error: function () {
            Swal.fire({
                text: "Data Tidak Terkirim, Hubungi Administrator !!",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
            return false;
        }
    });
}

function get_dataTrAssetInventory()
{
    $.ajax({
        url: BaseURL + "/dash/data/transaksi/assetinventory",
        async:false,
        data: {
            form_filter_tahun, 
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            // $('.dataContenDashboard').hide();
            // $('.loaderConten').show();
        },
        success: function (data) {
            // console.log(data);
            if(data.status == true)
            {
                // Line 02 - Transaksi Asset Inventory
                $("#data_line2_trinventory_total").html(data.data['count_tr_assetinventory'] + " Barang");
                $("#data_line2_trinventory_estimasi").html("Rp. " + data.data['jumlah_tr_assetinventory_hargajual']);
                $("#data_line2_trinventory_barang").html(data.data['count_tr_assetinventory'] + " Barang");
                $("#data_line2_trinventory_barang_unit").html(data.data['jumlah_tr_assetinventory_stok'] + " Unit");

                $("#loaderconten_line2_trinventory").hide();
                $('#conten_line2_trinventory_setharga').show();
                $('#conten_line2_trinventory_total').show();
                $('#conten_line2_trinventory_estimasi').show();
                $('#conten_line2_trinventory_barang').show();
                $('#conten_line2_trinventory_barang_unit').show();

            }else{                
                Swal.fire({
                    text: data.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                return false;
            }
        },
        error: function () {
            Swal.fire({
                text: "Data Tidak Terkirim, Hubungi Administrator !!",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
            return false;
        }
    });
}

function get_dataTrPenjualan()
{
    $.ajax({
        url: BaseURL + "/dash/data/transaksi/penjualan",
        async:false,
        data: {
            form_filter_tahun, 
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            // $('.dataContenDashboard').hide();
            // $('.loaderConten').show();
        },
        success: function (data) {
            // console.log(data);
            if(data.status == true)
            {
                // Line 03 - Transaksi Penjualan
                $("#data_line3_trpenjualan_harian").html(data.data['count_tr_penjualan_harian'] + " | Rp. " + data.data['jumlah_tr_penjualan_harian']);
                $("#data_line3_trpenjualan_total").html(data.data['count_tr_penjualan'] + " Transaksi");
                $("#data_line3_trpenjualan_barang").html(data.data['count_tr_penjualandetail_barang'] + " Barang - "+data.data['unit_tr_penjualandetail_barang'] +" Unit");
                $("#data_line3_trpenjualan_estimasipendapatan").html("Rp. " + data.data['jumlah_tr_penjualan']);

                $("#loaderconten_line3_trpenjualan").hide();
                $('#conten_line3_trpenjualan_harian').show();
                $('#conten_line3_trpenjualan_total').show();
                $('#conten_line3_trpenjualan_barang').show();
                $('#conten_line3_trpenjualan_estimasipendapatan').show();

                tmp_statistik_tr_penjualan = data.data['statistik_tr_penjualan'];
                row4_grafik_trpenjualan_total();

            }else{                
                Swal.fire({
                    text: data.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                return false;
            }
        },
        error: function () {
            Swal.fire({
                text: "Data Tidak Terkirim, Hubungi Administrator !!",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
            return false;
        }
    });
}

function get_dataTrKeuangan()
{
    $.ajax({
        url: BaseURL + "/dash/data/transaksi/keuangan",
        async:false,
        data: {
            form_filter_tahun, 
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            // $('.dataContenDashboard').hide();
            // $('.loaderConten').show();
        },
        success: function (data) {
            console.log(data);
            if(data.status == true)
            {
                tmp_statistik_tr_keuangan_pengeluaran = data.data['statistik_tr_keuangan_pengeluaran'];
                chart_statistik_tr_keuangan_pengeluaran();

                diagram_statistik_tr_keuangan(data.data['jumlah_tr_keuangan_pengeluaran'], data.data['jumlah_tr_keuangan_pendapatan']);
            }else{                
                Swal.fire({
                    text: data.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                return false;
            }
        },
        error: function () {
            Swal.fire({
                text: "Data Tidak Terkirim, Hubungi Administrator !!",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
            return false;
        }
    });
}

// Grafik dan Diagram
function row4_grafik_trpenjualan_total()
{    
    var tanggal = arrayTanggal();

    var pass_tanggal_order = tmp_statistik_tr_penjualan;

    var velue = [];
    var k;
    for(k = 0; k < tanggal.length; k++)
    {
        var tmp_velue = 0;

        var keyValidasi = pass_tanggal_order.hasOwnProperty(tanggal[k]);
        if (keyValidasi) {
        // tmp_velue = formatNumber(pass_tanggal_order[tanggal[k]]);
        tmp_velue = pass_tanggal_order[tanggal[k]];
        }

        velue.push(tmp_velue);
    }

    var options = {
        series: [{
        name: 'Transaksi Penjualan',
        data: velue,
    }],
        annotations: {
        points: [{
        x: 'Bananas',
        seriesIndex: 0,
        label: {
            borderColor: '#775DD0',
            offsetY: 0,
            style: {
            color: '#fff',
            background: '#775DD0',
            },
            text: 'Bananas are good',
        }
        }]
    },
    chart: {
        height: 450,
        type: 'bar',
    },
    plotOptions: {
        bar: {
        borderRadius: 10,
        columnWidth: '50%',
        dataLabels: {
            orientation: 'vertical',
            position: 'center' // bottom/center/top
        }
        }
    },
    dataLabels: {
        style: {
        colors: ['#000000']
        },
        offsetY: 15, // play with this value
        formatter: function (value) {
        return formatNumber(value);
        }
    },
    stroke: {
        width: 2
    },
    
    grid: {
        row: {
        colors: ['#fff', '#f2f2f2']
        }
    },
    xaxis: {
        labels: {
        rotate: -45
        },
        categories: tanggal,
        tickPlacement: 'on'
    },
    yaxis: {
        title: {
        text: 'Jumlah Transaksi Penjualan PerHari',
        },
    },
    fill: {
        type: 'gradient',
        gradient: {
        shade: 'light',
        type: "horizontal",
        shadeIntensity: 0.25,
        gradientToColors: undefined,
        inverseColors: true,
        opacityFrom: 0.85,
        opacityTo: 0.85,
        stops: [50, 0, 100]
        },
    }
    };

    document.getElementById('line4_grafik_penjualan').innerHTML = '';
    var chart = new ApexCharts(document.querySelector("#line4_grafik_penjualan"), options);
    chart.render();

    $('#loaderconten_line4_grafik_penjualan').hide();
    $('#conten_line4_grafik_penjualan').show();
}

function chart_statistik_tr_keuangan_pengeluaran()
{    
    var tanggal = arrayTanggal();

    var pass_tanggal_order = tmp_statistik_tr_keuangan_pengeluaran;

    var velue = [];
    var k;
    for(k = 0; k < tanggal.length; k++)
    {
        var tmp_velue = 0;

        var keyValidasi = pass_tanggal_order.hasOwnProperty(tanggal[k]);
        if (keyValidasi) {
        // tmp_velue = formatNumber(pass_tanggal_order[tanggal[k]]);
        tmp_velue = pass_tanggal_order[tanggal[k]];
        }

        velue.push(tmp_velue);
    }

    var options = {
        series: [{
        name: 'Transaksi Pengeluaran',
        data: velue,
    }],
        annotations: {
        points: [{
        x: 'Bananas',
        seriesIndex: 0,
        label: {
            borderColor: '#775DD0',
            offsetY: 0,
            style: {
            color: '#fff',
            background: '#775DD0',
            },
            text: 'Bananas are good',
        }
        }]
    },
    chart: {
        height: 450,
        type: 'bar',
    },
    plotOptions: {
        bar: {
        borderRadius: 10,
        columnWidth: '50%',
        dataLabels: {
            orientation: 'vertical',
            position: 'center' // bottom/center/top
        }
        }
    },
    dataLabels: {
        style: {
        colors: ['#000000']
        },
        offsetY: 15, // play with this value
        formatter: function (value) {
        return formatNumber(value);
        }
    },
    stroke: {
        width: 2
    },
    
    grid: {
        row: {
        colors: ['#fff', '#f2f2f2']
        }
    },
    xaxis: {
        labels: {
        rotate: -45
        },
        categories: tanggal,
        tickPlacement: 'on'
    },
    yaxis: {
        title: {
        text: 'Chart Laporan Pengeluaran Keuangan PerHari',
        },
    },
    fill: {
        type: 'gradient',
        gradient: {
        shade: 'light',
        type: "horizontal",
        shadeIntensity: 0.25,
        gradientToColors: undefined,
        inverseColors: true,
        opacityFrom: 0.85,
        opacityTo: 0.85,
        stops: [50, 0, 100]
        },
    }
    };

    document.getElementById('line4_chart_statistik_tr_keuangan_pengeluaran').innerHTML = '';
    var chart = new ApexCharts(document.querySelector("#line4_chart_statistik_tr_keuangan_pengeluaran"), options);
    chart.render();

    $('#loaderconten_line4_grafik_keuangan_pengeluaran').hide();
    $('#conten_statistik_tr_keuangan_pengeluaran').show();
}

function diagram_statistik_tr_keuangan(jumlah_tr_keuangan_pengeluaran, jumlah_tr_keuangan_pendapatan)
{
    var options = {        
        chart: {
            type: 'donut',
        },        
        colors: ['#99a7f9', '#f0f02f'],
        labels: ['Pengeluaran Keuangan', 'Pemasukan Keuangan'],
        series: [jumlah_tr_keuangan_pengeluaran, jumlah_tr_keuangan_pendapatan],
        stroke: {
            width: 0,
            lineCap: "round"
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
        legend: {
            show: !0,
            position: "bottom",
            horizontalAlign: "center",
            labels: {
                useSeriesColors: !1
            },
            markers: {
                width: 10,
                height: 10,
                offsetX: -3
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: "70%",
                    labels: {
                        show: !0,
                        name: {
                            fontSize: "0.938rem",
                            offsetY: 20
                        },
                        value: {
                            show: !0,
                            fontSize: "2rem",
                            fontFamily: "Rubik",
                            fontWeight: "500",
                            offsetY: -20,
                            formatter: function(o) {
                                return o
                            }
                        },
                        total: {
                            show: !0,
                            label: "Total Transaksi",
                            formatter: function(o) {
                                return o.globals.seriesTotals.reduce(function(o, e) {
                                    return o + e
                                }, 0)
                            }
                        }
                    }
                }
            }
        },
    };

    document.getElementById('diagram_statistik_tr_keuangan').innerHTML = '';
    var chart = new ApexCharts(document.querySelector("#diagram_statistik_tr_keuangan"), options);
    chart.render();

    $('#loaderconten_line4_diagram_statistik_tr_keuangan').hide();
    $('#conten_diagram_statistik_tr_keuangan').show();
}

$(document).ready(function() {
    get_dataMasterDash();
    get_dataTrPurchases();
    get_dataTrAssetInventory();
    get_dataTrPenjualan();
    get_dataTrKeuangan();

    $("#tabel_master_data").DataTable({
        pageLength: 5,
        "language": {
            "lengthMenu": "Show _MENU_",
        },
        "dom":
            "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +
    
            "<'table-responsive'tr>" +
    
            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
    });
});