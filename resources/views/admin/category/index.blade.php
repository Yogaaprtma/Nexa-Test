@extends('admin.layouts.main')

@section('title', 'Kelola Kategori')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="m-0">
                <i class="fas fa-tags me-2 text-secondary"></i>
                Kelola Kategori
            </h2>
            <p class="text-muted mt-2">Mengelola kategori produk Beanie Coffee Shop</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('home.admin') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
            <a href="{{ route('category.create') }}" class="btn btn-coffee">
                <i class="fas fa-plus-circle me-2"></i>Tambah Kategori
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
                    <h5 class="m-0 text-secondary">Daftar Kategori</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari kategori..." id="searchCategory">
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
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                @if($category->gambar)
                                    <img src="{{ asset('storage/'.$category->gambar) }}" class="img-thumbnail rounded" width="70" height="70" alt="{{ $category->nama }}">
                                @else
                                    <div class="bg-light rounded text-center p-3" style="width: 70px; height: 70px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-medium">{{ $category->nama }}</td>
                            <td>
                                <div class="text-muted text-truncate" style="max-width: 350px;">
                                    {{ $category->deskripsi }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit Kategori">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-bs-toggle="tooltip" title="Hapus Kategori">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if(count($categories) == 0)
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="py-5">
                                    <i class="fas fa-folder-open text-muted mb-3" style="font-size: 3rem;"></i>
                                    <p class="text-muted">Belum ada kategori yang tersedia</p>
                                    <a href="{{ route('category.create') }}" class="btn btn-sm btn-coffee mt-2">
                                        <i class="fas fa-plus-circle me-2"></i>Tambah Kategori Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <p class="text-muted mb-0">Menampilkan {{ count($categories) }} kategori</p>
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
                <p class="text-center">Apakah Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.</p>
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
        $("#searchCategory").on("keyup", function() {
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