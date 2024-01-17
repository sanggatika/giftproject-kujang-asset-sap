@extends('layouts/landingLayoutMaster')

@section('title', 'Beranda')

@section('page-style')
    <!-- Current Page CSS Costum -->
    <style>
        #card_landing_informasi {
            margin-top: -150px;
        }

        @media only screen and (max-width: 450px) {
            #card_landing_informasi {
                margin-top: -70px;
            }
        }
    </style>

@endsection

@section('content')

@php
    use Carbon\Carbon;
@endphp

<!--begin::Content-->
<div class="container">

    @if ($model['trpurchases'])

    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-10 mt-5">
                    <div class="separator separator-dotted separator-content border-success my-2">
                        <img src="{{ asset('images/logo_giftproject_landscape.png') }}" style="max-height: 75px;" class="img-fluid" alt="logo-pssi">
                    </div>
                </div>                    

                <div class="col-md-12 mt-5 text-center">
                    <h1 class="fw-bold"> Data Tracking Transaksi Purchases </h1>
                </div> 

                <div class="col-md-6 mt-5">
                    <div class="row">
                        <!--begin::Input group-->
                        <div class="col-md-4 mb-3">
                            <span class="form-label fw-bold text-dark"><i class="bi bi-buildings fs-2 me-3 text-primary"></i> Data Supplier</span>
                        </div>
                        <div class="col-md-8 mb-3">
                            <span class="form-label fw-bold text-dark fs-5" id="card_supplier_email">: {{ $model['trpurchases']->mSupplier->nama }}</span>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="col-md-4 mb-3">
                            <span class="form-label fw-bold text-dark"><i class="bi bi-envelope-at fs-2 me-3 text-primary"></i> Email Supplier</span>
                        </div>
                        <div class="col-md-8 mb-3">
                            <span class="form-label fw-bold text-dark" id="card_supplier_email">: {{ $model['trpurchases']->mSupplier->email }}</span>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="col-md-4 mb-3">
                            <span class="form-label fw-bold text-dark"><i class="bi bi-whatsapp fs-2 me-3 text-primary"></i> Hp Supplier</span>
                        </div>
                        <div class="col-md-8 mb-3">
                            <span class="form-label fw-bold text-dark" id="card_supplier_hp">: {{ $model['trpurchases']->mSupplier->handphone }}</span>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="col-md-4 mb-3">
                            <span class="form-label fw-bold text-dark"><i class="bi bi-pin-map-fill fs-2 me-3 text-primary"></i> Alamat Supplier</span>
                        </div>
                        <div class="col-md-8 mb-3">
                            <span class="form-label fw-bold text-dark" id="card_supplier_alamat">: {{ $model['trpurchases']->mSupplier->alamat }} - {{ $model['trpurchases']->mSupplier->alamat_kabupaten_nama }}</span>
                        </div>
                        <!--end::Input group-->
                    </div>
                </div>

                <div class="col-md-6 mt-5">
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-lg-12 mb-2">
                             <!--begin::Label-->
                            <label class="form-label fw-bold">Nomor Pembelian :</label>
                            <!--end::Label-->
    
                            <!--begin::Input group-->
                            <div class="input-group">
                                <span class="form-label fw-bold text-dark fs-2"> {{ $model['trpurchases']->invoice_nomor }}</span>
                            </div>
                            <!--end::Input group--> 
                        </div>
                        <!--end::Col-->                           
                        
                        <!--begin::Col-->
                        <div class="col-lg-12">
                            <!--begin::Label-->
                            <label class="form-label fw-bold">Tanggal Pembelian :</label>
                            <!--end::Label-->
                            <div class="input-group">
                                <span class="form-label fw-bold text-dark fs-2"> {{ Carbon::parse($model['trpurchases']->invoice_tanggal)->locale('id')->isoFormat('D MMMM Y') }}</span>
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                </div>                   

            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-body">

            <!--begin::Table-->
            <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-5" id="tabel_masterdata_satuan">
                <!--begin::Table head-->
                <thead class="bg-light-warning text-center">
                    <!--begin::Table row-->
                    <tr class="text-info fw-bolder fs-7 text-uppercase gs-0">                                
                        <th>No.</th>
                        <th>Produk</th>
                        <th>Jenis</th>
                        <th>Kondisi</th>
                        <th>Harga Per Unit</th>
                        <th>QTY</th>
                        <th>Diskon</th>
                        <th>Sub-Total</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->

                <!--begin::Table body-->
                <tbody class="text-gray-600 fw-bold" id="tableListPurchasesProduk">
                    @php
                        $purchases_sub_total = 0;
                        $purchases_pajak = 0;
                        $purchases_diskon = 0;
                        $purchases_shipping = 0;
                        $purchases_grandtotal = 0;
                    @endphp

                    @foreach ($model['trpurchases']->trPurchasesDetail as $barang)
                    <tr>
                        <td class="text-center">
                            <div class="position-relative py-2">
                                <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>
                                <a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">{{ $loop->iteration }}</a>
                            </div>
                        </td>
                        <td class="text-start">
                            <div class="d-flex justify-content-start flex-column">
                                <span class="form-label fw-bold text-dark fs-5"> {{ $barang->barang_nama }}</span>
                                <small>{{ $barang->barang_kode }}</small>
                                <hr>
                            </div>
                        </td>
                        <td class="text-start">
                            <span class="form-label fw-bold text-dark"> {{ $barang->jenis_barang_nama }}</span>
                        </td>
                        <td class="text-start">
                            <span class="form-label fw-bold text-dark"> {{ $barang->kondisi }}</span>
                        </td>
                        <td class="text-end">
                            <span class="form-label fw-bold text-dark"> {{ number_format($barang->harga,0,',','.') }}</span>
                        </td>
                        <td class="text-center">
                            <span class="form-label fw-bold text-dark"> {{ number_format($barang->qty,0,',','.') }}</span>
                        </td>
                        <td class="text-center">
                            <span class="form-label fw-bold text-dark"> {{ number_format($barang->discount,0,',','.') }}</span>
                        </td>
                        <td class="text-center">
                            <span class="form-label fw-bold text-dark"> {{ number_format($barang->total,0,',','.') }}</span>
                        </td>
                    </tr>

                    @php
                        $purchases_sub_total = (int)$purchases_sub_total + (int)$barang->total;
                    @endphp
                    @endforeach

                    @php
                        $purchases_pajak = ($model['trpurchases']->tax / 100) * ($purchases_sub_total);
                        $purchases_diskon = ($model['trpurchases']->discount / 100) * ($purchases_sub_total);
                        $purchases_shipping = $model['trpurchases']->shipping;

                        // Perhitungan Grand Total
                        $purchases_grandtotal = $purchases_sub_total + $purchases_pajak;
                        $purchases_grandtotal = $purchases_grandtotal - $purchases_diskon;
                        $purchases_grandtotal = $purchases_grandtotal + $purchases_shipping;
                    @endphp 
                </tbody>
                <!--end::Table body-->
                
            </table>
            <!--end::Table-->

            <div class="separator border-4 my-10"></div>

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Label-->
                   <label class="form-label fw-bold">Catatan / Keterangan :</label>
                   <!--end::Label-->

                   <!--begin::Input group-->
                   <div class="form-floating">
                        <textarea class="form-control" placeholder="Catatan / Keterangan" name="form_purchases_catatan" id="form_purchases_catatan" style="height: 100px">{{ $model['trpurchases']->catatan }}</textarea>
                        <label for="floatingTextarea2">Catatan / Keterangan</label>
                    </div>
                   <!--end::Input group-->
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Sub-Total  </label>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">: Rp. </label>
                        </div>
                        <div class="col-md-6 text-end mb-5">
                            <label class="form-label fw-bold me-3" id="card_purchases_subtotal">{{ number_format($purchases_sub_total,0,',','.') }}</label>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Pajak </label>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">: Rp. </label>
                        </div>
                        <div class="col-md-6 text-end">
                            <label class="form-label fw-bold me-3" id="card_purchases_pajak">{{ number_format($purchases_pajak,0,',','.') }}</label>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Diskon </label>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">: Rp. </label>
                        </div>
                        <div class="col-md-6 text-end">
                            <label class="form-label fw-bold me-3" id="card_purchases_diskon">{{ number_format($purchases_diskon,0,',','.') }}</label>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Shipping </label>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">: Rp. </label>
                        </div>
                        <div class="col-md-6 text-end">
                            <label class="form-label fw-bold me-3" id="card_purchases_shipping">{{ number_format($purchases_shipping,0,',','.') }}</label>
                        </div>

                        <div class="col-md-12">
                            <div class="separator border-3 my-5"></div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Grand Total </label>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">: Rp. </label>
                        </div>
                        <div class="col-md-6 text-end">
                            <label class="form-label fw-bold me-3" id="card_purchases_grandtotal">{{ number_format($purchases_grandtotal,0,',','.') }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="separator border-4 my-5"></div>                

        </div>
    </div>

    @else

    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-10 mt-5">
                    <div class="separator separator-dotted separator-content border-success my-2">
                        <img src="{{ asset('images/logo_giftproject_landscape.png') }}" style="max-height: 75px;" class="img-fluid" alt="logo-pssi">
                    </div>
                </div>                    

                <div class="col-md-12 mt-5 text-center">
                    <h1 class="fw-bold"> -- Tidak Ada Data Transaksi Penjualan -- </h1>
                </div>                   

            </div>
        </div>
    </div>

    @endif

    
</div>    
<!--end::Content-->
@endsection

@section('page-script')
    <!-- Current Page JS Costum -->

@endsection
