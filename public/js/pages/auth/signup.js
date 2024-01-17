"use strict";
var data_decrpty = null;

const form = document.getElementById('kt_sign_up_form');
var e = document.querySelector("#kt_sign_up_submit");

var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            form_useradm_nama: {
                validators: {
                    notEmpty: {
                        message: "Nama User tidak boleh kosong"
                    }
                }
            },
            form_useradm_email: {
                validators: {
                    regexp: {
                        regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                        message: "The value is not a valid email address"
                    },
                    notEmpty: {
                        message: "Email address is required"
                    }
                }
            },
        },

        plugins: {
            trigger: new FormValidation.plugins.Trigger,
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: ".fv-row",
                eleInvalidClass: "",
                eleValidClass: ""
            })
        }
    }
);

function btn_submitRegister()
{
    if (validator) {
        validator.validate().then(function (status) {
            if (status == 'Valid') {
                e.setAttribute("data-kt-indicator", "on");
                e.disabled = !0;

                act_submitRegister();
            }
        });
    }
}

function reset_form_password()
{
    $("#form_useradm_password").val('');
    $("#form_useradm_password_re").val('');
}

function act_submitRegister()
{
    let form_useradm_nama = $("#form_useradm_nama").val();
    let form_useradm_email = $("#form_useradm_email").val();
    let form_useradm_password = $("#form_useradm_password").val();
    let form_useradm_password_re = $("#form_useradm_password_re").val();

    let recaptcha = $(".g-recaptcha-response").val();

    // validasi google captcha
    if(recaptcha == "")
    {
        e.removeAttribute("data-kt-indicator");
        e.disabled = !1;

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
        e.removeAttribute("data-kt-indicator");
        e.disabled = !1;

        grecaptcha.reset();

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
        e.removeAttribute("data-kt-indicator");
        e.disabled = !1;

        grecaptcha.reset();

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
        e.removeAttribute("data-kt-indicator");
        e.disabled = !1;

        grecaptcha.reset();
        reset_form_password();

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

    // Proses Kirim Data AJAX
    $.ajax({
        url: BaseURL + "/auth/register/act",
        data: {
            form_useradm_nama,
            form_useradm_email,
            form_useradm_password,
            recaptcha
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            e.removeAttribute("data-kt-indicator");
            e.disabled = !1;

            checkStrength('');
            grecaptcha.reset(); 
            reset_form_password();

            if(data.status == true)
            {
                Swal.fire({
                    title: 'Berhasil Kirim Email',
                    text: data.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Masuk Aplikasi',
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger ml-1',
                    buttonsStyling: false,
                    allowOutsideClick: false,
                }).then(function (result) {
                    if (result.value) {
                        /* Read more about isConfirmed, isDenied below */
                        window.location.replace(BaseURL + "/auth/login");
                        return false;
                    }
                })
            }else{
                Swal.fire({
                    title: "Informasi !",
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
            e.removeAttribute("data-kt-indicator");
            e.disabled = !1;

            checkStrength('');
            grecaptcha.reset(); 
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