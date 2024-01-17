@extends('layouts/landingLayoutMaster')

@section('title', ' - Home')

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
    <!--begin::Content-->
    <div class="container">
        <div class="mx-15 mx-lg-50 mb-15" id="card_landing_informasi">
            <div class="card shadow-sm">
    
                <div class="card-body text-center">
                    <h3 class="fs-2hx text-primary fw-bold">Tentang Aplikasi</h3>
                    <div class="separator separator-dotted separator-content border-success my-5">
                        <i class="bi bi-check-square text-success fs-2"></i>
                    </div>
                    <br>
                    <div class="fs-5 text-muted fw-bold">
                        Aset Inventori adalah sebuah sistem manajemen yang dirancang untuk membantu perusahaan atau organisasi dalam mengelola aset mereka, khususnya yang terkait dengan pembelian, stok, monitoring stok, penjualan, dan pelaporan keuangan. Aplikasi ini memberikan solusi terpadu untuk efisiensi dan transparansi dalam pengelolaan aset perusahaan. untuk meningkatkan efisiensi, mengurangi kesalahan, dan memberikan visibilitas yang baik terhadap aset perusahaan secara keseluruhan. Dengan fitur-fitur antara lain:
                    </div>
    
                    <div class="row mt-10"> 
                        <!--begin::Col-->
                        <div class="col-lg-4 mb-2">
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex align-items-center me-3 text-start">
                                    <!--begin::Logo-->
                                    <span class="indicator-label"><i class="bi bi-clipboard-check fs-2hx me-5 text-primary"></i></span>
                                    <!--end::Logo-->
                                    <!--begin::Section-->
                                    <div class="flex-grow-1" style="text-align: justify;">
                                        <!--begin::Text-->
                                        <div class="mb-5">
                                            <div class="d-flex flex-stack">
                                                <div class="fw-bolder fs-4">Pembelian
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
                                        <!--end::Text-->
                                        <!--begin::Description-->
                                        <span class="text-gray-400 fw-semibold d-block fs-6"> Aplikasi ini memungkinkan pengguna untuk mencatat setiap transaksi pembelian aset atau barang. Menyimpan data lengkap mengenai pemasok</span>
                                        <!--end::Description=-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <div class="separator separator-dashed my-3"></div>
                        </div>
                        <!--end::Col-->
    
                        <!--begin::Col-->
                        <div class="col-lg-4 mb-2">
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex align-items-center me-3 text-start">
                                    <!--begin::Logo-->
                                    <span class="indicator-label"><i class="bi bi-calculator fs-2hx me-5 text-primary"></i></span>
                                    <!--end::Logo-->
                                    <!--begin::Section-->
                                    <div class="flex-grow-1" style="text-align: justify;">
                                        <!--begin::Text-->
                                        <div class="mb-5">
                                            <div class="d-flex flex-stack">
                                                <div class="fw-bolder fs-4">Monitoring Stok
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
                                        <!--end::Text-->
                                        <!--begin::Description-->
                                        <span class="text-gray-400 fw-semibold d-block fs-6"> Merekam setiap pergerakan stok, baik itu penerimaan dari pembelian atau pengeluaran karena penjualan Monitoring Stok Real-time memudahkan pencarian dan analisis.</span>
                                        <!--end::Description=-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <div class="separator separator-dashed my-3"></div>
                        </div>
                        <!--end::Col-->
    
                        <!--begin::Col-->
                        <div class="col-lg-4 mb-2">
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex align-items-center me-3 text-start">
                                    <!--begin::Logo-->
                                    <span class="indicator-label"><i class="bi bi-qr-code-scan fs-2hx me-5 text-primary"></i></span>
                                    <!--end::Logo-->
                                    <!--begin::Section-->
                                    <div class="flex-grow-1" style="text-align: justify;">
                                        <!--begin::Text-->
                                        <div class="mb-5">
                                            <div class="d-flex flex-stack">
                                                <div class="fw-bolder fs-4">Penjualan
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
                                        <!--end::Text-->
                                        <!--begin::Description-->
                                        <span class="text-gray-400 fw-semibold d-block fs-6"> Mencatat setiap transaksi penjualan yang melibatkan aset atau barang Melacak informasi pelanggan, riwayat transaksi, dan preferensi.</span>
                                        <!--end::Description=-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <div class="separator separator-dashed my-3"></div>
                        </div>
                        <!--end::Col-->
    
                        <!--begin::Col-->
                        <div class="col-lg-4 mb-2">
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex align-items-center me-3 text-start">
                                    <!--begin::Logo-->
                                    <span class="indicator-label"><i class="bi bi-bar-chart-fill fs-2hx me-5 text-primary"></i></span>
                                    <!--end::Logo-->
                                    <!--begin::Section-->
                                    <div class="flex-grow-1" style="text-align: justify;">
                                        <!--begin::Text-->
                                        <div class="mb-5">
                                            <div class="d-flex flex-stack">
                                                <div class="fw-bolder fs-4">Laporan Keuangan
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
                                        <!--end::Text-->
                                        <!--begin::Description-->
                                        <span class="text-gray-400 fw-semibold d-block fs-6"> Menyajikan laporan keuangan yang merinci pendapatan, biaya, laba bersih, dan lainnya. Membantu pengguna dalam menganalisis profitabilitas.</span>
                                        <!--end::Description=-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <div class="separator separator-dashed my-3"></div>
                        </div>
                        <!--end::Col-->
    
                        <!--begin::Col-->
                        <div class="col-lg-4 mb-2">
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex align-items-center me-3 text-start">
                                    <!--begin::Logo-->
                                    <span class="indicator-label"><i class="bi bi-shield-lock fs-2hx me-5 text-primary"></i></span>
                                    <!--end::Logo-->
                                    <!--begin::Section-->
                                    <div class="flex-grow-1" style="text-align: justify;">
                                        <!--begin::Text-->
                                        <div class="mb-5">
                                            <div class="d-flex flex-stack">
                                                <div class="fw-bolder fs-4">Keamanan dan Hak Akses
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
                                        <!--end::Text-->
                                        <!--begin::Description-->
                                        <span class="text-gray-400 fw-semibold d-block fs-6"> Memastikan bahwa setiap pengguna memiliki tingkat akses yang sesuai dengan tanggung jawabnya. Menjaga keamanan data dengan menerapkan enkripsi</span>
                                        <!--end::Description=-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <div class="separator separator-dashed my-3"></div>
                        </div>
                        <!--end::Col-->
    
                        <!--begin::Col-->
                        <div class="col-lg-4 mb-2">
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex align-items-center me-3 text-start">
                                    <!--begin::Logo-->
                                    <span class="indicator-label"><i class="bi bi-back fs-2hx me-5 text-primary"></i></span>
                                    <!--end::Logo-->
                                    <!--begin::Section-->
                                    <div class="flex-grow-1" style="text-align: justify;">
                                        <!--begin::Text-->
                                        <div class="mb-5">
                                            <div class="d-flex flex-stack">
                                                <div class="fw-bolder fs-4">Antarmuka Pengguna yang Ramah
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
                                        <!--end::Text-->
                                        <!--begin::Description-->
                                        <span class="text-gray-400 fw-semibold d-block fs-6">Menyediakan antarmuka yang mudah digunakan agar pengguna dapat dengan cepat mengakses informasi dan menjalankan fungsi yang diperlukan.</span>
                                        <!--end::Description=-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <div class="separator separator-dashed my-3"></div>
                        </div>
                        <!--end::Col-->
    
                    </div>
    
                </div>
    
            </div>
        </div>
    </div>    
    <!--end::Content-->
@endsection

@section('page-script')
    <!-- Current Page JS Costum -->

@endsection
