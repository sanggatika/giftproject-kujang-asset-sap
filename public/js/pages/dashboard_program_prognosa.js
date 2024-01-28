"use strict";
var data_decrpty = null;

form_filter_tanggal_cutoff.onchange = evt => {
    let form_filter_tanggal_cutoff = $("#form_filter_tanggal_cutoff").val();
    window.location.replace(BaseURL + "/dash/prognosa/" + form_filter_tanggal_cutoff);
    return false;
}

const formatNumber = (number)=>{
    return number.toLocaleString('id-ID');
}

function line2_diagram_progres_realisasi()
{
    var options = {        
        chart: {
            type: 'donut',
        },        
        colors: ['#99a7f9', '#f0f02f'],
        labels: ['Prognosa Program', 'Sisa Anggaran'],
        series: [total_program_prognosa, total_program_anggaran_sisa],
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
                            label: "Total Anggaran",
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

    document.getElementById('line2_diagram_progres_realisasi').innerHTML = '';
    var chart = new ApexCharts(document.querySelector("#line2_diagram_progres_realisasi"), options);
    chart.render();
}

$(document).ready(function() {
    line2_diagram_progres_realisasi();

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

    $("#tabel_master_data_program_lokasi").DataTable({
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

    $("#tabel_master_tr_prognosa").DataTable({
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
});