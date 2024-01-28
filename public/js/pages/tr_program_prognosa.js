"use strict";
var data_decrpty = null;

form_filter_program.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_jenis.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_lokasi.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_priority.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_fundnumber.onchange = evt => {
    serverSideDatatables();
}

form_filter_tanggal_cutoff.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_min_anggaran.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_max_anggaran.onchange = evt => {
    serverSideDatatables();
}

function serverSideDatatables()
{
    let form_filter_program = $("#form_filter_program").val();
    let form_filter_program_jenis = $("#form_filter_program_jenis").val();
    let form_filter_program_lokasi = $("#form_filter_program_lokasi").val();
    let form_filter_program_priority = $("#form_filter_program_priority").val();

    let form_filter_program_fundnumber = $("#form_filter_program_fundnumber").val();
    let form_filter_tanggal_cutoff = $("#form_filter_tanggal_cutoff").val();
    let form_filter_program_min_anggaran = $("#form_filter_program_min_anggaran").val();
    let form_filter_program_max_anggaran = $("#form_filter_program_max_anggaran").val();

    $('#tabel_master_data').dataTable().fnDestroy();

    $('#tabel_master_data').DataTable({
        processing: true,
        serverSide: true,
        searching:true,        
        pageLength: 10,
        ajax: {
            url: BaseURL + "/transaksi/program/prognosa/get_datatable",
            type: "POST",
            data: {
                form_filter_program:form_filter_program,
                form_filter_program_jenis:form_filter_program_jenis,
                form_filter_program_lokasi:form_filter_program_lokasi,
                form_filter_program_priority:form_filter_program_priority,
                form_filter_program_fundnumber:form_filter_program_fundnumber,
                form_filter_tanggal_cutoff:form_filter_tanggal_cutoff,
                form_filter_program_min_anggaran:form_filter_program_min_anggaran,
                form_filter_program_max_anggaran:form_filter_program_max_anggaran
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                // setting a timeout
                KTApp.showPageLoading();
            },
            dataSrc: function (data) {
                // console.log(data);
                KTApp.hidePageLoading();
                loadingEl.remove(); 

                $("#data_line2_program_total").html(data.jumlahMsProgram +" | "+data.totalMsProgramNominal);
                $("#data_line2_program_total_filter").html(data.jumlahFilterMsProgram +" | "+data.totalFilterMsProgramNominal);

                $("#data_line2_program_total_realisasi").html(data.totalTrPrognosaGR);
                $("#data_line2_program_total_prognosa").html(data.totalMsProgramPrognosa);
                // $("#data_totalTrProgresGR").html(data.totalTrProgresGR);

                return data.data;
            },
            error: function ()
            {
                KTApp.hidePageLoading();
                loadingEl.remove(); 

                Swal.fire({
                    title: 'Informasi !',
                    text: ' Harap Hubungi Petugas, Data Tidak Bisa Di Load',
                    icon: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', class:'text-center'},
            {data: 'fund_number', name: 'fund_number'},
            {data: 'fild_name', name: 'fild_name'},
            {data: 'fild_nominal', name: 'fild_nominal'},
            {data: 'fild_mr', name: 'fild_mr'},
            {data: 'fild_gr', name: 'fild_gr'},
            {data: 'fild_prognosa', name: 'fild_prognosa'},
            {data: 'fild_sisa', name: 'fild_sisa'}            
        ]
    });
}

function datatabelesreload()
{
	$('#tabel_master_data').DataTable().ajax.reload(null, false); //Reload Tanpa Reset Page Datatable
}

$(document).ready(function() {
    serverSideDatatables();    

    $("#form_filter_tanggal_cutoff").flatpickr();
});