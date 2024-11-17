
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
               <h3> Interaction Ads</h3>
            </div>
         </div>
      </div>
   </div>
</section>





<div class="ads-container">
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($ads->isEmpty())
        <p>No ads available based on your preferences.</p>
    @else
        <div class="ad-slider">
            @foreach($ads as $ad)
                <div class="ad-slide" style="display: none;"> <!-- Hide all ads initially -->
                    <h3>{{ $ad->title }}</h3>
                    @if ($ad->image_path)
                        <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}" class="ad-image">
                    @endif
                    <p>{{ $ad->description }}</p>
                    <button class="track-ad btn btn-primary" data-ad-id="{{ $ad->id }}">Track Interaction</button>
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
            @endforeach
        </div>
    @endif
</div>

<style>
    .ads-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .ad-slide {
        border: 1px solid #ddd;
        padding: 20px;
        width: 500px;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: opacity 0.5s ease-in-out;
    }

    .ad-slide img {
        max-width: 100%;
        height: auto;
        padding: 90px;
    }

    .ad-slide.active {
        display: block !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ads = document.querySelectorAll('.ad-slide');
        let currentIndex = 0;

        if (ads.length > 0) {
            ads[currentIndex].style.display = 'block'; // Show the first ad

            // Timer to change ads every 2 seconds
            setInterval(function () {
                ads[currentIndex].style.display = 'none'; // Hide current ad
                currentIndex = (currentIndex + 1) % ads.length; // Move to the next ad
                ads[currentIndex].style.display = 'block'; // Show the next ad
            }, 3000); // 2000 milliseconds = 2 seconds
        }

        // Handle ad interaction tracking
        document.querySelectorAll('.track-ad').forEach(button => {
            button.addEventListener('click', function () {
                let adId = this.dataset.adId;

                // Send the ad ID to the backend to track the interaction
                fetch('/track-ad-interaction', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ ad_id: adId })
                }).then(response => {
                    if (response.ok) {
                        console.log('Interaction tracked successfully');
                    } else {
                        console.error('Failed to track interaction');
                    }
                });
            });
        });
    });
</script>
<x-notify::notify />
@notifyJs

<br>
@include('home.layout.footerPage')