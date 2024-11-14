

@extends('home.layout.head')

@section('title') Ads @endsection
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

@notifyCss
<body>
@include('home.layout.header')
<section class="inner_page_head">
   <div class="container_fuild">
      <div class="row">
         <div class="col-md-12">
            <div class="full">
               <h3> Featured Ads</h3>
            </div>
         </div>
      </div>
   </div>
</section>
<div class="container mt-5">
    <h2 class="text-center">Featured Ads</h2>

    <a href="{{ route('home') }}" class="btn btn-danger float-end">Back</a>
<br>
    <br>
    @if ($ads->isEmpty())
        <p>No ads available based on your preferences.</p>
    @else
        <div class="ad-slider-container">
            <div class="ad-slider">
                @foreach ($ads as $ad)
                    <div class="ad-slide">
                        <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}" class="ad-slide-img">
                        <div class="ad-slide-info">
                            <h5>{{ $ad->title }}</h5>
                            <p>{{ $ad->description }}</p>
                            <h3>Products Associated with this Ad</h3>

                @if($ad->products->count() > 0)
                  @foreach($ad->products as $product)
                  <div class="product">
                <h4 class="text-success">{{ $product->name }}</h4>
                <p>Price: ${{ $product->price }}</p>
                <!-- Button to go to the product page -->
                <a href="{{ route('home.productdetails', $product->id) }}" class="btn btn-info">
                    View Product
                </a>
            </div>
        @endforeach
    @else
        <p>No products are associated with this ad.</p>
    @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation arrows -->
            <button class="ad-slider-nav prev">❮</button>
            <button class="ad-slider-nav next">❯</button>
        </div>
    @endif
</div>
<x-notify::notify />
@notifyJs
<!-- Custom CSS for the slider -->
<style>
    .ad-slider-container {
        position: relative;
        overflow: hidden;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .ad-slider {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .ad-slide {
        min-width: 100%;
        box-sizing: border-box;
        text-align: center;
    }

    .ad-slide-img {
        max-width: 100%;
        height: auto;
        padding: 0px  350px ;
    }

    .ad-slide-info {
        padding: 10px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        text-align: center;
    }

    /* Navigation buttons */
    .ad-slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 24px;
    }

    .ad-slider-nav.prev {
        left: 10px;
    }

    .ad-slider-nav.next {
        right: 10px;
    }

    .ad-slider-nav:hover {
        background: rgba(0, 0, 0, 0.7);
    }
</style>


<!-- Custom JS for the slider -->
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.querySelector('.ad-slider');
        const slides = document.querySelectorAll('.ad-slide');
        const prevButton = document.querySelector('.ad-slider-nav.prev');
        const nextButton = document.querySelector('.ad-slider-nav.next');

        let currentIndex = 0;
        const totalSlides = slides.length;

        function updateSliderPosition() {
            const translateX = currentIndex * -100;
            slider.style.transform = `translateX(${translateX}%)`;
        }

        prevButton.addEventListener('click', function () {
            currentIndex = currentIndex === 0 ? totalSlides - 1 : currentIndex - 1;
            updateSliderPosition();
        });

        nextButton.addEventListener('click', function () {
            currentIndex = currentIndex === totalSlides - 1 ? 0 : currentIndex + 1;
            updateSliderPosition();
        });

        // Optional: Auto-slide functionality (change slides every 5 seconds)
        setInterval(function () {
            currentIndex = currentIndex === totalSlides - 1 ? 0 : currentIndex + 1;
            updateSliderPosition();
        }, 5000);
    });
</script>
<br>
@include('home.layout.footerPage')
