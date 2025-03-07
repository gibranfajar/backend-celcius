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
                    <li class="breadcrumb-item active">Products</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Products</h5>
                                <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                                    Add Product
                                </a>
                            </div>

                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Article</th>
                                        <th>Plu</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>{{ $product->article }}</td>
                                            <td>{{ $product->plu }}</td>
                                            <td class="d-flex gap-2">
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <div class="dropdown">
                                                    <button
                                                        class="btn {{ $product->status == 'active' ? 'btn-success' : 'btn-danger' }} btn-sm dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ Str::ucfirst($product->status) }}
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form action="{{ route('products.status', $product->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="active">
                                                                <button type="submit" class="dropdown-item">Active</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('products.status', $product->id) }}"
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
@endsection
