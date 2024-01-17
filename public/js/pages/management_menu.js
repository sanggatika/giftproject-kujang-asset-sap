"use strict";

// const { defaultsDeep } = require("lodash");

// validator

var tambahManagemntMenu = function() {
    var e, t, i;
    return {
        init: function() {
            e = document.querySelector("#form_management_menu"), 
            t = document.querySelector("#btnSubmitTambahData"), 
            i = FormValidation.formValidation(e, {
                fields: {                    
                    form_menu_nama: {
                        validators: {
                            notEmpty: {
                                message: "Nama Menu Wajib Di Isi"
                            }
                        }
                    },
                    form_menu_uri: {
                        validators: {
                            notEmpty: {
                                message: "URI Menu Wajib Di Isi"
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
            }), t.addEventListener("click", (function(n) {
                n.preventDefault(), i.validate().then((function(i) {
                    "Valid" == i ? (
                        // disable submit botton
                        t.setAttribute("data-kt-indicator", "on"), 
                        t.disabled = !0,

                        // action auth login
                        actsubmitTambahManagementMenu(),                        

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

form_menu_parent.onchange = evt => {
    $("#form_menu_icon").prop("disabled",false);
    let form_menu_parent = $("#form_menu_parent").val();
    if(form_menu_parent != "-")
    {
        $("#form_menu_icon").prop("disabled",true);
    }
}

function actsubmitTambahManagementMenu()
{
    $("#card_alert_informasi").hide(1000);
    let form_menu_grup = $("#form_menu_grup").val();
    let form_menu_parent = $("#form_menu_parent").val();
    let form_menu_nama = $("#form_menu_nama").val();
    let form_menu_icon = $("#form_menu_icon").val();
    let form_menu_uri = $("#form_menu_uri").val();
    let form_menu_routename = $("#form_menu_routename").val();
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
    if(form_menu_nama == "" || form_menu_uri == "" || form_menu_routename == "")
    {
        grecaptcha.reset();
        $("#card_alert_informasi").show(1000);
        $("#alert_informasi").html('Pastikan Anda Sudah Mengisi Semua Form Data..!!');
        
        return false;
    }

    // Proses Kirim Data AJAX
    $.ajax({
        url: BaseURL + "/management/menu/act_tambah",
        data: {
            form_menu_grup,
            form_menu_parent,
            form_menu_nama,
            form_menu_icon,
            form_menu_uri,
            form_menu_routename,
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

function editManagementMenu(data_uuid)
{
    $("#formedit_menu_icon").prop("disabled",false);
    let data_id = data_uuid;
    var data_decrpty = null;

    $.ajax({
        url: BaseURL + "/management/menu/get_detail",
        data: {
            data_id,
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            // console.log(data);
            if(data.status == true)
            {                
                data_decrpty = JSON.parse(decryptAES256CBC(data.data));                
                console.log(data_decrpty);

                if(data_decrpty)
                {   
                    $('#formedit_menu_uuid').val(data_decrpty.menu_uuid).prop('readonly', true);

                    $('#formedit_menu_grup').val(data_decrpty.m_menu_grup.uuid).change().prop('readonly', false); 

                    if(data_decrpty.menu_parent != 0)
                    {
                        $('#formedit_menu_parent').val(data_decrpty.parent_uuid).change().prop('readonly', false);
                        $("#formedit_menu_icon").prop("disabled",true);
                    } 
                    $('#formedit_menu_nama').val(data_decrpty.menu_title).prop('readonly', false);
                    $('#formedit_menu_uri').val(data_decrpty.menu_url).prop('readonly', false); 
                    $('#formedit_menu_routename').val(data_decrpty.menu_routename).prop('readonly', false);                

                    $('#modal-data-menu').modal('show');
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

var valideditManagemntMenu = function() {
    var e, t, i;
    return {
        init: function() {
            e = document.querySelector("#form_management_menu_edit"), 
            t = document.querySelector("#btnSubmitEditData"), 
            i = FormValidation.formValidation(e, {
                fields: {                    
                    formedit_menu_nama: {
                        validators: {
                            notEmpty: {
                                message: "Nama Menu Wajib Di Isi"
                            }
                        }
                    },
                    formedit_menu_uri: {
                        validators: {
                            notEmpty: {
                                message: "URI Menu Wajib Di Isi"
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
                        actsubmitEditManagementMenu(),                        

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

formedit_menu_parent.onchange = evt => {
    $("#formedit_menu_icon").prop("disabled",false);
    let formedit_menu_parent = $("#formedit_menu_parent").val();
    if(formedit_menu_parent != "-")
    {
        $("#formedit_menu_icon").prop("disabled",true);
    }
}

function actsubmitEditManagementMenu()
{
    $("#card_alert_informasi_edit").hide(1000);
    let form_menu_uuid = $("#formedit_menu_uuid").val();
    let form_menu_grup = $("#formedit_menu_grup").val();
    let form_menu_parent = $("#formedit_menu_parent").val();
    let form_menu_nama = $("#formedit_menu_nama").val();
    let form_menu_icon = $("#formedit_menu_icon").val();
    let form_menu_uri = $("#formedit_menu_uri").val();
    let form_menu_routename = $("#formedit_menu_routename").val();

    // validasi form required
    if(form_menu_nama == "" || form_menu_uri == "" || form_menu_routename == "")
    {
        $("#card_alert_informasi_edit").show(1000);
        $("#alert_informasi_edit").html('Pastikan Anda Sudah Mengisi Semua Form Data..!!');
        
        return false;
    }

    Swal.fire({
        title: 'Anda akan update data ?',
        text: 'Pastikan data yang akang diupdate sudah sesuai dan di cek kembali.',
        icon: 'warning',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: 'Simpan Data',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            // Proses Kirim Data AJAX
            $.ajax({
                url: BaseURL + "/management/menu/act_edit",
                data: {
                    form_menu_uuid,
                    form_menu_grup,
                    form_menu_parent,
                    form_menu_nama,
                    form_menu_icon,
                    form_menu_uri,
                    form_menu_routename
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

function aktifManagementMenu(data_menu, data_status)
{    
    Swal.fire({
        title: 'Anda akan update data ?',
        text: 'Pastikan data yang akang diupdate sudah sesuai dan di cek kembali.',
        icon: 'warning',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: 'Simpan Data',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            // Proses Kirim Data AJAX
            $.ajax({
                url: BaseURL + "/management/menu/act_edit_status",
                data: {
                    data_menu,
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

function sortManagementMenu(data_menu, data_sort)
{    
    $.ajax({
        url: BaseURL + "/management/menu/act_sort",
        data: {
            data_menu,
            data_sort
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

KTUtil.onDOMContentLoaded((function() {
    tambahManagemntMenu.init(),
    valideditManagemntMenu.init()
}));