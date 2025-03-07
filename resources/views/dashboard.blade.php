@extends('layouts.app')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item filter-option" href="#"
                                                data-filter="today">Today</a></li>
                                        <li><a class="dropdown-item filter-option" href="#" data-filter="month">This
                                                Month</a></li>
                                        <li><a class="dropdown-item filter-option" href="#" data-filter="year">This
                                                Year</a></li>
                                    </ul>

                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Sales <span class="filter-label">| Today</span>
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="orders-count">{{ number_format($orders, 0, ',', '.') }}</h6>
                                            <span class="order-change text-success small pt-1 fw-bold">0%</span>
                                            <span class="text-muted small pt-2 ps-1"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item filter-option" href="#"
                                                data-filter="today">Today</a></li>
                                        <li><a class="dropdown-item filter-option" href="#" data-filter="month">This
                                                Month</a></li>
                                        <li><a class="dropdown-item filter-option" href="#" data-filter="year">This
                                                Year</a></li>
                                    </ul>

                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Revenue <span class="filter-label">| This Month</span>
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <span class="fw-bold d-flex">Rp</span>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="revenue-count">IDR {{ number_format($total, 0, ',', '.') }}</h6>
                                            <span class="revenue-change text-success small pt-1 fw-bold">0%</span>
                                            <span class="text-muted small pt-2 ps-1"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-xl-12">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Customers
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ number_format($customers, 0, ',', '.') }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.filter-option').forEach(item => {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    let filter = this.getAttribute('data-filter');

                    fetch(`/dashboard/filter?filter=${filter}`, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Update jumlah order dan total revenue
                            document.querySelector('.orders-count').innerText = data.orders;
                            document.querySelector('.revenue-count').innerText =
                                `IDR ${data.total}`;

                            // Update persentase perubahan
                            let orderChangeEl = document.querySelector('.order-change');
                            let revenueChangeEl = document.querySelector('.revenue-change');

                            orderChangeEl.innerText = `${data.orderChange}%`;
                            revenueChangeEl.innerText = `${data.totalChange}%`;

                            // Ubah warna (hijau naik, merah turun)
                            orderChangeEl.classList.remove('text-success', 'text-danger');
                            revenueChangeEl.classList.remove('text-success', 'text-danger');

                            if (parseFloat(data.orderChange) >= 0) {
                                orderChangeEl.classList.add('text-success');
                            } else {
                                orderChangeEl.classList.add('text-danger');
                            }

                            if (parseFloat(data.totalChange) >= 0) {
                                revenueChangeEl.classList.add('text-success');
                            } else {
                                revenueChangeEl.classList.add('text-danger');
                            }

                            // Update label filter (Today, This Month, This Year)
                            document.querySelector('.filter-label').innerText = data
                                .filterLabel;
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endsection
