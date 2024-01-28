"use strict";
var data_decrpty = null;

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

form_filter_program_sr_nomor.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_status.onchange = evt => {
    serverSideDatatables();
}

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

    let form_filter_program_sr_nomor = $("#form_filter_program_sr_nomor").val();
    let form_filter_program_status = $("#form_filter_program_status").val();
    let form_filter_program_min_anggaran = $("#form_filter_program_min_anggaran").val();
    let form_filter_program_max_anggaran = $("#form_filter_program_max_anggaran").val();

    $('#tabel_master_data').dataTable().fnDestroy();

    $('#tabel_master_data').DataTable({
        processing: true,
        serverSide: true,
        searching:true,        
        pageLength: 10,
        ajax: {
            url: BaseURL + "/transaksi/progres/program/mr_sr/get_datatable",
            type: "POST",
            data: {
                form_filter_program:form_filter_program,
                form_filter_program_jenis:form_filter_program_jenis,
                form_filter_program_lokasi:form_filter_program_lokasi,
                form_filter_program_priority:form_filter_program_priority,
                form_filter_program_sr_nomor:form_filter_program_sr_nomor,
                form_filter_program_status:form_filter_program_status,
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

                $("#data_line2_program_total").html(data.jumlahMsProgram +" | "+data.totalMsProgramNominal);
                $("#data_line2_program_total_filter").html(data.jumlahFilterMsProgram +" | "+data.totalFilterMsProgramNominal);

                $("#data_line2_program_total_sr_sudah").html(data.jumlahFilterMsProgramSR +" | "+data.totalFilterMsProgramNominalSR);
                $("#data_line2_program_total_sr_belum").html(data.jumlahFilterMsProgramSRBelum +" | "+data.totalFilterMsProgramNominalSRBelum);

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
            {data: 'fild_nominal_fix', name: 'fild_nominal_fix'},
            {data: 'action', name: 'action', class:'text-center'}            
        ]
    });
}

function datatabelesreload()
{
	$('#tabel_master_data').DataTable().ajax.reload(null, false); //Reload Tanpa Reset Page Datatable
}

function reset_formData()
{
    $('#btnUpdateMasterdata').hide();
}

