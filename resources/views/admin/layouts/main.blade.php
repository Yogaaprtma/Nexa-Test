<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Beanie Coffee Shop Admin Dashboard">
    <title>@yield('title', 'Admin Dashboard') | Beanie</title>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6c3f20;
            --secondary-color: #a67c52;
            --light-color: #f5f5f5;
            --dark-color: #343a40;
            --sidebar-width: 250px;
            --sidebar-mini-width: 70px;
            --transition-speed: 0.3s;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1030;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--light-color) !important;
        }
        
        /* Sidebar styling */
        .sidebar {
            position: fixed;
            top: 56px; /* Navbar height */
            left: 0;
            bottom: 0;
            width: var(--sidebar-mini-width);
            background-color: #fff;
            box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1);
            transition: width var(--transition-speed) ease;
            overflow: hidden;
            z-index: 1020;
        }
        
        .sidebar:hover:not(.pinned) {
            width: var(--sidebar-width);
        }
        
        .sidebar.pinned {
            width: var(--sidebar-width);
        }
        
        .sidebar-header {
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
        }
        
        .sidebar-title {
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            opacity: 0;
            transition: opacity var(--transition-speed) ease;
        }
        
        .sidebar:hover .sidebar-title,
        .sidebar.pinned .sidebar-title {
            opacity: 1;
        }
        
        .pin-button {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #aaa;
            cursor: pointer;
            opacity: 0;
            transition: opacity var(--transition-speed) ease;
        }
        
        .sidebar:hover .pin-button,
        .sidebar.pinned .pin-button {
            opacity: 1;
        }
        
        .pin-button.active {
            color: var(--primary-color);
        }
        
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            color: #333;
            padding: 0.75rem 1.25rem;
            border-radius: 0;
            margin: 0.2rem 0;
            transition: all 0.3s;
            white-space: nowrap;
        }
        
        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        .nav-link-text {
            opacity: 0;
            transition: opacity var(--transition-speed) ease;
        }
        
        .sidebar:hover .nav-link-text,
        .sidebar.pinned .nav-link-text {
            opacity: 1;
        }
        
        /* Adjust main content based on sidebar state */
        .main-content {
            margin-left: var(--sidebar-mini-width);
            padding: 20px;
            transition: margin-left var(--transition-speed) ease;
        }
        
        .main-content.shifted {
            margin-left: var(--sidebar-width);
        }
        
        .footer {
            background-color: #fff;
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.05);
            margin-left: var(--sidebar-mini-width);
            transition: margin-left var(--transition-speed) ease;
        }
        
        .footer.shifted {
            margin-left: var(--sidebar-width);
        }
        
        .user-dropdown .dropdown-toggle::after {
            display: none;
        }
        
        .user-dropdown .dropdown-menu {
            right: 0;
            left: auto;
        }
        
        .bg-coffee {
            background-color: var(--primary-color) !important;
        }
        
        .btn-coffee {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .btn-coffee:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        /* Mobile responsiveness */
        @media (max-width: 767.98px) {
            .sidebar {
                width: 0;
            }
            
            .sidebar.mobile-show,
            .sidebar.pinned {
                width: var(--sidebar-width);
            }
            
            .main-content,
            .footer {
                margin-left: 0;
            }
            
            .main-content.shifted,
            .footer.shifted {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-coffee">
        <div class="container-fluid">
            <button id="sidebar-toggle" class="btn btn-link text-white me-2 d-md-none">
                <i class="fas fa-bars"></i>
            </button>
            
            <a class="navbar-brand" href="{{ route('home.admin') }}">
                <i class="fas fa-coffee me-2"></i> Beanie Admin
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown user-dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fs-5 me-2"></i>
                            <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-0">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="d-flex align-items-center">
                    <i class="fas fa-coffee text-primary me-2"></i>
                    <span class="sidebar-title">Beanie Admin</span>
                </div>
                <div class="pin-button" id="pin-sidebar">
                    <i class="fas fa-thumbtack"></i>
                </div>
            </div>
            <div class="mt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home.admin') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('category.page') }}">
                            <i class="fas fa-list"></i>
                            <span class="nav-link-text">Categories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('product.page') }}">
                            <i class="fas fa-coffee"></i>
                            <span class="nav-link-text">Products</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('order.page') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="nav-link-text">Orders</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3">
        <div class="container">
            <span class="text-muted">© {{ date('Y') }} Beanie Coffee Shop. All rights reserved.</span>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        $(document).ready(function() {
            const sidebar = $(".sidebar");
            const mainContent = $(".main-content");
            const footer = $(".footer");
            const pinButton = $("#pin-sidebar");
            const sidebarToggle = $("#sidebar-toggle");
            
            // Toggle pin status
            pinButton.on("click", function(e) {
                e.preventDefault();
                sidebar.toggleClass("pinned");
                pinButton.toggleClass("active");
                mainContent.toggleClass("shifted");
                footer.toggleClass("shifted");
                
                // Store pin state in localStorage
                if (sidebar.hasClass("pinned")) {
                    localStorage.setItem('sidebarPinned', 'true');
                } else {
                    localStorage.setItem('sidebarPinned', 'false');
                }
            });
            
            // Mobile sidebar toggle
            sidebarToggle.on("click", function(e) {
                e.preventDefault();
                sidebar.toggleClass("mobile-show");
            });
            
            // Check if sidebar was pinned from previous session
            if (localStorage.getItem('sidebarPinned') === 'true') {
                sidebar.addClass("pinned");
                pinButton.addClass("active");
                mainContent.addClass("shifted");
                footer.addClass("shifted");
            }
            
            // Close sidebar on mobile when clicking outside
            $(document).on("click", function(e) {
                if ($(window).width() < 768) {
                    if (!$(e.target).closest('.sidebar').length && !$(e.target).closest('#sidebar-toggle').length) {
                        sidebar.removeClass("mobile-show");
                    }
                }
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>