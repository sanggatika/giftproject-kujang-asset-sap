"use strict";

var KTSigninGeneral = function() {
    var e, t, i;
    return {
        init: function() {
            e = document.querySelector("#kt_sign_in_form"), 
            t = document.querySelector("#kt_sign_in_submit"), 
            i = FormValidation.formValidation(e, {
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
                    form_password: {
                        validators: {
                            notEmpty: {
                                message: "The password is required"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), t.addEventListener("click", (function(n) {
                n.preventDefault(), i.validate().then((function(i) {
                    "Valid" == i ? (
                        // disable submit botton
                        t.setAttribute("data-kt-indicator", "on"), 
                        t.disabled = !0,

                        // action auth login
                        actsubmitAuthSignin(),                        

                        setTimeout(function() {
                            // reset input password
                            $('#form_password').val(''),

                            // allow submit botton
                            t.removeAttribute("data-kt-indicator"), 
                            t.disabled = !1
                        }, 2000)

                        ) : Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                }))
            }))
        }
    }
}();

KTUtil.onDOMContentLoaded((function() {
    KTSigninGeneral.init()
}));

function actsubmitAuthSignin()
{
    $("#card_alert_informasi").hide(1000);

    let username = $("#form_email").val();
    let password = $("#form_password").val();
    let recaptcha = $(".g-recaptcha-response").val();

    // validasi google captcha
    if(recaptcha == "")
    {
        grecaptcha.reset();
        $("#card_alert_informasi").show(1000);
        $("#alert_informasi").html('Pastikan Anda Bukan Robot, Ceklis Google Captcha..!!');

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

    // validasi form required
    if(username == "" || password == "")
    {
        grecaptcha.reset();
        $("#card_alert_informasi").show(1000);
        $("#alert_informasi").html('Pastikan Anda Sudah Mengisi Semua Form Data..!!');
        
        return false;
    }

    // Proses Kirim Data AJAX
    $.ajax({
        url: BaseURL + "/auth/login/act",
        data: {
            username,
            password,
            recaptcha
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            grecaptcha.reset();
            
            if(data.status == true)
            {
                Swal.fire({
                    title: 'Berhasil Signin Aplikasi',
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
                        window.location.replace(BaseURL + "/dash");
                        return false;
                    }
                })
            }else{
                grecaptcha.reset();
                $("#card_alert_informasi").show(1000);
                $("#alert_informasi").html(data.message); 

                return false;
            }
        },
        error: function () {
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

const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#form_password");

togglePassword.addEventListener("click", function () {
    // toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    
    // toggle the icon
    this.classList.toggle("bi-eye");
});