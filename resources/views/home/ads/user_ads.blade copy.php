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
        width: 300px;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: opacity 0.5s ease-in-out;
    }

    .ad-slide img {
        max-width: 100%;
        height: auto;
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
