@extends('home.layout.head')
@notifyCss
@section('title') Products for Category @endsection
<body>
@include('home.layout.header')
<section class="inner_page_head">
   <div class="container_fuild">
      <div class="row">
         <div class="col-md-12">
            <div class="full">
               <h3>  Products for Category</h3>
            </div>
         </div>
      </div>
   </div>
</section>

<section class="product_section layout_padding">
    <div class="container">
       <div class="heading_container heading_center">
          <h2>
            Products for Category: <span> {{ $category->name }}</span>
            <br>
          </h2>
          <a href="{{ url('/') }}" class="btn btn-danger float-end"> Back</a>
       </div>

       @if($category->products->isEmpty())
       <p>No products found in this category.</p>
       @else
       <div class="row">
        @foreach($category->products as $product)
           <div class="col-sm-6 col-md-4 col-lg-4">
              <div class="box">
                 <div class="option_container">
                    <div class="options">
                       <a href="{{ route('home.productdetails', $product->id ) }}" class="option1">
                       productDetalails
                       </a>

                       <form action="{{ url('/cart/add') }}"  method="POST">
                        @csrf
                        <div class="row">
                         <div class="col-md-4">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}" style="width:100px ;background:rgb(112, 133, 190) ">

                          </div>
                         <div class="col-md-4">
                            <input type="Submit" value="Buy Now">
                        </div>
                        </div>
                      </form>
                    </div>
                 </div>


                 <div class="img-box">

                    @if ($product->photo)
                    <img src="{{ asset('storage/' . $product->photo) }}" alt="Photo" width="100">
                   @endif
                 <td>

                 </div>
                 <div class="detail-box">
                    <h5>
                        <td>{{ $product->name }}</td>
                    </h5>
                    @if(number_format($product->discount, 2)!= 0.00)
                    <h6 style="color:crimson">
                        DiscountPrice:
                        <br>
                        <td>${{ number_format($product->priceAfterDiscount(), 2) }}</td>
                     </h6>
                     <h6 style="color:rgb(10, 25, 165)   ;text-decoration:line-through">
                        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    </h6>
                     @else
                    <h6 style="color:rgb(10, 25, 165)  ">
                        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    </h6>
                    @endif
                 </div>
                 <div class="detail-box">
                    <h5>
                        <td>{{ $product->quantity }}</td>
                    </h5>

                 </div>
              </div>
           </div>


       @endforeach
       </div>
       @endif


    </div>
</section>

@include('sweetalert::alert')



@include('notify::components.notify')
@notifyJs


@include('home.layout.footerPage')
