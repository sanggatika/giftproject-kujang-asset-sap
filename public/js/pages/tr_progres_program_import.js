"use strict";
var data_decrpty = null;

$("#form_progres_program_upload_tanggal").flatpickr({
    maxDate: "today"
});

function btn_importProgresProgram()
{
    // reset_formDataUser();
    $('#modal-data-upload').modal('show');
}

function act_btnTambahDataUpload()
{
    let form_progres_program_upload_tanggal = $("#form_progres_program_upload_tanggal").val();
    if(form_progres_program_upload_tanggal == "")
    {
        Swal.fire({
            title: "Informasi !",
            text: "Pastikan Anda Sudah Memilih Tanggal Upload",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    var fileInput = document.getElementById("form_progres_program_upload_file");
    var files = fileInput.files;
    if (files.length === 0) {
        Swal.fire({
            title: "Informasi !",
            text: "Anda Belum Upload Excell Master Program",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    var formData = new FormData();
    // Iterate over all selected files    
    $.each($('#form_progres_program_upload_file')[0].files,function(key,input){
        formData.append('form_progres_program_upload_file[]', input);
    });

    formData.append('form_progres_program_upload_tanggal', form_progres_program_upload_tanggal);    

    KTApp.showPageLoading();

    $.ajax({
        url: BaseURL + "/transaksi/progres/import/act_upload",
        data: formData,
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {    
            KTApp.showPageLoading();                    
        },
        success: function (data) {
            KTApp.hidePageLoading();
            loadingEl.remove();

            console.log(data);

            if(data.status == true)
            {
                Swal.fire({
                    title: 'Berhasil !',
                    text: "Data Berhasil Disimpan Dalam Database, Terimakasih.",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Berhasil Disimpan !'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
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
        }
    });
}

form_filter_program.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_account.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_departement.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_bagian.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_kriteria.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_direktorat.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_statusprogres.onchange = evt => {
    serverSideDatatables();
}

form_filter_program_priority.onchange = evt => {
    serverSideDatatables();
}

function serverSideDatatables()
{
    let form_filter_program = $("#form_filter_program").val();
    let form_filter_program_account = $("#form_filter_program_account").val();
    let form_filter_program_departement = $("#form_filter_program_departement").val();
    let form_filter_program_bagian = $("#form_filter_program_bagian").val();
    let form_filter_program_kriteria = $("#form_filter_program_kriteria").val();
    let form_filter_program_direktorat = $("#form_filter_program_direktorat").val();
    let form_filter_program_statusprogres = $("#form_filter_program_statusprogres").val();
    let form_filter_program_priority = $("#form_filter_program_priority").val();

    $('#tabel_master_data').dataTable().fnDestroy();

    $('#tabel_master_data').DataTable({
        processing: true,
        serverSide: true,
        searching:true,        
        pageLength: 10,
        ajax: {
            url: BaseURL + "/transaksi/progres/import/get_datatable",
            type: "POST",
            data: {
                form_filter_program:form_filter_program,
                form_filter_program_account:form_filter_program_account,
                form_filter_program_departement:form_filter_program_departement,
                form_filter_program_bagian:form_filter_program_bagian,
                form_filter_program_kriteria:form_filter_program_kriteria,
                form_filter_program_direktorat:form_filter_program_direktorat,
                form_filter_program_statusprogres:form_filter_program_statusprogres,
                form_filter_program_priority:form_filter_program_priority
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                // setting a timeout
                KTApp.showPageLoading();
            },
            dataSrc: function (data) {
                console.log(data);
                KTApp.hidePageLoading();
                loadingEl.remove(); 

                $("#data_line2_program_total").html(data.jumlahMsProgram +" | "+data.totalMsProgramNominal);
                $("#data_line2_program_total_filter").html(data.jumlahFilterMsProgram +" | "+data.totalFilterMsProgramNominal);
                $("#data_line2_program_single_year").html(data.jumlahFilterMsProgramSingleYear +" | "+data.totalFilterMsProgramNominalSingleYear);
                $("#data_line2_program_multi_year").html(data.jumlahFilterMsProgramMultiYear +" | "+data.totalFilterMsProgramNominalMultiYear);

                $("#data_account_pabrik_program_jml").html(data.jumlahFilterMsProgramAccountPabrik);
                $("#data_account_pabrik_program_nilai").html(data.totalFilterMsProgramNominalAccountPabrik);
                $("#data_account_pabrik_user_jml").html(data.jumlahFilterMsProgramAccountPabrikUser);
                $("#data_account_pabrik_user_nilai").html(data.totalFilterMsProgramNominalAccountPabrikUser);
                $("#data_account_pabrik_mir_jml").html(data.jumlahFilterMsProgramAccountPabrikMIR);
                $("#data_account_pabrik_mir_nilai").html(data.totalFilterMsProgramNominalAccountPabrikMIR);
                $("#data_account_pabrik_sr_jml").html(data.jumlahFilterMsProgramAccountPabrikSR);
                $("#data_account_pabrik_sr_nilai").html(data.totalFilterMsProgramNominalAccountPabrikSR);
                $("#data_account_pabrik_pr_jml").html(data.jumlahFilterMsProgramAccountPabrikPR);
                $("#data_account_pabrik_pr_nilai").html(data.totalFilterMsProgramNominalAccountPabrikPR);
                $("#data_account_pabrik_po_jml").html(data.jumlahFilterMsProgramAccountPabrikPO);
                $("#data_account_pabrik_po_nilai").html(data.totalFilterMsProgramNominalAccountPabrikPO);
                $("#data_account_pabrik_gr_jml").html(data.jumlahFilterMsProgramAccountPabrikGR);
                $("#data_account_pabrik_gr_nilai").html(data.totalFilterMsProgramNominalAccountPabrikGR);

                $("#data_account_a2b_program_jml").html(data.jumlahFilterMsProgramAccountA2B);
                $("#data_account_a2b_program_nilai").html(data.totalFilterMsProgramNominalAccountA2B);
                $("#data_account_a2b_user_jml").html(data.jumlahFilterMsProgramAccountA2BUser);
                $("#data_account_a2b_user_nilai").html(data.totalFilterMsProgramNominalAccountA2BUser);
                $("#data_account_a2b_mir_jml").html(data.jumlahFilterMsProgramAccountA2BMIR);
                $("#data_account_a2b_mir_nilai").html(data.totalFilterMsProgramNominalAccountA2BMIR);
                $("#data_account_a2b_sr_jml").html(data.jumlahFilterMsProgramAccountA2BSR);
                $("#data_account_a2b_sr_nilai").html(data.totalFilterMsProgramNominalAccountA2BSR);
                $("#data_account_a2b_pr_jml").html(data.jumlahFilterMsProgramAccountA2BPR);
                $("#data_account_a2b_pr_nilai").html(data.totalFilterMsProgramNominalAccountA2BPR);
                $("#data_account_a2b_po_jml").html(data.jumlahFilterMsProgramAccountA2BPO);
                $("#data_account_a2b_po_nilai").html(data.totalFilterMsProgramNominalAccountA2BPO);
                $("#data_account_a2b_gr_jml").html(data.jumlahFilterMsProgramAccountA2BGR);
                $("#data_account_a2b_gr_nilai").html(data.totalFilterMsProgramNominalAccountA2BGR);

                $("#data_account_peralatan_program_jml").html(data.jumlahFilterMsProgramAccountPeralatan);
                $("#data_account_peralatan_program_nilai").html(data.totalFilterMsProgramNominalAccountPeralatan);
                $("#data_account_peralatan_user_jml").html(data.jumlahFilterMsProgramAccountPeralatanUser);
                $("#data_account_peralatan_user_nilai").html(data.totalFilterMsProgramNominalAccountPeralatanUser);
                $("#data_account_peralatan_mir_jml").html(data.jumlahFilterMsProgramAccountPeralatanMIR);
                $("#data_account_peralatan_mir_nilai").html(data.totalFilterMsProgramNominalAccountPeralatanMIR);
                $("#data_account_peralatan_sr_jml").html(data.jumlahFilterMsProgramAccountPeralatanSR);
                $("#data_account_peralatan_sr_nilai").html(data.totalFilterMsProgramNominalAccountPeralatanSR);
                $("#data_account_peralatan_pr_jml").html(data.jumlahFilterMsProgramAccountPeralatanPR);
                $("#data_account_peralatan_pr_nilai").html(data.totalFilterMsProgramNominalAccountPeralatanPR);
                $("#data_account_peralatan_po_jml").html(data.jumlahFilterMsProgramAccountPeralatanPO);
                $("#data_account_peralatan_po_nilai").html(data.totalFilterMsProgramNominalAccountPeralatanPO);
                $("#data_account_peralatan_gr_jml").html(data.jumlahFilterMsProgramAccountPeralatanGR);
                $("#data_account_peralatan_gr_nilai").html(data.totalFilterMsProgramNominalAccountPeralatanGR);

                $("#data_account_bangunan_program_jml").html(data.jumlahFilterMsProgramAccountBangunan);
                $("#data_account_bangunan_program_nilai").html(data.totalFilterMsProgramNominalAccountBangunan);
                $("#data_account_bangunan_user_jml").html(data.jumlahFilterMsProgramAccountBangunanUser);
                $("#data_account_bangunan_user_nilai").html(data.totalFilterMsProgramNominalAccountBangunanUser);
                $("#data_account_bangunan_mir_jml").html(data.jumlahFilterMsProgramAccountBangunanMIR);
                $("#data_account_bangunan_mir_nilai").html(data.totalFilterMsProgramNominalAccountBangunanMIR);
                $("#data_account_bangunan_sr_jml").html(data.jumlahFilterMsProgramAccountBangunanSR);
                $("#data_account_bangunan_sr_nilai").html(data.totalFilterMsProgramNominalAccountBangunanSR);
                $("#data_account_bangunan_pr_jml").html(data.jumlahFilterMsProgramAccountBangunanPR);
                $("#data_account_bangunan_pr_nilai").html(data.totalFilterMsProgramNominalAccountBangunanPR);
                $("#data_account_bangunan_po_jml").html(data.jumlahFilterMsProgramAccountBangunanPO);
                $("#data_account_bangunan_po_nilai").html(data.totalFilterMsProgramNominalAccountBangunanPO);
                $("#data_account_bangunan_gr_jml").html(data.jumlahFilterMsProgramAccountBangunanGR);
                $("#data_account_bangunan_gr_nilai").html(data.totalFilterMsProgramNominalAccountBangunanGR);

                $("#data_account_asettbwjd_program_jml").html(data.jumlahFilterMsProgramAccountAsetTBWJD);
                $("#data_account_asettbwjd_program_nilai").html(data.totalFilterMsProgramNominalAccountAsetTBWJD);
                $("#data_account_asettbwjd_user_jml").html(data.jumlahFilterMsProgramAccountAsetTBWJDUser);
                $("#data_account_asettbwjd_user_nilai").html(data.totalFilterMsProgramNominalAccountAsetTBWJDUser);
                $("#data_account_asettbwjd_mir_jml").html(data.jumlahFilterMsProgramAccountAsetTBWJDMIR);
                $("#data_account_asettbwjd_mir_nilai").html(data.totalFilterMsProgramNominalAccountAsetTBWJDMIR);
                $("#data_account_asettbwjd_sr_jml").html(data.jumlahFilterMsProgramAccountAsetTBWJDSR);
                $("#data_account_asettbwjd_sr_nilai").html(data.totalFilterMsProgramNominalAccountAsetTBWJDSR);
                $("#data_account_asettbwjd_pr_jml").html(data.jumlahFilterMsProgramAccountAsetTBWJDPR);
                $("#data_account_asettbwjd_pr_nilai").html(data.totalFilterMsProgramNominalAccountAsetTBWJDPR);
                $("#data_account_asettbwjd_po_jml").html(data.jumlahFilterMsProgramAccountAsetTBWJDPO);
                $("#data_account_asettbwjd_po_nilai").html(data.totalFilterMsProgramNominalAccountAsetTBWJDPO);
                $("#data_account_asettbwjd_gr_jml").html(data.jumlahFilterMsProgramAccountAsetTBWJDGR);
                $("#data_account_asettbwjd_gr_nilai").html(data.totalFilterMsProgramNominalAccountAsetTBWJDGR);

                $("#data_account_scp_program_jml").html(data.jumlahFilterMsProgramAccountSCP);
                $("#data_account_scp_program_nilai").html(data.totalFilterMsProgramNominalAccountSCP);
                $("#data_account_scp_user_jml").html(data.jumlahFilterMsProgramAccountSCPUser);
                $("#data_account_scp_user_nilai").html(data.totalFilterMsProgramNominalAccountSCPUser);
                $("#data_account_scp_mir_jml").html(data.jumlahFilterMsProgramAccountSCPMIR);
                $("#data_account_scp_mir_nilai").html(data.totalFilterMsProgramNominalAccountSCPMIR);
                $("#data_account_scp_sr_jml").html(data.jumlahFilterMsProgramAccountSCPSR);
                $("#data_account_scp_sr_nilai").html(data.totalFilterMsProgramNominalAccountSCPSR);
                $("#data_account_scp_pr_jml").html(data.jumlahFilterMsProgramAccountSCPPR);
                $("#data_account_scp_pr_nilai").html(data.totalFilterMsProgramNominalAccountSCPPR);
                $("#data_account_scp_po_jml").html(data.jumlahFilterMsProgramAccountSCPPO);
                $("#data_account_scp_po_nilai").html(data.totalFilterMsProgramNominalAccountSCPPO);
                $("#data_account_scp_gr_jml").html(data.jumlahFilterMsProgramAccountSCPGR);
                $("#data_account_scp_gr_nilai").html(data.totalFilterMsProgramNominalAccountSCPGR);

                $("#data_account_program_jml").html(data.jumlahFilterMsProgramAccount);
                $("#data_account_program_nilai").html(data.totalFilterMsProgramNominalAccount);
                $("#data_account_program_jml_user").html(data.jumlahFilterMsProgramAccountUser);
                $("#data_account_program_nilai_user").html(data.totalFilterMsProgramNominalAccountUser);
                $("#data_account_program_jml_mir").html(data.jumlahFilterMsProgramAccountMIR);
                $("#data_account_program_nilai_mir").html(data.totalFilterMsProgramNominalAccountMIR);
                $("#data_account_program_jml_sr").html(data.jumlahFilterMsProgramAccountSR);
                $("#data_account_program_nilai_sr").html(data.totalFilterMsProgramNominalAccountSR);
                $("#data_account_program_jml_pr").html(data.jumlahFilterMsProgramAccountPR);
                $("#data_account_program_nilai_pr").html(data.totalFilterMsProgramNominalAccountPR);
                $("#data_account_program_jml_po").html(data.jumlahFilterMsProgramAccountPO);
                $("#data_account_program_nilai_po").html(data.totalFilterMsProgramNominalAccountPO);
                $("#data_account_program_jml_gr").html(data.jumlahFilterMsProgramAccountGR);
                $("#data_account_program_nilai_gr").html(data.totalFilterMsProgramNominalAccountGR);

                $("#data_account_program_persentase_jml").html(data.jumlahFilterMsProgramPersentaseAccount + " %");
                $("#data_account_program_persentase_nilai").html(data.totalFilterMsProgramNominalPersentaseAccount + " %");
                $("#data_account_program_persentase_jml_user").html(data.jumlahFilterMsProgramPersentaseAccountUser + " %");
                $("#data_account_program_persentase_nilai_user").html(data.totalFilterMsProgramNominalPersentaseAccountUser + " %");
                $("#data_account_program_persentase_jml_mir").html(data.jumlahFilterMsProgramPersentaseAccountMIR + " %");
                $("#data_account_program_persentase_nilai_mir").html(data.totalFilterMsProgramNominalPersentaseAccountMIR + " %");
                $("#data_account_program_persentase_jml_sr").html(data.jumlahFilterMsProgramPersentaseAccountSR + " %");
                $("#data_account_program_persentase_nilai_sr").html(data.totalFilterMsProgramNominalPersentaseAccountSR + " %");
                $("#data_account_program_persentase_jml_pr").html(data.jumlahFilterMsProgramPersentaseAccountPR + " %");
                $("#data_account_program_persentase_nilai_pr").html(data.totalFilterMsProgramNominalPersentaseAccountPR + " %");
                $("#data_account_program_persentase_jml_po").html(data.jumlahFilterMsProgramPersentaseAccountPO + " %");
                $("#data_account_program_persentase_nilai_po").html(data.totalFilterMsProgramNominalPersentaseAccountPO + " %");
                $("#data_account_program_persentase_jml_gr").html(data.jumlahFilterMsProgramPersentaseAccountGR + " %");
                $("#data_account_program_persentase_nilai_gr").html(data.totalFilterMsProgramNominalPersentaseAccountGR + " %");

                if(data.status_cut_off_set > 0)
                {
                    $('.cardDataCutOff').show();
                }

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
            {data: 'fild_kriteria', name: 'fild_kriteria'},
            {data: 'fild_departement', name: 'fild_departement'},
            {data: 'fild_direktorat', name: 'fild_direktorat'},
            {data: 'fild_account', name: 'fild_account'},
            {data: 'fild_progres', name: 'fild_progres'},
            {data: 'fild_nominal', name: 'fild_nominal'},
            {data: 'fild_nominal_commit', name: 'fild_nominal_commit'},
            {data: 'fild_nominal_sisa', name: 'fild_nominal_sisa'},
            // {data: 'action', name: 'action'}            
        ]
    });
}

function btn_cutoffProgresProgram()
{
    Swal.fire({
        title: 'Yakin Cut Off Data ?',
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
            KTApp.showPageLoading();

            $.ajax({
                url: BaseURL + "/transaksi/progres/import/cut_off_data",
                data: {
                    
                },
                method: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
            KTApp.hidePageLoading();
            loadingEl.remove();

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

function datatabelesreload()
{
	$('#tabel_master_data').DataTable().ajax.reload(null, false); //Reload Tanpa Reset Page Datatable
}

$(document).ready(function() {
    serverSideDatatables();    
});