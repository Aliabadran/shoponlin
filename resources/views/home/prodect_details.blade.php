
@extends('home.layout.head')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
   <style>
        .oval-title {
            background-color: #007bff;
            color: white;
            border-radius: 50px;
            padding: 10px 30px;
            display: inline-block;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
    </style>
@notifyCss
@section('title') Products @endsection
<body>
    @include('home.layout.header')
    <section class="inner_page_head">
    <div class="container_fuild">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                <h3>Product Details</h3>
                </div>
            </div>
        </div>
    </div>
    </section>
    <div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">



<br>
<br>
<br>


<div class="container mt-5 text-center">
    <h1 class="oval-title">Page Title</h1>
</div>



<br>
<br>
	<!-- single product -->
	<div class="single-product mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<div class="single-product-img">
                        <div class="product-image">
                            @if ($product->photo)
                            <img src="{{ asset('storage/' . $product->photo) }}" alt="Photo" >
                        @endif  </div>

					</div>
				</div>
				<div class="col-md-7">
					<div class="single-product-content">
						<h3 style="color:rgb(226, 57, 51) ">{{ $product->name }}</h3>
						<p class="single-product-pricing">
						<p>{{ $product->description}}</p>
                        @if(number_format($product->discount, 2)!= 0.00)
                        <h6 style="color:rgb(69, 216, 226)   ;text-decoration:line-through">
                            <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                        <h6 style="color:rgb(228, 132, 151)">
                            DiscountPrice:
                            <td>${{ number_format($product->priceAfterDiscount(), 2) }}</td>
                         </h6>

                        </h6>
                        @else
                        <h6 style="color:rgb(82, 96, 223)  ">
                        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                        </h6>
                        @endif
                        </p>



						<div class="col-xs-2">
                            <p> Available Quantity : <td>{{ $product->quantity }}</td> </p>
                            @if($product->quantity != null)
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

                            @else
                            <p>The Quantity Is Finish</p>
                            <button class=" btn btn-info add-to-cart-btn">
                                <i class="bi bi-cart"></i> Add to Cart
                            </button>
                            @endif
                        </div>



							<p><strong>Categories: </strong> {{ $product->category->name }}</p>
						</div>
						<h4>Share:</h4>
                        <div class="footer_social">
                            <a href="">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a href="">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                            <a href="">
                            <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </a>
                            <a href="">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                            <a href="">
                            <i class="fa fa-pinterest" aria-hidden="true"></i>
                            </a>
                         </div>
                         <br>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end single product -->

    @include('notify::components.notify')
    @notifyJs
    @include('home.comments', ['comments' => $product->comments, 'type' => 'product', 'id' => $product->id])




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>




                    </div></div></div></div></div>


@include('home.layout.footerPage')


