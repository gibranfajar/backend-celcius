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
                    <li class="breadcrumb-item active">Colors</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Colors</h5>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addColorModal">
                                    Add Color
                                </button>
                            </div>

                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Color</th>
                                        <th>Pallet</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $color)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $color->color }}</td>
                                            <td><img src="{{ asset('storage/' . $color->image) }}" alt="{{ $color->color }}"
                                                    class="img-fluid border" width="50"></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editCategoryModal{{ $color->id }}">Edit</button>
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
        <div class="modal fade" id="addColorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="addColorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addColorModalLabel">Add Color</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('colors.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="color" class="form-label">Color Name</label>
                                <input type="text" name="color" class="form-control" id="color" required>
                            </div>

                            <div class="input-group mb-3">
                                <input type="file" name="image" class="form-control" id="image" required>
                                <img class="imagePreviewEdit img-thumbnail" width="40" />
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
        @foreach ($data as $color)
            <div class="modal fade" id="editCategoryModal{{ $color->id }}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $color->id }}"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editCategoryModalLabel{{ $color->id }}">Edit Color</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('colors.update', $color->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="color" class="form-label">Color Name</label>
                                    <input type="text" name="color" class="form-control" id="color"
                                        value="{{ $color->color }}" required>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="file" name="image" class="form-control" id="image" required>
                                    <img class="imagePreviewEdit img-thumbnail" width="40" />
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

        <script>
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener("change", function(event) {
                    let file = event.target.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            let preview = event.target.closest('.modal-content').querySelector(
                                '.imagePreviewEdit');
                            if (preview) {
                                preview.src = e.target.result;
                                preview.style.display = "block";
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>

    </main>
@endsection
