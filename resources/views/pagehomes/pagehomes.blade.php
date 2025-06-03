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
                    <li class="breadcrumb-item active">Page homes</li>
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
                            <form action="{{ $data ? route('pagehomes.update', $data->id) : route('pagehomes.store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @if ($data)
                                    @method('PUT')
                                @endif
                                <input type="hidden" name="type" value="men">
                                <input type="hidden" name="id" value="{{ $data ? $data->id : '' }}">
                                <div class="row mb-3">
                                    <div class="mb-3">
                                        <label for="title">Title Banner (Men)</label>
                                        <input type="text" name="title" class="form-control"
                                            value="{{ $data ? $data->title : old('title') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bannertop_desktop_image">Banner Top Desktop (Men)</label>
                                            <img src="{{ $data ? asset('storage/' . $data->bannertop_desktop_image) : '' }}"
                                                width="250" class="d-block my-2">
                                            <input type="file" name="bannertop_desktop_image" class="form-control"
                                                id="bannertopdesktop_image">
                                            <img id="bannertop_desktop_imagePreview" width="250" class="mt-2">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bannertop_desktop_image">Banner Top Mobile (Men)</label>
                                            <img src="{{ $data ? asset('storage/' . $data->bannertop_mobile_image) : '' }}"
                                                width="250" class="d-block my-2">
                                            <input type="file" name="bannertop_mobile_image" class="form-control"
                                                id="bannertop_mobile_image">
                                            <img id="bannertop_mobile_imagePreview" width="250" class="mt-2">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bannerbottom_desktop_image">Banner Bottom Desktop (Men)</label>
                                            <img src="{{ $data ? asset('storage/' . $data->bannerbottom_desktop_image) : '' }}"
                                                width="250" class="d-block my-2">
                                            <input type="file" name="bannerbottom_desktop_image" class="form-control"
                                                id="bannerbottom_desktop_image">
                                            <img id="bannerbottom_desktop_imagePreview" width="250" class="mt-2">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bannerbottom_desktop_image">Banner Bottom Mobile (Men)</label>
                                            <img src="{{ $data ? asset('storage/' . $data->bannerbottom_mobile_image) : '' }}"
                                                width="250" class="d-block my-2">
                                            <input type="file" name="bannerbottom_mobile_image" class="form-control"
                                                id="bannerbottom_mobile_image">
                                            <img id="bannerbottom_mobile_imagePreview" width="250" class="mt-2">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 d-flex justify-content-end gap-2">
                                    <button type="submit"
                                        class="btn btn-primary btn-sm">{{ $data ? 'Update' : 'Save' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
