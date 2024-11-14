<!-- Add Bootstrap CSS in your <head> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Add Bootstrap JS before the closing </body> tag -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


<div class="container mt-5">
    <h2 class="text-center">Featured Ads</h2>

    @if ($ads->isEmpty())
        <p>No ads available based on your preferences.</p>
    @else
        <div id="adCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000"> <!-- Set to 3 seconds -->

            <!-- Indicators/dots -->
            <ol class="carousel-indicators">
                @foreach ($ads as $index => $ad)
                    <li data-bs-target="#adCarousel" data-bs-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                @endforeach
            </ol>

            <!-- Carousel slides -->
            <div class="carousel-inner">
                @foreach ($ads as $index => $ad)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="d-flex justify-content-center align-items-center" style="height: 400px;">
                            <img src="{{ asset('storage/' . $ad->image_path) }}" class="d-block" alt="{{ $ad->title }}" style="max-height: 100%; max-width: 100%; object-fit: cover;">
                        </div>
                        <div class="carousel-caption d-none d-md-block">
                            <h5>{{ $ad->title }}</h5>
                            <p>{{ $ad->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#adCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#adCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>
    @endif
</div>

<style>
    .carousel-item {
        background-color: #f8f9fa;
        height: 400px;
    }

    .carousel-indicators li {
        background-color: #333;
    }

    .carousel-caption {
        background-color: rgba(0, 0, 0, 0.6);
        padding: 10px;
        border-radius: 5px;
    }
</style>
