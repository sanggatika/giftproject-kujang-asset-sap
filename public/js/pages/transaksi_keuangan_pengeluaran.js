"use strict";
var data_decrpty = null;

function act_resetFilter()
{
    location.reload();
    return false;
}

$("#form_filter_startdate").flatpickr();
$("#form_filter_enddate").flatpickr();

function reset_formData()
{
    $('#btnTambahMasterdata').show();
    $('#btnUpdateMasterdata').hide();
}

form_filter_pengeluaran.onchange = evt => {
    serverSideDatatables();
}

form_filter_jenispengeluaran.onchange = evt => {
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
    let form_filter_pengeluaran = $("#form_filter_pengeluaran").val();
    let form_filter_jenispengeluaran = $("#form_filter_jenispengeluaran").val();
    let form_filter_startdate = $("#form_filter_startdate").val();
    let form_filter_enddate = $("#form_filter_enddate").val();

    $('#tabel_master_data').dataTable().fnDestroy();

    $('#tabel_master_data').DataTable({
        processing: true,
        serverSide: true,
        searching:true,        
        pageLength: 10,
        ajax: {
            url: BaseURL + "/transaksi/keuangan/pengeluaran/get_datatable",
            type: "POST",
            data: {
                form_filter_pengeluaran:form_filter_pengeluaran,
                form_filter_jenispengeluaran:form_filter_jenispengeluaran,
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
            {data: 'fild_judul', name: 'fild_judul'},
            {data: 'fild_jenis', name: 'fild_jenis'},
            {data: 'fild_waktu', name: 'fild_waktu'},
            {data: 'fild_nominal', name: 'fild_nominal'},
            {data: 'fild_status', name: 'fild_status'},
            {data: 'action', name: 'action'}            
        ]
    });
}

function datatabelesreload()
{
	$('#tabel_master_data').DataTable().ajax.reload(null, false); //Reload Tanpa Reset Page Datatable
}

$("#form_keuanagan_pengeluaran_waktu").flatpickr();
$('#form_card_pegawai').hide();

function btn_tambahTrPengeluaranKeuangan()
{
    reset_formData();
    $('#form_card_pegawai').hide();
    $('#modal-masterdata-jenisbarang').modal('show');
}

form_keuanagan_pengeluaran_jenis.onchange = evt => {
    let form_keuanagan_pengeluaran_jenis = $("#form_keuanagan_pengeluaran_jenis").val();

    $('#form_card_pegawai').hide();
    if(form_keuanagan_pengeluaran_jenis == 'pinjaman-pegawai')
    {
        $('#form_card_pegawai').show();
    }
}

form_keuanagan_pengeluaran_pegawai.onchange = evt => {
    let form_keuanagan_pengeluaran_pegawai = $("#form_keuanagan_pengeluaran_pegawai").val();

    if(form_keuanagan_pengeluaran_pegawai != '-')
    {
        $("#form_keuanagan_pengeluaran_judul").val('Pengeluaran Pinjaman Pegawai a.n ' + form_keuanagan_pengeluaran_pegawai);
        $('#form_keuanagan_pengeluaran_deskripsi').val('Pengeluaran Pinjaman Pegawai a.n ' + form_keuanagan_pengeluaran_pegawai +' Untuk Keperluan');
    }
}

function act_submitTambahData()
{
    let form_keuanagan_pengeluaran_judul = $("#form_keuanagan_pengeluaran_judul").val();
    let form_keuanagan_pengeluaran_jenis = $("#form_keuanagan_pengeluaran_jenis").val();
    let form_keuanagan_pengeluaran_waktu = $("#form_keuanagan_pengeluaran_waktu").val();
    let form_keuanagan_pengeluaran_deskripsi = $("#form_keuanagan_pengeluaran_deskripsi").val();
    let form_keuanagan_pengeluaran_nominal = $("#form_keuanagan_pengeluaran_nominal").val();

    // Proses Kirim Data AJAX
    $.ajax({
        url: BaseURL + "/transaksi/keuangan/pengeluaran/act_tambah",
        data: {
            form_keuanagan_pengeluaran_judul,
            form_keuanagan_pengeluaran_jenis,
            form_keuanagan_pengeluaran_waktu,
            form_keuanagan_pengeluaran_deskripsi,
            form_keuanagan_pengeluaran_nominal
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {            
            if(data.status == true)
            {
                Swal.fire({
                    title: 'Berhasil Menambahkan !',
                    text: data.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Relode Page',
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger ml-1',
                    buttonsStyling: false,
                    allowOutsideClick: false,
                }).then(function (result) {
                    if (result.value) {
                        /* Read more about isConfirmed, isDenied below */
                        location.reload();
                        return false;
                    }
                })
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

function actUpdateStatusMasterdata(data)
{
    let data_id = $(data).attr('data-id');
    let data_status = $(data).attr('data-status');

    Swal.fire({
        title: 'Yakin Update Data ?',
        text: "Pastikan Anda Sudah Mengecek Kembali Data akan di update?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Submit!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ml-1'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {

            $.ajax({
                url: BaseURL + "/transaksi/keuangan/pengeluaran/act_update_status",
                data: {
                    data_id,
                    data_status,
                },
                method: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if(data.status == true)
                    {
                        Swal.fire({
                            title: 'Update Success !',
                            text: data.message,
                            icon: "success",
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Oke',
                            allowOutsideClick: false,
                            closeOnClickOutside: false,
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                location.reload();
                                return false;
                            }                    
                        })
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
            
        }else{
            Swal.fire({
                text: "Pastikan Anda Sudah Mengisi Form Required.. !!",
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

function act_btnDonloadExcell()
{
    let form_filter_pengeluaran = $("#form_filter_pengeluaran").val();
    let form_filter_jenispengeluaran = $("#form_filter_jenispengeluaran").val();
    let form_filter_startdate = $("#form_filter_startdate").val();
    let form_filter_enddate = $("#form_filter_enddate").val();

    $.ajax({
        xhrFields: {
            responseType: 'blob',
        },
        url: BaseURL + "/dev/export/excell/transaksi/keuangan/pengeluaran",
        data: {
            form_filter_pengeluaran,
            form_filter_jenispengeluaran,
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
            var filename = (matches != null && matches[1] ? matches[1] : 'data-transaksi-keuangan-pengeluaran-'+data_time+'.xlsx');

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