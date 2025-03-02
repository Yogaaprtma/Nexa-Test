<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beanie - @yield('title', 'Coffee Shop')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container-fluid px-5"> 
        <hr class="top-border">

        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <ul class="navbar-nav d-flex align-items-center gap-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('home.customer') }}">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#shop-best-coffee">SHOP</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#blog-section">BLOG</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pages-section">PAGES</a>
                        </li>
                    </ul>                    

                    <div class="d-flex align-items-center">
                        <div class="search-form">
                            <div class="input-group position-relative">
                                <input class="form-control rounded-pill" type="search" placeholder="Search here..." aria-label="Search">
                                <button class="btn position-absolute search-btn" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <a href="#" class="mx-3 icon-link"><i class="far fa-heart"></i></a>
                        <a href="#" class="mx-3 icon-link"><i class="fas fa-shopping-bag"></i> (0)</a>
                        <a href="{{ route('logout') }}" class="ms-3 btn btn-outline-secondary btn-sm rounded-pill">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </nav>
        </header>

        <hr class="bottom-border">

        @yield('content')

        <footer class="py-5">
            <div class="container">
                <div class="text-center mb-4">
                    <h2 class="instagram-heading">FOLLOW OUR INSTAGRAM #BEANIE</h2>
                </div>
                
                <div class="instagram-feed">
                    <div class="row g-3">
                        @for ($i = 1; $i <= 6; $i++)
                        <div class="col-6 col-md-2">
                            <a href="" target="_blank" class="instagram-item">
                                <img src="{{ asset('images/blog1.jpg') }}" alt="Blog 1" class="img-fluid rounded">
                            </a>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
            
            <div class="container footer-links mt-5">
                <div class="row">
                    <div class="col-md-3 col-6 footer-column">
                        <ul class="list-unstyled">
                            <li><a href="{{ route('home.customer') }}">HOME</a></li>
                            <li><a href="#">ABOUT</a></li>
                            <li><a href="#">SHOP</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-6 footer-column">
                        <ul class="list-unstyled">
                            <li><a href="#">SHOP SINGLE</a></li>
                            <li><a href="#">BLOG</a></li>
                            <li><a href="#">CONTACT</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-6 footer-column">
                        <ul class="list-unstyled">
                            <li><a href="#">TERMS & CONDITIONS</a></li>
                            <li><a href="#">SHIPPING</a></li>
                            <li><a href="#">PRIVACY POLICY</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-6 footer-column">
                        <ul class="list-unstyled">
                            <li>ADDRESS: LOCATION, 123</li>
                            <li>YOU@BEANCOFFEE.COM</li>
                            <li>TEL: 555-444-333</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="container text-center footer-copyright mt-5 pt-4">
                <p class="small text-muted">© {{ date('Y') }} Beanie. Designed by <a href="#" class="text-muted">designagency</a></p>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variabel untuk pelacakan posisi carousel
            let currentPage = 0;
            const productsPerPage = 3;
            const totalProducts = {{ count($featuredProducts) }};
            const totalPages = Math.ceil(totalProducts / productsPerPage);
            
            // Fungsi untuk mengupdate tampilan tombol
            function updateButtons() {
                const prevBtn = document.getElementById('prevProducts');
                const nextBtn = document.getElementById('nextProducts');
                
                prevBtn.classList.toggle('active', currentPage > 0);
                nextBtn.classList.toggle('active', currentPage < totalPages - 1);
            }
            
            // Fungsi untuk menampilkan produk berdasarkan halaman saat ini
            function showProductsForPage(page) {
                const products = document.querySelectorAll('.product-item');
                
                products.forEach((product, index) => {
                    const shouldShow = index >= page * productsPerPage && index < (page + 1) * productsPerPage;
                    product.classList.toggle('d-none', !shouldShow);
                });
            }
            
            // Event listener untuk tombol next
            document.getElementById('nextProducts').addEventListener('click', function() {
                if (currentPage < totalPages - 1) {
                    currentPage++;
                    showProductsForPage(currentPage);
                    updateButtons();
                }
            });
            
            // Event listener untuk tombol prev
            document.getElementById('prevProducts').addEventListener('click', function() {
                if (currentPage > 0) {
                    currentPage--;
                    showProductsForPage(currentPage);
                    updateButtons();
                }
            });
            
            // Inisialisasi
            updateButtons();
        });
    </script>
</body>
</html>