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
                    <li class="breadcrumb-item active">Campaigns</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Campaigns</h5>
                                <a href="{{ route('campaigns.create') }}" class="btn btn-primary btn-sm">
                                    Add Campaign
                                </a>
                            </div>

                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @foreach ($data as $campaign)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $campaign->name }}</td>
                                            <td>{{ $campaign->category }}</td>
                                            <td><img src="{{ asset('storage/' . $campaign->image) }}"
                                                    alt="{{ $campaign->name }}" class="img-fluid border" width="50">
                                            </td>
                                            <td>
                                                <a href="{{ route('campaigns.edit', $campaign->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('campaigns.destroy', $campaign->id) }}"
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
    </main>
@endsection
