<!-- slider section -->
<section class="slider_section ">
    <div class="slider_bg_box">
        <img src="/images/slider-bg.jpg" alt="">
    </div>
    <div id="customCarousel1" class="carousel slide" data-ride="carousel" data-bs-interval="3000"> <!-- Set timer for 3 seconds -->

        <div class="carousel-inner">

            <!-- For Guests: Show all ads -->
            @guest
                @forelse($allAds as $index => $ad)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-7 col-lg-6">
                                    <div class="detail-box">
                                        <h1>
                                            <span>{{ $ad->title }}</span>
                                            <br>
                                            {{ $ad->subtitle }}
                                        </h1>
                                        <p>{{ $ad->description }}</p>
                                        <div class="btn-box">
                                            <a href="{{ $ad->link }}" class="btn1">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="carousel-item active">
                        <div class="container">
                            <div class="detail-box">
                                <h3>No ads are currently available.</h3>
                            </div>
                        </div>
                    </div>
                @endforelse
            @endguest

            <!-- For Logged-in Users: Show ads based on preferences or fallback to default ads -->
            @auth
                @if ($preferredAds->isEmpty())
                    @foreach($allAds->take(3) as $index => $ad)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-7 col-lg-6">
                                        <div class="detail-box">
                                            <h1>
                                                <span>{{ $ad->title }}</span>
                                                <br>
                                                {{ $ad->subtitle }}
                                            </h1>
                                            <p>{{ $ad->description }}</p>
                                            <div class="btn-box">
                                                <a href="{{ $ad->link }}" class="btn1">Shop Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @foreach($preferredAds as $index => $ad)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-7 col-lg-6">
                                        <div class="detail-box">
                                            <h1>
                                                <span>{{ $ad->title }}</span>
                                                <br>
                                                {{ $ad->subtitle }}
                                            </h1>
                                            <p>{{ $ad->description }}</p>
                                            <div class="btn-box">
                                                @if($ad->products->count() > 0)
                                                    @foreach($ad->products as $product)
                                                        <a href="{{ route('home.productdetails', $product->id) }}" class="btn1">Shop Now</a>
                                                    @endforeach
                                                @else
                                                    <a href="{{ route('home.product') }}" class="btn1">Shop Now</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endauth

        </div>

        <!-- Carousel indicators for guests and authenticated users -->
        <div class="container">
            <ol class="carousel-indicators">
                @guest
                    @foreach($allAds as $index => $ad)
                        <li data-target="#customCarousel1" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                    @endforeach
                @endguest

                @auth
                    @if ($preferredAds->isEmpty())
                        @foreach($allAds->take(3) as $index => $ad)
                            <li data-target="#customCarousel1" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                        @endforeach
                    @else
                        @foreach($preferredAds as $index => $ad)
                            <li data-target="#customCarousel1" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                        @endforeach
                    @endif
                @endauth
            </ol>
        </div>
    </div>
</section>
<!-- end slider section -->
