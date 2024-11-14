
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

<body>

    <section class="product_section layout_padding">
        <div class="container">
           <div class="heading_container heading_center">
              <h2>
                 Our <span>Categories</span>
              </h2>
           </div>



    <div class="container">
        <div class="row">
            @foreach ($categories as $category)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if ($category->photo)
                    <img src="{{ asset('storage/' . $category->photo) }}" alt="Photo" width="100">
                @endif
                <div class="card-body">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="card-text">{{ Str::limit($category->description, 100) }}</p>
                        <a href="{{ route('home.category.products', $category->id  ) }}" class="btn btn-info">View Products</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <br>
    <div class="container">
          <span style="padding-top: 20px;"></span>
          {{  $categories->withQueryString()->links('pagination::bootstrap-5') }}
        </span>
    </div>
    <div class="btn-box">
        <a href="{{  route('home.category') }}">
        View All Categories
        </a>
     </div>
 </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>



