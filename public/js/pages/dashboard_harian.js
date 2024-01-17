"use strict";
var data_decrpty = null;

function act_submitTambahData()
{
    let form_atlet_nik = $("#form_atlet_nik").val();
    let form_atlet_kk = $("#form_atlet_kk").val();
    let form_atlet_nama = $("#form_atlet_nama").val();

    // validasi ktp
    var fileInput_ktp = document.getElementById("form_club_file_ktp");
    var files_ktp = fileInput_ktp.files;
    if (files_ktp.length === 0)
    {
        Swal.fire({
            text: "Pastikan Anda Sudah Upload Wajib KTP Atlet",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    // validasi kk
    var fileInput_kk = document.getElementById("form_club_file_kk");
    var files_kk = fileInput_kk.files;
    if (files_kk.length === 0)
    {
        Swal.fire({
            text: "Pastikan Anda Sudah Upload Wajib KK Atlet",
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

    $.each($('#form_club_file_ktp')[0].files,function(key,input){
        formData.append('form_club_file_ktp', input);
    });

    $.each($('#form_club_file_kk')[0].files,function(key,input){
        formData.append('form_club_file_kk', input);
    });

    formData.append('form_atlet_nik', form_atlet_nik);
    formData.append('form_atlet_kk', form_atlet_kk);
    formData.append('form_atlet_nama', form_atlet_nama);

    KTApp.showPageLoading();

    $.ajax({
        url: BaseURL + "/dash/harian/act_tambah",
        data: formData,
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            console.log(data);
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
                        window.location.href = BaseURL + "/dash/harian";
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
        }
    });
}

function act_submitTambahDataLocal()
{
    let form_atlet_nik = $("#form_atlet_nik").val();
    let form_atlet_kk = $("#form_atlet_kk").val();
    let form_atlet_nama = $("#form_atlet_nama").val();

    // validasi ktp
    var fileInput_ktp = document.getElementById("form_club_file_ktp");
    var files_ktp = fileInput_ktp.files;
    if (files_ktp.length === 0)
    {
        Swal.fire({
            text: "Pastikan Anda Sudah Upload Wajib KTP Atlet",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    // validasi kk
    var fileInput_kk = document.getElementById("form_club_file_kk");
    var files_kk = fileInput_kk.files;
    if (files_kk.length === 0)
    {
        Swal.fire({
            text: "Pastikan Anda Sudah Upload Wajib KK Atlet",
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

    $.each($('#form_club_file_ktp')[0].files,function(key,input){
        formData.append('form_club_file_ktp', input);
    });

    $.each($('#form_club_file_kk')[0].files,function(key,input){
        formData.append('form_club_file_kk', input);
    });

    formData.append('form_atlet_nik', form_atlet_nik);
    formData.append('form_atlet_kk', form_atlet_kk);
    formData.append('form_atlet_nama', form_atlet_nama);

    KTApp.showPageLoading();

    $.ajax({
        url: BaseURL + "/dash/harian/act_tambah_local",
        data: formData,
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            console.log(data);
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
                        window.location.href = BaseURL + "/dash/harian";
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
        }
    });
}