@extends('Admin.admin-layout')
@section('main')
<!-- Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

<div class="container dashboard">
    <div class="row">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
