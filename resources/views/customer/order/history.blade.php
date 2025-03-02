<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .order-history-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .page-title {
            color: #3a3a3a;
            font-weight: 600;
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
        }
        .page-title:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 3px;
            background-color: #0d6efd;
            bottom: -10px;
            left: 0;
        }
        .table {
            border-radius: 8px;
            overflow: hidden;
            border-collapse: separate;
            border-spacing: 0;
            border: none;
        }
        .table thead {
            background-color: #f1f5fd;
        }
        .table thead th {
            border: none;
            color: #495057;
            font-weight: 600;
            padding: 15px;
            vertical-align: middle;
        }
        .table tbody td {
            border-color: #edf2f9;
            padding: 15px;
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9ff;
        }
        .order-id {
            font-weight: 600;
            color: #0d6efd;
            cursor: pointer;
        }
        .badge {
            padding: 8px 12px;
            font-weight: 500;
            border-radius: 6px;
        }
        .badge-pending {
            background-color: #ffc107;
            color: #856404;
        }
        .badge-completed {
            background-color: #28a745;
            color: white;
        }
        .badge-cancelled {
            background-color: #dc3545;
            color: white;
        }
        .price {
            font-weight: 600;
            color: #212529;
        }
        .date {
            color: #6c757d;
        }
        .no-orders {
            text-align: center;
            padding: 40px 0;
            color: #6c757d;
        }
        .pagination {
            margin-top: 30px;
            justify-content: center;
        }
        .pagination .page-link {
            border-radius: 5px;
            margin: 0 3px;
            color: #0d6efd;
        }
        .pagination .active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        @media (max-width: 767px) {
            .order-history-container,
            .order-detail-container {
                padding: 15px;
            }
            .table thead {
                display: none;
            }
            .table, .table tbody, .table tr, .table td {
                display: block;
                width: 100%;
            }
            .table tr {
                margin-bottom: 15px;
                border: 1px solid #edf2f9;
                border-radius: 8px;
            }
            .table td {
                text-align: right;
                padding: 10px 15px;
                position: relative;
            }
            .table td:before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 50%;
                font-weight: 600;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="container order-history-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Riwayat Pesanan</h2>
            <a href="{{ route('home.customer') }}" class="btn btn-primary btn-back"><i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda</a>
        </div>

        <div id="ordersList">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Status</th>
                            <th>Total Pembayaran</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td data-label="ID Pesanan"><span class="order-id" onclick="showOrderDetail()">#{{ $order->id }}</span></td>
                            <td data-label="Status">
                                @if($order->status == 'pending')
                                    <span class="badge badge-pending"><i class="fas fa-clock me-1"></i> Pending</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge badge-completed"><i class="fas fa-check me-1"></i> Completed</span>
                                @else
                                    <span class="badge badge-cancelled"><i class="fas fa-times me-1"></i> Cancelled</span>
                                @endif
                            </td>
                            <td data-label="Total Pembayaran"><span class="price">Rp {{ number_format($order->orderItems->sum(function($item) {
                                    return $item->harga * $item->jumlah;
                                }), 0, ',', '.') }}</span>
                            </td>
                            <td data-label="Tanggal"><span class="date"><i class="far fa-calendar-alt me-1"></i> {{ $order->created_at->format('d M Y') }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>