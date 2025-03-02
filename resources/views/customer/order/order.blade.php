<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .page-header {
            background-color: #28a745;
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card {
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 16px rgba(0, 0, 0, 0.12);
        }
        .card-img-top {
            height: 220px;
            object-fit: cover;
        }
        .card-title {
            font-weight: 600;
            color: #333;
        }
        .price {
            font-size: 1.25rem;
            font-weight: 700;
            color: #28a745;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #218838;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
            transform: translateY(-2px);
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }
        .btn-back:hover {
            background-color: #5a6268;
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
            transform: translateY(-2px);
            color: white;
        }
        .quantity-control {
            display: flex;
            margin-bottom: 1rem;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .quantity-btn {
            background-color: #f0f0f0;
            border: none;
            color: #555;
            font-weight: bold;
            height: 38px;
            width: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .quantity-input {
            border: none;
            text-align: center;
            flex-grow: 1;
            height: 38px;
        }
        .badge-category {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <h1 class="text-center mb-2"><i class="fas fa-store me-2"></i>Katalog Produk</h1>
            <p class="text-center mb-0">Temukan produk berkualitas dengan harga terbaik</p>
        </div>
    </div>
    
    <div class="container">
        <a href="{{ route('home.customer') }}" class="btn btn-back">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
        </a>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="mb-0">Menampilkan semua produk</h5>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <form method="GET" action="{{ route('customer.order') }}" class="d-flex">
                    <div class="input-group me-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                    <div class="dropdown">
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="">Urutkan</option>
                            <option value="low-high" {{ request('sort') == 'low-high' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                            <option value="high-low" {{ request('sort') == 'high-low' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        </select>
                    </div>
                </form>
            </div>            
        </div>

        <div class="row">
            @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="card-img-top">
                    <div class="card-body p-4">
                        <h5 class="card-title">{{ $product->nama }}</h5>
                        <p class="price mb-3">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                        <form action="{{ route('customer.addToCart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn decrease"><i class="fas fa-minus"></i></button>
                                <input type="number" name="jumlah" class="quantity-input" min="1" value="1">
                                <button type="button" class="quantity-btn increase"><i class="fas fa-plus"></i></button>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-shopping-cart me-2"></i>Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; Beanie Coffee Shop. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.increase').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentNode.querySelector('input');
                    input.value = parseInt(input.value) + 1;
                });
            });

            document.querySelectorAll('.decrease').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentNode.querySelector('input');
                    const value = parseInt(input.value);
                    if (value > 1) {
                        input.value = value - 1;
                    }
                });
            });
        });
    </script>
</body>
</html>