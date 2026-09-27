@extends("base")

@section('title', 'FreshFind - Products')

@section("main")

<section class="products-hero">
  <div class="hero-inner">
    <p class="hero-kicker">FRESH &amp; LOCAL</p>
    <h1>Our Products</h1>
    <p>Discover fresh, organic and locally grown products from trusted farmers.</p>
    <div class="breadcrumb"><span class="material-symbols-outlined">home</span> Home <span>›</span> Products</div>
  </div>
</section>

<main class="products-wrap">
  <aside class="filter-panel">
    <div class="filter-title"><span class="material-symbols-outlined">filter_alt</span> Filter Products</div>

    <div class="filter-group">
      <div class="filter-heading">Categories <span class="material-symbols-outlined">expand_less</span></div>
      <button class="side-filter active" data-category="all"><span><span class="material-symbols-outlined">grid_view</span>All Products</span><b>24</b></button>
      <button class="side-filter" data-category="vegetables"><span><span class="material-symbols-outlined">eco</span>Vegetables</span><b>8</b></button>
      <button class="side-filter" data-category="fruits"><span><span class="material-symbols-outlined">nutrition</span>Fruits</span><b>6</b></button>
      <button class="side-filter" data-category="grains"><span><span class="material-symbols-outlined">grain</span>Grains</span><b>4</b></button>
      <button class="side-filter" data-category="dairy"><span><span class="material-symbols-outlined">local_drink</span>Dairy</span><b>3</b></button>
      <button class="side-filter" data-category="herbs"><span><span class="material-symbols-outlined">grass</span>Herbs</span><b>2</b></button>
      <button class="side-filter" data-category="others"><span><span class="material-symbols-outlined">category</span>Others</span><b>1</b></button>
    </div>

    <div class="filter-group">
      <div class="filter-heading">Price Range <span class="material-symbols-outlined">expand_less</span></div>
      <label class="radio-row"><input type="radio" name="price" value="all" checked> <span>All Prices</span></label>
      <label class="radio-row"><input type="radio" name="price" value="0-5"> <span>$0 - $5</span></label>
      <label class="radio-row"><input type="radio" name="price" value="5-10"> <span>$5 - $10</span></label>
      <label class="radio-row"><input type="radio" name="price" value="10-20"> <span>$10 - $20</span></label>
      <label class="radio-row"><input type="radio" name="price" value="20"> <span>$20+</span></label>
    </div>

    <div class="filter-group">
      <div class="filter-heading">Rating <span class="material-symbols-outlined">expand_less</span></div>
      <button class="rating-row" data-rating="5"><span>★★★★★</span><em>5 Stars</em><b>12</b></button>
      <button class="rating-row" data-rating="4"><span>★★★★</span><em>4 Stars &amp; Up</em><b>8</b></button>
      <button class="rating-row" data-rating="3"><span>★★★</span><em>3 Stars &amp; Up</em><b>5</b></button>
      <button class="rating-row" data-rating="2"><span>★★</span><em>2 Stars &amp; Up</em><b>2</b></button>
      <button class="rating-row" data-rating="1"><span>★</span><em>1 Star &amp; Up</em><b>1</b></button>
    </div>

    <button class="reset-btn" id="resetFilters"><span class="material-symbols-outlined">refresh</span> Reset Filters</button>
  </aside>

  <section class="products-content">
    <div class="top-controls">
      <div class="search-box">
        <input id="productSearch" type="search" placeholder="Search for products...">
        <button id="searchButton" aria-label="Search"><span class="material-symbols-outlined">search</span></button>
      </div>
      <div class="sort-box"><label for="sortProducts">Sort by:</label><select id="sortProducts"><option value="featured">Featured</option><option value="price-low">Price: Low to High</option><option value="price-high">Price: High to Low</option><option value="name">Name</option></select></div>
    </div>

    <div class="product-grid" id="productGrid">
      <article class="product-card" data-name="Fresh Organic Spinach" data-category="vegetables" data-price="3.99" data-rating="4.8">
        <div class="card-image"><img src="images/1.jpg" alt="Fresh Organic Spinach"><span class="fresh-badge">Fresh</span><button class="heart-btn"><span class="material-symbols-outlined">favorite</span></button></div>
        <div class="card-body"><p class="category">VEGETABLES</p><h2>Fresh Organic Spinach</h2><p class="farmer"><span>🌱</span> Green Valley Farm</p><div class="rating"><span>★★★★★</span><small>(4.8)</small></div><div class="card-footer"><div class="price">$3.99 <small>/kg</small></div><button class="details-btn">View Details →</button></div></div>
      </article>

      <article class="product-card" data-name="Fresh Tomatoes" data-category="vegetables" data-price="2.49" data-rating="4.6">
        <div class="card-image"><img src="images/3.jpg" alt="Fresh Tomatoes"><span class="fresh-badge">Fresh</span><button class="heart-btn"><span class="material-symbols-outlined">favorite</span></button></div>
        <div class="card-body"><p class="category">VEGETABLES</p><h2>Fresh Tomatoes</h2><p class="farmer"><span>🌱</span> Sunny Fields Farm</p><div class="rating"><span>★★★★★</span><small>(4.6)</small></div><div class="card-footer"><div class="price">$2.49 <small>/kg</small></div><button class="details-btn">View Details →</button></div></div>
      </article>

      <article class="product-card" data-name="Organic Carrots" data-category="vegetables" data-price="2.99" data-rating="4.7">
        <div class="card-image"><img src="images/4.jpg" alt="Organic Carrots"><span class="fresh-badge">Organic</span><button class="heart-btn"><span class="material-symbols-outlined">favorite</span></button></div>
        <div class="card-body"><p class="category">VEGETABLES</p><h2>Organic Carrots</h2><p class="farmer"><span>🌱</span> Happy Harvest Farm</p><div class="rating"><span>★★★★★</span><small>(4.7)</small></div><div class="card-footer"><div class="price">$2.99 <small>/kg</small></div><button class="details-btn">View Details →</button></div></div>
      </article>

      <article class="product-card" data-name="Fresh Apples" data-category="fruits" data-price="1.99" data-rating="4.5">
        <div class="card-image"><img src="images/3.jpg" alt="Fresh Apples"><span class="fresh-badge">Fresh</span><button class="heart-btn"><span class="material-symbols-outlined">favorite</span></button></div>
        <div class="card-body"><p class="category">FRUITS</p><h2>Fresh Apples</h2><p class="farmer"><span>🌱</span> Riverside Farm</p><div class="rating"><span>★★★★★</span><small>(4.5)</small></div><div class="card-footer"><div class="price">$1.99 <small>/kg</small></div><button class="details-btn">View Details →</button></div></div>
      </article>

      <article class="product-card" data-name="Organic Blueberries" data-category="fruits" data-price="4.99" data-rating="4.7">
        <div class="card-image"><img src="images/5.jp.webp" alt="Organic Blueberries"><span class="fresh-badge">Organic</span><button class="heart-btn"><span class="material-symbols-outlined">favorite</span></button></div>
        <div class="card-body"><p class="category">FRUITS</p><h2>Organic Blueberries</h2><p class="farmer"><span>🌱</span> Blue Ridge Farm</p><div class="rating"><span>★★★★★</span><small>(4.7)</small></div><div class="card-footer"><div class="price">$4.99 <small>/kg</small></div><button class="details-btn">View Details →</button></div></div>
      </article>

      <article class="product-card" data-name="Fresh Cow Milk" data-category="dairy" data-price="2.99" data-rating="4.6">
        <div class="card-image"><img src="images/1.jpg" alt="Fresh Cow Milk"><span class="fresh-badge">Fresh</span><button class="heart-btn"><span class="material-symbols-outlined">favorite</span></button></div>
        <div class="card-body"><p class="category">DAIRY</p><h2>Fresh Cow Milk</h2><p class="farmer"><span>🌱</span> Meadow Brook Farm</p><div class="rating"><span>★★★★★</span><small>(4.6)</small></div><div class="card-footer"><div class="price">$2.99 <small>/L</small></div><button class="details-btn">View Details →</button></div></div>
      </article>

      <article class="product-card" data-name="Farm Fresh Eggs" data-category="dairy" data-price="3.49" data-rating="4.8">
        <div class="card-image"><img src="images/2.jpg" alt="Farm Fresh Eggs"><span class="fresh-badge">Local</span><button class="heart-btn"><span class="material-symbols-outlined">favorite</span></button></div>
        <div class="card-body"><p class="category">DAIRY</p><h2>Farm Fresh Eggs</h2><p class="farmer"><span>🌱</span> Sunrise Farm</p><div class="rating"><span>★★★★★</span><small>(4.8)</small></div><div class="card-footer"><div class="price">$3.49 <small>/dozen</small></div><button class="details-btn">View Details →</button></div></div>
      </article>

      <article class="product-card" data-name="Fresh Basil" data-category="herbs" data-price="1.49" data-rating="4.5">
        <div class="card-image"><img src="images/5.jpg" alt="Fresh Basil"><span class="fresh-badge">Fresh</span><button class="heart-btn"><span class="material-symbols-outlined">favorite</span></button></div>
        <div class="card-body"><p class="category">HERBS</p><h2>Fresh Basil</h2><p class="farmer"><span>🌱</span> Herb Garden Farm</p><div class="rating"><span>★★★★★</span><small>(4.5)</small></div><div class="card-footer"><div class="price">$1.49 <small>/bunch</small></div><button class="details-btn">View Details →</button></div></div>
      </article>
    </div>

    <div class="pagination"><button>‹</button><button class="active">1</button><button>2</button><button>3</button><button>›</button></div>
    <div class="no-products" id="noProducts"><span class="material-symbols-outlined">search_off</span><h3>No products found</h3><p>Try another search or filter.</p></div>
  </section>
</main>

@endsection

@push("style")
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@push("js")
    <script src="{{ asset('js/products.js') }}"></script>
@endpush

