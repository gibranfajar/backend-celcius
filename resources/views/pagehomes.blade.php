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
                                <input type="hidden" name="id" value="{{ $data ? $data->id : '' }}">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="title_bannertop">Title Banner Top</label>
                                            <input type="text" name="title_bannertop" class="form-control"
                                                value="{{ $data ? $data->title_bannertop : old('title_bannertop') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="toptitleurl_left">Title Top URL Left</label>
                                            <input type="text" name="toptitleurl_left" class="form-control"
                                                value="{{ $data ? $data->toptitleurl_left : old('toptitleurl_left') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="topurl_left">Top URL Left</label>
                                            <input type="text" name="topurl_left" class="form-control"
                                                value="{{ $data ? $data->topurl_left : old('topurl_left') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="toptitleurl_right">Title Top URL Right</label>
                                            <input type="text" name="toptitleurl_right" class="form-control"
                                                value="{{ $data ? $data->toptitleurl_right : old('toptitleurl_right') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="topurl_right">Top URL Right</label>
                                            <input type="text" name="topurl_right" class="form-control"
                                                value="{{ $data ? $data->topurl_right : old('topurl_right') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bannertop_desktop_image">Banner Top Desktop</label>
                                            <img src="{{ $data ? asset('storage/' . $data->bannertop_desktop_image) : '' }}"
                                                width="250" class="d-block my-2">
                                            <input type="file" name="bannertop_desktop_image" class="form-control"
                                                id="bannertopdesktop_image">
                                            <img id="bannertop_desktop_imagePreview" width="250" class="mt-2">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bannertop_desktop_image">Banner Top Mobile</label>
                                            <img src="{{ $data ? asset('storage/' . $data->bannertop_mobile_image) : '' }}"
                                                width="250" class="d-block my-2">
                                            <input type="file" name="bannertop_mobile_image" class="form-control"
                                                id="bannertop_mobile_image">
                                            <img id="bannertop_mobile_imagePreview" width="250" class="mt-2">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="title_bannerbottom">Title Banner Bottom</label>
                                            <input type="text" name="title_bannerbottom" class="form-control"
                                                value="{{ $data ? $data->title_bannerbottom : old('title_bannerbottom') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bottomtitleurl_left">Title Bottom URL Left</label>
                                            <input type="text" name="bottomtitleurl_left" class="form-control"
                                                value="{{ $data ? $data->bottomtitleurl_left : old('bottomtitleurl_left') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bottomurl_left">Bottom URL Left</label>
                                            <input type="text" name="bottomurl_left" class="form-control"
                                                value="{{ $data ? $data->bottomurl_left : old('bottomurl_left') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bottomtitleurl_right">Title Bottom URL Right</label>
                                            <input type="text" name="bottomtitleurl_right" class="form-control"
                                                value="{{ $data ? $data->bottomtitleurl_right : old('bottomtitleurl_right') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bottomurl_right">Bottom URL Right</label>
                                            <input type="text" name="bottomurl_right" class="form-control"
                                                value="{{ $data ? $data->bottomurl_right : old('bottomurl_right') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bannerbottom_desktop_image">Banner Bottom Desktop</label>
                                            <img src="{{ $data ? asset('storage/' . $data->bannerbottom_desktop_image) : '' }}"
                                                width="250" class="d-block my-2">
                                            <input type="file" name="bannerbottom_desktop_image" class="form-control"
                                                id="bannerbottom_desktop_image">
                                            <img id="bannerbottom_desktop_imagePreview" width="250" class="mt-2">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bannerbottom_desktop_image">Banner Bottom Mobile</label>
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
