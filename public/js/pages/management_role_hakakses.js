function changeRoleAksesMenu(action)
{
    let role_aksesuser = $('#form_role_uuid').val();     

    let switchStatus = false;
    if($(action).is(':checked'))
    {
        switchStatus = $(action).is(':checked');
    }
    
    let menuAuth = $(action).data("auth");
    let menuID = $(action).data("menu");
    
    Swal.fire({
        title: 'Yakin Merubah Data ?',
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
                url: BaseURL + "/management/role/act_hakakses",
                data: {
                    role_aksesuser,
                    switchStatus,
                    menuAuth,
                    menuID
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
                        });
                        return false;
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