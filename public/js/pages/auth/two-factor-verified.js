"use strict";
var data_decrpty = null;

var e = document.querySelector("#kt_sing_in_two_factor_submit");

function reset_form_two_factor()
{
    $("#form_code_1").val('');
    $("#form_code_2").val('');
    $("#form_code_3").val('');
    $("#form_code_4").val('');
    $("#form_code_5").val('');
    $("#form_code_6").val('');
}

function acttion_VerifiedUser()
{
    let token = $("#form_token").val();
    let form_code_1 = $("#form_code_1").val();
    let form_code_2 = $("#form_code_2").val();
    let form_code_3 = $("#form_code_3").val();
    let form_code_4 = $("#form_code_4").val();
    let form_code_5 = $("#form_code_5").val();
    let form_code_6 = $("#form_code_6").val();

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
    if(form_code_1 == "" || form_code_2 == "" || form_code_3 == "" || form_code_4 == "" || form_code_5 == "" || form_code_6 == "")
    {
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
            
            e.setAttribute("data-kt-indicator", "on");
            e.disabled = !0;

            $.ajax({
                url: BaseURL + "/auth/two-factor/act",
                data: {
                    token,
                    form_code_1,
                    form_code_2,
                    form_code_3,
                    form_code_4,
                    form_code_5,
                    form_code_6,
                    recaptcha
                },
                method: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    grecaptcha.reset();

                    e.removeAttribute("data-kt-indicator");
                    e.disabled = !1;    

                    reset_form_two_factor();  

                    if(data.status == true)
                    {
                        Swal.fire({
                            title: 'Berhasil Verifikasis !',
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
                                window.location.replace(BaseURL + "/auth/login");
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
                    grecaptcha.reset();

                    e.removeAttribute("data-kt-indicator");
                    e.disabled = !1; 

                    reset_form_two_factor();

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
            grecaptcha.reset();

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