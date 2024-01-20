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

function serverSideDatatables()
{
    let form_filter_program = $("#form_filter_program").val();
    let form_filter_program_jenis = $("#form_filter_program_jenis").val();
    let form_filter_program_lokasi = $("#form_filter_program_lokasi").val();
    let form_filter_program_priority = $("#form_filter_program_priority").val();

    $('#tabel_master_data').dataTable().fnDestroy();

    $('#tabel_master_data').DataTable({
        processing: true,
        serverSide: true,
        searching:true,        
        pageLength: 10,
        ajax: {
            url: BaseURL + "/masterdata/program/get_datatable",
            type: "POST",
            data: {
                form_filter_program:form_filter_program,
                form_filter_program_jenis:form_filter_program_jenis,
                form_filter_program_lokasi:form_filter_program_lokasi,
                form_filter_program_priority:form_filter_program_priority
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

                $("#data_line2_program_jenis").html(data.jumlahMsProgramJenis + " CCK");
                $("#data_line2_program_lokasi").html(data.jumlahMsProgramLokasi + " CC");
                $("#data_line2_program_total").html(data.jumlahMsProgram +" | "+data.totalMsProgramNominal);
                $("#data_line2_program_total_filter").html(data.jumlahFilterMsProgram +" | "+data.totalFilterMsProgramNominal);

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
            {data: 'fild_jenis', name: 'fild_jenis'},
            {data: 'fild_lokasi', name: 'fild_lokasi'},
            {data: 'fild_priority', name: 'fild_priority'},
            {data: 'fild_nominal', name: 'fild_nominal'},
            {data: 'action', name: 'action'}            
        ]
    });
}

function datatabelesreload()
{
	$('#tabel_master_data').DataTable().ajax.reload(null, false); //Reload Tanpa Reset Page Datatable
}

function reset_formData()
{
    $('#btnTambahMasterdata').show();
    $('#btnUpdateMasterdata').hide();
}

function btn_tambahMasterdata()
{
    reset_formData();
    $('#modal-masterdata-program').modal('show');
}

function act_submitTambahData()
{
    let form_masterdata_program_nama = $("#form_masterdata_program_nama").val();
    let form_masterdata_program_fundnumber = $("#form_masterdata_program_fundnumber").val();
    let form_masterdata_program_fundcenter = $("#form_masterdata_program_fundcenter").val();
    let form_masterdata_program_deskripsi = $("#form_masterdata_program_deskripsi").val();
    let form_masterdata_program_anggaran = $("#form_masterdata_program_anggaran").val();
    let form_masterdata_program_jenis = $("#form_masterdata_program_jenis").val();
    let form_masterdata_program_lokasi = $("#form_masterdata_program_lokasi").val();
    let form_masterdata_program_priority = $("#form_masterdata_program_priority").val();

    // validasi form
    if(form_masterdata_program_nama == "" || form_masterdata_program_deskripsi == "" || form_masterdata_program_anggaran == "")
    {
        Swal.fire({
            text: "Pastikan Anda Sudah Mengisi Semua Form Data..!!",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    // validasi form
    if(form_masterdata_program_jenis == "" || form_masterdata_program_lokasi == "" || form_masterdata_program_priority == "")
    {
        Swal.fire({
            text: "Pastikan Anda Sudah Mengisi dan Memilih Semua Form Data..!!",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    Swal.fire({
        title: 'Yakin Menambah Data ?',
        text: "Pastikan Anda Sudah Mengecek Kembali Data Yang Akan Dikirim..",
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
                url: BaseURL + "/masterdata/program/act_tambah",
                data: {
                    form_masterdata_program_nama,
                    form_masterdata_program_fundnumber,
                    form_masterdata_program_fundcenter,
                    form_masterdata_program_deskripsi,
                    form_masterdata_program_anggaran,
                    form_masterdata_program_jenis,
                    form_masterdata_program_lokasi,
                    form_masterdata_program_priority
                },
                method: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {    
                    KTApp.showPageLoading();                    
                },
                success: function (data) {
                    KTApp.hidePageLoading();
                    loadingEl.remove();
 
                    if(data.status == true)
                    {
                        Swal.fire({
                            title: 'Insert Success !',
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
                    KTApp.hidePageLoading();
                    loadingEl.remove();

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
                },
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

function act_btnUpdateData(data)
{
    reset_formData();

    let data_id = $(data).attr('data-id');

    $.ajax({
        url: BaseURL + "/masterdata/program/act_detail",
        data: {
            data_id,
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {    
            KTApp.showPageLoading();                    
        },
        success: function (data) {
            KTApp.hidePageLoading();
            loadingEl.remove();

            if(data.status == true)
            {
                // console.log(data.data);
                $('#btnTambahMasterdata').hide();
                $('#btnUpdateMasterdata').show();   
                
                $('#form_masterdata_program_uuid').val(data.data.uuid).prop('readonly', true);
                $('#form_masterdata_program_fundnumber').val(data.data.fund_number);
                $('#form_masterdata_program_nama').val(data.data.name);
                $('#form_masterdata_program_deskripsi').val(data.data.description);
                $('#form_masterdata_program_anggaran').val(data.data.nominal);

                $('#form_masterdata_program_fundcenter').val(data.data.fund_center);
                $('#form_masterdata_program_jenis').val(data.data.m_program_jenis_c_c_k.uuid).change();
                $('#form_masterdata_program_lokasi').val(data.data.m_program_lokasi_c_c.uuid).change();
                $('#form_masterdata_program_priority').val(data.data.priority).change();

                $('#modal-masterdata-program').modal('show');
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
            KTApp.hidePageLoading();
            loadingEl.remove();

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

function act_sumbitUpdateData()
{
    let form_masterdata_program_uuid = $("#form_masterdata_program_uuid").val();
    let form_masterdata_program_nama = $("#form_masterdata_program_nama").val();
    let form_masterdata_program_fundnumber = $("#form_masterdata_program_fundnumber").val();
    let form_masterdata_program_fundcenter = $("#form_masterdata_program_fundcenter").val();
    let form_masterdata_program_deskripsi = $("#form_masterdata_program_deskripsi").val();
    let form_masterdata_program_anggaran = $("#form_masterdata_program_anggaran").val();
    let form_masterdata_program_jenis = $("#form_masterdata_program_jenis").val();
    let form_masterdata_program_lokasi = $("#form_masterdata_program_lokasi").val();
    let form_masterdata_program_priority = $("#form_masterdata_program_priority").val();

    // validasi form
    if(form_masterdata_program_nama == "" || form_masterdata_program_deskripsi == "" || form_masterdata_program_anggaran == "")
    {
        Swal.fire({
            text: "Pastikan Anda Sudah Mengisi Semua Form Data..!!",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    // validasi form
    if(form_masterdata_program_jenis == "-" || form_masterdata_program_lokasi == "-" || form_masterdata_program_priority == "-")
    {
        Swal.fire({
            text: "Pastikan Anda Sudah Mengisi dan Memilih Semua Form Data..!!",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    Swal.fire({
        title: 'Yakin Update Data ?',
        text: "Pastikan Anda Sudah Mengecek Kembali Data Yang Akan Dikirim..",
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
                url: BaseURL + "/masterdata/program/act_update",
                data: {
                    form_masterdata_program_uuid,
                    form_masterdata_program_nama,
                    form_masterdata_program_fundnumber,
                    form_masterdata_program_fundcenter,
                    form_masterdata_program_deskripsi,
                    form_masterdata_program_anggaran,
                    form_masterdata_program_jenis,
                    form_masterdata_program_lokasi,
                    form_masterdata_program_priority
                },
                method: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {    
                    KTApp.showPageLoading();                    
                },
                success: function (data) {
                    KTApp.hidePageLoading();
                    loadingEl.remove();
 
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
                    KTApp.hidePageLoading();
                    loadingEl.remove();

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
                },
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

$(document).ready(function() {
    serverSideDatatables();    
});