function act_btnUpdateData(data)
{
    reset_formData();

    let data_id = $(data).attr('data-id');

    $.ajax({
        url: BaseURL + "/masterdata/program/act_detail",
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
                // console.log(data.data);
                $('#btnUpdateMasterdata').show();   
                
                $('#form_masterdata_program_uuid').val(data.data.uuid).prop('readonly', true);
                $('#form_masterdata_program_fundnumber').val(data.data.fund_number).prop( "disabled", true );
                $('#form_masterdata_program_nama').val(data.data.name).prop( "disabled", true );
                $('#form_masterdata_program_anggaran').val(data.data.nominal).prop( "disabled", true );

                $('#form_masterdata_program_fundcenter').val(data.data.fund_center).prop( "disabled", true );
                $('#form_masterdata_program_jenis').val(data.data.m_program_jenis_c_c_k.uuid).change().prop('disabled', true);
                $('#form_masterdata_program_lokasi').val(data.data.m_program_lokasi_c_c.uuid).change().prop('disabled', true);

                $('#form_masterdata_program_anggaran_fix').val(data.data.nominal);
                if(data.data.tr_progres_program_s_r != null)
                {
                    $("#form_masterdata_program_tanggal").flatpickr({
                        defaultDate: [data.data.tr_progres_program_s_r.sr_tanggal]
                    });
                    $('#form_masterdata_program_tanggal').val(data.data.tr_progres_program_s_r.sr_tanggal);
                    $('#form_masterdata_program_nomor_mmr').val(data.data.tr_progres_program_s_r.sr_nomor);
                    $('#form_masterdata_program_anggaran_fix').val(data.data.tr_progres_program_s_r.sr_nominal);
                }

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
    let form_masterdata_program_uuid = $("#form_masterdata_program_uuid").val();
    let form_masterdata_program_tanggal = $("#form_masterdata_program_tanggal").val();
    let form_masterdata_program_nomor_mmr = $("#form_masterdata_program_nomor_mmr").val();
    let form_masterdata_program_anggaran_fix = $("#form_masterdata_program_anggaran_fix").val();

    // validasi form
    if(form_masterdata_program_tanggal == "" || form_masterdata_program_nomor_mmr == "" || form_masterdata_program_anggaran_fix == "")
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
                url: BaseURL + "/transaksi/progres/program/mr_sr/act_update",
                data: {
                    form_masterdata_program_uuid,
                    form_masterdata_program_tanggal,
                    form_masterdata_program_nomor_mmr,
                    form_masterdata_program_anggaran_fix,
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

function act_btnPurchaseRequisition(data)
{
    let data_id = $(data).attr('data-id');
    let data_sr = $(data).attr('data-sr');
    let data_rrm = $(data).attr('data-rrm');

    let form_masterdata_program_fundnumber = data_rrm;

    if(form_masterdata_program_fundnumber == "")
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
        url: BaseURL + "/transaksi/progres/program/mr_sr/act_detail",
        data: {
            form_masterdata_program_fundnumber,
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
            if(data.status == true)
            {       
                $('#form_masterdata_program_sr_nomor').val(data.data.sr_nomor);         
                $('#form_masterdata_program_sr_uuid').val(data.data.uuid).prop('readonly', true);
                $('#form_masterdata_program_sr_nama').val(data.data.name);
                $('#form_masterdata_program_sr_anggaran').val(data.data.sr_nominal);

                $('#form_masterdata_program_sr_fundcenter').val(data.data.fund_center);
                $('#form_masterdata_program_sr_jenis').val(data.data.m_program_jenis_c_c_k.uuid).change();
                $('#form_masterdata_program_sr_lokasi').val(data.data.m_program_lokasi_c_c.uuid).change();

                data_tr_program_progres_sr = data.data;

                $('.dataContenFormPR').show();

                $('#modal-tambah-pr').modal('show');
            }else{  
                data_tr_program_progres_sr = null;

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

function act_submitTambahDataPR()
{
    let form_masterdata_program_fundnumber = $("#form_masterdata_program_sr_nomor").val();
    let form_masterdata_program_uuid = $("#form_masterdata_program_sr_uuid").val();
    let form_masterdata_program_pr_tanggal = $("#form_masterdata_program_pr_tanggal").val();
    let form_masterdata_program_pr_nomor = $("#form_masterdata_program_pr_nomor").val();
    let form_masterdata_program_pr_vendor = $("#form_masterdata_program_pr_vendor").val();
    let form_masterdata_program_pr_anggaran = $("#form_masterdata_program_pr_anggaran").val();

    // validasi form
    if(form_masterdata_program_fundnumber == "" || form_masterdata_program_pr_tanggal == "" || form_masterdata_program_pr_nomor == "" || form_masterdata_program_pr_vendor == "" || form_masterdata_program_pr_anggaran == "")
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

    if(form_masterdata_program_pr_anggaran > data_tr_program_progres_sr.sr_nominal)
    {
        Swal.fire({
            text: "Anggaran PR Tidak Boleh Melebihi Batas Anggaran !!",
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
        title: 'Yakin Menambah Data - Purchase Requisition (PR) ?',
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
                url: BaseURL + "/transaksi/progres/program/pr/act_tambah",
                data: {
                    form_masterdata_program_fundnumber,
                    form_masterdata_program_uuid,
                    form_masterdata_program_pr_tanggal,
                    form_masterdata_program_pr_nomor,
                    form_masterdata_program_pr_vendor,
                    form_masterdata_program_pr_anggaran
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
                                // location.reload();
                                window.location.replace(BaseURL + "/transaksi/progres/program/pr");

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

    $("#form_masterdata_program_tanggal").flatpickr();
    $("#form_masterdata_program_pr_tanggal").flatpickr();
});