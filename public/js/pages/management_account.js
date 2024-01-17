"use strict";
var data_decrpty = null;

function reset_form_password()
{
    $("#form_useradm_password_current").val('');
    $("#form_useradm_password").val('');
    $("#form_useradm_password_re").val('');
}

function acttion_UpdatePasswordUser()
{
    let form_useradm_password_current = $("#form_useradm_password_current").val();
    let form_useradm_password = $("#form_useradm_password").val();
    let form_useradm_password_re = $("#form_useradm_password_re").val();

    // validasi form
    if(form_useradm_password_current == "" || form_useradm_password =="")
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
                url: BaseURL + "/management/account/password/act_update",
                data: {
                    form_useradm_password_current,
                    form_useradm_password
                },
                method: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {                      
                    reset_form_password();                  
                    if(data.status == true)
                    {
                        Swal.fire({
                            title: 'Berhasil Update !',
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
                    reset_form_password();
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
            checkStrength('');
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