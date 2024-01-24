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
                    <h3 class="fs-2hx text-primary fw-bold">ABOUT APPLICATION</h3>
                    <div class="separator separator-dotted separator-content border-success my-5">
                        <i class="bi bi-check-square text-success fs-2"></i>
                    </div>
                    <br>
                    <div class="fs-5 text-muted fw-bold">
                        Project Control Information System (PCIS) is a software application designed to facilitate the efficient management and control of projects. It serves as a centralized platform for planning, monitoring, and executing project activities. The system helps project managers, team members, and stakeholders collaborate, track progress, and make informed decisions throughout the project lifecycle.
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
                                                <div class="fw-bolder fs-4">Task and Resource Management
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
                                        <span class="text-gray-400 fw-semibold d-block fs-6"> This aspect of project management involves planning, assigning, tracking, and optimizing tasks and resources to achieve project objectives</span>
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
                                    <span class="indicator-label"><i class="bi bi-boxes fs-2hx me-5 text-primary"></i></span>
                                    <!--end::Logo-->
                                    <!--begin::Section-->
                                    <div class="flex-grow-1" style="text-align: justify;">
                                        <!--begin::Text-->
                                        <div class="mb-5">
                                            <div class="d-flex flex-stack">
                                                <div class="fw-bolder fs-4">Progress Tracking
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
                                        <span class="text-gray-400 fw-semibold d-block fs-6"> Progress Tracking is a vital aspect of project management that involves monitoring and assessing the advancement of tasks and milestones within a project.</span>
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
                                    <span class="indicator-label"><i class="bi bi-bar-chart fs-2hx me-5 text-primary"></i></span>
                                    <!--end::Logo-->
                                    <!--begin::Section-->
                                    <div class="flex-grow-1" style="text-align: justify;">
                                        <!--begin::Text-->
                                        <div class="mb-5">
                                            <div class="d-flex flex-stack">
                                                <div class="fw-bolder fs-4">Reporting and Analytics
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
                                        <span class="text-gray-400 fw-semibold d-block fs-6"> involves regularly updating and monitoring the status of individual tasks. status of their assigned tasks, providing real-time insights into project progression.</span>
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
                                                <div class="fw-bolder fs-4">Security and Access Control
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
                                        <span class="text-gray-400 fw-semibold d-block fs-6"> ensuring that only authorized users have access to specific resources and that sensitive information is protected. Security and Access Control</span>
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
                                    <span class="indicator-label"><i class="bi bi-grid-1x2 fs-2hx me-5 text-primary"></i></span>
                                    <!--end::Logo-->
                                    <!--begin::Section-->
                                    <div class="flex-grow-1" style="text-align: justify;">
                                        <!--begin::Text-->
                                        <div class="mb-5">
                                            <div class="d-flex flex-stack">
                                                <div class="fw-bolder fs-4">Mobile Accessibility
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
                                        <span class="text-gray-400 fw-semibold d-block fs-6"> Design and implementation of digital products, services, or applications to ensure that they are usable and inclusive for accessed through mobile devices</span>
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
                                                <div class="fw-bolder fs-4">Scalability
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
                                        <span class="text-gray-400 fw-semibold d-block fs-6">Scale to accommodate projects of varying sizes and complexities. System streamlines project management processes, enhances communication, and contributes</span>
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
