

<div class="container">
    <div class="heading_container heading_center">
       <h2 style=" color: rgb(29, 73, 218)">
        Advertisements
       </h2>
    </div>

<div class="ads-container">
    <div id="ad-container" class="ad">
        @foreach($allAds as $ad)
        <div class="ad">
            <h3>{{ $ad->title }}</h3>
            @if ($ad->image_path)
                <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}" class="ad-image">
            @endif
            <p class="ad-description">{{ $ad->description }}</p>
            @if($ad->products->count() > 0)
            @foreach($ad->products as $product)
                <div class="product">
                    <h4 class="text-success">{{ $product->name }}</h4>
                    <p>Price: ${{ $product->price }}</p>
                    <!-- Button to go to the product page -->
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">
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
</div>
</div>
<script>
    // Array of ads passed from the backend
    const ads = @json($allAds);

    // Current ad index
    let currentAdIndex = 0;

    // Function to display the current ad
    function displayAd() {
        const adContainer = document.getElementById('ad-container');
        const ad = ads[currentAdIndex];

        // Create ad HTML content
        let adContent = `
            <h3>${ad.title}</h3>
            ${ad.image_path ? `<img src="{{ asset('storage') }}/${ad.image_path}" alt="${ad.title}" class="ad-image">` : ''}
            <p class="ad-description">${ad.description}</p>
        `;

        // Update the container's inner HTML
        adContainer.innerHTML = adContent;

        // Move to the next ad index
        currentAdIndex = (currentAdIndex + 1) % ads.length;
    }

    // Initial call to display the first ad
    displayAd();

    // Change ad every 3 minutes (300000 milliseconds)
    setInterval(displayAd, 90000);
</script>

<style>
    /* Add the same styles as before */
    .ads-container {
        display: flex;
        justify-content: center;
        padding: 20px;
        background-color: #f9f9f9;
    }

    .ad {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 300px;
        text-align: center;
    }

    .ad h3 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #333;
    }

    .ad-image {
        width: 100%;
        height: auto;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .ad-description {
        font-size: 14px;
        color: #301519;
    }

    @media (max-width: 768px) {
    .ad {
        width: 100%; /* Make ads full-width on small screens */
    }
}
</style>

