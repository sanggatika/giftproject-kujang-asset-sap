"use strict";
// validator

var tambahManagemntRole = function() {
    var e, t, i;
    return {
        init: function() {
            e = document.querySelector("#form_management_role"), 
            t = document.querySelector("#btnSubmitTambahData"), 
            i = FormValidation.formValidation(e, {
                fields: {                    
                    form_role_nama: {
                        validators: {
                            notEmpty: {
                                message: "Nama Role Wajib Di Isi"
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
                        actsubmitTambahManagementRole(),                        

                        setTimeout(function() {
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

function actsubmitTambahManagementRole()
{
    $("#card_alert_informasi").hide(1000);
    let form_role_nama = $("#form_role_nama").val();
    let form_role_deskripsi = $("#form_role_deskripsi").val();
    let recaptcha = $(".g-recaptcha-response").val();

    // validasi google captcha
    if(recaptcha == "")
    {
        grecaptcha.reset();
        $("#card_alert_informasi").show(1000);
        $("#alert_informasi").html('Pastikan Anda Bukan Robot, Ceklis Google Captcha..!!');
       
        return false;
    }

    // validasi form required
    if(form_role_nama == "")
    {
        grecaptcha.reset();
        $("#card_alert_informasi").show(1000);
        $("#alert_informasi").html('Pastikan Anda Sudah Mengisi Semua Form Data..!!');
        
        return false;
    }

    // Proses Kirim Data AJAX
    $.ajax({
        url: BaseURL + "/management/role/act_tambah",
        data: {
            form_role_nama,
            form_role_deskripsi,
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
                    title: 'Berhasil Menambahkan !',
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

function actDetailManagementRole(data)
{
    let data_id = $(data).attr('data-id');
    var data_decrpty = null;

    $.ajax({
        url: BaseURL + "/management/role/get_detail",
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
                // console.log(data.data);
                data_decrpty = JSON.parse(decryptAES256CBC(data.data));

                if(data_decrpty)
                {   
                    $('#formedit_role_uuid').val(data_decrpty.uuid).prop('readonly', true);
                    $('#formedit_role_nama').val(data_decrpty.name).prop('readonly', false);
                    $('#formedit_role_deskripsi').val(data_decrpty.description).prop('readonly', false);
                    $('#modal-data-role').modal('show');
                }else{
                    Swal.fire({
                        text: "Gagal Decrpty data, Hubungi Administrator !!",
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    return false;
                } 
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

function actUpdateManagementRole()
{
    $("#card_alert_informasi_edit").hide(1000);

    let form_role_uuid = $("#formedit_role_uuid").val();
    let form_role_nama = $("#formedit_role_nama").val();
    let form_role_deskripsi = $("#formedit_role_deskripsi").val();

    // validasi form required
    if(form_role_nama == "")
    {
        $("#card_alert_informasi_edit").show(1000);
        $("#alert_informasi_edit").html('Pastikan Anda Sudah Mengisi Semua Form Data..!!');
        
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
            // Proses Kirim Data AJAX
            $.ajax({
                url: BaseURL + "/management/role/act_edit",
                data: {
                    form_role_uuid,
                    form_role_nama,
                    form_role_deskripsi
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
                        $("#card_alert_informasi_edit").show(1000);
                        $("#alert_informasi_edit").html(data.message); 

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
    });
}

function actaktifManagementRole(data)
{   
    let data_id = $(data).attr('data-id');
    let data_nama = $(data).attr('data-nama');
    let data_status = $(data).attr('data-status');

    Swal.fire({
        title: 'Anda akan update data ?',
        text: "Pastikan Anda Sudah Mengecek Kembali Role "+data_nama+" akan di update?",
        icon: 'warning',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: 'Simpan Data',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            // Proses Kirim Data AJAX
            $.ajax({
                url: BaseURL + "/management/role/act_edit_status",
                data: {
                    data_id,
                    data_status
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
                            title: 'Gagal Update !',
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
    });    
}

KTUtil.onDOMContentLoaded((function() {
    tambahManagemntRole.init(),
    $("#kt_datatable_zero_configuration").DataTable()
}));