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
                    <li class="breadcrumb-item active">Vouchers</li>
                </ol>
            </nav>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Vouchers</h5>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addVoucherModal">
                                    Add Voucher
                                </button>
                            </div>

                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Qty</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $voucher)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $voucher->name }}</td>
                                            <td>{{ $voucher->amount }}</td>
                                            <td>{{ $voucher->qty }}</td>
                                            <td>{{ $voucher->type }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button
                                                        class="btn {{ $voucher->status == 'active' ? 'btn-success' : 'btn-danger' }} btn-sm dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ Str::ucfirst($voucher->status) }}
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form action="{{ route('vouchers.status', $voucher->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="active">
                                                                <button type="submit" class="dropdown-item">Active</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('vouchers.status', $voucher->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="inactive">
                                                                <button type="submit"
                                                                    class="dropdown-item">Inactive</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class="d-flex gap-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editCategoryModal{{ $voucher->id }}">Edit</button>
                                                <form action="{{ route('vouchers.destroy', $voucher->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
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

        <!-- Modal for Add Voucher -->
        <div class="modal fade" id="addVoucherModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="addVoucherModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addVoucherModalLabel">Add Voucher</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('vouchers.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" name="code" class="form-control" id="code" required>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select name="type" class="form-select" id="type">
                                    <option value="ongkir">Ongkir</option>
                                    <option value="belanja">Belanja</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="text" name="amount" class="form-control" id="amount" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" cols="30" rows="4" class="form-control" required></textarea>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" id="start_date"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" name="end_date" class="form-control" id="end_date" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-select" id="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="qty" class="form-label">Qty</label>
                                    <input type="number" name="qty" class="form-control" id="qty" required>
                                </div>
                            </div>

                            <div class="mb-3 d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-danger btn-sm"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Edit Category -->
        @foreach ($data as $voucher)
            <div class="modal fade" id="editCategoryModal{{ $voucher->id }}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $voucher->id }}"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editCategoryModalLabel{{ $voucher->id }}">Edit Voucher
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('vouchers.update', $voucher->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ $voucher->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="code" class="form-label">Code</label>
                                    <input type="text" name="code" class="form-control" id="code"
                                        value="{{ $voucher->code }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select name="type" class="form-select" id="type">
                                        <option value="ongkir" {{ $voucher->type == 'ongkir' ? 'selected' : '' }}>Ongkir
                                        </option>
                                        <option value="belanja" {{ $voucher->type == 'belanja' ? 'selected' : '' }}>
                                            Belanja</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="text" name="amount" class="form-control" id="amount"
                                        value="{{ $voucher->amount }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="4" class="form-control" required> {{ $voucher->description }} </textarea>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input type="date" name="start_date" class="form-control" id="start_date"
                                            value="{{ $voucher->start_date }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" name="end_date" class="form-control" id="end_date"
                                            value="{{ $voucher->end_date }}" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" class="form-select" id="status">
                                            <option value="active" {{ $voucher->status == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="inactive"
                                                {{ $voucher->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="qty" class="form-label">Qty</label>
                                        <input type="number" name="qty" class="form-control" id="qty"
                                            value="{{ $voucher->qty }}" required>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-danger btn-sm"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </main>
@endsection
