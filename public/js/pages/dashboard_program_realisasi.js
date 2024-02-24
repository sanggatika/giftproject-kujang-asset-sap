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

function line2_chart_program_investasi_multiyear()
{
    var options = {
        series: [{
        name: 'PROGRAM',
        data: [jumlahMsProgramMultiyearAccountUser, jumlahMsProgramMultiyearAccountMIR, jumlahMsProgramMultiyearAccountSR, jumlahMsProgramMultiyearAccountPR, jumlahMsProgramMultiyearAccountPO, jumlahMsProgramMultiyearAccountGR]
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
          text: 'PROGRAM MULTIYEAR',
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

    document.getElementById('line2_chart_program_investasi_multiyear').innerHTML = '';
    var chart = new ApexCharts(document.querySelector("#line2_chart_program_investasi_multiyear"), options);
    chart.render();
}

function line2_diagram_program_account()
{
    var options = {        
      chart: {
          type: 'donut',
      },        
      colors: ['#5E1675', '#FFE3CA', '#387ADF', '#F9F07A', '#8E7AB5','#E1F0DA'],
      labels: ['Pabrik', 'A2B', 'Peralatan', 'Bangunan', 'AsetTBWJD', 'SCP'],
      series: [jumlahMsProgramAccountPabrik, jumlahMsProgramAccountA2B, jumlahMsProgramAccountPeralatan, jumlahMsProgramAccountBangunan, jumlahMsProgramAccountAsetTBWJD, jumlahMsProgramAccountSCP],
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
                          label: "GL ACCOUNT",
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

  document.getElementById('line2_diagram_program_account').innerHTML = '';
  var chart = new ApexCharts(document.querySelector("#line2_diagram_program_account"), options);
  chart.render();
}

function line2_diagram_proses_pengadaan()
{
    var options = {        
        chart: {
            type: 'donut',
        },        
        colors: ['#98ABEE', '#1D24CA'],
        labels: ['ANPER - PKC', 'SENTRALISASI PI'],
        series: [jumlahProsesPengadanInvestasiANPER, jumlahProsesPengadanInvestasiPI],
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
                            label: "PROSES PENGADAAN",
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

    document.getElementById('line2_diagram_proses_pengadaan').innerHTML = '';
    var chart = new ApexCharts(document.querySelector("#line2_diagram_proses_pengadaan"), options);
    chart.render();
}

function line2_chart_proses_pengadaan()
{
  var options = {
    series: [{
        data: [jumlahProsesPengadanInvestasiANPER, jumlahProsesPengadanInvestasiPI]
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
        categories: ['ANPER', 'PIHC'],
    },
    colors: ['#98ABEE', '#1D24CA'], // Add your desired colors here
  };

    document.getElementById('line2_chart_proses_pengadaan').innerHTML = '';
    var chart = new ApexCharts(document.querySelector("#line2_chart_proses_pengadaan"), options);
    chart.render();
}

function line2_chart_proses_pengadaan_anper()
{
  var options = {
    series: [{
        data: [jumlahProsesPengadanInvestasiANPERUser, jumlahProsesPengadanInvestasiANPERMIR, jumlahProsesPengadanInvestasiANPERSR, jumlahProsesPengadanInvestasiANPERPR, jumlahProsesPengadanInvestasiANPERPO, jumlahProsesPengadanInvestasiANPERGR]
    }],
    chart: {
        type: 'bar',
        height: 210
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
        categories: ['USER', 'MIR', 'SR', 'PR', 'PO', 'GR'],
    },
    colors: ['#98ABEE', '#1D24CA'], // Add your desired colors here
  };

    document.getElementById('line2_chart_proses_pengadaan_anper').innerHTML = '';
    var chart = new ApexCharts(document.querySelector("#line2_chart_proses_pengadaan_anper"), options);
    chart.render();
}

function line2_chart_proses_pengadaan_pi()
{
  var options = {
    series: [{
        data: [jumlahProsesPengadanInvestasiPIUser, jumlahProsesPengadanInvestasiPIMIR, jumlahProsesPengadanInvestasiPISR, jumlahProsesPengadanInvestasiPIPR, jumlahProsesPengadanInvestasiPIPO, jumlahProsesPengadanInvestasiPIGR]
    }],
    chart: {
        type: 'bar',
        height: 210
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
        categories: ['USER', 'MIR', 'SR', 'PR', 'PO', 'GR'],
    },
    colors: ['#98ABEE', '#1D24CA'], // Add your desired colors here
  };

    document.getElementById('line2_chart_proses_pengadaan_pi').innerHTML = '';
    var chart = new ApexCharts(document.querySelector("#line2_chart_proses_pengadaan_pi"), options);
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

    line2_chart_program_investasi_multiyear();

    $("#tabel_progres_program_multiyear_departement").DataTable({
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

  line2_diagram_program_account();

  line2_diagram_proses_pengadaan();
  line2_chart_proses_pengadaan();

  line2_chart_proses_pengadaan_anper();
  line2_chart_proses_pengadaan_pi();

});