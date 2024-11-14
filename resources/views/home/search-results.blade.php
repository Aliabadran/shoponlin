
 @extends('home.layout.head')
 @section('title') Search  @endsection
 <body>
 @include('home.layout.header')
 <section class="inner_page_head">
     <div class="container_fuild">
        <div class="row">
           <div class="col-md-12">
              <div class="full">
                 <h3>Search Results for "{{ $query }}"</h3>
              </div>
           </div>
        </div>
     </div>
  </section>

  <div class="container">
    <div class="row">

    @if($results->isEmpty())
        <p>No results found.</p>
    @else
        <ul>
            @foreach($results as $result)
                <li>
                    @if($result instanceof App\Models\Product)
                    <div class="container">
                        <div class="row">
                            <div class="card" style="width: 18rem;">
                                @if ($result->photo)
                                <img src="{{ asset('storage/' . $result->photo) }}" alt="Photo" width="100" class="card-img-top" >
                                @endif
                                <div class="card-body">
                                  <p class="card-text">
                                    <h5 class="card-title">{{ $result->name }}</h5>
                                    <p class="card-text">{{ Str::limit($result->description, 100) }}</p>
                                    <a href="{{ route('home.productdetails', $result->id  ) }}" class="btn btn-info">productDetalails</a>
                                  </p>
                                </div>
                              </div>
                            </div>
                     </div>
                    @elseif($result instanceof App\Models\Category)
                    <div class="container">
                        <div class="row">
                            <div class="card" style="width: 18rem;">
                                @if ($result->photo)
                                <img src="{{ asset('storage/' . $result->photo) }}" alt="Photo" width="100" class="card-img-top" >
                                @endif
                                <div class="card-body">
                                  <p class="card-text">
                                    <h5 class="card-title">{{ $result->name }}</h5>
                                    <p class="card-text">{{ Str::limit($result->description, 100) }}</p>
                                    <a href="{{ route('home.category.products', $result->id  ) }}" class="btn btn-info">View Products</a>
                                  </p>
                                </div>
                              </div>
                            </div>
                     </div>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
    </div>
  </div>
  @include('home.layout.footerPage')



