<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .cart-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
        }
        
        .page-header {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eaeaea;
        }
        
        .table {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table thead th {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 15px;
        }
        
        .table tbody td {
            padding: 15px;
            vertical-align: middle;
        }
        
        .checkout-btn {
            margin-top: 30px;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        
        .cart-empty {
            text-align: center;
            padding: 40px 20px;
        }
        
        .cart-empty i {
            font-size: 60px;
            color: #dee2e6;
            margin-bottom: 20px;
        }
        
        .total-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .product-name {
            font-weight: 500;
            color: #2c3e50;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #dee2e6;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
        }
        
        .quantity-value {
            margin: 0 10px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="cart-container">
            <h2 class="page-header text-center">
                <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
            </h2>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-2 me-3">
                                        <i class="fas fa-box text-secondary"></i>
                                    </div>
                                    <span class="product-name">{{ $item['nama'] }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="quantity-control">
                                    <button class="quantity-btn">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="quantity-value">{{ $item['jumlah'] }}</span>
                                    <button class="quantity-btn">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="text-end">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if(count($cart) == 0)
                        <tr>
                            <td colspan="5">
                                <div class="cart-empty">
                                    <i class="fas fa-shopping-cart"></i>
                                    <h5>Keranjang Belanja Kosong</h5>
                                    <p class="text-muted">Silakan tambahkan beberapa produk ke keranjang Anda</p>
                                    <a href="{{ route('customer.order') }}" class="btn btn-primary mt-3">Lanjutkan Belanja</a>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            @if(count($cart) > 0)
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('customer.order') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Lanjutkan Belanja
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="total-section">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format(collect($cart)->sum('total'), 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pengiriman</span>
                            <span>Rp 0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span>Rp {{ number_format(collect($cart)->sum('total'), 0, ',', '.') }}</span>
                        </div>
                        
                        <form action="{{ route('customer.checkout') }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 checkout-btn">
                                <i class="fas fa-check-circle me-2"></i>Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>