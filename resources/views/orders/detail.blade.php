<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        p,
        span,
        td {
            font-size: 14px;
        }

        .card-body {
            padding: 1rem;
        }

        h5 {
            font-size: 18px;
        }

        h4 {
            font-size: 18px;
            margin-bottom: 0;
        }

        .order-item-table th,
        .order-item-table td {
            text-align: center;
            vertical-align: middle;
        }

        .order-item-img {
            max-width: 50px;
            max-height: 50px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table-responsive .table {
            margin-bottom: 0;
        }

        .table-no-vertical-border td,
        .table-no-vertical-border th {
            border-right: none !important;
        }

        .table-no-vertical-border {
            border-collapse: collapse;
        }

        .card-title-sm {
            font-size: 16px;
            font-weight: bold;
        }

        .discount-note {
            font-size: 0.8rem;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="m-2">
        <div class="row">
            <div class="col">
                <div class="row mb-2">
                    <div class="col-md-4 col-sm-12">
                        <div class="card mb-2">
                            <div class="card-body row">
                                <div class="col-md-10 col-sm-9">

                                    <!-- Logo brand -->
                                    <div class="logo-brand my-2">
                                        <img src="{{ asset('assets/img/logo.svg') }}" alt="" width="100">
                                    </div>

                                    <h5 class="card-title fw-bold fs-6">Order: {{ $item->invoice }}</h5>
                                    <span class="d-block">Status: {{ Str::ucfirst($item->status) }}</span>
                                    <span class="d-block">Date:
                                        @php
                                            use Carbon\Carbon;
                                        @endphp
                                        {{ Carbon::parse($item->created_at)->format('d F Y') }}</span>
                                </div>

                                <div class="col-md-2 col-sm-3">
                                    <div class="">
                                        <button class="btn btn-primary btn-sm" onclick="window.print()">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="card-body">
                                    <h5 class="fw-bold">From</h5>
                                    <span class="d-block">CELCIUS IDN</span>
                                    <span class="d-block">Jl. Kebayunan No.18, RT.02/RW.20, Depok</span>
                                    <span class="d-block">Phone: 089511274679</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="card-body">
                                    <h5 class="fw-bold">To</h5>
                                    <span class="d-block">{{ $item->user->name }}</span>
                                    <span class="d-block">{{ $item->user->address }}</span>
                                    <span class="d-block">Email: {{ $item->user->email }}</span>
                                    <span class="d-block">Phone: {{ $item->user->phone }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border"></div>
                <div class="mb-2">
                    <div class="card-body">
                        <h5 class="card-title-sm">Notes:</h5>
                        <span class="card-text">
                            {{ $item->note }}
                        </span>
                    </div>
                </div>
                <div class="border"></div>


                <!-- List Order Item -->
                <div class="">
                    <div class="card-body">
                        <h5 class="card-title-sm">List Order Item</h5>
                        <div class="table-responsive">
                            <table
                                class="table table-striped table-hover table-bordered table-no-vertical-border order-item-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Image</th>
                                        <th>Article</th>
                                        <th>Item Name</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                @foreach ($orderitems as $data)
                                    <tbody>
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ asset('storage/' . $data->image) }}" alt=""
                                                    class="img-fluid" width="50"></td>
                                            <td>{{ $data->product->article }}</td>
                                            <td>{{ $data->product->name }}</td>
                                            <td>{{ $data->color }}</td>
                                            <td>{{ $data->size }}</td>
                                            <td>{{ $data->qty }}</td>
                                            <td>IDR {{ number_format($data->price) }}</td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Summary Order Total -->
                <div class="row mt-2">
                    <div class="col-md-6 offset-md-6">
                        <div class="">
                            <div class="card-body">
                                <h5 class="card-title-sm">Summary Order Total</h5>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Sub Total</td>
                                            <td>IDR {{ number_format($item->total) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Cost</td>
                                            <td>IDR {{ number_format($item->service_ongkir) }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Discount <br />
                                                <!-- Keterangan discount dipakai, jika tidak menggunakan discount maka note hidden -->
                                                <span class="discount-note">
                                                    {{ $item->voucher->code ?? '' }}
                                                </span>
                                            </td>
                                            <td>IDR {{ number_format($item->discount) }}</td>
                                        </tr>
                                        @if ($item->voucher_type == 'shipping')
                                            <tr>
                                                <td>Shipping Discount</td>
                                                <td>IDR {{ number_format($item->discount) }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>Ongkir</td>
                                            <td>IDR {{ number_format($item->ongkir) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="card-title-sm">Total</td>
                                            <td>IDR {{ number_format($item->gross_amount) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>

</html>
