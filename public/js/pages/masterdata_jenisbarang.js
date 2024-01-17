"use strict";
var data_decrpty = null;

function reset_formDataUser()
{
    $('#btnTambahMasterdataJenisBarang').show();
    $('#btnUpdateMasterdataJenisBarang').hide();

    // $('#form_kecamatanmkios').val('-').change().prop('readonly', false).prop('disabled', false);
    // $('#form_desamkios').val('-').change().prop('readonly', false).prop('disabled', false);
    // $('#form_namamkios').val('').prop('readonly', false).prop('disabled', false);
    // $('#form_alamatmkios').val('').prop('readonly', false).prop('disabled', false);

    // $('#form_codemkios').val('').prop('readonly', true);
}

function btnTambahMasterdataJenisBarang()
{
    reset_formDataUser();
    $('#modal-masterdata-jenisbarang').modal('show');
}

form_masterdata_jenisbarang_icon.onchange = evt => {
    const [file] = form_masterdata_jenisbarang_icon.files
    if (file) {
        img_masterdata_jenisbarang.src = URL.createObjectURL(file)
    }
}

function act_submitTambahDataJenisBarang()
{
    let form_masterdata_jenisbarang_kategori = $("#form_masterdata_jenisbarang_kategori").val();
    let form_masterdata_jenisbarang_nama = $("#form_masterdata_jenisbarang_nama").val();
    let form_masterdata_jenisbarang_deskripsi = $("#form_masterdata_jenisbarang_deskripsi").val();

    var fileInput_Logo = document.getElementById("form_masterdata_jenisbarang_icon");
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

    var formData = new FormData();

    $.each($('#form_masterdata_jenisbarang_icon')[0].files,function(key,input){
        formData.append('form_masterdata_jenisbarang_icon', input);
    });

    formData.append('form_masterdata_jenisbarang_kategori', form_masterdata_jenisbarang_kategori);
    formData.append('form_masterdata_jenisbarang_nama', form_masterdata_jenisbarang_nama);
    formData.append('form_masterdata_jenisbarang_deskripsi', form_masterdata_jenisbarang_deskripsi);

    $.ajax({
        url: BaseURL + "/masterdata/jenis_barang/act_tambah",
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

function btnUpdateMasterdataJenisBarang(data)
{
    let data_id = $(data).attr('data-id');

    reset_formDataUser();
    $.ajax({
        url: BaseURL + "/masterdata/jenis_barang/act_detail",
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
                $('#btnTambahMasterdataJenisBarang').hide();
                $('#btnUpdateMasterdataJenisBarang').show();

                if(data.data.logo != null)
                {
                    // console.log(BaseURL + "/storage/dokumen-club/logo/" + data.data.logo);
                    $("#img_masterdata_jenisbarang").attr("src", BaseURL + "/storage/masterdata/jenis-barang/" + data.data.logo);
                }

                $('#form_masterdata_jenisbarang_kategori').val(data.data.kategori).change();
                $('#form_masterdata_jenisbarang_uuid').val(data.data.uuid);
                $('#form_masterdata_jenisbarang_nama').val(data.data.nama);
                $('#form_masterdata_jenisbarang_deskripsi').val(data.data.deskripsi);

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

function act_sumbitUpdateDataJenisBarang()
{
    let form_masterdata_jenisbarang_kategori = $("#form_masterdata_jenisbarang_kategori").val();
    let form_masterdata_jenisbarang_uuid = $("#form_masterdata_jenisbarang_uuid").val();
    let form_masterdata_jenisbarang_nama = $("#form_masterdata_jenisbarang_nama").val();
    let form_masterdata_jenisbarang_deskripsi = $("#form_masterdata_jenisbarang_deskripsi").val();

    var formData = new FormData();

    $.each($('#form_masterdata_jenisbarang_icon')[0].files,function(key,input){
        formData.append('form_masterdata_jenisbarang_icon', input);
    });

    formData.append('form_masterdata_jenisbarang_kategori', form_masterdata_jenisbarang_kategori);
    formData.append('form_masterdata_jenisbarang_uuid', form_masterdata_jenisbarang_uuid);
    formData.append('form_masterdata_jenisbarang_nama', form_masterdata_jenisbarang_nama);
    formData.append('form_masterdata_jenisbarang_deskripsi', form_masterdata_jenisbarang_deskripsi);

    $.ajax({
        url: BaseURL + "/masterdata/jenis_barang/act_update",
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

function actUpdateStatusMasterdataJenisBarang(data)
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
                url: BaseURL + "/masterdata/jenis_barang/act_update_status",
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
    $("#tabel_masterdata_jenisbarang").DataTable({
        pageLength: 10,
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