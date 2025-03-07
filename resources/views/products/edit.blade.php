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
                            <form action="{{ route('products.update', $product->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    @foreach ($images as $item)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                            class="img-fluid w-25">
                                    @endforeach
                                </div>

                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <div class="form-group">
                                        <input id="image" type="file" name="image[]" multiple class="form-control">
                                    </div>
                                    <div id="imagePreview" class="row"></div>
                                </div>

                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Product Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ $product->name }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="type" class="form-label">Type</label>
                                        <select name="type" class="form-select" id="type" required>
                                            <option value="man" {{ $product->type == 'man' ? 'selected' : '' }}>Man
                                            </option>
                                            <option value="woman" {{ $product->type == 'woman' ? 'selected' : '' }}>Woman
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <div class="col-md-6">
                                        <label for="category" class="form-label">Category</label>
                                        <select name="category" class="form-select" id="category" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="color" class="form-label">Colors</label>
                                        <select name="color" class="form-select" id="color" required>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}"
                                                    {{ $color->id == $product->color_id ? 'selected' : '' }}>
                                                    {{ $color->color }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <div class="col-md-6">
                                        <label for="collection" class="form-label">Collection</label>
                                        <select name="collection" class="form-select" id="collection">
                                            <option value="0">Regular</option>
                                            @foreach ($collections as $collection)
                                                <option value="{{ $collection->id }}"
                                                    {{ $collection->id == $product->collection_id ? 'selected' : '' }}>
                                                    {{ $collection->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="weight" class="form-label">Weight</label>
                                        <input type="text" name="weight" class="form-control" id="weight"
                                            value="{{ $product->weight }}" required>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <div class="col-md-6">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="text" name="price" class="form-control" id="price"
                                            value="{{ $product->price }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="discount" class="form-label">Discount</label>
                                        <input type="text" name="discount" class="form-control"
                                            value="{{ $product->discount }}" id="discount" required>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <div class="col-md-6">
                                        <label for="article" class="form-label">Article</label>
                                        <input type="text" name="article" class="form-control"
                                            value="{{ $product->article }}" id="article" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="plu" class="form-label">PLU</label>
                                        <input type="text" name="plu" class="form-control"
                                            value="{{ $product->plu }}" id="plu" required>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <div class="col-md-6">
                                        <label for="description" class="form-label">Description</label>
                                        <input id="description" type="hidden" name="description"
                                            value="{{ $product->description }}" required>
                                        <trix-editor input="description"></trix-editor>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="sizechart" class="form-label">Sizechart</label>
                                        <input id="sizechart" type="hidden" name="sizechart"
                                            value="{{ $product->sizechart }}" required>
                                        <trix-editor input="sizechart"></trix-editor>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-3 align-items-center gap-2">
                                        <label for="size">Size and Stock</label>
                                        <button type="button" class="btn btn-success btn-sm" id="add-size-stock">Add
                                            Size</button>
                                    </div>
                                    <div id="size-stock-wrapper" class="mb-3">
                                        @foreach ($sizes as $size)
                                            <div
                                                class="form-group size-stock-group row d-flex justify-content-between mb-2">
                                                <div class="col-md-4">
                                                    <input type="text" name="size[]" class="form-control"
                                                        placeholder="Size" value="{{ $size->size }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="stock[]" class="form-control"
                                                        placeholder="Stock" value="{{ $size->stock }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-size-stock"><i
                                                            class="bi bi-trash3"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mb-3 d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="window.history.back()">Close</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
