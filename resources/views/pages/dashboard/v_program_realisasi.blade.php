@extends('layouts/adminLayoutMaster')

@section('title', 'Dashboard Admin')

@section('page-style')
    <!-- Current Page CSS Costum -->

@endsection

@section('content')

@php
    $jumlahMsProgram =  $model['ms_program']->count();
    $totalMsProgramNominal =  $model['ms_program']->sum('nominal');

    $data_ms_program_realisasi = $model['ms_program']->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == "GR";
    });
    $jumlahMsProgramRealisasi =  $data_ms_program_realisasi->count();
    $totalMsProgramNominalRealisasi =  $data_ms_program_realisasi->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    $persentaseMsProgramRealisasi =  ($totalMsProgramNominalRealisasi / $totalMsProgramNominal) * 100;

    $jumlahMsProgramSisa =  $jumlahMsProgram - $jumlahMsProgramRealisasi;
    $totalMsProgramNominalSisa =  $totalMsProgramNominal - $totalMsProgramNominalRealisasi;
    $persentaseMsProgramSisa =  ($totalMsProgramNominalSisa / $totalMsProgramNominal) * 100;

    // Data Master Program Single Year
    $data_ms_program_singleyear = $model['ms_program']->where('kriteria_pengadaan','Singleyear');
    $jumlahMsProgramSingleYear =  $data_ms_program_singleyear->count();
    $totalMsProgramNominalSingleYear =  $data_ms_program_singleyear->sum('nominal');

    // Single Year GL Account Pabrik
    $dataMsProgramSingleyearPabrik = $data_ms_program_singleyear->where('id_program_account', 4);
    $jumlahMsProgramSingleyearAccountPabrik = $dataMsProgramSingleyearPabrik->count();
    $nominalMsProgramSingleyearAccountPabrik = $dataMsProgramSingleyearPabrik->sum('nominal');
    // Single Year GL Account Pabrik - User
    $dataMsProgramSingleyearPabrikUser = $dataMsProgramSingleyearPabrik->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'USER';
    });
    $jumlahMsProgramSingleyearAccountPabrikUser = $dataMsProgramSingleyearPabrikUser->count();
    $nominalMsProgramSingleyearAccountPabrikUser = $dataMsProgramSingleyearPabrikUser->sum('nominal');
    // Single Year GL Account Pabrik - MIR
    $dataMsProgramSingleyearPabrikMIR = $dataMsProgramSingleyearPabrik->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'MIR';
    });
    $jumlahMsProgramSingleyearAccountPabrikMIR = $dataMsProgramSingleyearPabrikMIR->count();
    $nominalMsProgramSingleyearAccountPabrikMIR = $dataMsProgramSingleyearPabrikMIR->sum('nominal');
    // Single Year GL Account Pabrik - SR
    $dataMsProgramSingleyearPabrikSR = $dataMsProgramSingleyearPabrik->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'SR';
    });
    $jumlahMsProgramSingleyearAccountPabrikSR = $dataMsProgramSingleyearPabrikSR->count();
    $nominalMsProgramSingleyearAccountPabrikSR = $dataMsProgramSingleyearPabrikSR->sum('nominal');
    // Single Year GL Account Pabrik - PR
    $dataMsProgramSingleyearPabrikPR = $dataMsProgramSingleyearPabrik->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'PR';
    });
    $jumlahMsProgramSingleyearAccountPabrikPR = $dataMsProgramSingleyearPabrikPR->count();
    $nominalMsProgramSingleyearAccountPabrikPR = $dataMsProgramSingleyearPabrikPR->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    // Single Year GL Account Pabrik - PO
    $dataMsProgramSingleyearPabrikPO = $dataMsProgramSingleyearPabrik->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'PO';
    });
    $jumlahMsProgramSingleyearAccountPabrikPO = $dataMsProgramSingleyearPabrikPO->count();
    $nominalMsProgramSingleyearAccountPabrikPO = $dataMsProgramSingleyearPabrikPO->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    // Single Year GL Account Pabrik - GR
    $dataMsProgramSingleyearPabrikGR = $dataMsProgramSingleyearPabrik->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'GR';
    });
    $jumlahMsProgramSingleyearAccountPabrikGR = $dataMsProgramSingleyearPabrikGR->count();
    $nominalMsProgramSingleyearAccountPabrikGR = $dataMsProgramSingleyearPabrikGR->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });

    // Single Year GL Account A2B
    $dataMsProgramSingleyearA2B = $data_ms_program_singleyear->where('id_program_account', 1);
    $jumlahMsProgramSingleyearAccountA2B = $dataMsProgramSingleyearA2B->count();
    $nominalMsProgramSingleyearAccountA2B = $dataMsProgramSingleyearA2B->sum('nominal');
    // Single Year GL Account A2B - User
    $dataMsProgramSingleyearA2BUser = $dataMsProgramSingleyearA2B->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'USER';
    });
    $jumlahMsProgramSingleyearAccountA2BUser = $dataMsProgramSingleyearA2BUser->count();
    $nominalMsProgramSingleyearAccountA2BUser = $dataMsProgramSingleyearA2BUser->sum('nominal');
    // Single Year GL Account A2B - MIR
    $dataMsProgramSingleyearA2BMIR = $dataMsProgramSingleyearA2B->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'MIR';
    });
    $jumlahMsProgramSingleyearAccountA2BMIR = $dataMsProgramSingleyearA2BMIR->count();
    $nominalMsProgramSingleyearAccountA2BMIR = $dataMsProgramSingleyearA2BMIR->sum('nominal');
    // Single Year GL Account A2B - SR
    $dataMsProgramSingleyearA2BSR = $dataMsProgramSingleyearA2B->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'SR';
    });
    $jumlahMsProgramSingleyearAccountA2BSR = $dataMsProgramSingleyearA2BSR->count();
    $nominalMsProgramSingleyearAccountA2BSR = $dataMsProgramSingleyearA2BSR->sum('nominal');
    // Single Year GL Account A2B - PR
    $dataMsProgramSingleyearA2BPR = $dataMsProgramSingleyearA2B->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'PR';
    });
    $jumlahMsProgramSingleyearAccountA2BPR = $dataMsProgramSingleyearA2BPR->count();
    $nominalMsProgramSingleyearAccountA2BPR = $dataMsProgramSingleyearA2BPR->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    // Single Year GL Account A2B - PO
    $dataMsProgramSingleyearA2BPO = $dataMsProgramSingleyearA2B->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'PO';
    });
    $jumlahMsProgramSingleyearAccountA2BPO = $dataMsProgramSingleyearA2BPO->count();
    $nominalMsProgramSingleyearAccountA2BPO = $dataMsProgramSingleyearA2BPO->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    // Single Year GL Account A2B - GR
    $dataMsProgramSingleyearA2BGR = $dataMsProgramSingleyearA2B->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'GR';
    });
    $jumlahMsProgramSingleyearAccountA2BGR = $dataMsProgramSingleyearA2BGR->count();
    $nominalMsProgramSingleyearAccountA2BGR = $dataMsProgramSingleyearA2BGR->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });

    // Single Year GL Account Peralatan
    $dataMsProgramSingleyearPeralatan = $data_ms_program_singleyear->where('id_program_account', 5);
    $jumlahMsProgramSingleyearAccountPeralatan = $dataMsProgramSingleyearPeralatan->count();
    $nominalMsProgramSingleyearAccountPeralatan = $dataMsProgramSingleyearPeralatan->sum('nominal');
    // Single Year GL Account Peralatan - User
    $dataMsProgramSingleyearPeralatanUser = $dataMsProgramSingleyearPeralatan->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'USER';
    });
    $jumlahMsProgramSingleyearAccountPeralatanUser = $dataMsProgramSingleyearPeralatanUser->count();
    $nominalMsProgramSingleyearAccountPeralatanUser = $dataMsProgramSingleyearPeralatanUser->sum('nominal');
    // Single Year GL Account Peralatan - MIR
    $dataMsProgramSingleyearPeralatanMIR = $dataMsProgramSingleyearPeralatan->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'MIR';
    });
    $jumlahMsProgramSingleyearAccountPeralatanMIR = $dataMsProgramSingleyearPeralatanMIR->count();
    $nominalMsProgramSingleyearAccountPeralatanMIR = $dataMsProgramSingleyearPeralatanMIR->sum('nominal');
    // Single Year GL Account Peralatan - SR
    $dataMsProgramSingleyearPeralatanSR = $dataMsProgramSingleyearPeralatan->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'SR';
    });
    $jumlahMsProgramSingleyearAccountPeralatanSR = $dataMsProgramSingleyearPeralatanSR->count();
    $nominalMsProgramSingleyearAccountPeralatanSR = $dataMsProgramSingleyearPeralatanSR->sum('nominal');
    // Single Year GL Account Peralatan - PR
    $dataMsProgramSingleyearPeralatanPR = $dataMsProgramSingleyearPeralatan->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'PR';
    });
    $jumlahMsProgramSingleyearAccountPeralatanPR = $dataMsProgramSingleyearPeralatanPR->count();
    $nominalMsProgramSingleyearAccountPeralatanPR = $dataMsProgramSingleyearPeralatanPR->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    // Single Year GL Account Peralatan - PO
    $dataMsProgramSingleyearPeralatanPO = $dataMsProgramSingleyearPeralatan->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'PO';
    });
    $jumlahMsProgramSingleyearAccountPeralatanPO = $dataMsProgramSingleyearPeralatanPO->count();
    $nominalMsProgramSingleyearAccountPeralatanPO = $dataMsProgramSingleyearPeralatanPO->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    // Single Year GL Account Peralatan - GR
    $dataMsProgramSingleyearPeralatanGR = $dataMsProgramSingleyearPeralatan->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'GR';
    });
    $jumlahMsProgramSingleyearAccountPeralatanGR = $dataMsProgramSingleyearPeralatanGR->count();
    $nominalMsProgramSingleyearAccountPeralatanGR = $dataMsProgramSingleyearPeralatanGR->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    
    // Single Year GL Account Bangunan
    $dataMsProgramSingleyearBangunan = $data_ms_program_singleyear->where('id_program_account', 3);
    $jumlahMsProgramSingleyearAccountBangunan = $dataMsProgramSingleyearBangunan->count();
    $nominalMsProgramSingleyearAccountBangunan = $dataMsProgramSingleyearBangunan->sum('nominal');
    // Single Year GL Account Bangunan - User
    $dataMsProgramSingleyearBangunanUser = $dataMsProgramSingleyearBangunan->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'USER';
    });
    $jumlahMsProgramSingleyearAccountBangunanUser = $dataMsProgramSingleyearBangunanUser->count();
    $nominalMsProgramSingleyearAccountBangunanUser = $dataMsProgramSingleyearBangunanUser->sum('nominal');
    // Single Year GL Account Bangunan - MIR
    $dataMsProgramSingleyearBangunanMIR = $dataMsProgramSingleyearBangunan->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'MIR';
    });
    $jumlahMsProgramSingleyearAccountBangunanMIR = $dataMsProgramSingleyearBangunanMIR->count();
    $nominalMsProgramSingleyearAccountBangunanMIR = $dataMsProgramSingleyearBangunanMIR->sum('nominal');
    // Single Year GL Account Bangunan - SR
    $dataMsProgramSingleyearBangunanSR = $dataMsProgramSingleyearBangunan->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'SR';
    });
    $jumlahMsProgramSingleyearAccountBangunanSR = $dataMsProgramSingleyearBangunanSR->count();
    $nominalMsProgramSingleyearAccountBangunanSR = $dataMsProgramSingleyearBangunanSR->sum('nominal');
    // Single Year GL Account Bangunan - PR
    $dataMsProgramSingleyearBangunanPR = $dataMsProgramSingleyearBangunan->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'PR';
    });
    $jumlahMsProgramSingleyearAccountBangunanPR = $dataMsProgramSingleyearBangunanPR->count();
    $nominalMsProgramSingleyearAccountBangunanPR = $dataMsProgramSingleyearBangunanPR->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    // Single Year GL Account Bangunan - PO
    $dataMsProgramSingleyearBangunanPO = $dataMsProgramSingleyearBangunan->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'PO';
    });
    $jumlahMsProgramSingleyearAccountBangunanPO = $dataMsProgramSingleyearBangunanPO->count();
    $nominalMsProgramSingleyearAccountBangunanPO = $dataMsProgramSingleyearBangunanPO->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    // Single Year GL Account Bangunan - GR
    $dataMsProgramSingleyearBangunanGR = $dataMsProgramSingleyearBangunan->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'GR';
    });
    $jumlahMsProgramSingleyearAccountBangunanGR = $dataMsProgramSingleyearBangunanGR->count();
    $nominalMsProgramSingleyearAccountBangunanGR = $dataMsProgramSingleyearBangunanGR->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });

    // Single Year GL Account AsetTBWJD
    $dataMsProgramSingleyearAsetTBWJD = $data_ms_program_singleyear->where('id_program_account', 2);
    $jumlahMsProgramSingleyearAccountAsetTBWJD = $dataMsProgramSingleyearAsetTBWJD->count();
    $nominalMsProgramSingleyearAccountAsetTBWJD = $dataMsProgramSingleyearAsetTBWJD->sum('nominal');
    // Single Year GL Account AsetTBWJD - User
    $dataMsProgramSingleyearAsetTBWJDUser = $dataMsProgramSingleyearAsetTBWJD->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'USER';
    });
    $jumlahMsProgramSingleyearAccountAsetTBWJDUser = $dataMsProgramSingleyearAsetTBWJDUser->count();
    $nominalMsProgramSingleyearAccountAsetTBWJDUser = $dataMsProgramSingleyearAsetTBWJDUser->sum('nominal');
    // Single Year GL Account AsetTBWJD - MIR
    $dataMsProgramSingleyearAsetTBWJDMIR = $dataMsProgramSingleyearAsetTBWJD->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'MIR';
    });
    $jumlahMsProgramSingleyearAccountAsetTBWJDMIR = $dataMsProgramSingleyearAsetTBWJDMIR->count();
    $nominalMsProgramSingleyearAccountAsetTBWJDMIR = $dataMsProgramSingleyearAsetTBWJDMIR->sum('nominal');
    // Single Year GL Account AsetTBWJD - SR
    $dataMsProgramSingleyearAsetTBWJDSR = $dataMsProgramSingleyearAsetTBWJD->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'SR';
    });
    $jumlahMsProgramSingleyearAccountAsetTBWJDSR = $dataMsProgramSingleyearAsetTBWJDSR->count();
    $nominalMsProgramSingleyearAccountAsetTBWJDSR = $dataMsProgramSingleyearAsetTBWJDSR->sum('nominal');
    // Single Year GL Account AsetTBWJD - PR
    $dataMsProgramSingleyearAsetTBWJDPR = $dataMsProgramSingleyearAsetTBWJD->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'PR';
    });
    $jumlahMsProgramSingleyearAccountAsetTBWJDPR = $dataMsProgramSingleyearAsetTBWJDPR->count();
    $nominalMsProgramSingleyearAccountAsetTBWJDPR = $dataMsProgramSingleyearAsetTBWJDPR->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    // Single Year GL Account AsetTBWJD - PO
    $dataMsProgramSingleyearAsetTBWJDPO = $dataMsProgramSingleyearAsetTBWJD->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'PO';
    });
    $jumlahMsProgramSingleyearAccountAsetTBWJDPO = $dataMsProgramSingleyearAsetTBWJDPO->count();
    $nominalMsProgramSingleyearAccountAsetTBWJDPO = $dataMsProgramSingleyearAsetTBWJDPO->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    // Single Year GL Account AsetTBWJD - GR
    $dataMsProgramSingleyearAsetTBWJDGR = $dataMsProgramSingleyearAsetTBWJD->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'GR';
    });
    $jumlahMsProgramSingleyearAccountAsetTBWJDGR = $dataMsProgramSingleyearAsetTBWJDGR->count();
    $nominalMsProgramSingleyearAccountAsetTBWJDGR = $dataMsProgramSingleyearAsetTBWJDGR->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });

    // Single Year GL Account SCP
    $dataMsProgramSingleyearSCP = $data_ms_program_singleyear->where('id_program_account', 6);
    $jumlahMsProgramSingleyearAccountSCP = $dataMsProgramSingleyearSCP->count();
    $nominalMsProgramSingleyearAccountSCP = $dataMsProgramSingleyearSCP->sum('nominal');
    // Single Year GL Account SCP - User
    $dataMsProgramSingleyearSCPUser = $dataMsProgramSingleyearSCP->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'USER';
    });
    $jumlahMsProgramSingleyearAccountSCPUser = $dataMsProgramSingleyearSCPUser->count();
    $nominalMsProgramSingleyearAccountSCPUser = $dataMsProgramSingleyearSCPUser->sum('nominal');
    // Single Year GL Account SCP - MIR
    $dataMsProgramSingleyearSCPMIR = $dataMsProgramSingleyearSCP->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'MIR';
    });
    $jumlahMsProgramSingleyearAccountSCPMIR = $dataMsProgramSingleyearSCPMIR->count();
    $nominalMsProgramSingleyearAccountSCPMIR = $dataMsProgramSingleyearSCPMIR->sum('nominal');
    // Single Year GL Account SCP - SR
    $dataMsProgramSingleyearSCPSR = $dataMsProgramSingleyearSCP->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'SR';
    });
    $jumlahMsProgramSingleyearAccountSCPSR = $dataMsProgramSingleyearSCPSR->count();
    $nominalMsProgramSingleyearAccountSCPSR = $dataMsProgramSingleyearSCPSR->sum('nominal');
    // Single Year GL Account SCP - PR
    $dataMsProgramSingleyearSCPPR = $dataMsProgramSingleyearSCP->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'PR';
    });
    $jumlahMsProgramSingleyearAccountSCPPR = $dataMsProgramSingleyearSCPPR->count();
    $nominalMsProgramSingleyearAccountSCPPR = $dataMsProgramSingleyearSCPPR->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    // Single Year GL Account SCP - PO
    $dataMsProgramSingleyearSCPPO = $dataMsProgramSingleyearSCP->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'PO';
    });
    $jumlahMsProgramSingleyearAccountSCPPO = $dataMsProgramSingleyearSCPPO->count();
    $nominalMsProgramSingleyearAccountSCPPO = $dataMsProgramSingleyearSCPPO->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });
    // Single Year GL Account SCP - GR
    $dataMsProgramSingleyearSCPGR = $dataMsProgramSingleyearSCP->filter(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->status_progres == 'GR';
    });
    $jumlahMsProgramSingleyearAccountSCPGR = $dataMsProgramSingleyearSCPGR->count();
    $nominalMsProgramSingleyearAccountSCPGR = $dataMsProgramSingleyearSCPGR->sum(function ($program) {
        return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
    });

    $jumlahMsProgramSingleyearAccount = $jumlahMsProgramSingleyearAccountPabrik + $jumlahMsProgramSingleyearAccountA2B + $jumlahMsProgramSingleyearAccountPeralatan + $jumlahMsProgramSingleyearAccountBangunan + $jumlahMsProgramSingleyearAccountAsetTBWJD + $jumlahMsProgramSingleyearAccountSCP;
    $nominalMsProgramSingleyearAccount = $nominalMsProgramSingleyearAccountPabrik + $nominalMsProgramSingleyearAccountA2B + $nominalMsProgramSingleyearAccountPeralatan + $nominalMsProgramSingleyearAccountBangunan + $nominalMsProgramSingleyearAccountAsetTBWJD + $nominalMsProgramSingleyearAccountSCP;
    $jumlahMsProgramSingleyearAccountUser = $jumlahMsProgramSingleyearAccountPabrikUser + $jumlahMsProgramSingleyearAccountA2BUser + $jumlahMsProgramSingleyearAccountPeralatanUser + $jumlahMsProgramSingleyearAccountBangunanUser + $jumlahMsProgramSingleyearAccountAsetTBWJDUser + $jumlahMsProgramSingleyearAccountSCPUser;
    $nominalMsProgramSingleyearAccountUser = $nominalMsProgramSingleyearAccountPabrikUser + $nominalMsProgramSingleyearAccountA2BUser + $nominalMsProgramSingleyearAccountPeralatanUser + $nominalMsProgramSingleyearAccountBangunanUser + $nominalMsProgramSingleyearAccountAsetTBWJDUser + $nominalMsProgramSingleyearAccountSCPUser;
    $jumlahMsProgramSingleyearAccountMIR = $jumlahMsProgramSingleyearAccountPabrikMIR + $jumlahMsProgramSingleyearAccountA2BMIR + $jumlahMsProgramSingleyearAccountPeralatanMIR + $jumlahMsProgramSingleyearAccountBangunanMIR + $jumlahMsProgramSingleyearAccountAsetTBWJDMIR + $jumlahMsProgramSingleyearAccountSCPMIR;
    $nominalMsProgramSingleyearAccountMIR = $nominalMsProgramSingleyearAccountPabrikMIR + $nominalMsProgramSingleyearAccountA2BMIR + $nominalMsProgramSingleyearAccountPeralatanMIR + $nominalMsProgramSingleyearAccountBangunanMIR + $nominalMsProgramSingleyearAccountAsetTBWJDMIR + $nominalMsProgramSingleyearAccountSCPMIR;
    $jumlahMsProgramSingleyearAccountSR = $jumlahMsProgramSingleyearAccountPabrikSR + $jumlahMsProgramSingleyearAccountA2BSR + $jumlahMsProgramSingleyearAccountPeralatanSR + $jumlahMsProgramSingleyearAccountBangunanSR + $jumlahMsProgramSingleyearAccountAsetTBWJDSR + $jumlahMsProgramSingleyearAccountSCPSR;
    $nominalMsProgramSingleyearAccountSR = $nominalMsProgramSingleyearAccountPabrikSR + $nominalMsProgramSingleyearAccountA2BSR + $nominalMsProgramSingleyearAccountPeralatanSR + $nominalMsProgramSingleyearAccountBangunanSR + $nominalMsProgramSingleyearAccountAsetTBWJDSR + $nominalMsProgramSingleyearAccountSCPSR;
    $jumlahMsProgramSingleyearAccountPR = $jumlahMsProgramSingleyearAccountPabrikPR + $jumlahMsProgramSingleyearAccountA2BPR + $jumlahMsProgramSingleyearAccountPeralatanPR + $jumlahMsProgramSingleyearAccountBangunanPR + $jumlahMsProgramSingleyearAccountAsetTBWJDPR + $jumlahMsProgramSingleyearAccountSCPPR;
    $nominalMsProgramSingleyearAccountPR = $nominalMsProgramSingleyearAccountPabrikPR + $nominalMsProgramSingleyearAccountA2BPR + $nominalMsProgramSingleyearAccountPeralatanPR + $nominalMsProgramSingleyearAccountBangunanPR + $nominalMsProgramSingleyearAccountAsetTBWJDPR + $nominalMsProgramSingleyearAccountSCPPR;
    $jumlahMsProgramSingleyearAccountPO = $jumlahMsProgramSingleyearAccountPabrikPO + $jumlahMsProgramSingleyearAccountA2BPO + $jumlahMsProgramSingleyearAccountPeralatanPO + $jumlahMsProgramSingleyearAccountBangunanPO + $jumlahMsProgramSingleyearAccountAsetTBWJDPO + $jumlahMsProgramSingleyearAccountSCPPO;
    $nominalMsProgramSingleyearAccountPO = $nominalMsProgramSingleyearAccountPabrikPO + $nominalMsProgramSingleyearAccountA2BPO + $nominalMsProgramSingleyearAccountPeralatanPO + $nominalMsProgramSingleyearAccountBangunanPO + $nominalMsProgramSingleyearAccountAsetTBWJDPO + $nominalMsProgramSingleyearAccountSCPPO;
    $jumlahMsProgramSingleyearAccountGR = $jumlahMsProgramSingleyearAccountPabrikGR + $jumlahMsProgramSingleyearAccountA2BGR + $jumlahMsProgramSingleyearAccountPeralatanGR + $jumlahMsProgramSingleyearAccountBangunanGR + $jumlahMsProgramSingleyearAccountAsetTBWJDGR + $jumlahMsProgramSingleyearAccountSCPGR;
    $nominalMsProgramSingleyearAccountGR = $nominalMsProgramSingleyearAccountPabrikGR + $nominalMsProgramSingleyearAccountA2BGR + $nominalMsProgramSingleyearAccountPeralatanGR + $nominalMsProgramSingleyearAccountBangunanGR + $nominalMsProgramSingleyearAccountAsetTBWJDGR + $nominalMsProgramSingleyearAccountSCPGR;

    $persentaseJumlahMsProgramSingleyearAccount = 0;
    if($jumlahMsProgramSingleyearAccount != 0)
    {
        $persentaseJumlahMsProgramSingleyearAccount = ( $jumlahMsProgramSingleyearAccount / $jumlahMsProgramSingleyearAccount) * 100;
    }
    $persentaseNominalMsProgramSingleyearAccount = 0;
    if($nominalMsProgramSingleyearAccount != 0)
    {
        $persentaseNominalMsProgramSingleyearAccount = ( $nominalMsProgramSingleyearAccount / $nominalMsProgramSingleyearAccount) * 100;
    }
    $persentaseJumlahMsProgramSingleyearAccountUser = 0;
    if($jumlahMsProgramSingleyearAccountUser != 0)
    {
        $persentaseJumlahMsProgramSingleyearAccountUser = ( $jumlahMsProgramSingleyearAccountUser / $jumlahMsProgramSingleyearAccount) * 100;
    }
    $persentaseNominalMsProgramSingleyearAccountUser = 0;
    if($nominalMsProgramSingleyearAccountUser != 0)
    {
        $persentaseNominalMsProgramSingleyearAccountUser = ( $nominalMsProgramSingleyearAccountUser / $nominalMsProgramSingleyearAccount) * 100;
    }
    $persentaseJumlahMsProgramSingleyearAccountMIR = 0;
    if($jumlahMsProgramSingleyearAccountMIR != 0)
    {
        $persentaseJumlahMsProgramSingleyearAccountMIR = ( $jumlahMsProgramSingleyearAccountMIR / $jumlahMsProgramSingleyearAccount) * 100;
    }
    $persentaseNominalMsProgramSingleyearAccountMIR = 0;
    if($nominalMsProgramSingleyearAccountMIR != 0)
    {
        $persentaseNominalMsProgramSingleyearAccountMIR = ( $nominalMsProgramSingleyearAccountMIR / $nominalMsProgramSingleyearAccount) * 100;
    }
    $persentaseJumlahMsProgramSingleyearAccountSR = 0;
    if($jumlahMsProgramSingleyearAccountSR != 0)
    {
        $persentaseJumlahMsProgramSingleyearAccountSR = ( $jumlahMsProgramSingleyearAccountSR / $jumlahMsProgramSingleyearAccount) * 100;
    }
    $persentaseNominalMsProgramSingleyearAccountSR = 0;
    if($nominalMsProgramSingleyearAccountSR != 0)
    {
        $persentaseNominalMsProgramSingleyearAccountSR = ( $nominalMsProgramSingleyearAccountSR / $nominalMsProgramSingleyearAccount) * 100;
    }
    $persentaseJumlahMsProgramSingleyearAccountPR = 0;
    if($jumlahMsProgramSingleyearAccountPR != 0)
    {
        $persentaseJumlahMsProgramSingleyearAccountPR = ( $jumlahMsProgramSingleyearAccountPR / $jumlahMsProgramSingleyearAccount) * 100;
    }
    $persentaseNominalMsProgramSingleyearAccountPR = 0;
    if($nominalMsProgramSingleyearAccountPR != 0)
    {
        $persentaseNominalMsProgramSingleyearAccountPR = ( $nominalMsProgramSingleyearAccountPR / $nominalMsProgramSingleyearAccount) * 100;
    }
    $persentaseJumlahMsProgramSingleyearAccountPO = 0;
    if($jumlahMsProgramSingleyearAccountPO != 0)
    {
        $persentaseJumlahMsProgramSingleyearAccountPO = ( $jumlahMsProgramSingleyearAccountPO / $jumlahMsProgramSingleyearAccount) * 100;
    }
    $persentaseNominalMsProgramSingleyearAccountPO = 0;
    if($nominalMsProgramSingleyearAccountPO != 0)
    {
        $persentaseNominalMsProgramSingleyearAccountPO = ( $nominalMsProgramSingleyearAccountPO / $nominalMsProgramSingleyearAccount) * 100;
    }
    $persentaseJumlahMsProgramSingleyearAccountGR = 0;
    if($jumlahMsProgramSingleyearAccountGR != 0)
    {
        $persentaseJumlahMsProgramSingleyearAccountGR = ( $jumlahMsProgramSingleyearAccountGR / $jumlahMsProgramSingleyearAccount) * 100;
    }
    $persentaseNominalMsProgramSingleyearAccountGR = 0;
    if($nominalMsProgramSingleyearAccountGR != 0)
    {
        $persentaseNominalMsProgramSingleyearAccountGR = ( $nominalMsProgramSingleyearAccountGR / $nominalMsProgramSingleyearAccount) * 100;
    }

    // Data Master Program Multi Year
    $data_ms_program_multiyear = $model['ms_program']->where('kriteria_pengadaan','Multiyears 24-25');
    $jumlahMsProgramMultiYear =  $data_ms_program_multiyear->count();
    $totalMsProgramNominalMultiYear =  $data_ms_program_multiyear->sum('nominal');

