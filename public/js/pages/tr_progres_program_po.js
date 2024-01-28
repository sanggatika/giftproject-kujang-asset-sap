"use strict";
var data_decrpty = null;

function reset_formData()
{
    $('#btnTambahMasterdata').show();
    $('#btnUpdateMasterdata').hide();
}

function btn_tambahMasterdata()
{
    reset_formData();
    $('#modal-masterdata-program').modal('show');
}

form_masterdata_program_pr_nomor.onchange = evt => {
    sync_masterdata();
}

function sync_masterdata()
{
    let data_id = $("#form_masterdata_program_pr_nomor").val();

    if(data_id == "")
    {
        Swal.fire({
            text: "Pastikan Anda Sudah Mengisi Fund Number / MMR ..!!",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    $.ajax({
        url: BaseURL + "/transaksi/progres/program/pr/act_detail",
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

            console.log(data.data);
            // return false;

            if(data.status == true)
            {                
                $('#form_masterdata_program_pr_uuid').val(data.data.uuid).prop('readonly', true);
                
                $('#form_masterdata_program_jenis').val(data.data.m_program_jenis_c_c_k.uuid).change();                
                $("#form_masterdata_program_pr_tanggal").flatpickr({
                    defaultDate: [data.data.pr_tanggal]
                });

                $('#form_masterdata_program_nama').val(data.data.name);
                $('#form_masterdata_program_lokasi').val(data.data.m_program_lokasi_c_c.uuid).change();
                $('#form_masterdata_program_pr_nominal').val(data.data.pr_nominal); 
                
                $('#form_masterdata_program_po_anggaran').val(data.data.pr_nominal);  
                $('#form_masterdata_program_po_vendor').val(data.data.pr_vendor);  

                data_tr_program_progres_pr = data.data;

                $('.dataContenFormPR').show();
            }else{  
                $('#form_masterdata_program_pr_uuid').val('').prop('readonly', true);
                
                $('#form_masterdata_program_jenis').val('-').change();                
                $("#form_masterdata_program_pr_tanggal").flatpickr({
                    defaultDate: ['2024-01-01']
                });

                $('#form_masterdata_program_nama').val('');
                $('#form_masterdata_program_lokasi').val('-').change();
                $('#form_masterdata_program_pr_nominal').val('');   

                $('#form_masterdata_program_po_anggaran').val('');  
                $('#form_masterdata_program_po_vendor').val('');

                data_tr_program_progres_pr = null;

                $('.dataContenFormPR').hide();

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

function act_submitTambahData()
{
    let form_masterdata_program_pr_nomor = $("#form_masterdata_program_pr_nomor").val();
    let form_masterdata_program_pr_uuid = $("#form_masterdata_program_pr_uuid").val();
    let form_masterdata_program_po_tanggal = $("#form_masterdata_program_po_tanggal").val();
    let form_masterdata_program_po_nomor = $("#form_masterdata_program_po_nomor").val();
    let form_masterdata_program_po_anggaran = $("#form_masterdata_program_po_anggaran").val();
    let form_masterdata_program_po_vendor = $("#form_masterdata_program_po_vendor").val();
    let form_masterdata_program_po_otoritas = $("#form_masterdata_program_po_otoritas").val();
    let form_masterdata_program_po_tanggal_estimasi = $("#form_masterdata_program_po_tanggal_estimasi").val();

    // validasi form
    if(form_masterdata_program_pr_nomor == "" || form_masterdata_program_po_nomor == "")
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
                url: BaseURL + "/transaksi/progres/program/po/act_tambah",
                data: {
                    form_masterdata_program_pr_nomor,
                    form_masterdata_program_pr_uuid,
                    form_masterdata_program_po_tanggal,
                    form_masterdata_program_po_nomor,
                    form_masterdata_program_po_anggaran,
                    form_masterdata_program_po_vendor,
                    form_masterdata_program_po_otoritas,
                    form_masterdata_program_po_tanggal_estimasi
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

form_filter_program.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_jenis.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_lokasi.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_priority.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_po_nomor.onchange = evt => {
    serverSideDatatables();
}

$("#form_filter_program_po_tanggal").flatpickr({
    altInput: true,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d",
    mode: "range",
    onClose: function(selectedDates, dateStr, instance) {
        // Memanggil fungsi serverSideDatatables() saat rentang tanggal dipilih
        serverSideDatatables();
    }
});

form_filter_program_min_anggaran.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_max_anggaran.onchange = evt => {
    serverSideDatatables();
}

function serverSideDatatables()
{
    let form_filter_program = $("#form_filter_program").val();
    let form_filter_program_jenis = $("#form_filter_program_jenis").val();
    let form_filter_program_lokasi = $("#form_filter_program_lokasi").val();
    let form_filter_program_priority = $("#form_filter_program_priority").val();

    let form_filter_program_po_nomor = $("#form_filter_program_po_nomor").val();
    let form_filter_program_po_tanggal = $("#form_filter_program_po_tanggal").val();
    let form_filter_program_min_anggaran = $("#form_filter_program_min_anggaran").val();
    let form_filter_program_max_anggaran = $("#form_filter_program_max_anggaran").val();

    $('#tabel_master_data').dataTable().fnDestroy();

    $('#tabel_master_data').DataTable({
        processing: true,
        serverSide: true,
        searching:true,        
        pageLength: 10,
        ajax: {
            url: BaseURL + "/transaksi/progres/program/po/get_datatable",
            type: "POST",
            data: {
                form_filter_program:form_filter_program,
                form_filter_program_jenis:form_filter_program_jenis,
                form_filter_program_lokasi:form_filter_program_lokasi,
                form_filter_program_priority:form_filter_program_priority,
                form_filter_program_po_nomor:form_filter_program_po_nomor,
                form_filter_program_po_tanggal:form_filter_program_po_tanggal,
                form_filter_program_min_anggaran:form_filter_program_min_anggaran,
                form_filter_program_max_anggaran:form_filter_program_max_anggaran
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

                $("#data_line2_program_total_po").html(data.jumlahtrProgresProgramPO +" | "+data.totaltrProgresProgramPONominal);
                $("#data_line2_program_total_po_progres").html(data.jumlahtrProgresProgramPOProses +" | "+data.totaltrProgresProgramPONominalProses);
                $("#data_line2_program_total_po_selesai").html(data.jumlahtrProgresProgramPOSelesai +" | "+data.totaltrProgresProgramPONominalSelesai);
                $("#data_line2_program_progres").html(data.persentasetrProgresProgramPONominalSelesai +" %");

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
            {data: 'fund_number', name: 'fund_number'},
            {data: 'fild_name', name: 'fild_name'},
            {data: 'fild_nominal', name: 'fild_nominal'},
            {data: 'fild_tanggal', name: 'fild_tanggal'},
            {data: 'fild_nomor', name: 'fild_nomor'},
            {data: 'fild_tanggal_estimasi', name: 'fild_tanggal_estimasi'},
            {data: 'fild_nominal_fix', name: 'fild_nominal_fix'},
            {data: 'action', name: 'action', class:'text-center'}            
        ]
    });
}

function datatabelesreload()
{
	$('#tabel_master_data').DataTable().ajax.reload(null, false); //Reload Tanpa Reset Page Datatable
}

function act_btnUpdateData(data)
{
    reset_formData();

    let data_id = $(data).attr('data-id');

    $.ajax({
        url: BaseURL + "/transaksi/progres/program/po/act_detail",
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
                console.log(data.data);
                $('#btn_syncMasterData').hide();

                $('#btnTambahMasterdata').hide();
                $('#btnUpdateMasterdata').show();

                $('#form_masterdata_program_pr_nomor').val(data.data.tr_progres_program_p_r_one.pr_nomor).prop( "disabled", true );
                $('#form_masterdata_program_jenis').val(data.data.m_program_jenis_c_c_k.uuid).change().prop('disabled', true);
                $("#form_masterdata_program_pr_tanggal").flatpickr({
                    defaultDate: [data.data.tr_progres_program_p_r_one.pr_tanggal]
                });

                $('#form_masterdata_program_nama').val(data.data.name).prop( "disabled", true );
                $('#form_masterdata_program_pr_uuid').val(data.data.tr_progres_program_p_r_one.uuid).prop('readonly', true);
                $('#form_masterdata_program_lokasi').val(data.data.m_program_lokasi_c_c.uuid).change().prop('disabled', true);
                $('#form_masterdata_program_pr_nominal').val(data.data.tr_progres_program_p_r_one.pr_nominal).prop( "disabled", true );

                $('#form_masterdata_program_po_uuid').val(data.data.uuid).prop('readonly', true);
                $("#form_masterdata_program_po_tanggal").flatpickr({
                    defaultDate: [data.data.po_tanggal]
                });
                $('#form_masterdata_program_po_nomor').val(data.data.po_nomor);
                $('#form_masterdata_program_po_anggaran').val(data.data.po_nominal);
                $('#form_masterdata_program_po_vendor').val(data.data.po_vendor);
                $('#form_masterdata_program_po_otoritas').val(data.data.po_otorisasi).change();
                $("#form_masterdata_program_po_tanggal_estimasi").flatpickr({
                    defaultDate: [data.data.po_tempo]
                });

                $('.dataContenFormPR').show();

                $('#modal-masterdata-program').modal('show');
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

function act_sumbitUpdateData()
{    
    let form_masterdata_program_pr_nomor = $("#form_masterdata_program_pr_nomor").val();
    let form_masterdata_program_pr_uuid = $("#form_masterdata_program_pr_uuid").val();
    let form_masterdata_program_po_uuid = $("#form_masterdata_program_po_uuid").val();
    let form_masterdata_program_po_nomor = $("#form_masterdata_program_po_nomor").val();
    let form_masterdata_program_po_anggaran = $("#form_masterdata_program_po_anggaran").val();
    let form_masterdata_program_po_vendor = $("#form_masterdata_program_po_vendor").val();
    let form_masterdata_program_po_otoritas = $("#form_masterdata_program_po_otoritas").val();
    let form_masterdata_program_po_tanggal = $("#form_masterdata_program_po_tanggal").val();
    let form_masterdata_program_po_tanggal_estimasi = $("#form_masterdata_program_po_tanggal_estimasi").val();

    // validasi form
    if(form_masterdata_program_po_uuid == "" || form_masterdata_program_po_nomor == "" || form_masterdata_program_po_anggaran == "" || form_masterdata_program_po_tanggal == "")
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
                url: BaseURL + "/transaksi/progres/program/po/act_update",
                data: {
                    form_masterdata_program_pr_nomor,
                    form_masterdata_program_pr_uuid,
                    form_masterdata_program_po_uuid,
                    form_masterdata_program_po_nomor,
                    form_masterdata_program_po_anggaran,
                    form_masterdata_program_po_vendor,
                    form_masterdata_program_po_otoritas,
                    form_masterdata_program_po_tanggal,
                    form_masterdata_program_po_tanggal_estimasi
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
                },
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

$(document).ready(function() {
    serverSideDatatables();  
    
    $("#form_masterdata_program_pr_tanggal").flatpickr();
    $("#form_masterdata_program_po_tanggal").flatpickr();
    $("#form_masterdata_program_po_tanggal_estimasi").flatpickr();
});