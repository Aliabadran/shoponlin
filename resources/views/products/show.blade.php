
@extends('admin.layout.head')
@section('title') Product  Details @endsection
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    @notifyCss

<body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.layout.sidebar')

      <!-- partial:partials/_navbar.html -->
        <div class="container-fluid page-body-wrapper">
           <div class="main-panel">
           <div class="panel-body">
            <div class="content-wrapper">
              @include('admin.layout.header')
                    <div class="container mt-5">
                       <div class="row">
                        <div class="col-md-12">

                            @if ($errors->any())
                            <ul class="alert alert-warning">
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                            @endif

             <div class="card">
               <div class="card-header">
                 <h4>Product Details
                 <br>
                 </h4>
                 </div>
                 <div class="card-body">
                     <div class="card" style="width: 23rem;">
                           <div class="mb-3">
                              @if ($product->photo)
                            <p><strong>Photo:</strong></p>
                          <div class="product-image">
                            @if ($product->photo)
                            <img src="{{ asset('storage/' . $product->photo) }}" alt="Photo" width="100">
                        @endif  </div>
                             @endif
                             </div>
                             <div class="card-body">
                            <h2 class="card-title"> <p><strong>Name:</strong> {{ $product->name }}</p> </h2>
                            <p class="card-text">
                            <div class="mb-3">
                           <p><strong>Description:</strong> {{ $product->description}}</p>
                           </div></p>
                           <div class="mb-3">
                            <p><strong>Category:</strong> {{ $product->category->name }}</p>
                            </div></p>
                           <p class="card-number">
                            <div class="mb-3">
                           <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                           </div></p>
                           <p class="card-number">
                            <div class="mb-3">
                           <p><strong>Discount :</strong> {{ number_format($product->discount, 2) }}%</p>
                           <p><strong>Price After Discount:</strong> ${{ number_format($product->priceAfterDiscount(), 2) }}</p>

                        </div></p>


                               <p class="card-number">
                            <div class="mb-3">
                           <p><strong>Quantity :</strong> {{ $product->quantity  }}</p>
                           </div></p>


                          <a href="{{ url('products') }}" class="btn btn-info float-end">  Back to List </a>
                          </div>
                           </div>

                   </div>


               </div>
           </div>
           </div>
        </div>
     </div>
     </div>
    </div>
  </div>
</div>
@include('notify::components.notify')
@notifyJs
   @include('admin.layout.footer')
    </body>
