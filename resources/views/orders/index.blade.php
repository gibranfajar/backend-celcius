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
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Orders</h5>
                            </div>

                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Order Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        use Carbon\Carbon;
                                    @endphp
                                    @foreach ($data as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $product->invoice }}</td>
                                            <td>{{ $product->user->name }}</td>
                                            <td>{{ Str::ucfirst($product->status) }}</td>
                                            <td>
                                                @if ($product->status_payment == 'pending')
                                                    <span class="badge bg-warning">
                                                        {{ Str::ucfirst($product->status_payment) }}
                                                    </span>
                                                @elseif ($product->status_payment == 'settlement')
                                                    <span class="badge bg-success">
                                                        {{ Str::ucfirst($product->status_payment) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        {{ Str::ucfirst($product->status_payment) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ Carbon::parse($product->created_at)->format('d F Y') }}</td>
                                            <td class="d-flex gap-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#changeStatus{{ $product->id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#showOrder{{ $product->id }}">
                                                    <i class="bi bi-printer"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


    {{-- modal change status --}}
    @foreach ($data as $item)
        <div class="modal fade" id="changeStatus{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="changeStatusLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="changeStatusLabel">Status Order</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('orders.update', $item->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="dikemas" {{ $item->status == 'dikemas' ? 'selected' : '' }}>Dikemas
                                    </option>
                                    <option value="pengiriman" {{ $item->status == 'pengiriman' ? 'selected' : '' }}>
                                        Pengiriman</option>
                                    <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                    <option value="pengembalian dana"
                                        {{ $item->status == 'pengembalian dana' ? 'selected' : '' }}>Pengembalian Dana
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="resi">Resi Number</label>
                                <input type="text" name="resi" id="resi" class="form-control"
                                    value="{{ $item->resi }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal show print --}}
        <div class="modal modal-xl" id="showOrder{{ $item->id }}" tabindex="-1" aria-labelledby="showOrderLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="showOrderLabel">Print Invoice
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe src="{{ route('orders.show', $item->id) }}" width="100%" height="600px"></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
