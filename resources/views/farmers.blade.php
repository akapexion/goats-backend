@extends("base")

@section('title', 'FreshFind - Farmers')

@section("main")

  <section class="farmers-hero">
    <div class="farmers-hero-content">
      <span class="hero-badge"><i class="fa-solid fa-seedling"></i> LOCAL FARMERS</span>
      <h1 id="pageTitle">Farmers at this Market</h1>
      <p id="pageDescription">Meet the local farmers and explore their shops.</p>
      <a href="market.html" class="back-link"><i class="fa-solid fa-arrow-left"></i> Back to Markets</a>
    </div>
  </section>

  <main class="farmers-page">
    <div class="market-info">
      <div>
        <span class="section-label">MARKET FARMERS</span>
        <h2 id="marketName">Market Farmers</h2>
      </div>
      <span class="farmer-count" id="farmerCount">0 Farmers</span>
    </div>

    <section class="farmer-grid" id="farmerGrid">
      
    </section>
  </main>

@endsection

@push("style")
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/farmers.css') }}">
@endpush

@push("js")
    <script src="{{ asset('js/farmers.js') }}"></script>
@endpush