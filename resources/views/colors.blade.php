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
                                            <td>
                                                <div class="w-100 p-2 rounded border"
                                                    style="background-color: {{ $color->palette }}; color: silver; max-width: 100px;">
                                                    {{ $color->palette }}
                                                </div>
                                            </td>
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

        <!-- Modal Add Color -->
        <div class="modal fade" id="addColorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="addColorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('colors.store') }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Color</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="color_add" class="form-label">Color Name</label>
                            <input type="text" name="color" class="form-control" id="color_add" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="color" name="pallet_picker" value="#ff0000" id="pallet_picker_add"
                                class="form-control form-control-color" style="max-width: 60px;">
                            <input type="text" name="palette" class="form-control" id="palette_add" value="#ff0000"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Modal for Edit Category -->
        @foreach ($data as $color)
            <div class="modal fade" id="editCategoryModal{{ $color->id }}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $color->id }}"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('colors.update', $color->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Color</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="color_{{ $color->id }}" class="form-label">Color Name</label>
                                <input type="text" name="color" class="form-control" id="color_{{ $color->id }}"
                                    value="{{ $color->color }}" required>
                            </div>

                            <div class="input-group mb-3">
                                <input type="color" name="pallet_picker" value="{{ $color->palette }}"
                                    id="pallet_picker_{{ $color->id }}" class="form-control form-control-color"
                                    style="max-width: 60px;">
                                <input type="text" name="palette" class="form-control"
                                    id="palette_{{ $color->id }}" value="{{ $color->palette }}" required>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Untuk form ADD
                const addPicker = document.getElementById('pallet_picker_add');
                const addInput = document.getElementById('palette_add');

                if (addPicker && addInput) {
                    addPicker.addEventListener('input', function() {
                        addInput.value = this.value;
                    });

                    addInput.addEventListener('input', function() {
                        if (/^#([0-9A-Fa-f]{6})$/.test(this.value)) {
                            addPicker.value = this.value;
                        }
                    });
                }

                // Untuk semua form EDIT
                @foreach ($data as $color)
                    const picker{{ $color->id }} = document.getElementById('pallet_picker_{{ $color->id }}');
                    const input{{ $color->id }} = document.getElementById('palette_{{ $color->id }}');

                    if (picker{{ $color->id }} && input{{ $color->id }}) {
                        picker{{ $color->id }}.addEventListener('input', function() {
                            input{{ $color->id }}.value = this.value;
                        });

                        input{{ $color->id }}.addEventListener('input', function() {
                            if (/^#([0-9A-Fa-f]{6})$/.test(this.value)) {
                                picker{{ $color->id }}.value = this.value;
                            }
                        });
                    }
                @endforeach
            });
        </script>

    </main>
@endsection
