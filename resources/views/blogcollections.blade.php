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
                    <li class="breadcrumb-item active">Blog Collections</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Blog Collections</h5>
                                @if ($data->count() < 3)
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addCategoryModal">
                                        Add Blog Collection
                                    </button>
                                @endif
                            </div>

                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Collection</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @foreach ($data as $collection)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $collection->collection->name }}</td>
                                            <td><img src="{{ asset('storage/' . $collection->banner) }}"
                                                    alt="{{ $collection->collection->name }}" class="img-fluid border"
                                                    width="50}}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editCategoryModal{{ $collection->id }}">Edit</button>
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

        <!-- Modal for Add Category -->
        <div class="modal fade" id="addCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addCategoryModalLabel">Add Blog Collection</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('blogcollections.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="collection" class="form-label">Collection</label>
                                <select name="collection" id="collection" class="form-select">
                                    @foreach ($collections as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="thumbnail">Image Thumbnail</label>
                                <input type="file" name="banner" class="form-control" id="thumbnail" required>
                                <img id="preview" width="250" class="mt-2">
                            </div>
                            <div class="mb-3 d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Edit Category -->
        @foreach ($data as $collection)
            <div class="modal fade" id="editCategoryModal{{ $collection->id }}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $collection->id }}"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editCategoryModalLabel{{ $collection->id }}">Edit Blog
                                Collection
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('blogcollections.update', $collection->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="collection" class="form-label">Collection</label>
                                    <select name="collection" id="collection" class="form-select">
                                        @foreach ($collections as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $collection->collection_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="thumbnail">Image Thumbnail</label>
                                    <input type="file" name="banner" class="form-control" id="thumbnail" required>
                                    <img id="preview" width="250" class="mt-2">
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
        @endforeach

    </main>
@endsection
