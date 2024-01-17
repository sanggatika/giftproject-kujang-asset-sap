"use strict";
var data_decrpty = null;

function act_resetFilter()
{
    location.reload();
    return false;
}

form_filter_supplier.onchange = evt => {
    serverSideDatatables();
}

form_filter_kota.onchange = evt => {
    serverSideDatatables();
}

form_filter_status.onchange = evt => {
    serverSideDatatables();
}

function serverSideDatatables()
{
    let form_filter_supplier = $("#form_filter_supplier").val();
    let form_filter_kota = $("#form_filter_kota").val();
    let form_filter_status = $("#form_filter_status").val();

    $('#tabel_master_data').dataTable().fnDestroy();

    $('#tabel_master_data').DataTable({
        processing: true,
        serverSide: true,
        searching:true,        
        pageLength: 10,
        ajax: {
            url: BaseURL + "/masterdata/supplier/get_datatable",
            type: "POST",
            data: {
                form_filter_supplier:form_filter_supplier,
                form_filter_kota:form_filter_kota,
                form_filter_status:form_filter_status
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
            {data: 'fild_img', name: 'fild_img'},
            {data: 'fild_nama', name: 'fild_nama'},
            {data: 'fild_kontak', name: 'fild_kontak'},
            {data: 'fild_alamat', name: 'fild_alamat'},
            {data: 'fild_status', name: 'fild_status'},
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

function btn_tambahMasterdataSupplier()
{
    reset_formData();
    $('#modal-masterdata-jenisbarang').modal('show');
}

form_masterdata_supplier_icon.onchange = evt => {
    const [file] = form_masterdata_supplier_icon.files
    if (file) {
        img_masterdata_supplier.src = URL.createObjectURL(file)
    }
}

function act_submitTambahData()
{
    let form_masterdata_supplier_nama = $("#form_masterdata_supplier_nama").val();
    let form_masterdata_supplier_tlp = $("#form_masterdata_supplier_tlp").val();
    let form_masterdata_supplier_handphone = $("#form_masterdata_supplier_handphone").val();
    let form_masterdata_supplier_email = $("#form_masterdata_supplier_email").val();
    let form_masterdata_supplier_kota = $("#form_masterdata_supplier_kota").val();
    let form_masterdata_supplier_alamat = $("#form_masterdata_supplier_alamat").val();

    var formData = new FormData();

    $.each($('#form_masterdata_supplier_icon')[0].files,function(key,input){
        formData.append('form_masterdata_supplier_icon', input);
    });

    formData.append('form_masterdata_supplier_nama', form_masterdata_supplier_nama);
    formData.append('form_masterdata_supplier_tlp', form_masterdata_supplier_tlp);
    formData.append('form_masterdata_supplier_handphone', form_masterdata_supplier_handphone);
    formData.append('form_masterdata_supplier_email', form_masterdata_supplier_email);
    formData.append('form_masterdata_supplier_kota', form_masterdata_supplier_kota);
    formData.append('form_masterdata_supplier_alamat', form_masterdata_supplier_alamat);

    $.ajax({
        url: BaseURL + "/masterdata/supplier/act_tambah",
        data: formData,
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
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

function btnUpdateMasterdata(data)
{
    let data_id = $(data).attr('data-id');

    reset_formData();

    $.ajax({
        url: BaseURL + "/masterdata/supplier/act_detail",
        async:false,
        data: {
            data_id,
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if(data.status == true)
            {   
                $('#btnTambahMasterdata').hide();
                $('#btnUpdateMasterdata').show();
                
                if(data.data.logo != null)
                {
                    // console.log(BaseURL + "/storage/dokumen-club/logo/" + data.data.logo);
                    $("#img_masterdata_supplier").attr("src", BaseURL + "/storage/masterdata/supplier/" + data.data.logo);
                }

                $('#form_masterdata_supplier_uuid').val(data.data.uuid);
                $('#form_masterdata_supplier_nama').val(data.data.nama);
                $('#form_masterdata_supplier_tlp').val(data.data.telephone);
                $('#form_masterdata_supplier_handphone').val(data.data.handphone);
                $('#form_masterdata_supplier_email').val(data.data.email);
                $('#form_masterdata_supplier_kota').val(data.data.alamat_kabupaten_id).change();
                $('#form_masterdata_supplier_alamat').val(data.data.alamat);

                $('#modal-masterdata-jenisbarang').modal('show');
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

function act_sumbitUpdateData()
{
    let form_masterdata_supplier_nama = $("#form_masterdata_supplier_nama").val();
    let form_masterdata_supplier_uuid = $("#form_masterdata_supplier_uuid").val();
    let form_masterdata_supplier_tlp = $("#form_masterdata_supplier_tlp").val();
    let form_masterdata_supplier_handphone = $("#form_masterdata_supplier_handphone").val();
    let form_masterdata_supplier_email = $("#form_masterdata_supplier_email").val();
    let form_masterdata_supplier_kota = $("#form_masterdata_supplier_kota").val();
    let form_masterdata_supplier_alamat = $("#form_masterdata_supplier_alamat").val();

    var formData = new FormData();

    $.each($('#form_masterdata_supplier_icon')[0].files,function(key,input){
        formData.append('form_masterdata_supplier_icon', input);
    });

    formData.append('form_masterdata_supplier_uuid', form_masterdata_supplier_uuid);
    formData.append('form_masterdata_supplier_nama', form_masterdata_supplier_nama);
    formData.append('form_masterdata_supplier_tlp', form_masterdata_supplier_tlp);
    formData.append('form_masterdata_supplier_handphone', form_masterdata_supplier_handphone);
    formData.append('form_masterdata_supplier_email', form_masterdata_supplier_email);
    formData.append('form_masterdata_supplier_kota', form_masterdata_supplier_kota);
    formData.append('form_masterdata_supplier_alamat', form_masterdata_supplier_alamat);

    $.ajax({
        url: BaseURL + "/masterdata/supplier/act_update",
        data: formData,
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
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
                url: BaseURL + "/masterdata/supplier/act_update_status",
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

$(document).ready(function() {
    serverSideDatatables();    
});