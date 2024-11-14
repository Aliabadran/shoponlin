      <!-- product section -->
      <section class="product_section layout_padding">
         <div class="container">
            <div class="heading_container heading_center">
               <h2>
                  Our <span>products</span>
               </h2>
                  <!-- Search Form -->
        <form method="GET" action="{{ route('product.search') }}">
          <input type="text" name="query" value="" placeholder="Search for products">
          <button type="submit">Search</button>
         </form>
            </div>


            <div class="row">
                @foreach ($products as $product)
               <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="box">
                     <div class="option_container">
                        <div class="options">
                           <a href="{{ route('home.productdetails', $product->id ) }}" class="option1">
                           productDetalails
                           </a>

                           @can('add to cart')
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
                          @endcan
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
            <br>
            <br>
            <span style="padding-top: 20px;"></span>
                  {{  $products->withQueryString()->links('pagination::bootstrap-5') }}
                </span>
                <div class="btn-box">
                    <a href="{{  route('home.product') }}">
                    View All Products
                    </a>
                 </div>
         </div>
      </section>
      <!-- end product section -->
