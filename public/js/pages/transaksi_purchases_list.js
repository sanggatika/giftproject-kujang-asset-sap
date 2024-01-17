"use strict";
var data_decrpty = null;

$("#form_filter_startdate").flatpickr();
$("#form_filter_enddate").flatpickr();

function act_resetFilter()
{
    location.reload();
    return false;
}

form_filter_supplier.onchange = evt => {
    serverSideDatatables();
}

form_filter_barang.onchange = evt => {
    serverSideDatatables();
}

form_filter_startdate.onchange = evt => {
    serverSideDatatables();
}

form_filter_enddate.onchange = evt => {
    serverSideDatatables();
}

function serverSideDatatables()
{
    let form_filter_supplier = $("#form_filter_supplier").val();
    let form_filter_barang = $("#form_filter_barang").val();
    let form_filter_startdate = $("#form_filter_startdate").val();
    let form_filter_enddate = $("#form_filter_enddate").val();

    $('#tabel_master_data').dataTable().fnDestroy();

    $('#tabel_master_data').DataTable({
        processing: true,
        serverSide: true,
        searching:true,        
        pageLength: 10,
        ajax: {
            url: BaseURL + "/transaksi/purchases/get_datatable",
            type: "POST",
            data: {
                form_filter_supplier:form_filter_supplier,
                form_filter_barang:form_filter_barang,
                form_filter_startdate:form_filter_startdate,
                form_filter_enddate:form_filter_enddate
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
            {data: 'fild_nama', name: 'fild_nama', class:'align-top'},
            {data: 'fild_supplier', name: 'fild_supplier', class:'align-top'},
            {data: 'fild_barang', name: 'fild_barang'},
            {data: 'total_pembelian', name: 'total_pembelian'},
            {data: 'fild_status', name: 'fild_status'},
            {data: 'action', name: 'action'}            
        ]
    });
}

function datatabelesreload()
{
	$('#tabel_master_data').DataTable().ajax.reload(null, false); //Reload Tanpa Reset Page Datatable
}

function act_btnDonloadExcell()
{
    let form_filter_supplier = $("#form_filter_supplier").val();
    let form_filter_barang = $("#form_filter_barang").val();
    let form_filter_startdate = $("#form_filter_startdate").val();
    let form_filter_enddate = $("#form_filter_enddate").val();

    $.ajax({
        xhrFields: {
            responseType: 'blob',
        },
        url: BaseURL + "/dev/export/excell/transaksi/purchases",
        data: {
            form_filter_supplier,
            form_filter_barang,
            form_filter_startdate,
            form_filter_enddate
        },
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (result, status, xhr) {
            var disposition = xhr.getResponseHeader('content-disposition');
            var matches = /"([^"]*)"/.exec(disposition);

            const data_datetime = new Date();
            let data_time = data_datetime.getTime();
            var filename = (matches != null && matches[1] ? matches[1] : 'data-transaksi-purchases-'+data_time+'.xlsx');

            // The actual download
            var blob = new Blob([result], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;

            document.body.appendChild(link);

            link.click();
            document.body.removeChild(link);
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

$(document).ready(function() {
    serverSideDatatables();    
});