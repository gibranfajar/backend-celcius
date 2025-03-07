@extends('layouts.app')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Campaign</li>
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
                        <div class="card-body p-4">
                            <form action="{{ route('campaigns.update', $campaign->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Campaign Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ $campaign->name }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="category" class="form-label">Category</label>
                                        <select name="category" class="form-select" id="category">
                                            <option value="man" @if ($campaign->category == 'man') selected @endif>Man
                                            </option>
                                            <option value="woman" @if ($campaign->category == 'woman') selected @endif>Woman
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Image Thumbnail Slider</label>
                                    <input type="file" name="image" class="form-control" id="thumbnail">
                                    <img id="preview" width="250" class="mt-2">
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="banner_left" class="form-label">Banner Left</label>
                                        <input type="file" name="banner_left" class="form-control" id="banner_left">
                                        <img id="preview_banner_left" width="250" class="mt-2">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-2">
                                            <label for="product1_id" class="form-label">Product</label>
                                            <select name="product1_id" class="form-select" id="product1_id">
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ $product->id == $campaign->product1_id ? 'selected' : '' }}>
                                                        {{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row mb-2">
                                            <label for="product2_id" class="form-label">Product</label>
                                            <select name="product2_id" class="form-select" id="product2_id">
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ $product->id == $campaign->product2_id ? 'selected' : '' }}>
                                                        {{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 d-flex flex-wrap">
                                        <div class="col-md-6">
                                            <label for="product3_id" class="form-label">Product</label>
                                            <select name="product3_id" class="form-select" id="product3_id">
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ $product->id == $campaign->product3_id ? 'selected' : '' }}>
                                                        {{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="product4_id" class="form-label">Product</label>
                                            <select name="product4_id" class="form-select" id="product4_id">
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ $product->id == $campaign->product4_id ? 'selected' : '' }}>
                                                        {{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="product5_id" class="form-label">Product</label>
                                            <select name="product5_id" class="form-select" id="product5_id">
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ $product->id == $campaign->product5_id ? 'selected' : '' }}>
                                                        {{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="product6_id" class="form-label">Product</label>
                                            <select name="product6_id" class="form-select" id="product6_id">
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ $product->id == $campaign->product6_id ? 'selected' : '' }}>
                                                        {{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="banner_right" class="form-label">Banner Right</label>
                                        <input type="file" name="banner_right" class="form-control"
                                            id="banner_right">
                                        <img id="preview_banner_right" width="250" class="mt-2">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="banner_center" class="form-label">Banner Center</label>
                                    <input type="file" name="banner_center" class="form-control" id="banner_center">
                                    <img id="preview_banner_center" width="250" class="mt-2">
                                </div>

                                <div class="mb-3 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="window.history.back()">Close</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
