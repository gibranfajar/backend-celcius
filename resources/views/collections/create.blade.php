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
                    <li class="breadcrumb-item active">Collection</li>
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
                            <form action="{{ route('collections.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Collection Name</label>
                                        <input type="text" name="name" class="form-control" id="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="category" class="form-label">Category</label>
                                        <select name="category" class="form-select" id="category" required>
                                            <option value="man">Man</option>
                                            <option value="woman">Woman</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <input id="description" type="hidden" name="description" required>
                                    <trix-editor input="description"></trix-editor>
                                </div>

                                <div class="mb-3">
                                    <label for="thumbnail">Image Thumbnail Slider</label>
                                    <input type="file" name="thumbnail" class="form-control" id="thumbnail" required>
                                    <img id="preview" width="250" class="mt-2">
                                </div>

                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <div class="form-group">
                                        <input id="image" type="file" name="image[]" multiple class="form-control"
                                            required>
                                    </div>
                                    <div id="imagePreview" class="row"></div>
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
