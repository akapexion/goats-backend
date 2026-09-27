@extends("base")

@section('title', 'FreshFind - Home')

@section("main")

     
    <!-- Hero Section -->
    <main class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">

            <!-- Top Badge -->
            <div class="hero-badge">
                <span class="badge-icon">🌿</span>
                <span>Fresh • Local • Trusted</span>
            </div>

            <!-- Main Headline -->
            <h1 class="hero-title">
                Fresh Finds. Local Farmers.<br>
                <span class="highlight-text">Better Living.</span>
            </h1>

            <p class="hero-subtitle">
                Discover fresh, local produce and connect with farmers near you.
            </p>

            <!-- Search Bar -->
            <div class="search-container">
                <span class="material-symbols-outlined search-icon">search</span>
                <input type="text" placeholder="Search fresh produce, farmers or nearby markets..."
                    class="search-input">
            </div>

            <!-- Quick Action Chips -->
            <div class="chips-group">
                <button class="chip-btn">
                    <span class="material-symbols-outlined">location_on</span>
                    Nearby Markets
                </button>
                <button class="chip-btn">
                    <span class="material-symbols-outlined">nutrition</span>
                    Fresh Produce
                </button>
                <button class="chip-btn">
                    <span class="material-symbols-outlined">auto_awesome</span>
                    This Week
                </button>
            </div>

        </div>
    </main>

    <!-- How It Works / Steps Section -->
    <section class="features-section">
        <div class="features-container">

            <!-- Section Header -->
            <div class="features-header">
                <span class="sub-badge">EGREEN BASKET</span>
                <h2>Everything fresh, right around you.</h2>
                <p>Discover local farmers, browse weekly stock and reserve fresh items for pickup.</p>
            </div>

            <!-- Feature Cards Grid -->
            <div class="features-grid">

                <!-- Card 01 -->
                <div class="feature-card">
                    <span class="step-number">01</span>
                    <div class="card-icon-box">
                        <span class="icon">📍</span>
                    </div>
                    <h3>Find Nearby Markets</h3>
                    <p>Explore local markets and farmers by area, day and pickup time.</p>
                    <a href="#" class="feature-link">Explore markets &rarr;</a>
                    <div class="bg-shape"></div>
                </div>

                <!-- Card 02 -->
                <div class="feature-card">
                    <span class="step-number">02</span>
                    <div class="card-icon-box">
                        <span class="icon">🥕</span>
                    </div>
                    <h3>Choose Fresh Produce</h3>
                    <p>Search products by category and check price, unit and farmer information.</p>
                    <a href="#" class="feature-link">Browse produce &rarr;</a>
                    <div class="bg-shape"></div>
                </div>

                <!-- Card 03 -->
                <div class="feature-card">
                    <span class="step-number">03</span>
                    <div class="card-icon-box">
                        <span class="icon">🧺</span>
                    </div>
                    <h3>Reserve for Pickup</h3>
                    <p>Add products to your cart and collect your order directly from the market.</p>
                    <a href="#" class="feature-link">Start shopping &rarr;</a>
                    <div class="bg-shape"></div>
                </div>

            </div>

        </div>
    </section>

    <!-- Category Grid Section -->
    <section class="categories-section">
        <div class="container">

            <!-- Section Header -->
            <div class="section-header">
                <h2>What are you cooking today?</h2>
                <p>Fresh essentials for every Pakistani kitchen.</p>
            </div>

            <!-- Category Grid -->
            <div class="category-grid">

                <!-- Card 1 -->
                <div class="category-card">
                    <img src="{{ asset("images/1.jpg") }}" alt="Leafy Greens" class="card-img">
                    <div class="card-overlay"></div>
                    <div class="card-content">
                        <div class="card-text">
                            <h3>Leafy Greens</h3>
                            <span>3 products</span>
                        </div>
                        <button class="arrow-btn" aria-label="View Category">→</button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="category-card">
                    <img src="{{ asset("images/2.jpg") }}" alt="Root Vegetables" class="card-img">
                    <div class="card-overlay"></div>
                    <div class="card-content">
                        <div class="card-text">
                            <h3>Root Vegetables</h3>
                            <span>4 products</span>
                        </div>
                        <button class="arrow-btn" aria-label="View Category">→</button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="category-card">
                    <img src="{{ asset("images/3.jpg") }}" alt="Tomatoes & Onions" class="card-img">
                    <div class="card-overlay"></div>
                    <div class="card-content">
                        <div class="card-text">
                            <h3>Tomatoes & Onions</h3>
                            <span>4 products</span>
                        </div>
                        <button class="arrow-btn" aria-label="View Category">→</button>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="category-card">
                    <img src="{{ asset("images/4.jpg") }}" alt="Green Vegetables" class="card-img">
                    <div class="card-overlay"></div>
                    <div class="card-content">
                        <div class="card-text">
                            <h3>Green Vegetables</h3>
                            <span>5 products</span>
                        </div>
                        <button class="arrow-btn" aria-label="View Category">→</button>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="category-card">
                    <img src="{{ asset("images/5.jpg") }}" alt="Herbs" class="card-img">
                    <div class="card-overlay"></div>
                    <div class="card-content">
                        <div class="card-text">
                            <h3>Herbs</h3>
                            <span>5 products</span>
                        </div>
                        <button class="arrow-btn" aria-label="View Category">→</button>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="category-card">
                    <img src="{{ asset("images/6.jpg") }}" alt="Salad Essentials" class="card-img">
                    <div class="card-overlay"></div>
                    <div class="card-content">
                        <div class="card-text">
                            <h3>Salad Essentials</h3>
                            <span>3 products</span>
                        </div>
                        <button class="arrow-btn" aria-label="View Category">→</button>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Popular Local Products Section -->
    <section class="products-section">
        <div class="products-container">

            <!-- Section Header -->
            <div class="products-header">
                <span class="sub-badge">WEEKLY PICKS</span>
                <h2>Popular Local Products</h2>
                <p>Fresh products from our demo farmers.</p>
                <a href="#" class="view-all-link">View all products</a>
            </div>

            <!-- Product Cards Grid -->
            <div class="products-grid">

                <!-- Product Card 1 -->
                <div class="product-card">
                    <div class="card-image-box">
                        <img src="https://images.unsplash.com/photo-1576045057995-568f588f82fb?q=80&w=600" alt="Spinach"
                            class="product-img">
                        <span class="status-badge">Fresh</span>
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <span class="material-symbols-outlined">favorite</span>
                        </button>
                    </div>
                    <div class="card-details">
                        <span class="category-tag">VEGETABLES</span>
                        <h3 class="product-title">Fresh Organic Spinach</h3>
                        <div class="farm-info">
                            <span class="farm-icon">🌱</span>
                            <span class="farm-name">Green Valley Farm</span>
                        </div>
                        <div class="rating-box">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">(4.8)</span>
                        </div>
                        <div class="card-footer">
                            <div class="price-box">
                                <span class="price">$3.99</span>
                                <span class="unit">/ kg</span>
                            </div>
                            <a href="#" class="view-details-btn">View Details &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="product-card">
                    <div class="card-image-box">
                        <img src="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?q=80&w=600"
                            alt="Tomatoes" class="product-img">
                        <span class="status-badge">Fresh</span>
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <span class="material-symbols-outlined">favorite</span>
                        </button>
                    </div>
                    <div class="card-details">
                        <span class="category-tag">VEGETABLES</span>
                        <h3 class="product-title">Fresh Red Tomatoes</h3>
                        <div class="farm-info">
                            <span class="farm-icon">🌱</span>
                            <span class="farm-name">Sunrise Organics</span>
                        </div>
                        <div class="rating-box">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">(4.9)</span>
                        </div>
                        <div class="card-footer">
                            <div class="price-box">
                                <span class="price">$2.49</span>
                                <span class="unit">/ kg</span>
                            </div>
                            <a href="#" class="view-details-btn">View Details &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="product-card">
                    <div class="card-image-box">
                        <img src="https://images.unsplash.com/photo-1518977676601-b53f82aba655?q=80&w=600"
                            alt="Potatoes" class="product-img">
                        <span class="status-badge">Fresh</span>
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <span class="material-symbols-outlined">favorite</span>
                        </button>
                    </div>
                    <div class="card-details">
                        <span class="category-tag">ROOTS</span>
                        <h3 class="product-title">Organic Farm Potatoes</h3>
                        <div class="farm-info">
                            <span class="farm-icon">🌱</span>
                            <span class="farm-name">Highland Acres</span>
                        </div>
                        <div class="rating-box">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">(4.7)</span>
                        </div>
                        <div class="card-footer">
                            <div class="price-box">
                                <span class="price">$1.99</span>
                                <span class="unit">/ kg</span>
                            </div>
                            <a href="#" class="view-details-btn">View Details &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 4 -->
                <div class="product-card">
                    <div class="card-image-box">
                        <img src="https://images.unsplash.com/photo-1604977042946-1eecc30f269e?q=80&w=600"
                            alt="Cucumbers" class="product-img">
                        <span class="status-badge">Fresh</span>
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <span class="material-symbols-outlined">favorite</span>
                        </button>
                    </div>
                    <div class="card-details">
                        <span class="category-tag">SALAD</span>
                        <h3 class="product-title">Crisp Green Cucumbers</h3>
                        <div class="farm-info">
                            <span class="farm-icon">🌱</span>
                            <span class="farm-name">Valley Fresh</span>
                        </div>
                        <div class="rating-box">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">(4.6)</span>
                        </div>
                        <div class="card-footer">
                            <div class="price-box">
                                <span class="price">$2.10</span>
                                <span class="unit">/ kg</span>
                            </div>
                            <a href="#" class="view-details-btn">View Details &rarr;</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Popular Local Products Section -->
    <section class="products-section">
        <div class="products-container">

            <!-- Section Header -->

            <!-- Product Cards Grid -->
            <div class="products-grid">

                <!-- Product Card 1 -->
                <div class="product-card">
                    <div class="card-image-box">
                        <img src="https://images.unsplash.com/photo-1576045057995-568f588f82fb?q=80&w=600" alt="Spinach"
                            class="product-img">
                        <span class="status-badge">Fresh</span>
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <span class="material-symbols-outlined">favorite</span>
                        </button>
                    </div>
                    <div class="card-details">
                        <span class="category-tag">VEGETABLES</span>
                        <h3 class="product-title">Fresh Organic Spinach</h3>
                        <div class="farm-info">
                            <span class="farm-icon">🌱</span>
                            <span class="farm-name">Green Valley Farm</span>
                        </div>
                        <div class="rating-box">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">(4.8)</span>
                        </div>
                        <div class="card-footer">
                            <div class="price-box">
                                <span class="price">$3.99</span>
                                <span class="unit">/ kg</span>
                            </div>
                            <a href="#" class="view-details-btn">View Details &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="product-card">
                    <div class="card-image-box">
                        <img src="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?q=80&w=600"
                            alt="Tomatoes" class="product-img">
                        <span class="status-badge">Fresh</span>
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <span class="material-symbols-outlined">favorite</span>
                        </button>
                    </div>
                    <div class="card-details">
                        <span class="category-tag">VEGETABLES</span>
                        <h3 class="product-title">Fresh Red Tomatoes</h3>
                        <div class="farm-info">
                            <span class="farm-icon">🌱</span>
                            <span class="farm-name">Sunrise Organics</span>
                        </div>
                        <div class="rating-box">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">(4.9)</span>
                        </div>
                        <div class="card-footer">
                            <div class="price-box">
                                <span class="price">$2.49</span>
                                <span class="unit">/ kg</span>
                            </div>
                            <a href="#" class="view-details-btn">View Details &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="product-card">
                    <div class="card-image-box">
                        <img src="https://images.unsplash.com/photo-1518977676601-b53f82aba655?q=80&w=600"
                            alt="Potatoes" class="product-img">
                        <span class="status-badge">Fresh</span>
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <span class="material-symbols-outlined">favorite</span>
                        </button>
                    </div>
                    <div class="card-details">
                        <span class="category-tag">ROOTS</span>
                        <h3 class="product-title">Organic Farm Potatoes</h3>
                        <div class="farm-info">
                            <span class="farm-icon">🌱</span>
                            <span class="farm-name">Highland Acres</span>
                        </div>
                        <div class="rating-box">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">(4.7)</span>
                        </div>
                        <div class="card-footer">
                            <div class="price-box">
                                <span class="price">$1.99</span>
                                <span class="unit">/ kg</span>
                            </div>
                            <a href="#" class="view-details-btn">View Details &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 4 -->
                <div class="product-card">
                    <div class="card-image-box">
                        <img src="https://images.unsplash.com/photo-1604977042946-1eecc30f269e?q=80&w=600"
                            alt="Cucumbers" class="product-img">
                        <span class="status-badge">Fresh</span>
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <span class="material-symbols-outlined">favorite</span>
                        </button>
                    </div>
                    <div class="card-details">
                        <span class="category-tag">SALAD</span>
                        <h3 class="product-title">Crisp Green Cucumbers</h3>
                        <div class="farm-info">
                            <span class="farm-icon">🌱</span>
                            <span class="farm-name">Valley Fresh</span>
                        </div>
                        <div class="rating-box">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">(4.6)</span>
                        </div>
                        <div class="card-footer">
                            <div class="price-box">
                                <span class="price">$2.10</span>
                                <span class="unit">/ kg</span>
                            </div>
                            <a href="#" class="view-details-btn">View Details &rarr;</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
    
    <!-- Call To Action Section -->
    <section class="cta-section">
        <div class="cta-container">
            <div class="cta-card">

                <!-- Text Content -->
                <div class="cta-content">
                    <span class="cta-badge">START LOCAL</span>
                    <h2 class="cta-title">Ready to explore your local market?</h2>
                    <p class="cta-description">
                        Browse markets, compare products and choose your preferred pickup location.
                    </p>
                </div>

                <!-- Action Button -->
                <div class="cta-action">
                    <a href="#" class="cta-btn">Explore Markets &rarr;</a>
                </div>

            </div>
        </div>
    </section>

@endsection

@push("style")
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@push("js")
    <script src="{{ asset('js/script.js') }}"></script>
@endpush