@endphp

<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="row">
            
            <!--begin::Col-->
            <div class="col-lg-2 mb-2 mt-5">
                <!--begin::Label-->
                <label class="form-label fw-bold"> Dashboard Progres - {{ Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('HH:mm:ss') }}</label>
                <!--end::Label-->
                <h3 class="fw-bold">{{ Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd, D
                    MMMM Y') }}</h3>
                <h2 class="fw-bold" id="time"></h2>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-10 mb-2 mt-2">
                <div class="row">
                    <!--begin::Col-->
                    <div class="col-lg-3">
                        <div class="card shadow-sm bg-light-info">
                            <div class="card-body p-3">
                                <div class="d-flex flex-stack">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex align-items-center me-3">
                                        <!--begin::Logo-->
                                        <span class="indicator-label d-none"><i class="bi bi-boxes fs-1 me-5 text-primary"></i></span>
                                        <!--end::Logo-->
                
                                        <!--begin::Section-->
                                        <div class="flex-grow-1">
                                            <!--begin::Text-->
                                            <a href="#" class="text-gray-500 text-hover-primary fs-7 fw-semibold lh-0">Data Program Anggran</a>
                                            <!--end::Text-->
                                            <!--begin::Description-->
                                            <span class="text-gray-800 fw-bold d-block fs-5">{{ number_format($jumlahMsProgram,0,',','.') }} - Rp. {{ number_format($totalMsProgramNominal,0,',','.') }}</span>
                                            <!--end::Description=-->
                                        </div>
                                        <!--end::Section-->
                
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <div class="separator separator-dashed my-2"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-lg-3">
                        <div class="card shadow-sm bg-light-info">
                            <div class="card-body p-3">
                                <div class="d-flex flex-stack">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex align-items-center me-3">
                                        <!--begin::Logo-->
                                        <span class="indicator-label d-none"><i class="bi bi-boxes fs-1 me-5 text-primary"></i></span>
                                        <!--end::Logo-->
                
                                        <!--begin::Section-->
                                        <div class="flex-grow-1">
                                            <!--begin::Text-->
                                            <a href="#" class="text-gray-500 text-hover-primary fs-7 fw-semibold lh-0">Data Program Realisasi</a>
                                            <!--end::Text-->
                                            <!--begin::Description-->
                                            <span class="text-gray-800 fw-bold d-block fs-5">Rp. {{ number_format($totalMsProgramNominalRealisasi,0,',','.') }} ({{ number_format($persentaseMsProgramRealisasi,2,',','.') }}%)</span>
                                            <!--end::Description=-->
                                        </div>
                                        <!--end::Section-->
                
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <div class="separator separator-dashed my-2"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-lg-3">
                        <div class="card shadow-sm bg-light-info">
                            <div class="card-body p-3">
                                <div class="d-flex flex-stack">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex align-items-center me-3">
                                        <!--begin::Logo-->
                                        <span class="indicator-label d-none"><i class="bi bi-boxes fs-1 me-5 text-primary"></i></span>
                                        <!--end::Logo-->
                
                                        <!--begin::Section-->
                                        <div class="flex-grow-1">
                                            <!--begin::Text-->
                                            <a href="#" class="text-gray-500 text-hover-primary fs-7 fw-semibold lh-0">Data Sisa Anggaran</a>
                                            <!--end::Text-->
                                            <!--begin::Description-->
                                            <span class="text-gray-800 fw-bold d-block fs-5">Rp. {{ number_format($totalMsProgramNominalSisa,0,',','.') }} ({{ number_format($persentaseMsProgramSisa,2,',','.') }}%)</span>
                                            <!--end::Description=-->
                                        </div>
                                        <!--end::Section-->
                
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <div class="separator separator-dashed my-2"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-lg-3">
                        <!--begin::Label-->
                        <label class="form-label fw-bold fs-7">Tanggal Cut OFF : </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="position-relative d-flex align-items-center">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-calendar-8 fs-1 position-absolute mx-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                                <span class="path6"></span>
                            </i>
                            <!--end::Icon-->
                            <!--begin::Datepicker-->
                            <input class="form-control ps-12" placeholder="Select a date" value="{{date('Y')}}-12-31" placeholder="{{date('Y')}}-12-31" id="form_filter_tanggal_cutoff" name="form_filter_tanggal_cutoff"/>
                            <!--end::Datepicker-->
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Col-->
                </div>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-4 mb-2 mt-2">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <div id="kt_carousel_3_carousel_diagram" class="carousel carousel-custom slide" data-bs-ride="carousel" data-bs-interval="60000">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <!--begin::Label-->
                                <span class="fs-4 fw-bold pe-2">Program Investasi</span>
                                <!--end::Label-->
                        
                                <!--begin::Carousel Indicators-->
                                <ol class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-primary">
                                    <li data-bs-target="#kt_carousel_3_carousel_diagram" data-bs-slide-to="0" class="ms-1 active"></li>
                                    <li data-bs-target="#kt_carousel_3_carousel_diagram" data-bs-slide-to="1" class="ms-1"></li>
                                    <li data-bs-target="#kt_carousel_3_carousel_diagram" data-bs-slide-to="2" class="ms-1"></li>
                                </ol>
                                <!--end::Carousel Indicators-->
                            </div>
                            <!--end::Heading-->
                        
                            <!--begin::Carousel-->
                            <div class="carousel-inner pt-8">
                                <!--begin::Item-->
                                <div class="carousel-item active">

                                    <div id="line2_diagram_program_investasi_year" style="margin-top: -20px;"></div>

                                    <div class="table-responsive mt-2">
                                        <!--begin::Table-->
                                        <table class="table table-striped table-hover align-middle table-row-dashed fs-7" id="tabel_master_data_program_year">
                                            <!--begin::Table head-->
                                            <thead class="bg-light-info">
                                                <!--begin::Table row-->
                                                <tr class="text-center text-dark fw-bolder text-uppercase gs-0">                                
                                                    <th>No.</th>
                                                    <th>Program</th>
                                                    <th>Jumlah</th>
                                                    <th>Anggaran</th>
                                                    <th>&nbsp;%&nbsp;</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="text-gray-600 fw-bold">
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="position-relative py-2">
                                                            <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>&nbsp;
                                                            <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">1</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-start">
                                                        <div class="d-flex flex-column">
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder">SINGLEYEAR</a>
                                                            <hr class="my-1">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex flex-column">
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($jumlahMsProgramSingleYear,0,',','.')  }}</a>
                                                            <hr class="my-1">
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex flex-column">
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($totalMsProgramNominalSingleYear,0,',','.')  }}</a>
                                                            <hr class="my-1">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex flex-column">
                                                            @php
                                                                $persentaseMsProgramSingleYear = 0;
                                                                if($jumlahMsProgramSingleYear != 0)
                                                                {
                                                                    $persentaseMsProgramSingleYear = ($jumlahMsProgramSingleYear / $jumlahMsProgram ) * 100;
                                                                }
                                                            @endphp
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($persentaseMsProgramSingleYear,2,',','.')  }} % &nbsp;</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="position-relative py-2">
                                                            <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>&nbsp;
                                                            <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">2</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-start">
                                                        <div class="d-flex flex-column">
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder">MULTIYEARS</a>
                                                            <hr class="my-1">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex flex-column">
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($jumlahMsProgramMultiYear,0,',','.')  }}</a>
                                                            <hr class="my-1">
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex flex-column">
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($totalMsProgramNominalMultiYear,0,',','.')  }}</a>
                                                            <hr class="my-1">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex flex-column">
                                                            @php
                                                                $persentaseMsProgramMultiYear = 0;
                                                                if($jumlahMsProgramMultiYear != 0)
                                                                {
                                                                    $persentaseMsProgramMultiYear = ($jumlahMsProgramMultiYear / $jumlahMsProgram ) * 100;
                                                                }
                                                            @endphp
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> {{ number_format($persentaseMsProgramMultiYear,2,',','.')  }} % &nbsp;</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!--end::Table body-->
                                            <tfoot class="bg-light-info">
                                                <!--begin::Table row-->
                                                <tr class="text-center text-dark fw-bolder text-uppercase gs-0"> 
                                                    @php
                                                        $totalMsProgramInvestasiYear = $jumlahMsProgramSingleYear + $jumlahMsProgramMultiYear;
                                                        $nominalMsProgramInvestasiYear = $totalMsProgramNominalSingleYear + $totalMsProgramNominalMultiYear;
                                                    @endphp 
                                                    <th colspan="2">Total</th>
                                                    <th>{{ number_format($totalMsProgramInvestasiYear,0,',','.')  }}</th>
                                                    <th class="text-end">{{ number_format($nominalMsProgramInvestasiYear,0,',','.')  }}</th>
                                                    <th></th>
                                                </tr>
                                                <!--end::Table row-->
                                            </tfoot>
                                        </table>
                                        <!--end::Table-->
                                    </div>

                                    <div id="line2_chart_program_investasi_year"></div>

                                </div>
                                <!--end::Item-->
                        
                                <!--begin::Item-->
                                <div class="carousel-item">
                                    
                                    ...............

                                </div>
                                <!--end::Item-->
                        
                                <!--begin::Item-->
                                <div class="carousel-item">
                                    ...
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--end::Carousel-->
                        </div>
                    </div>
                </div>                
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-8 mb-2 mt-2">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <div id="kt_carousel_3_carousel_tabel" class="carousel carousel-custom slide" data-bs-ride="carousel" data-bs-interval="60000">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <!--begin::Label-->
                                <span class="fs-4 fw-bold pe-2">Program Investasi - Detail</span>
                                <!--end::Label-->
                        
                                <!--begin::Carousel Indicators-->
                                <ol class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-primary">
                                    <li data-bs-target="#kt_carousel_3_carousel_tabel" data-bs-slide-to="0" class="ms-1 active"></li>
                                    <li data-bs-target="#kt_carousel_3_carousel_tabel" data-bs-slide-to="1" class="ms-1"></li>
                                    <li data-bs-target="#kt_carousel_3_carousel_tabel" data-bs-slide-to="2" class="ms-1"></li>
                                </ol>
                                <!--end::Carousel Indicators-->
                            </div>
                            <!--end::Heading-->
                        
                            <!--begin::Carousel-->
                            <div class="carousel-inner pt-8">
                                <!--begin::Item-->
                                <div class="carousel-item active">
                                    
                                    <div class="mb-5" style="margin-top: -20px;">
                                        <div class="d-flex flex-stack">
                                            <div class="fw-bolder fs-4">UPDATE PROGRAM INVESTASI 2024 (SINGLEYEAR)
                                                <span class="fs-6 text-gray-400 ms-2"></span>
                                            </div>
                                            <!--begin::Menu-->
                                            <div>
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary"
                                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                                    <span class="svg-icon svg-icon-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                            viewBox="0 0 24 24">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="5" y="5" width="5"
                                                                    height="5" rx="1" fill="#000000"></rect>
                                                                <rect x="14" y="5" width="5"
                                                                    height="5" rx="1" fill="#000000" opacity="0.3">
                                                                </rect>
                                                                <rect x="5" y="14" width="5"
                                                                    height="5" rx="1" fill="#000000" opacity="0.3">
                                                                </rect>
                                                                <rect x="14" y="14" width="5"
                                                                    height="5" rx="1" fill="#000000" opacity="0.3">
                                                                </rect>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            </div>
                                            <!--end::Menu-->
                                        </div>
                                        <div class="h-3px w-100 bg-warning"></div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered table-sm border-primary align-middle table-row-dashed fs-9" id="tabel_progres_program_singleyear">
                                            <!--begin::Table head-->
                                            <thead class="bg-light-info">
                                                <!--begin::Table row-->
                                                <tr class="text-center text-dark fw-bolder text-uppercase gs-0">                                
                                                    <th rowspan="2" class="align-middle">NO.</th>
                                                    <th colspan="3">PROGRAM</th>
                                                    <th colspan="2">USER</th>
                                                    <th colspan="2">MIR</th>
                                                    <th colspan="2">SR</th>
                                                    <th colspan="2">PR</th>
                                                    <th colspan="2">PO</th>
                                                    <th colspan="2">REALISASI</th>
                                                </tr>
                                                <tr class="text-center text-dark fw-bolder text-uppercase gs-0">   
                                                    <th>ACCOUNT</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--begin::Table body-->
                                            <tbody class="text-gray-600 fw-bold">
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">1</a>
                                                    </td>
                                                    <td class="text-start">
                                                        PABRIK
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPabrik,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPabrik,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPabrikUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPabrikUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPabrikMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPabrikMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPabrikSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPabrikSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPabrikPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPabrikPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPabrikPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPabrikPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPabrikGR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPabrikGR,0,',','.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">2</a>
                                                    </td>
                                                    <td class="text-start">
                                                        A2B
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountA2B,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountA2B,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountA2BUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountA2BUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountA2BMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountA2BMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountA2BSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountA2BSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountA2BPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountA2BPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountA2BPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountA2BPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountA2BGR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountA2BGR,0,',','.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">3</a>
                                                    </td>
                                                    <td class="text-start">
                                                        PERALATAN
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPeralatan,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPeralatan,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPeralatanUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPeralatanUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPeralatanMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPeralatanMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPeralatanSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPeralatanSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPeralatanPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPeralatanPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPeralatanPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPeralatanPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPeralatanGR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPeralatanGR,0,',','.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">4</a>
                                                    </td>
                                                    <td class="text-start">
                                                        BANGUNAN
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountBangunan,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountBangunan,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountBangunanUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountBangunanUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountBangunanMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountBangunanMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountBangunanSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountBangunanSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountBangunanPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountBangunanPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountBangunanPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountBangunanPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountBangunanGR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountBangunanGR,0,',','.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">5</a>
                                                    </td>
                                                    <td class="text-start">
                                                        ASETT'BWJD
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountAsetTBWJD,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountAsetTBWJD,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountAsetTBWJDUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountAsetTBWJDUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountAsetTBWJDMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountAsetTBWJDMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountAsetTBWJDSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountAsetTBWJDSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountAsetTBWJDPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountAsetTBWJDPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountAsetTBWJDPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountAsetTBWJDPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountAsetTBWJDGR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountAsetTBWJDGR,0,',','.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">6</a>
                                                    </td>
                                                    <td class="text-start">
                                                        SCP
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountSCP,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountSCP,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountSCPUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountSCPUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountSCPMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountSCPMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountSCPSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountSCPSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountSCPPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountSCPPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountSCPPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountSCPPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountSCPGR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountSCPGR,0,',','.') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!--end::Table body-->
                                            <tfoot class="text-gray-600 fw-bold bg-light-info">
                                                <tr>
                                                    <td class="text-center" colspan="2">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">Total</a>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccount,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccount,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($jumlahMsProgramSingleyearAccountGR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($nominalMsProgramSingleyearAccountGR,0,',','.') }}
                                                    </td>
                                                </tr>
                                                <tr class="fs-8">
                                                    <td class="text-center" colspan="2">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">Persentase</a>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($persentaseJumlahMsProgramSingleyearAccount,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($persentaseNominalMsProgramSingleyearAccount,2,',','.') }} %
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($persentaseJumlahMsProgramSingleyearAccountUser,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($persentaseNominalMsProgramSingleyearAccountUser,2,',','.') }} %
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($persentaseJumlahMsProgramSingleyearAccountMIR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($persentaseNominalMsProgramSingleyearAccountMIR,2,',','.') }} %
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($persentaseJumlahMsProgramSingleyearAccountSR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($persentaseNominalMsProgramSingleyearAccountSR,2,',','.') }} %
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($persentaseJumlahMsProgramSingleyearAccountPR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($persentaseNominalMsProgramSingleyearAccountPR,2,',','.') }} %
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($persentaseJumlahMsProgramSingleyearAccountPO,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($persentaseNominalMsProgramSingleyearAccountPO,2,',','.') }} %
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($persentaseJumlahMsProgramSingleyearAccountGR,0,',','.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($persentaseNominalMsProgramSingleyearAccountGR,2,',','.') }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-4">
                                            <div id="line2_chart_program_investasi_singleyear"></div>
                                        </div>
                                        <!--end::Col-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-sm align-middle table-row-dashed fs-8" id="tabel_progres_program_singleyear_departement">
                                                    <!--begin::Table head-->
                                                    <thead class="bg-light-info">
                                                        <!--begin::Table row-->
                                                        <tr class="text-center text-dark fw-bolder text-uppercase gs-0">                                
                                                            <th rowspan="2" class="align-middle">NO.</th>
                                                            <th colspan="3">Program</th>
                                                            <th colspan="3">Realisasi</th>
                                                            <th colspan="3">Sisa</th>
                                                        </tr>
                                                        <tr class="text-center text-dark fw-bolder text-uppercase gs-0">   
                                                            <th>Departement</th>
                                                            <th>JML</th>
                                                            <th>NILAI</th>
                                                            <th>JML</th>
                                                            <th>NILAI</th>
                                                            <th>%</th>
                                                            <th>JML</th>
                                                            <th>NILAI</th>
                                                            <th>%</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--begin::Table body-->
                                                    <tbody class="text-gray-600 fw-bold">
                                                        @foreach ($model['ms_program']->where('kriteria_pengadaan','Singleyear')->groupBy('id_program_departement_cck') as $program_departement)
                                                        <tr>
                                                            @php
                                                                $jumlahProgramDepartement = $program_departement->count();
                                                                $nominalProgramDepartement = $program_departement->sum('nominal');

                                                                $dataProgramDepartementAccountUser = $program_departement->filter(function ($program) {
                                                                    return optional($program->tmpProgramProgresImportLast)->status_progres == 'USER';
                                                                });
                                                                $jumlahProgramDepartementAccountUser = $dataProgramDepartementAccountUser->count();
                                                                $nominalProgramDepartementAccountUser = $dataProgramDepartementAccountUser->sum('nominal');

                                                                $dataProgramDepartementAccountMIR = $program_departement->filter(function ($program) {
                                                                    return optional($program->tmpProgramProgresImportLast)->status_progres == 'MIR';
                                                                });
                                                                $jumlahProgramDepartementAccountMIR = $dataProgramDepartementAccountMIR->count();
                                                                $nominalProgramDepartementAccountMIR = $dataProgramDepartementAccountMIR->sum('nominal');

                                                                $dataProgramDepartementAccountSR = $program_departement->filter(function ($program) {
                                                                    return optional($program->tmpProgramProgresImportLast)->status_progres == 'SR';
                                                                });
                                                                $jumlahProgramDepartementAccountSR = $dataProgramDepartementAccountSR->count();
                                                                $nominalProgramDepartementAccountSR = $dataProgramDepartementAccountSR->sum('nominal');

                                                                $dataProgramDepartementAccountPR = $program_departement->filter(function ($program) {
                                                                    return optional($program->tmpProgramProgresImportLast)->status_progres == 'PR';
                                                                });
                                                                $jumlahProgramDepartementAccountPR = $dataProgramDepartementAccountPR->count();
                                                                $nominalProgramDepartementAccountPR = $dataProgramDepartementAccountPR->sum(function ($program) {
                                                                    return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
                                                                });

                                                                $dataProgramDepartementAccountPO = $program_departement->filter(function ($program) {
                                                                    return optional($program->tmpProgramProgresImportLast)->status_progres == 'PO';
                                                                });
                                                                $jumlahProgramDepartementAccountPO = $dataProgramDepartementAccountPO->count();
                                                                $nominalProgramDepartementAccountPO = $dataProgramDepartementAccountPO->sum(function ($program) {
                                                                    return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
                                                                });

                                                                $dataProgramDepartementAccountGR = $program_departement->filter(function ($program) {
                                                                    return optional($program->tmpProgramProgresImGRrtLast)->status_progres == 'GR';
                                                                });
                                                                $jumlahProgramDepartementAccountGR = $dataProgramDepartementAccountGR->count();
                                                                $nominalProgramDepartementAccountGR = $dataProgramDepartementAccountGR->sum(function ($program) {
                                                                    return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
                                                                });

                                                                $persentaseProgramDepartementAccountGR = 0;
                                                                if($nominalProgramDepartementAccountGR != 0)
                                                                {
                                                                    $persentaseProgramDepartementAccountGR = ($nominalProgramDepartementAccountGR / $nominalProgramDepartement) * 100;
                                                                }

                                                                $sisaJumlahProgramDepartement = $jumlahProgramDepartement - $jumlahProgramDepartementAccountGR;
                                                                $sisaNominalProgramDepartement = $nominalProgramDepartement - $nominalProgramDepartementAccountGR;
                                                                $sisaPersentaseProgramDepartement = 0;
                                                                if($sisaNominalProgramDepartement != 0)
                                                                {
                                                                    $sisaPersentaseProgramDepartement = ($sisaNominalProgramDepartement / $nominalProgramDepartement) * 100;
                                                                }

                                                            @endphp

                                                            <td class="text-center">
                                                                <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">{{ $loop->iteration }}</a>
                                                            </td>
                                                            <td class="text-start">
                                                                <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">{{ $program_departement[0]->name_program_departement_cck }}</a>
                                                            </td>
                                                            <td class="text-center">
                                                                {{ number_format($jumlahProgramDepartement,0,',','.') }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format($nominalProgramDepartement,0,',','.') }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ number_format($jumlahProgramDepartementAccountGR,0,',','.') }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format($nominalProgramDepartementAccountGR,0,',','.') }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ number_format($persentaseProgramDepartementAccountGR,2,',','.') }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ number_format($sisaJumlahProgramDepartement,0,',','.') }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format($sisaNominalProgramDepartement,0,',','.') }}
                                                            </td> 
                                                            <td class="text-center">
                                                                {{ number_format($sisaPersentaseProgramDepartement,2,',','.') }}
                                                            </td>                                                          
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    

                                </div>
                                <!--end::Item-->
                        
                                <!--begin::Item-->
                                <div class="carousel-item">
                                    <div class="mb-5" style="margin-top: -20px;">
                                        <div class="d-flex flex-stack">
                                            <div class="fw-bolder fs-4">UPDATE PROGRAM INVESTASI 2024-2025 (MULTIYEARS)
                                                <span class="fs-6 text-gray-400 ms-2"></span>
                                            </div>
                                            <!--begin::Menu-->
                                            <div>
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary"
                                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                                    <span class="svg-icon svg-icon-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                            viewBox="0 0 24 24">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="5" y="5" width="5"
                                                                    height="5" rx="1" fill="#000000"></rect>
                                                                <rect x="14" y="5" width="5"
                                                                    height="5" rx="1" fill="#000000" opacity="0.3">
                                                                </rect>
                                                                <rect x="5" y="14" width="5"
                                                                    height="5" rx="1" fill="#000000" opacity="0.3">
                                                                </rect>
                                                                <rect x="14" y="14" width="5"
                                                                    height="5" rx="1" fill="#000000" opacity="0.3">
                                                                </rect>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            </div>
                                            <!--end::Menu-->
                                        </div>
                                        <div class="h-3px w-100 bg-warning"></div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered table-sm border-primary align-middle table-row-dashed fs-8" id="tabel_progres_program_multiyear">
                                            <!--begin::Table head-->
                                            <thead class="bg-light-info">
                                                <!--begin::Table row-->
                                                <tr class="text-center text-dark fw-bolder text-uppercase gs-0">                                
                                                    <th rowspan="2" class="align-middle">NO.</th>
                                                    <th colspan="3">PROGRAM</th>
                                                    <th colspan="2">USER</th>
                                                    <th colspan="2">MIR</th>
                                                    <th colspan="2">SR</th>
                                                    <th colspan="2">PR</th>
                                                    <th colspan="2">PO</th>
                                                    <th colspan="2">REALISASI</th>
                                                </tr>
                                                <tr class="text-center text-dark fw-bolder text-uppercase gs-0">   
                                                    <th>GL ACCOUNT</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--begin::Table body-->
                                            <tbody class="text-gray-600 fw-bold">
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">1</a>
                                                    </td>
                                                    <td class="text-start">
                                                        PABRIK
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">2</a>
                                                    </td>
                                                    <td class="text-start">
                                                        A2B
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">3</a>
                                                    </td>
                                                    <td class="text-start">
                                                        PERALATAN
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">4</a>
                                                    </td>
                                                    <td class="text-start">
                                                        BANGUNAN
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">5</a>
                                                    </td>
                                                    <td class="text-start">
                                                        ASET T'BWJD
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">6</a>
                                                    </td>
                                                    <td class="text-start">
                                                        SCP
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!--end::Table body-->
                                            <tfoot class="text-gray-600 fw-bold bg-light-info">
                                                <tr>
                                                    <td class="text-center" colspan="2">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">Total</a>
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                </tr>
                                                <tr class="fs-8">
                                                    <td class="text-center" colspan="2">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">Persentase</a>
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!--end::Item-->
                        
                                <!--begin::Item-->
                                <div class="carousel-item">
                                    <div class="mb-5" style="margin-top: -20px;">
                                        <div class="d-flex flex-stack">
                                            <div class="fw-bolder fs-4">PROSES PENGADAAN INVESTASI RUTIN 2024-2025
                                                <span class="fs-6 text-gray-400 ms-2"></span>
                                            </div>
                                            <!--begin::Menu-->
                                            <div>
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary"
                                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                                    <span class="svg-icon svg-icon-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                            viewBox="0 0 24 24">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="5" y="5" width="5"
                                                                    height="5" rx="1" fill="#000000"></rect>
                                                                <rect x="14" y="5" width="5"
                                                                    height="5" rx="1" fill="#000000" opacity="0.3">
                                                                </rect>
                                                                <rect x="5" y="14" width="5"
                                                                    height="5" rx="1" fill="#000000" opacity="0.3">
                                                                </rect>
                                                                <rect x="14" y="14" width="5"
                                                                    height="5" rx="1" fill="#000000" opacity="0.3">
                                                                </rect>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            </div>
                                            <!--end::Menu-->
                                        </div>
                                        <div class="h-3px w-100 bg-warning"></div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered table-sm border-primary align-middle table-row-dashed fs-8" id="tabel_progres_program_multiyear">
                                            <!--begin::Table head-->
                                            <thead class="bg-light-info">
                                                <!--begin::Table row-->
                                                <tr class="text-center text-dark fw-bolder text-uppercase gs-0">                                
                                                    <th rowspan="2" class="align-middle">NO.</th>
                                                    <th colspan="3">PROGRAM</th>
                                                    <th colspan="2">USER</th>
                                                    <th colspan="2">MIR</th>
                                                    <th colspan="2">SR</th>
                                                    <th colspan="2">PR</th>
                                                    <th colspan="2">PO</th>
                                                    <th colspan="2">REALISASI</th>
                                                </tr>
                                                <tr class="text-center text-dark fw-bolder text-uppercase gs-0">   
                                                    <th>GL ACCOUNT</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                    <th>JML</th>
                                                    <th>NILAI</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--begin::Table body-->
                                            <tbody class="text-gray-600 fw-bold">
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">1</a>
                                                    </td>
                                                    <td class="text-start">
                                                        ANPER - PKC
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">2</a>
                                                    </td>
                                                    <td class="text-start">
                                                        SENTRALISASI PI
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                </tr>                                                
                                            </tbody>
                                            <!--end::Table body-->
                                            <tfoot class="text-gray-600 fw-bold bg-light-info">
                                                <tr>
                                                    <td class="text-center" colspan="2">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">Total</a>
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                </tr>
                                                <tr class="fs-8">
                                                    <td class="text-center" colspan="2">
                                                        <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">Persentase</a>
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                    <td class="text-center">
                                                        0
                                                    </td>
                                                    <td class="text-end">
                                                        0
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--end::Carousel-->
                        </div>
                    </div>
                </div>                
            </div>
            <!--end::Col-->

            

        </div>
    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->


