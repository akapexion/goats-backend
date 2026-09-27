@extends("base")

@section('title', 'FreshFind - Market')

@section("main")

<!-- ================= HERO ================= -->

    <section class="hero">

        <div class="hero-content">

            <div class="badge">
                <i class="fa-solid fa-leaf"></i>
                LOCAL MARKETS
            </div>

            <h1>
                Discover Fresh <span>Farmers Markets</span>
            </h1>

            <p>
                Find fresh products, local farmers and nearby markets
                in your area.
            </p>

            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search farmers market...">
                <button>Search</button>
            </div>

        </div>

    </section>


    <!-- ================= MARKET SECTION ================= -->

    <main class="markets">

        <div class="section-heading">
            <div>
                <p class="section-label">EXPLORE</p>
                <h2>Nearby Farmers Markets</h2>
            </div>

            <p class="market-count">
                4 Markets Available
            </p>
        </div>


        <div class="market-grid">

            <!-- CARD 1 -->

            <article class="market-card">

                <div class="card-top">
                    <div class="location-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <span class="open">
                        Open
                    </span>
                </div>

                <h3>Green Valley Market</h3>

                <p class="location">
                    <i class="fa-solid fa-location-dot"></i>
                    Gulshan
                </p>

                <div class="details">

                    <div>
                        <i class="fa-regular fa-calendar"></i>
                        <span>Saturday</span>
                    </div>

                    <div>
                        <i class="fa-regular fa-clock"></i>
                        <span>08:00 AM - 02:00 PM</span>
                    </div>

                    <div>
                        <i class="fa-solid fa-user"></i>
                        <span>Ali Organic Farm</span>
                    </div>

                </div>

                <a class="map-btn" href="{{ route('farmers', ['market' =>'green-valley']) }}">
                    View Farmers
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </article>


            <!-- CARD 2 -->

            <article class="market-card">

                <div class="card-top">
                    <div class="location-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <span class="open">
                        Open
                    </span>
                </div>

                <h3>City Farmers Market</h3>

                <p class="location">
                    <i class="fa-solid fa-location-dot"></i>
                    Clifton
                </p>

                <div class="details">

                    <div>
                        <i class="fa-regular fa-calendar"></i>
                        <span>Sunday</span>
                    </div>

                    <div>
                        <i class="fa-regular fa-clock"></i>
                        <span>09:00 AM - 03:00 PM</span>
                    </div>

                    <div>
                        <i class="fa-solid fa-user"></i>
                        <span>Fresh Roots Farm</span>
                    </div>

                </div>

                <a class="map-btn" href="{{ route('farmers', ['market' =>'city-farmers']) }}">
                    View Farmers
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </article>


            <!-- CARD 3 -->

            <article class="market-card">

                <div class="card-top">
                    <div class="location-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <span class="open">
                        Open
                    </span>
                </div>

                <h3>Saturday Fresh Market</h3>

                <p class="location">
                    <i class="fa-solid fa-location-dot"></i>
                    North Nazimabad
                </p>

                <div class="details">

                    <div>
                        <i class="fa-regular fa-calendar"></i>
                        <span>Saturday</span>
                    </div>

                    <div>
                        <i class="fa-regular fa-clock"></i>
                        <span>07:30 AM - 01:30 PM</span>
                    </div>

                    <div>
                        <i class="fa-solid fa-user"></i>
                        <span>Local Farmers</span>
                    </div>

                </div>

                <a class="map-btn" href="{{ route('farmers', ['market' =>'saturday-fresh']) }}">
                    View Farmers
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </article>


            <!-- CARD 4 -->

            <article class="market-card">

                <div class="card-top">
                    <div class="location-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <span class="open">
                        Open
                    </span>
                </div>

                <h3>Sunday Local Market</h3>

                <p class="location">
                    <i class="fa-solid fa-location-dot"></i>
                    PECHS
                </p>

                <div class="details">

                    <div>
                        <i class="fa-regular fa-calendar"></i>
                        <span>Sunday</span>
                    </div>

                    <div>
                        <i class="fa-regular fa-clock"></i>
                        <span>08:30 AM - 02:30 PM</span>
                    </div>

                    <div>
                        <i class="fa-solid fa-user"></i>
                        <span>Green Roots Farm</span>
                    </div>

                </div>

                 <a class="map-btn" href="{{ route('farmers', ['market' =>'sunday-local']) }}">
                    View Farmers
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </article>

        </div>

    </main>
    
@endsection

@push("style")
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/market.css') }}">
@endpush

@push("js")
    <script src="{{ asset('js/script.js') }}"></script>
@endpush