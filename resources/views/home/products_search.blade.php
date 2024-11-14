
@extends('home.layout.head')

@section('title') Products  Search @endsection
<body>
@include('home.layout.header')
<section class="inner_page_head">
   <div class="container_fuild">
      <div class="row">
         <div class="col-md-12">
            <div class="full">
               <h3>Search Results for "{{ $searchQuery }}"</h3>
            </div>
         </div>
      </div>
   </div>
</section>

<br>
<br>
   <!-- product section -->
   <section class="product_section layout_padding">
    <div class="container">
       <div class="heading_container heading_center">
          <h2>
            Search Results for <span>"{{ $searchQuery }}"</span>
          </h2>

    <!-- Search Form -->
    <form method="GET" action="{{ route('product.search') }}">
        <input type="text" name="query" value="{{ $searchQuery }}" placeholder="Search for products">
        <button type="submit">Search</button>
    </form>

    <a href="{{ route('home') }}" class="btn btn-danger float-end">Back</a>
</div>
    <!-- Display the Products and Their Comments -->
    @if($products->count())
        <ul>
            @foreach($products as $product)
                <li>
                    <h2>{{ $product->name }}</h2>

                    <!-- Display Comments for the Product -->
                    @if($product->comments->count())
                        <h3 style="color: rgb(233, 28, 79)">Comments:</h3>




    @include('home.comments-edit', ['comments' => $product->comments, 'type' => 'product', 'id' => $product->id])



                    @else
                    @include('home.comments-edit', ['comments' => $product->comments, 'type' => 'product', 'id' => $product->id])
                    @endif

                </li>
           <div>
                <a href="{{ route('home.productdetails', $product->id ) }}"  class="btn btn-warning">
                    productDetalails
                    </a></div>
            @endforeach
          <br>
         </ul>

        <!-- Pagination Links -->
        <div>
            {{ $products->appends(['query' => $searchQuery])->links() }}
        </div>
    @else
        <p>No products found.</p>
    @endif
</div>
</div>


        </div>
</div>
@include('home.layout.footerPage')


</body>
