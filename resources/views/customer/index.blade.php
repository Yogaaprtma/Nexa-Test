@extends('customer.layouts.main')

@section('title', 'User Dashboard')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row g-0">
            <div class="col-md-6 p-0">
                <img src="{{ asset('storage/images/coffee.jpg') }}" alt="Specialty Coffee" class="img-fluid w-100 h-100 object-fit-cover">
            </div>
            
            <div class="col-md-6 p-0 d-flex flex-column justify-content-center align-items-center text-center bg-light">
                <div class="hero-text text-dark p-4">
                    <h2><span class="text-dark">SPECIAL</span> <span class="text-coffee">COFFEE</span></h2>
                    <p>Morbi justo vel diam non leo elementum massa. Molestie ipsum condimentum egestas vitae ut cras aenean enim. Laoreet odio adipiscing auctor scelerisque phasellus nisl faucibus.</p>
                    <button onclick="window.location.href='{{ route('customer.order') }}'" class="btn btn-outline-dark rounded-pill">
                        ORDER NOW
                    </button>
                </div>
            </div>            
        </div>
    </div>

    <section class="intro-text mt-5 py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <p class="lead font-italic">
                        Morbi justo vel diam non leo elementum massa. Molestie ipsum 
                        condimentum egestas vitae ut cras aenean enim. Laoreet odio adipiscing auctor scelerisque phasellus nisl faucibus.
                    </p>
                </div>
            </div>
        </div>
    </section>    

    <!-- Shop Best Coffee -->
    <section class="best-coffee py-5" id="shop-best-coffee">
        <div class="container">
            <div class="section-header d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-uppercase">SHOP BEST COFFEE</h3>
                <div class="view-all-container d-flex align-items-center">
                    <a href="#" class="view-all text-uppercase">View All</a>
                    <button class="arrow-btn prev" id="prevProducts"><i class="fas fa-chevron-left"></i></button>
                    <button class="arrow-btn next active" id="nextProducts"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            
            <div class="product-carousel-container">
                <div class="product-carousel">
                    @foreach($featuredProducts as $index => $product)
                    <div class="product-item {{ $index >= 3 ? 'd-none' : '' }}">
                        <div class="product-card mb-4">
                            <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="img-fluid product-image">
                            <div class="product-info mt-2">
                                <h6 class="text-uppercase">{{ $product->nama }}</h6>
                                <p class="price small">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="testimonial py-5 bg-light">
        <div class="container">
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- Testimonial 1 -->
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="testimonial-content">
                                    <p class="font-italic">"Habitant aliquet sed suspendisse lectus sit gravida sit morbi augue. Porta cursus diam sit velit mi. Maecenas scelerisque tellus nulla sit vitae amet morbi platea blandit vestibulum dignissim."</p>
                                    <p class="customer-name">SARAH ANDERSON</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 2 -->
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="testimonial-content">
                                    <p class="font-italic">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo."</p>
                                    <p class="customer-name">JASON SMITH</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Previous Button -->
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                </button>
                
                <!-- Next Button -->
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <div class="container-fluid mt-5 p-0" id="pages-section">
        <div class="grid-container">
            @php $count = 0; @endphp
            @foreach($categories as $category)
                @php $count++; @endphp
                
                @if($count == 1)
                    <!-- First image (Filter Coffee) -->
                    <div class="grid-item">
                        <img src="{{ asset('storage/' . $category->gambar) }}" alt="{{ $category->nama }}">
                    </div>
                    
                    <!-- First text (Instant Coffee) -->
                    <div class="grid-item text-item">
                        <div class="text-container">
                            <h3 class="category-title">{{ strtoupper($category->nama) }}</h3>
                            <p class="category-text">{{ $category->deskripsi }}</p>
                            <a href="#" class="shop-category">SHOP CATEGORY</a>
                        </div>
                    </div>
                @elseif($count == 2)
                    <!-- Second image (Coffee Makers) -->
                    <div class="grid-item">
                        <img src="{{ asset('storage/' . $category->gambar) }}" alt="{{ $category->nama }}">
                    </div>
                    
                    <!-- Second text (Coffee Makers Text) -->
                    <div class="grid-item text-item">
                        <div class="text-container">
                            <h3 class="category-title">{{ strtoupper($category->nama) }}</h3>
                            <p class="category-text">{{ $category->deskripsi }}</p>
                            <a href="#" class="shop-category">SHOP CATEGORY</a>
                        </div>
                    </div>
                @elseif($count == 3)
                    <!-- Third text (Coffee Accessories Text) -->
                    <div class="grid-item text-item">
                        <div class="text-container">
                            <h3 class="category-title">{{ strtoupper($category->nama) }}</h3>
                            <p class="category-text">{{ $category->deskripsi }}</p>
                            <a href="#" class="shop-category">SHOP CATEGORY</a>
                        </div>
                    </div>
                    
                    <!-- Third image (Coffee Accessories Image) -->
                    <div class="grid-item">
                        <img src="{{ asset('storage/' . $category->gambar) }}" alt="{{ $category->nama }}">
                    </div>
                @elseif($count == 4)
                    <!-- Fourth text (Gift Sets Text) -->
                    <div class="grid-item text-item">
                        <div class="text-container">
                            <h3 class="category-title">{{ strtoupper($category->nama) }}</h3>
                            <p class="category-text">{{ $category->deskripsi }}</p>
                            <a href="#" class="shop-category">SHOP CATEGORY</a>
                        </div>
                    </div>
                    
                    <!-- Fourth image (Gift Sets Image) -->
                    <div class="grid-item">
                        <img src="{{ asset('storage/' . $category->gambar) }}" alt="{{ $category->nama }}">
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- New Arrivals & Best Selling -->
    <section class="featured-products mt-5 py-5">
        <div class="container">
            <div class="row">
                <!-- New Arrivals -->
                <div class="col-md-6">
                    <h3 class="text-uppercase mb-4">NEW ARRIVALS</h3>
                    @foreach($newArrivals as $product)
                    <div class="product-list-item d-flex align-items-center mb-3">
                        <div class="product-img mr-3">
                            <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <div class="product-info flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-uppercase mb-0">{{ $product->nama }}</h6>
                                <p class="price mb-0">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                            </div>
                            <p class="small text-muted">{{ $product->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                    <p class="text-uppercase font-weight-bold mt-3">
                        <a href="" class="text-dark">VIEW ALL</a>
                    </p>
                </div>

                <!-- Best Selling -->
                <div class="col-md-6">
                    <h3 class="text-uppercase mb-4">BEST SELLING</h3>
                    @foreach($bestSelling as $product)
                    <div class="product-list-item d-flex align-items-center mb-3">
                        <div class="product-img mr-3">
                            <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <div class="product-info flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-uppercase mb-0">{{ $product->nama }}</h6>
                                <p class="price mb-0">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                            </div>
                            <p class="small text-muted">{{ $product->order_items_count }} sold</p>
                        </div>
                    </div>
                    @endforeach
                    <p class="text-uppercase font-weight-bold mt-3">
                        <a href="" class="text-dark">VIEW ALL</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Subscribe Section -->
    <section class="subscribe-section mt-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="subscribe-title">SUBSCRIBE US</h2>
                    <p class="subscribe-text">Subscribe to our newsletter to discover cookies and updates.</p>
                    <form class="subscribe-form">
                        <div class="input-wrapper">
                            <input type="email" class="subscribe-input" placeholder="Write your email address here...">
                            <button class="subscribe-btn" type="submit">SUBSCRIBE</button>
                        </div>
                    </form>                    
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section mt-5 py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 text-center feature-box">
                    <i class="fas fa-shipping-fast feature-icon"></i>
                    <h5>QUICK DELIVERY</h5>
                    <p>Fast delivery within 24 hours</p>
                </div>
                <div class="col-md-3 text-center feature-box">
                    <i class="fas fa-store feature-icon"></i>
                    <h5>PICKUP IN STORE</h5>
                    <p>Buy online, pick up in store</p>
                </div>
                <div class="col-md-3 text-center feature-box">
                    <i class="fas fa-box-open feature-icon"></i>
                    <h5>NO SHIPPING CHARGE</h5>
                    <p>Free shipping on orders over</p>
                </div>
                <div class="col-md-3 text-center feature-box">
                    <i class="fas fa-headset feature-icon"></i>
                    <h5>FRIENDLY SERVICE</h5>
                    <p>24/7 customer support</p>
                </div>
            </div>
        </div>
    </section>      

    <!-- Blog Posts Section -->
    <section class="blog-section py-5" id="blog-section">
        <div class="container">
            <div class="section-header d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-uppercase fw-bold">READ OUR BLOGS</h2>
                <a href="" class="read-more text-uppercase">READ BLOG POSTS</a>
            </div>
            
            <div class="row align-items-start">
                <div class="col-md-4">
                    <div class="blog-card mb-4">
                        <a href="">
                            <div class="blog-image-container">
                                <img src="{{ asset('images/blog1.jpg') }}" alt="Blog 1" class="img-fluid rounded">
                            </div>
                        </a>
                        <div class="blog-info mt-3">
                            <h5 class="blog-title text-uppercase">WHAT IS THE BEST COFFEE?</h5>
                            <p class="blog-excerpt">Discover why Arabica, Ethiopian, and Kenyan Bourbon are local favorites in our menu. Sign up now to prefer one for the day.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="blog-card mb-4">
                        <a href="">
                            <div class="blog-image-container-extended">
                                <img src="{{ asset('images/blog2.jpg') }}" alt="Blog 2" class="img-fluid rounded">
                            </div>
                        </a>
                        <div class="blog-info mt-3">
                            <h5 class="blog-title text-uppercase">HOW COFFEE WORKS FOR YOUR BODY</h5>
                            <p class="blog-excerpt">Learn how caffeine affects mental energy, physical endurance, and aids body in overcoming fatigue from hectic daily routines.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="blog-card mb-4">
                        <a href="">
                            <div class="blog-image-container">
                                <img src="{{ asset('images/blog3.jpg') }}" alt="Blog 3" class="img-fluid rounded">
                            </div>
                        </a>
                        <div class="blog-info mt-3">
                            <h5 class="blog-title text-uppercase">CUP OF COFFEE FOR YOUR HAPPINESS</h5>
                            <p class="blog-excerpt">A delicious coffee can create a great mood. Discover different ways coffee influences your day-to-day mood to be more positive.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection