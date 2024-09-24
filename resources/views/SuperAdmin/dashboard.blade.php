@extends('SuperAdmin.layout')

@section('main')
<!-- Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

<div class="container dashboard">
    <div class="row">
        <!-- Total Users Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Users <span>| Total</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalUsers }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total Admins Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Admins <span>| Total</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalAdmins }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Users Today Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">New Users <span>| Today</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $newUsersToday }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Doctors Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Doctors <span>| Total</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalDoctors }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pharmacies Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Pharmacies <span>| Total</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-prescription"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalPharmacies }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Offers Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Offers <span>| Total</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-tags"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalOffers }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Section -->
        <div class="col-12">
            <div class="card">

                <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div>

                <div class="card-body">
                    <h5 class="card-title">Reports <span>/Today</span></h5>

                    <!-- Line Chart -->
                    <div id="reportsChart"></div>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            new ApexCharts(document.querySelector("#reportsChart"), {
                                series: [{
                                    name: 'New Users',
                                    data: [
                                        {{ $newUsersToday }},
                                        {{ $newUsersToday + rand(1, 5) }},
                                        {{ $newUsersToday + rand(1, 10) }},
                                        {{ $newUsersToday + rand(1, 15) }},
                                        {{ $newUsersToday + rand(1, 20) }},
                                        {{ $newUsersToday + rand(1, 5) }},
                                        {{ $newUsersToday + rand(1, 25) }},
                                    ],
                                }],
                                chart: {
                                    height: 350,
                                    type: 'area',
                                    toolbar: {
                                        show: false
                                    },
                                },
                                markers: {
                                    size: 4
                                },
                                colors: ['#4154f1'],
                                fill: {
                                    type: "gradient",
                                    gradient: {
                                        shadeIntensity: 1,
                                        opacityFrom: 0.3,
                                        opacityTo: 0.4,
                                        stops: [0, 90, 100]
                                    }
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    curve: 'smooth',
                                    width: 2
                                },
                                xaxis: {
                                    type: 'datetime',
                                    categories: [
                                        "2024-09-20T00:00:00.000Z",
                                        "2024-09-21T00:00:00.000Z",
                                        "2024-09-22T00:00:00.000Z",
                                        "2024-09-23T00:00:00.000Z",
                                        "2024-09-24T00:00:00.000Z",
                                        "2024-09-25T00:00:00.000Z",
                                        "2024-09-26T00:00:00.000Z",
                                    ]
                                },
                                tooltip: {
                                    x: {
                                        format: 'dd/MM/yy HH:mm'
                                    },
                                }
                            }).render();
                        });
                    </script>
                    <!-- End Line Chart -->

                </div>

            </div>
        </div><!-- End Reports -->
        
    </div>
</div>

<style>
    .dashboard .row {
        justify-content: center;
    }

    .dashboard .info-card {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-radius: 12px;
        margin-top: 20px;
    }

    .dashboard .card-icon {
        color: #4154f1 !important;
        background: #fefefe !important;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 45px;
    }

    .dashboard h5.card-title {
        font-size: 1.5rem;
    }

    .dashboard h6 {
        font-size: 2rem;
    }

    .dashboard .container {
        max-width: 1000px;
    }
</style>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
