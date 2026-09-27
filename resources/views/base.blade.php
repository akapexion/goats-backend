<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>@yield('title', 'FreshFind')</title>

    <!-- Google Fonts & Material Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- CSS Stylesheet -->
    
    @stack("style")
</head>

<body>

    <!-- Sticky Navbar -->
    <header class="navbar">
        <div class="nav-container">

            <!-- Brand Logo -->
            <a href="#" class="brand-logo">
                <span class="logo-icon">🌿</span>
                <span class="logo-text">FreshFind</span>
            </a>

            <!-- Navigation Links -->
            <nav class="nav-links" id="navLinks">
                <a href="{{ route("index") }}" class="nav-link active">Home</a>
                <a href="{{ route("market") }}" class="nav-link">Markets</a>
                <a href="{{ route("products") }}" class="nav-link">Products</a>
                <a href="#" class="nav-link">Produce Guide</a>
                <a href="#" class="nav-link">About</a>
                <a href="#" class="nav-link">Contact</a>
            </nav>

            <!-- User Actions & Toggle -->
            <div class="nav-actions">

                <!-- Wishlist / Favorite Icon -->
                <a href="#" class="icon-btn" aria-label="Favorites">
                    <span class="material-symbols-outlined">favorite</span>
                    <span class="badge">2</span>
                </a>

                <!-- Cart Icon -->
                <a href="#" class="icon-btn" aria-label="Cart">
                    <span class="material-symbols-outlined">shopping_cart</span>
                    <span class="badge">3</span>
                </a>

                <!-- Auth Buttons -->
                <div class="auth-buttons">
                    <a href="#" class="btn-login">Login</a>
                    <a href="#" class="btn-signup">Sign Up</a>
                </div>

                <!-- Mobile Menu Toggle Button -->
                <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">
                    <span class="material-symbols-outlined" id="toggleIcon">menu</span>
                </button>

            </div>

        </div>
    </header>

    
    @yield("main")


    <!-- Footer Section -->
    <footer class="site-footer">
        <div class="footer-container">

            <!-- Top Footer: Brand Info & Newsletter -->
            <div class="footer-top">

                <!-- Brand & About -->
                <div class="footer-brand">
                    <a href="#" class="footer-logo">
                        <span class="logo-icon">🌿</span>
                        <span class="logo-text">FreshFind</span>
                    </a>
                    <p class="brand-desc">
                        Connecting you directly with local farmers for fresh, organic, and daily kitchen essentials.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-icon" aria-label="Facebook">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="social-icon" aria-label="Instagram">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#" class="social-icon" aria-label="Twitter">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.936 9.936 0 0024 4.59z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links Column 1 -->
                <div class="footer-col">
                    <h4 class="col-title">Navigation</h4>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Markets</a></li>
                        <li><a href="#">Produce Guide</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>

                <!-- Quick Links Column 2 -->
                <div class="footer-col">
                    <h4 class="col-title">Categories</h4>
                    <ul class="footer-links">
                        <li><a href="#">Leafy Greens</a></li>
                        <li><a href="#">Root Vegetables</a></li>
                        <li><a href="#">Fresh Herbs</a></li>
                        <li><a href="#">Salad Essentials</a></li>
                        <li><a href="#">Weekly Deals</a></li>
                    </ul>
                </div>

                <!-- Newsletter Column -->
                <div class="footer-newsletter">
                    <h4 class="col-title">Stay Updated</h4>
                    <p>Subscribe to get weekly updates on fresh stocks and market deals.</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault();">
                        <input type="email" placeholder="Enter your email address" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>

            </div>

            <hr class="footer-divider">

            <!-- Bottom Footer: Copyright & Legal -->
            <div class="footer-bottom">
                <p class="copyright">&copy; 2026 FreshFind. All rights reserved.</p>
                <div class="legal-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>

        </div>
    </footer>
    
    @stack("js")

</body>

</html>