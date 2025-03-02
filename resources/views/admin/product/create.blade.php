@extends('admin.layouts.main')

@section('title', 'Tambah Produk')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light py-2 px-3 rounded shadow-sm">
                    <li class="breadcrumb-item"><a href="{{ route('home.admin') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product.page') }}" class="text-decoration-none"><i class="fas fa-shopping-bag me-1"></i>Produk</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-plus-circle me-1"></i>Tambah Produk</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-plus-circle text-primary me-2"></i>
                        <h5 class="m-0">Tambah Produk Baru</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        <div class="mb-4">
                            <label for="nama" class="form-label fw-medium">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" required placeholder="Masukkan nama produk">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Contoh: Coffee Latte, Cappuccino, Espresso</small>
                        </div>
                        
                        <div class="mb-4">
                            <label for="harga" class="form-label fw-medium">Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" required placeholder="Masukkan harga produk">
                            </div>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Masukkan harga dalam rupiah tanpa titik atau koma</small>
                        </div>
                        
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-medium">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4" required placeholder="Masukkan deskripsi produk"></textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Berikan deskripsi lengkap tentang produk ini</small>
                        </div>
                        
                        <div class="mb-4">
                            <label for="category_id" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="" selected disabled>Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih kategori yang sesuai untuk produk ini</small>
                        </div>
                        
                        <div class="mb-4">
                            <label for="gambar" class="form-label fw-medium">Gambar Produk <span class="text-danger">*</span></label>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="text-center py-4 mb-3" id="imagePreviewContainer">
                                        <img src="/api/placeholder/200/200" id="imagePreview" class="img-fluid rounded border d-none" alt="Preview">
                                        <div id="noImagePreview" class="rounded border p-5 text-center text-muted">
                                            <i class="fas fa-image mb-3" style="font-size: 3rem;"></i>
                                            <p>Pratinjau gambar akan muncul di sini</p>
                                        </div>
                                    </div>
                                    
                                    <div class="input-group">
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*" required>
                                        <label class="input-group-text" for="gambar"><i class="fas fa-upload"></i></label>
                                    </div>
                                    @error('gambar')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Unggah gambar produk. Format: JPG, PNG, maksimal 2MB</small>
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
                        <button type="submit" form="productForm" class="btn btn-coffee">
                            <i class="fas fa-save me-2"></i>Simpan
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
        // Image preview
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
            } else {
                $('#imagePreview').addClass('d-none');
                $('#noImagePreview').removeClass('d-none');
            }
        });
        
        // Form validation
        $('#productForm').on('submit', function(e) {
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
            
            if ($('#category_id').val() === null) {
                $('#category_id').addClass('is-invalid');
                isValid = false;
            } else {
                $('#category_id').removeClass('is-invalid');
            }
            
            return isValid;
        });
    });
</script>
@endsection