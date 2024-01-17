"use strict";
var data_decrpty = null;

function act_resetFilter()
{
    location.reload();
    return false;
}

form_filter_barang.onchange = evt => {
    serverSideDatatables();
}

form_filter_jenisbarang.onchange = evt => {
    serverSideDatatables();
}

form_filter_status.onchange = evt => {
    serverSideDatatables();
}

function serverSideDatatables()
{
    let form_filter_barang = $("#form_filter_barang").val();
    let form_filter_jenisbarang = $("#form_filter_jenisbarang").val();
    let form_filter_status = $("#form_filter_status").val();

    $('#tabel_master_data').dataTable().fnDestroy();

    $('#tabel_master_data').DataTable({
        processing: true,
        serverSide: true,
        searching:true,        
        pageLength: 10,
        ajax: {
            url: BaseURL + "/masterdata/barang/get_datatable",
            type: "POST",
            data: {
                form_filter_barang:form_filter_barang,
                form_filter_jenisbarang:form_filter_jenisbarang,
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
            {data: 'fild_limit', name: 'fild_limit'},
            {data: 'fild_jenis', name: 'fild_jenis'},
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

function btn_tambahMasterdataBarang()
{
    reset_formData();
    $('#modal-masterdata-jenisbarang').modal('show');
}

form_masterdata_barang_icon.onchange = evt => {
    const [file] = form_masterdata_barang_icon.files
    if (file) {
        img_masterdata_barang.src = URL.createObjectURL(file)
    }
}

function act_submitTambahData()
{
    var fileInput_Logo = document.getElementById("form_masterdata_barang_icon");
    var files_logo = fileInput_Logo.files;
    if (files_logo.length === 0)
    {
        Swal.fire({
            text: "Pastikan Anda Sudah Upload Icon Jenis Barang",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    let form_masterdata_barang_jenisbarang = $("#form_masterdata_barang_jenisbarang").val();
    let form_masterdata_barang_nama = $("#form_masterdata_barang_nama").val();
    let form_masterdata_barang_deskripsi = $("#form_masterdata_barang_deskripsi").val();
    let form_masterdata_barang_satuan = $("#form_masterdata_barang_satuan").val();
    let form_masterdata_barang_limitstok = $("#form_masterdata_barang_limitstok").val();

    var formData = new FormData();

    $.each($('#form_masterdata_barang_icon')[0].files,function(key,input){
        formData.append('form_masterdata_barang_icon', input);
    });

    formData.append('form_masterdata_barang_jenisbarang', form_masterdata_barang_jenisbarang);
    formData.append('form_masterdata_barang_nama', form_masterdata_barang_nama);
    formData.append('form_masterdata_barang_deskripsi', form_masterdata_barang_deskripsi);
    formData.append('form_masterdata_barang_satuan', form_masterdata_barang_satuan);
    formData.append('form_masterdata_barang_limitstok', form_masterdata_barang_limitstok);

    $.ajax({
        url: BaseURL + "/masterdata/barang/act_tambah",
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
        url: BaseURL + "/masterdata/barang/act_detail",
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
                    $("#img_masterdata_barang").attr("src", BaseURL + "/storage/masterdata/barang/" + data.data.logo);
                }

                $('#form_masterdata_barang_jenisbarang').val(data.data.m_barang_jenis.uuid).change();    
                $('#form_masterdata_barang_uuid').val(data.data.uuid);
                $('#form_masterdata_barang_nama').val(data.data.nama);
                $('#form_masterdata_barang_deskripsi').val(data.data.deskripsi);
                $('#form_masterdata_barang_satuan').val(data.data.m_satuan.uuid).change();
                $('#form_masterdata_barang_limitstok').val(data.data.limit_stok);

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
    let form_masterdata_barang_jenisbarang = $("#form_masterdata_barang_jenisbarang").val();
    let form_masterdata_barang_uuid = $("#form_masterdata_barang_uuid").val();
    let form_masterdata_barang_nama = $("#form_masterdata_barang_nama").val();
    let form_masterdata_barang_deskripsi = $("#form_masterdata_barang_deskripsi").val();
    let form_masterdata_barang_satuan = $("#form_masterdata_barang_satuan").val();
    let form_masterdata_barang_limitstok = $("#form_masterdata_barang_limitstok").val();

    var formData = new FormData();

    $.each($('#form_masterdata_barang_icon')[0].files,function(key,input){
        formData.append('form_masterdata_barang_icon', input);
    });

    formData.append('form_masterdata_barang_jenisbarang', form_masterdata_barang_jenisbarang);
    formData.append('form_masterdata_barang_uuid', form_masterdata_barang_uuid);
    formData.append('form_masterdata_barang_nama', form_masterdata_barang_nama);
    formData.append('form_masterdata_barang_deskripsi', form_masterdata_barang_deskripsi);
    formData.append('form_masterdata_barang_satuan', form_masterdata_barang_satuan);
    formData.append('form_masterdata_barang_limitstok', form_masterdata_barang_limitstok);

    $.ajax({
        url: BaseURL + "/masterdata/barang/act_update",
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
                url: BaseURL + "/masterdata/barang/act_update_status",
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