@endsection

@section('page-script')
    <!-- Current Page JS Costum -->
    @if (session()->has('errors'))
    <script>
        Swal.fire({
            title: 'Error Data !',
            text: '{{ $errors->first() }}',
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    </script>
    @endif
    
    <script>
        let tanggal_cut_off = "{{ $model['tanggal_cut_off'] }}";

        let jumlahMsProgramSingleYear = {{ $jumlahMsProgramSingleYear }};
        let jumlahMsProgramMultiYear = {{ $jumlahMsProgramMultiYear }};

        let jumlahMsProgramSingleyearAccountUser = {{ $jumlahMsProgramSingleyearAccountUser }};
        let jumlahMsProgramSingleyearAccountMIR = {{ $jumlahMsProgramSingleyearAccountMIR }};
        let jumlahMsProgramSingleyearAccountSR = {{ $jumlahMsProgramSingleyearAccountSR }};
        let jumlahMsProgramSingleyearAccountPR = {{ $jumlahMsProgramSingleyearAccountPR }};
        let jumlahMsProgramSingleyearAccountPO = {{ $jumlahMsProgramSingleyearAccountPO }};
        let jumlahMsProgramSingleyearAccountGR = {{ $jumlahMsProgramSingleyearAccountGR }};

        $("#form_filter_tanggal_cutoff").flatpickr({
            defaultDate: [tanggal_cut_off]
        });

    </script>

    <script src="{{ URL::asset('js/pages/dashboard_program_realisasi.js?version=') }}{{uniqid()}}"></script>

@endsection