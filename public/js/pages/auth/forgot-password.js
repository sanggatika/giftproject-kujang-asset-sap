"use strict";

const form = document.getElementById('kt_password_reset_form');
var e = document.querySelector("#kt_password_reset_submit");
// e.setAttribute("data-kt-indicator", "on");
// e.disabled = !0;

var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            form_email: {
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

function btn_submitForgotPassword()
{
    if (validator) {
        validator.validate().then(function (status) {
            if (status == 'Valid') {
                e.setAttribute("data-kt-indicator", "on");
                e.disabled = !0;

                actsubmitForgotPassword();
            }
        });
    }
}

function actsubmitForgotPassword()
{
    let username = $("#form_email").val();
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

    // Proses Kirim Data AJAX
    $.ajax({
        url: BaseURL + "/auth/forgot/act",
        data: {
            username,
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

            grecaptcha.reset();
            
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
        }
    });
}