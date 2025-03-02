@extends('admin.layouts.main')

@section('title', 'Kelola Produk')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="row align-items-center mb-4">
            <div class="col">
                <h2 class="m-0">
                    <i class="fas fa-coffee me-2 text-secondary"></i>
                    Kelola Produk
                </h2>
                <p class="text-muted mt-2">Mengelola produk Beanie Coffee Shop</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('home.admin') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
                <a href="{{ route('products.create') }}" class="btn btn-coffee">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Produk
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="m-0 text-secondary">Daftar Produk</h5>
                    </div>
                    <div class="col-auto">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari produk..." id="searchProduct">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="60">No</th>
                                <th width="100">Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th class="text-center" width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    @if($product->gambar)
                                        <img src="{{ asset($product->gambar) }}" class="img-thumbnail rounded" width="70" height="70" alt="{{ $product->nama }}">
                                    @else
                                        <div class="bg-light rounded text-center p-3" style="width: 70px; height: 70px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="fw-medium">{{ $product->nama }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $product->category->nama }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit Produk">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-bs-toggle="tooltip" title="Hapus Produk">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="py-5">
                                        <i class="fas fa-coffee text-muted mb-3" style="font-size: 3rem;"></i>
                                        <p class="text-muted">Belum ada produk yang tersedia</p>
                                        <a href="{{ route('products.create') }}" class="btn btn-sm btn-coffee mt-2">
                                            <i class="fas fa-plus-circle me-2"></i>Tambah Produk Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="text-muted mb-0">Menampilkan {{ count($products) }} produk</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <p class="text-center">Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            
            // Search functionality
            $("#searchProduct").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            
            // Delete confirmation
            let deleteForm = null;
            
            $(".delete-btn").on("click", function(e) {
                e.preventDefault();
                deleteForm = $(this).closest('form');
                $("#deleteConfirmModal").modal('show');
            });
            
            $("#confirmDeleteBtn").on("click", function() {
                if (deleteForm) {
                    deleteForm.submit();
                }
                $("#deleteConfirmModal").modal('hide');
            });
        });
    </script>
@endsection