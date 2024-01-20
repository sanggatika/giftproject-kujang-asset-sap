"use strict";
var data_decrpty = null;

const formatNumber = (number)=>{
    return number.toLocaleString('id-ID');
}

function row4_grafik_transaksi_total()
{    
    var data_name = program_jenis_name;

    var data_nominal = program_jenis_nominal;

    // var options = {
    //     series: [{
    //     name: 'Anggaran',
    //     data: velue,
    // }],
    //     annotations: {
    //     points: [{
    //     x: 'Bananas',
    //     seriesIndex: 0,
    //     label: {
    //         borderColor: '#775DD0',
    //         offsetY: 0,
    //         style: {
    //         color: '#fff',
    //         background: '#775DD0',
    //         },
    //         text: 'Bananas are good',
    //     }
    //     }]
    // },
    // chart: {
    //     height: 550,
    //     type: 'bar',
    // },
    // plotOptions: {
    //     bar: {
    //     borderRadius: 10,
    //     columnWidth: '50%',
    //     dataLabels: {
    //         orientation: 'vertical',
    //         position: 'center' // bottom/center/top
    //     }
    //     }
    // },
    // dataLabels: {
    //     style: {
    //     colors: ['#000000']
    //     },
    //     offsetY: 15, // play with this value
    //     formatter: function (value) {
    //     return formatNumber(value);
    //     }
    // },
    // stroke: {
    //     width: 2
    // },
    
    // grid: {
    //     row: {
    //     colors: ['#fff', '#f2f2f2']
    //     }
    // },
    // xaxis: {
    //     labels: {
    //         rotate: -45,
    //     },
    //     categories: tanggal
    // },
    // yaxis: {
    //     title: {
    //     text: 'Jumlah Program Jenis CCK',
    //     },
    // },
    // fill: {
    //     type: 'gradient',
    //     gradient: {
    //     shade: 'light',
    //     type: "horizontal",
    //     shadeIntensity: 0.25,
    //     gradientToColors: undefined,
    //     inverseColors: true,
    //     opacityFrom: 0.85,
    //     opacityTo: 0.85,
    //     stops: [50, 0, 100]
    //     },
    // }
    // };

    var options = {
        series: [{
        data: data_nominal
      }],
        chart: {
        type: 'bar',
        height: 550
      },
      plotOptions: {
        bar: {
          barHeight: '100%',
          distributed: true,
          horizontal: true,
          dataLabels: {
            position: 'bottom'
          },
        }
      },
      colors: ['#775DD0'],
      dataLabels: {
        enabled: true,
        textAnchor: 'start',
        style: {
          colors: ['#fff']
        },
        formatter: function (val, opt) {
          return opt.w.globals.labels[opt.dataPointIndex] + ":  " + formatNumber(val) 
        },
        offsetX: 0,
        dropShadow: {
          enabled: true
        }
      },
      stroke: {
        width: 1,
        colors: ['#fff']
      },
      xaxis: {
        categories: data_name,
      },
      yaxis: {
        labels: {
          show: false
        }
      },
      tooltip: {
        theme: 'dark',
        x: {
          show: false
        },
        y: {
          title: {
            formatter: function (val, opt) {
                return opt.w.globals.labels[opt.dataPointIndex] + " :  " 
            }
          }
        }
      }
    };

    document.getElementById('line4_grafik_program_jenis').innerHTML = '';
    var chart = new ApexCharts(document.querySelector("#line4_grafik_program_jenis"), options);
    chart.render();

    // $('#loaderconten_line4_grafik_total').hide();
    // $('#conten_line4_grafik_total').show();
}

$(document).ready(function() {
    row4_grafik_transaksi_total();

    $("#tabel_master_data").DataTable({
        pageLength: 5,
        ordering: false,
        responsive: true,
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

    $("#tabel_master_data_program_jenis").DataTable({
        pageLength: 5,
        ordering: false,
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