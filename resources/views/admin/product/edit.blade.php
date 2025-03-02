@extends('admin.layouts.main')

@section('title', 'Edit Produk')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light py-2 px-3 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="{{ route('home.admin') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.page') }}" class="text-decoration-none"><i class="fas fa-box me-1"></i>Produk</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-edit me-1"></i>Edit Produk</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-edit text-primary me-2"></i>
                            <h5 class="m-0">Edit Produk</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="editProductForm">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="nama" class="form-label fw-medium">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ $product->nama }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="harga" class="form-label fw-medium">Harga <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="harga" name="harga" value="{{ $product->harga }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-medium">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ $product->deskripsi }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="category_id" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                            {{ $category->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="gambar" class="form-label fw-medium">Gambar Produk</label>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="text-center py-4 mb-3" id="imagePreviewContainer">
                                            @if($product->gambar)
                                                <img src="{{ asset($product->gambar) }}" id="imagePreview" class="img-fluid rounded border" alt="Preview" style="max-height: 200px;">
                                            @else
                                                <div id="noImagePreview" class="rounded border p-5 text-center text-muted">
                                                    <i class="fas fa-image mb-3" style="font-size: 3rem;"></i>
                                                    <p>Belum ada gambar untuk produk ini</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                                            <label class="input-group-text" for="gambar"><i class="fas fa-upload"></i></label>
                                        </div>
                                        <small class="text-muted">Unggah gambar baru untuk mengganti gambar saat ini (opsional). Format: JPG, PNG, maksimal 2MB</small>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-white pt-0 pb-4 border-0">
                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <a href="{{ route('product.page') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" form="editProductForm" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#gambar').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result);
                        $('#imagePreview').removeClass('d-none');
                        $('#noImagePreview').addClass('d-none');
                    }
                    reader.readAsDataURL(file);
                }
            });

            $('#editProductForm').on('submit', function(e) {
                let isValid = true;
                if ($('#nama').val().trim() === '') {
                    $('#nama').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#nama').removeClass('is-invalid');
                }
                if ($('#harga').val().trim() === '') {
                    $('#harga').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#harga').removeClass('is-invalid');
                }
                if ($('#deskripsi').val().trim() === '') {
                    $('#deskripsi').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#deskripsi').removeClass('is-invalid');
                }
                return isValid;
            });
        });
    </script>
@endsection