@extends('layouts/landingLayoutMaster')

@section('title', 'Beranda')

@section('page-style')
    <!-- Current Page CSS Costum -->
    <style>
        #card_landing_informasi {
            margin-top: -150px;
        }

        .position-relative {
            position: relative;
        }

        .watermark {
            position: absolute;
            top: 250px;
            /* left: 50px; */
            /* transform: translate(-50%, -50%); */
            opacity: 0.2;
            font-size: 32px;
            /* -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg); */
            /* Additional styles as desired */
        }

        @media only screen and (max-width: 450px) {
            #card_landing_informasi {
                margin-top: -70px;
            }
        }
    </style>

@endsection

@section('content')
    <!--begin::Content-->
    <div class="mb-n10 mb-lg-n20 z-index-2 h-100">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Heading-->
            <div class="text-center mb-5">
                <!--begin::Title-->
                <h3 class="fs-2hx text-muted" id="how-it-works" data-kt-scroll-offset="{default: 100, lg: 150}">Data Tracking</h3>
                <!--end::Title-->
                <h1 class="text-warning lh-base fw-bold fs-1x fs-lg-2x">
                    SISTEM RETRIBUSI LABKES KARAWANG 
                </h1>
                <h1 class="text-warning lh-base fw-bold fs-1x fs-lg-2x">
                    Pemerintah Kabupaten Karawang 
                </h1>
                <!--end::Text-->
            </div>
            <!--end::Heading-->
            <!--begin::Row-->
            <div class="row w-100 gy-10 mb-md-20 mb-sm-20 mb-20">
                <!--begin::Col-->

                <div class="col-lg-12 py-2 mt-5">
                    <div class="separator separator-dotted separator-content border-success my-5">
                        <i class="bi bi-check-square text-success fs-2"></i>
                    </div>
                </div>

                @if ($model['mslink'])
                    @if ($model['mslink']->type == "dokument-skr")
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('images/karawang-bsre.png') }}" style="max-height: 100px;" class="img-fluid" alt="Responsive image">
                        </div>

                        <div class="col-md-12 text-center">
                            <div class="position-relative w-100 text-center">
                                <p class="watermark w-100"><strong> SISTEM RETRIBUSI LABKES KARAWANG <br> - SKR / {{ $model['tr_permohonan']->tahun }} / {{ $model['tr_permohonan']->nomor }} -</strong></p>
                            </div>
                        </div> 

                        <div class="col-md-12">
                            <div class="form-group mt-4 mb-5">
                                
                                <label for="nomor-dokument" class="card-label mb-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-dark">Nomor Dokument :</span>
                                    </h3>
                                </label>
                                <input readonly="" value="{{ $model['tr_permohonan']->no_order_lab }}" class="form-control form-control-solid fw-bold text-dark">
                            </div>
                        </div>

                        @if ($model['tr_permohonan']->status_id <= 8)
                            <div class="d-flex flex-stack flex-wrap flex-md-nowrap card-rounded shadow p-10 p-lg-15" style="background: linear-gradient(90deg, #20AA3E 0%, #03A588 100%);">
                                <!--begin::Content-->
                                <div class="my-2 me-5">
                                    <!--begin::Title-->
                                    <div class="fs-1 fs-lg-2qx fw-bold text-white mb-2">Data Tracking Transaksi,
                                    <span class="fw-normal">Belum Dilakukan Pengesahan Dokument.</span></div>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="fs-6 fs-lg-5 text-white fw-semibold opacity-75">Dokument Surat Keterangan Retribusi Dalam Proses Penandatanganan, Terimakasih.</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Content-->
                            </div>
                        @endif

                        @if ($model['tr_permohonan']->status_id > 8)
                            <div class="col-md-12">
                                <div class="form-group">                                    
                                    <label for="nomor-dokument" class="card-label">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold text-dark">Dokumen ini telah ditandatangani secara elektronik oleh :</span>
                                        </h3>
                                    </label>
                                </div>
                            </div>
                            
                            @foreach ( $model['getTrPermohonanDokumentPenandatangan'] as $trpenandatangan)
                            <div class="col-md-12">
                                <div class="shadow-sm rounded border-gray-300 border-dotted w-100 p-5">
                                    <div class="separator separator-content border-dark mt-5 mb-10"><span class="w-250px fw-bold">Penandatanganan {{ $loop->iteration }}</span></div>
                                    <h5>Nama : {{$trpenandatangan->nama_lengkap}}</h5>
                                    <h5>Jabatan : {{$trpenandatangan->Penandatangan->jabatan}}</h5>
                                    <br>
                                    <h5>Waktu TTE : 
                                        @if ($trpenandatangan->waktu_tte != null)
                                            <span class="badge badge-primary badge-lg">{{$trpenandatangan->waktu_tte}}</span>
                                        @else
                                            <span class="badge badge-secondary badge-lg">Belum Tersedia</span>
                                        @endif                                        
                                    </h5>
                                </div>
                            </div>
                            @endforeach
                            
                            @php
                                $dokument_skr = $model['getTrPermohonanDokument']->where('jenis', 'Dokument SKR')->where('type', 'signature-kepala')->first();
                                $url_dokumentskr = url('/storage/dokument-permohonan')."/".$dokument_skr->name;
                            @endphp

                            <iframe frameborder="0" src="{{ url('/pdf-viewer?file=').$url_dokumentskr }}" width="100%" style="height:600px;"></iframe>

                        @endif

                    @endif

                    @if ($model['mslink']->type == "bukti-bayar")
                        <div class="col-md-12 text-center">
                            <div class="position-relative w-100 text-center">
                                <p class="watermark w-100"><strong> SISTEM RETRIBUSI LABKES KARAWANG <br> - SKR / {{ $model['tr_permohonan']->tahun }} / {{ $model['tr_permohonan']->nomor }} -</strong></p>
                            </div>
                        </div> 
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6 mb-5">
                                    <div class="d-flex justify-content-start">
                                        @if ($model['tr_pemabayaran']->status == 0)
                                            <button type="button" class="btn btn-danger py-4">
                                                <span class="indicator-label fs-2"><i class="bi bi-exclamation-octagon fs-2 me-2"></i> MENUNGGU PEMBAYARAN</span>
                                            </button>
                                        @endif
                                        @if ($model['tr_pemabayaran']->status == 1)
                                            <button type="button" class="btn btn-primary py-4">
                                                <span class="indicator-label fs-2"><i class="bi bi-patch-check fs-2 me-2"></i> SUDAH MELAKUKAN PEMBAYARAN</span>
                                            </button>
                                        @endif
                                        @if ($model['tr_pemabayaran']->status == 2)
                                            <button type="button" class="btn btn-danger py-4">
                                                <span class="indicator-label fs-2"><i class="bi bi-exclamation-octagon fs-2 me-2"></i> KODE QRIS SUDAH EXPIRED</span>
                                            </button>
                                        @endif
                                    </div>                                    
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="d-flex justify-content-center">
                                        <div class="fw-semibold">
                                            {{-- @php
                                                dd($model['MsMenu']);
                                            @endphp --}}
                                            <h4 class="text-gray-900 fw-bold">Kode Transaksi Pembayaran :</h4>
                                            <h1 class="text-gray-900 fw-bold">{{$model['tr_pemabayaran']->kode_transaksi}}</h1>                        
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-12 mb-5">
                            <div class="row mb-2" data-kt-buttons="true">                    
                               <!--begin::Input group-->
                               <div class="col-lg-3 py-2">
                                   <h5 class="text-dark fw-bold">No. Order Lab</h5>
                               </div>
                    
                               <div class="col-lg-9 py-2">
                                   <h5>: {{ $model['tr_permohonan']->no_order_lab }}</h5>
                               </div>
                               <!--end::Input group-->
                    
                               <!--begin::Input group-->
                               <div class="col-lg-3 py-2">
                                   <h5 class="text-dark fw-bold">Nama Customer</h5>
                               </div>
                    
                               <div class="col-lg-9 py-2">
                                   <h5 class="text-gray-500">: {{ $model['tr_permohonan']->nama_customer }}</h5>
                               </div>
                               <!--end::Input group-->
                    
                               <!--begin::Input group-->
                               <div class="col-lg-3 py-2">
                                   <h5 class="text-dark fw-bold">Alamat Customer</h5>
                               </div>
                    
                               <div class="col-lg-9 py-2">
                                   <h5 class="text-gray-500">: {{ $model['tr_permohonan']->alamat_customer }}</h5>
                               </div>
                               <!--end::Input group-->
                    
                               @php
                                   $tanggalPembuatan = CarbonBlade::parse($model['tr_pemabayaran']->created_at)->locale('id');
                                   $tanggalPembuatan->settings(['formatFunction' => 'translatedFormat']);
                               @endphp
                               <!--begin::Input group-->
                               <div class="col-lg-3 py-2">
                                   <h5 class="text-dark fw-bold">Tanggal Dibuat</h5>
                               </div>
                    
                               <div class="col-lg-9 py-2">
                                   <h5 class="text-gray-500">: {{ $tanggalPembuatan->format('l') }}, {{ $tanggalPembuatan->format('j F Y') }} - {{ $tanggalPembuatan->format('h:i') }}</h5>
                               </div>
                               <!--end::Input group-->
                    
                               <!--begin::Input group-->
                               <div class="col-lg-3 py-2">
                                   <h5 class="text-dark fw-bold">Total Layanan</h5>
                               </div>
                    
                               <div class="col-lg-9 py-2">
                                   <h5 class="text-gray-500">: {{ count($model['trpermohonandetail']) }} Layanan</h5>
                               </div>
                               <!--end::Input group-->
                    
                               <!--begin::Input group-->
                               <div class="col-lg-12 py-2">
                                   <div class="table-responsive">
                                       <table class="table table-bordered table-striped table-hover align-middle table-row-dashed fs-6">
                                           <thead>
                                               <tr class="fw-bold fs-6 text-gray-800">
                                                   <th>No.</th>
                                                   <th>Jenis Layanan</th>
                                                   <th>Kategori Layanan</th>
                                                   <th>Jumlah</th>
                                               </tr>
                                           </thead>
                                           <tbody id="tableListLayanan">
                                               @php
                                                  $total_harga = 0; 
                                               @endphp
                               
                                               @foreach ($model['trpermohonandetail'] as $trpermohonandetail)
                                               <tr>
                                                   <td>{{$loop->iteration}}. </td>
                                                   <td>{{$trpermohonandetail->msLayanan->name}}</td>
                                                   <td>{{$trpermohonandetail->msKategori->name}}</td>
                                                   <td>{{$trpermohonandetail->jumlah}}</td>
                                               </tr>
                                               @endforeach
                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                               <!--end::Input group-->
                    
                               <!--begin::Input group-->
                               <div class="col-lg-12 py-2 mt-5">
                                   <div class="separator separator-dotted separator-content border-success my-5">
                                       <i class="bi bi-check-square text-success fs-2"></i>
                                   </div>
                               </div>
                               <!--end::Input group-->
                           </div>
                        </div>

                        {{-- <div class="col-md-4 mb-5">                    
                            @if ($model['tr_pemabayaran']->status == 1)                                
                                @if ($model['trpermohonandokument'] != null)
                                <img src="{{ url('storage/bukti-bayar/'.$model['trpermohonandokument']->name) }}" class="img-fluid" alt="qris-pembayaran"> 
                                @endif
                            @endif
                        </div> --}}

                    @endif
                @endif

                @if ($model['mslink'] == null)
                <div class="d-flex flex-stack flex-wrap flex-md-nowrap card-rounded shadow p-10 p-lg-15" style="background: linear-gradient(90deg, #20AA3E 0%, #03A588 100%);">
                    <!--begin::Content-->
                    <div class="my-2 me-5">
                        <!--begin::Title-->
                        <div class="fs-1 fs-lg-2qx fw-bold text-white mb-2">Data Tracking Transaksi,
                        <span class="fw-normal">Tidak Ditemukan !!</span></div>
                        <!--end::Title-->
                        <!--begin::Description-->
                        <div class="fs-6 fs-lg-5 text-white fw-semibold opacity-75">Pastikan Anda Sudah Menscan QRCode Dengan Benar, Terimakasih.</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Content-->
                </div>
                @endif

            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->
@endsection

@section('page-script')
    <!-- Current Page JS Costum -->

@endsection
