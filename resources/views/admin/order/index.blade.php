@extends('admin.layouts.main')

@section('title', 'Riwayat Order User')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="m-0">
                <i class="fas fa-shopping-bag me-2 text-secondary"></i>
                Riwayat Order User
            </h2>
            <p class="text-muted mt-2">Melihat daftar pesanan pelanggan Beanie Coffee Shop</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('home.admin') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
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
                    <h5 class="m-0 text-secondary">Daftar Pesanan</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari pesanan..." id="searchOrder">
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
                            <th class="text-center" width="60">ID</th>
                            <th>Nama User</th>
                            <th>Nama Barang</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Total Pembayaran</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tanggal Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="text-center fw-medium">{{ $order->id }}</td>
                            <td>{{ $order->user->nama }}</td>
                            <td>
                                @foreach($order->orderItems as $item)
                                    <div class="mb-1">{{ $item->product->nama }}</div>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @foreach($order->orderItems as $item)
                                    <div class="mb-1">{{ $item->jumlah }}</div>
                                @endforeach
                            </td>
                            <td class="text-center fw-medium">
                                Rp {{ number_format($order->orderItems->sum(function($item) {
                                    return $item->harga * $item->jumlah;
                                }), 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @if($order->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                        
                        @if(count($orders) == 0)
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="py-5">
                                    <i class="fas fa-shopping-cart text-muted mb-3" style="font-size: 3rem;"></i>
                                    <p class="text-muted">Belum ada pesanan yang tersedia</p>
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
                    <p class="text-muted mb-0">Menampilkan {{ count($orders) }} pesanan</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Search functionality
        $("#searchOrder").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection