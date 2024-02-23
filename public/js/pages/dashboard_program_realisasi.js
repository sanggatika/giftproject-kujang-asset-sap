"use strict";
var data_decrpty = null;

const formatNumber = (number)=>{
    return number.toLocaleString('id-ID');
}

function line2_diagram_program_investasi_year()
{
    var options = {        
        chart: {
            type: 'donut',
        },        
        colors: ['#99a7f9', '#f0f02f'],
        labels: ['Single Year', 'Multi Year'],
        series: [jumlahMsProgramSingleYear, jumlahMsProgramMultiYear],
        stroke: {
            width: 0,
            lineCap: "round"
        },
        responsive: [{
            options: {
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
                            fontSize: "0.5rem",
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
                            label: "PROGRAM INVESTASI",
                            formatter: function(o) {
                                return o.globals.seriesTotals.reduce(function(o, e) {
                                    var data_jumlah = parseInt(o) + parseInt(e);
                                    return o + e
                                }, 0)
                            }
                        }
                    }
                }
            }
        },
    };

    document.getElementById('line2_diagram_program_investasi_year').innerHTML = '';
    var chart = new ApexCharts(document.querySelector("#line2_diagram_program_investasi_year"), options);
    chart.render();
}

function line2_chart_program_investasi_year()
{
    var options = {
        series: [{
        data: [jumlahMsProgramSingleYear, jumlahMsProgramMultiYear]
      }],
        chart: {
        type: 'bar',
        height: 150
      },
      plotOptions: {
        bar: {
          borderRadius: 4,
          horizontal: true,
        }
      },
      dataLabels: {
        enabled: false
      },
      xaxis: {
        categories: ['SINGLEYEAR', 'MULTIYEARS'],
      }
    };

    document.getElementById('line2_chart_program_investasi_year').innerHTML = '';
    var chart = new ApexCharts(document.querySelector("#line2_chart_program_investasi_year"), options);
    chart.render();
}

function line2_chart_program_investasi_singleyear()
{
    var options = {
        series: [{
        name: 'PROGRAM',
        data: [jumlahMsProgramSingleyearAccountUser, jumlahMsProgramSingleyearAccountMIR, jumlahMsProgramSingleyearAccountSR, jumlahMsProgramSingleyearAccountPR, jumlahMsProgramSingleyearAccountPO, jumlahMsProgramSingleyearAccountGR]
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
        height: 330,
        type: 'bar',
      },
      plotOptions: {
        bar: {
          borderRadius: 10,
          columnWidth: '50%',
        }
      },
      dataLabels: {
        enabled: false
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
        categories: ['USER', 'MIR', 'SR', 'PR', 'PO', 'GR'],
        tickPlacement: 'on'
      },
      yaxis: {
        title: {
          text: 'PROGRAM SINGLEYEAR',
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

    document.getElementById('line2_chart_program_investasi_singleyear').innerHTML = '';
    var chart = new ApexCharts(document.querySelector("#line2_chart_program_investasi_singleyear"), options);
    chart.render();
}

$(document).ready(function() {
    line2_diagram_program_investasi_year();
    line2_chart_program_investasi_year();
    line2_chart_program_investasi_singleyear();

    $("#tabel_progres_program_singleyear_departement").DataTable({
        pageLength: 6,
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