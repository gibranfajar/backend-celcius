<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ $title }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    {{-- trix editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    {{-- bootstrap icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- sortable js untuk drag and drop image --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

</head>

<body>

    {{-- navbar / header --}}
    @include('components.navbar')

    {{-- sidebar --}}
    @include('components.sidebar')

    @yield('content')

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- Cek jika ada session success --}}
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Success!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK"
            });
        </script>
    @elseif (session('error'))
        <script>
            Swal.fire({
                title: "Error!",
                text: "{{ session('error') }}",
                icon: "error",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK"
            });
        </script>
    @endif

    {{-- datatables --}}
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable(); // Inisialisasi DataTables tanpa server-side
        });
    </script>

    {{-- product-images preview --}}
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = '';

            // Array to keep track of file objects and their original indices
            const fileArray = Array.from(files).map((file, index) => ({
                file,
                index,
                name: file.name // Keep track of the original file name
            }));

            // Create image preview elements
            fileArray.forEach(({
                file,
                name
            }) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.classList.add('col-md-3', 'mt-3', 'image-item');
                    col.innerHTML = `
                <div class="card">
                    <div class="card-body p-0">
                        <img src="${e.target.result}" class="img-fluid img-thumbnail" />
                        <input type="hidden" name="image_names[]" value="${name}" />
                    </div>
                </div>
            `;
                    previewContainer.appendChild(col);
                };
                reader.readAsDataURL(file);
            });

            // Initialize sortable to handle drag-and-drop
            new Sortable(previewContainer, {
                animation: 150,
                onEnd: function() {
                    // Reorder files based on new order
                    const newOrder = Array.from(previewContainer.children);
                    const reorderedFiles = newOrder.map(item => {
                        const input = item.querySelector('input[type="hidden"]');
                        const name = input.value;
                        const index = fileArray.findIndex(f => f.name === name);
                        return fileArray[index].file;
                    });

                    // Create a new FileList from reordered files
                    const fileList = new DataTransfer();
                    reorderedFiles.forEach(file => fileList.items.add(file));
                    document.getElementById('image').files = fileList.files;
                }
            });
        });
    </script>


    {{-- image preview banner --}}
    <script>
        document.getElementById('bannertopdesktop_image').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Ambil file yang diunggah
            if (file) {
                const reader = new FileReader(); // Buat FileReader
                reader.onload = function(e) {
                    const preview = document.getElementById('bannertop_desktop_imagePreview');
                    preview.src = e.target.result; // Set URL gambar
                    preview.style.display = "block"; // Tampilkan gambar
                }
                reader.readAsDataURL(file); // Baca file sebagai URL Data
            }
        });
        document.getElementById('bannertop_mobile_image').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Ambil file yang diunggah
            if (file) {
                const reader = new FileReader(); // Buat FileReader
                reader.onload = function(e) {
                    const preview = document.getElementById('bannertop_mobile_imagePreview');
                    preview.src = e.target.result; // Set URL gambar
                    preview.style.display = "block"; // Tampilkan gambar
                }
                reader.readAsDataURL(file); // Baca file sebagai URL Data
            }
        });
        document.getElementById('bannerbottom_desktop_image').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Ambil file yang diunggah
            if (file) {
                const reader = new FileReader(); // Buat FileReader
                reader.onload = function(e) {
                    const preview = document.getElementById('bannerbottom_desktop_imagePreview');
                    preview.src = e.target.result; // Set URL gambar
                    preview.style.display = "block"; // Tampilkan gambar
                }
                reader.readAsDataURL(file); // Baca file sebagai URL Data
            }
        });
        document.getElementById('bannerbottom_mobile_image').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Ambil file yang diunggah
            if (file) {
                const reader = new FileReader(); // Buat FileReader
                reader.onload = function(e) {
                    const preview = document.getElementById('bannerbottom_mobile_imagePreview');
                    preview.src = e.target.result; // Set URL gambar
                    preview.style.display = "block"; // Tampilkan gambar
                }
                reader.readAsDataURL(file); // Baca file sebagai URL Data
            }
        });
    </script>


    {{-- image thumbnail preview --}}
    <script>
        document.getElementById('thumbnail').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Ambil file yang diunggah
            if (file) {
                const reader = new FileReader(); // Buat FileReader
                reader.onload = function(e) {
                    const preview = document.getElementById('preview');
                    preview.src = e.target.result; // Set URL gambar
                    preview.style.display = "block"; // Tampilkan gambar
                }
                reader.readAsDataURL(file); // Baca file sebagai URL Data
            }
        });
    </script>

    {{-- image preview for campaign --}}
    <script>
        document.getElementById('banner_left').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Ambil file yang diunggah
            if (file) {
                const reader = new FileReader(); // Buat FileReader
                reader.onload = function(e) {
                    const preview = document.getElementById('preview_banner_left');
                    preview.src = e.target.result; // Set URL gambar
                    preview.style.display = "block"; // Tampilkan gambar
                }
                reader.readAsDataURL(file); // Baca file sebagai URL Data
            }
        });
        document.getElementById('banner_right').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Ambil file yang diunggah
            if (file) {
                const reader = new FileReader(); // Buat FileReader
                reader.onload = function(e) {
                    const preview = document.getElementById('preview_banner_right');
                    preview.src = e.target.result; // Set URL gambar
                    preview.style.display = "block"; // Tampilkan gambar
                }
                reader.readAsDataURL(file); // Baca file sebagai URL Data
            }
        });
        document.getElementById('banner_center').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Ambil file yang diunggah
            if (file) {
                const reader = new FileReader(); // Buat FileReader
                reader.onload = function(e) {
                    const preview = document.getElementById('preview_banner_center');
                    preview.src = e.target.result; // Set URL gambar
                    preview.style.display = "block"; // Tampilkan gambar
                }
                reader.readAsDataURL(file); // Baca file sebagai URL Data
            }
        });
    </script>

    {{-- sizes and stock function --}}
    <script>
        document.getElementById('add-size-stock').addEventListener('click', function() {
            var wrapper = document.getElementById('size-stock-wrapper');
            var newFieldGroup = document.createElement('div');
            newFieldGroup.classList.add('form-group', 'size-stock-group', 'row', 'd-flex',
                'justify-content-between', 'mb-2');
            newFieldGroup.innerHTML = `
            <div class="col-md-4">
                <input type="text" name="size[]" class="form-control" placeholder="Size">
            </div>
            <div class="col-md-4">
                <input type="text" name="stock[]" class="form-control" placeholder="Stock">
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-danger btn-sm remove-size-stock"><i class="bi bi-trash3"></i></button>
            </div>
        `;
            wrapper.appendChild(newFieldGroup);
        });

        document.getElementById('size-stock-wrapper').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-size-stock')) {
                event.target.parentElement.parentElement.remove();
            }
        });
    </script>
</body>

</html>
