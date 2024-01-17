"use strict";
var data_decrpty = null;

form_filter_username.onchange = evt => {
    serverSideDatatables();
}

form_filter_nama.onchange = evt => {
    serverSideDatatables();
}

form_filter_role.onchange = evt => {
    serverSideDatatables();
}

form_filter_status.onchange = evt => {
    serverSideDatatables();
}

function serverSideDatatables()
{
    let form_filter_username = $("#form_filter_username").val();
    let form_filter_nama = $("#form_filter_nama").val();
    let form_filter_role = $("#form_filter_role").val();
    let form_filter_status = $("#form_filter_status").val();

    $('#tabel_master_users').dataTable().fnDestroy();

    $('#tabel_master_users').DataTable({
        processing: true,
        serverSide: true,
        searching:true,        
        pageLength: 10,
        ajax: {
            url: BaseURL + "/management/users/get_datatable",
            type: "POST",
            data: {
                form_filter_username:form_filter_username,
                form_filter_nama:form_filter_nama,
                form_filter_role:form_filter_role,
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
            {data: 'fild_username', name: 'fild_username'},
            {data: 'fild_nama', name: 'fild_nama'},
            {data: 'fild_role', name: 'fild_role'},
            {data: 'fild_status', name: 'fild_status'},
            {data: 'fild_lastlogin', name: 'fild_lastlogin'},
            {data: 'action', name: 'action'}            
        ]
    });
}

function datatabelesreload()
{
	$('#tabel_master_users').DataTable().ajax.reload(null, false); //Reload Tanpa Reset Page Datatable
}

function reset_formDataUser()
{
    $('.card_useradm_profil').show();
    $('.card_useradm_password').show();
    $('.card_useradm_captcha').show();
    $('#btnTambahDataUser').show();
    $('#btnUpdateDataUser').show();

    $('#form-useradmcsr').trigger("reset");
    $('#form_useradm_role').val('-').change().prop('readonly', false);
    $('#form_useradm_role').prop('disabled', false);
    $('#form_useradm_nama').prop('readonly', false);
    $('#form_useradm_email').prop('readonly', false);
    $('#form_useradm_password').prop('readonly', false);
    $('#form_useradm_password_re').prop('readonly', false);
}

function btnTambahDataUser()
{
    reset_formDataUser();
    $('#btnUpdateDataUser').hide();

    $('#modal-data-user').modal('show');
}

function validateEmail(sEmail) {
    var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
  
    if(!sEmail.match(reEmail)) {
      return false;
    }
  
    return true;
  
}

function act_btnTambahDataUser()
{
    let form_useradm_nama = $("#form_useradm_nama").val();
    let form_useradm_email = $("#form_useradm_email").val();
    let form_useradm_password = $("#form_useradm_password").val();
    let form_useradm_password_re = $("#form_useradm_password_re").val();

    let recaptcha = $(".g-recaptcha-response").val();
    // validasi google captcha
    if(recaptcha == "")
    {
        grecaptcha.reset();
        Swal.fire({
            text: "Pastikan Anda Bukan Robot, Ceklis Google Captcha..!!",
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
    if(form_useradm_nama == "" || form_useradm_email == "" || form_useradm_password =="")
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

    if(validateEmail(form_useradm_email) == false)
    {
        Swal.fire({
            text: "Pastikan Email Useradmin Sudah Benar..!!",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    // validasi password
    if (checkStrength(form_useradm_password) != 'Strong')
    {
        Swal.fire({
            text: "Pastikan Password Anda Sudah Cukup Kuat..!!",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    // validasi Re Password
    if(form_useradm_password != form_useradm_password_re)
    {
        Swal.fire({
            text: "Pastikan Password Sudah Sessuai Dengan Re-Password..!!",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    var formData = new FormData(document.getElementById("form-useradmcsr"));

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
                url: BaseURL + "/management/users/act_tambah",
                data: formData,
                method: "POST",
                cache:false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {    
                    KTApp.showPageLoading();                    
                },
                success: function (data) {
                    KTApp.hidePageLoading();
                    loadingEl.remove();

                    checkStrength('');
                    grecaptcha.reset();  
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

                    checkStrength('');
                    grecaptcha.reset();
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
            checkStrength('');
            grecaptcha.reset();
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

function act_btnDetailDataUser(data)
{
    reset_formDataUser();
    let data_id = $(data).attr('data-id');

    $.ajax({
        url: BaseURL + "/management/users/act_detail",
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
                $('.card_useradm_password').hide();
                $('.card_useradm_captcha').hide();
                $('.card_useradm_btnaction').hide();

                $('#form_useradm_role').val(data.data.role_id).change();

                $('#form_useradm_nama').val(data.data.name).prop('readonly', true);
                $('#form_useradm_email').val(data.data.email).prop('readonly', true);               

                $('#modal-data-user').modal('show');
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

function act_btnUpdateDataUser(data)
{
    reset_formDataUser();
    let data_id = $(data).attr('data-id');

    $.ajax({
        url: BaseURL + "/management/users/act_detail",
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
                $('.card_useradm_password').hide();
                $('.card_useradm_captcha').show();
                
                $('.card_useradm_btnaction').show();
                $('#btnTambahDataUser').hide();

                $('#form_useradm_code').val(data.data.uuid).prop('readonly', true);
                $('#form_useradm_act').val('update_data').prop('readonly', true);

                $('#form_useradm_role').val(data.data.role_id).change();

                $('#form_useradm_nama').val(data.data.name).prop('readonly', false);
                $('#form_useradm_email').val(data.data.email).prop('readonly', true);

                $('#modal-data-user').modal('show');
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

function act_btnUpdatePassDataUser(data)
{
    reset_formDataUser();
    let data_id = $(data).attr('data-id');

    $.ajax({
        url: BaseURL + "/management/users/act_detail",
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
                $('.card_useradm_profil').hide();
                $('.card_useradm_captcha').show();
                
                $('.card_useradm_btnaction').show();
                $('#btnTambahDataUser').hide();

                $('#form_useradm_code').val(data.data.uuid).prop('readonly', true);
                $('#form_useradm_act').val('update_pass').prop('readonly', true);

                $('#modal-data-user').modal('show');
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

function acttion_UpdateDataUser()
{
    let recaptcha = $(".g-recaptcha-response").val();
    // validasi google captcha
    if(recaptcha == "")
    {
        grecaptcha.reset();
        Swal.fire({
            text: "Pastikan Anda Bukan Robot, Ceklis Google Captcha..!!",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });        
        return false;
    }

    var formData = new FormData(document.getElementById("form-useradmcsr"));

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
                url: BaseURL + "/management/users/act_update",
                data: formData,
                method: "POST",
                cache:false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {    
                    KTApp.showPageLoading();                       
                },
                success: function (data) {
                    KTApp.hidePageLoading();
                    loadingEl.remove();

                    checkStrength('');
                    grecaptcha.reset();  
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

                    checkStrength('');
                    grecaptcha.reset();
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
            checkStrength('');
            grecaptcha.reset();
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

function acttion_UpdateStatusDataUser(data)
{
    let data_id = $(data).attr('data-id');
    let data_nama = $(data).attr('data-nama');
    let data_status = $(data).attr('data-status');

    Swal.fire({
        title: 'Yakin Update Data ?',
        text: "Pastikan Anda Sudah Mengecek Kembali Data "+data_nama+" akan di update?",
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
                url: BaseURL + "/management/users/act_update_status",
                data: {
                    data_id,
                    data_nama,
                    data_status,
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

$('#form_useradm_password').keyup(function() {
    var password = $('#form_useradm_password').val();
    $('#re-password-verif').addClass('text-danger').text('');

    if (checkStrength(password) == 'Strong') 
    {
        $('#btn-submit-register').prop('disabled', false);
    }else{
        $('#btn-submit-register').prop('disabled', true);
    }
});

$('#form_useradm_password_re').keyup(function() {
    var password = $('#form_useradm_password').val();
    var re_password = $('#form_useradm_password_re').val();
    if (password == re_password) 
    {
        $('#re-password-verif').addClass('text-success').text('Re-Password Sama');
    }else{
        $('#re-password-verif').addClass('text-danger').text('Re-Password Tidak Sama');
    }
});

function checkStrength(password)
{
    if(password == '')
    {
        $('#result').removeClass()
        $('#password-indikator').addClass('progress-bar-danger');
        $('#result').addClass('text-danger').text('');
        $('#password-strength').css('width', '0%');
    }

    var strength = 0;

    // If password contains both lower and uppercase characters, increase strength value.
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
        strength += 1;
    }

    // If it has numbers and characters, increase strength value.
    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
        strength += 1;
    }

    // If it has one special character, increase strength value.
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
        strength += 1;
    }

    // Atleast 8 Character
    if (password.length > 7) {
        strength += 1;
    }

    // If value is less than 2
    if (strength == 1) {
        $('#result').removeClass()
        $('#password-indikator').addClass('progress-bar-danger');
        $('#result').addClass('text-danger').text('Very Week');
        $('#password-strength').css('width', '10%');
        return 'Very Week'
    } else if (strength == 2) {
        $('#result').removeClass()
        $('#result').addClass('good');
        $('#password-indikator').removeClass('progress-bar-danger');
        $('#password-indikator').addClass('progress-bar-warning');
        $('#result').addClass('text-warning').text('Week')
        $('#password-strength').css('width', '30%');
        return 'Week'
    } else if (strength == 3) {
        $('#result').removeClass()
        $('#result').addClass('good');
        $('#password-indikator').removeClass('progress-bar-warning');
        $('#password-indikator').addClass('progress-bar-info');
        $('#result').addClass('text-warning').text('Medium')
        $('#password-strength').css('width', '60%');
        return 'Medium'
    }else if (strength == 4) {
        $('#result').removeClass()
        $('#result').addClass('strong');
        $('#password-indikator').removeClass('progress-bar-info');
        $('#password-indikator').addClass('progress-bar-success');
        $('#result').addClass('text-success').text('Strength');
        $('#password-strength').css('width', '100%');

        return 'Strong'
    }
}

$(document).ready(function() {
    serverSideDatatables();    
});