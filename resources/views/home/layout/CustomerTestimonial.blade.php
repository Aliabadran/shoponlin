            <!-- client section -->
      <section class="client_section layout_padding">
         <div class="container">
            <div class="heading_container heading_center">
               <h2>
                  Customer's Testimonial
               </h2>
            </div>


            @if ($feedbacks->isEmpty())
            <p>No ads available based on your preferences.</p>
            @else
            <div class="feedbacks-slider-container">
                <div class="feedbacks-slider">
                    @foreach ($feedbacks as $feedback)
                        <div class="feedbacks-slide">
                            <img src="images/client.jpg" alt="">
                            <div class="feedbacks-slide-info">
                                <h5> <p> {{ $feedback->user->name ?? 'Unknown' }}</p></h5>
                                <div class="feedbacks-slide-in">
                                <p> Customer</p>
                                </div>
                                <div class="feedbacks-slide-info">
                                <h3>{{ $feedback->title }}</h3>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation arrows -->
                <button class="feedbacks-slider-nav prev">❮</button>
                <button class="feedbacks-slider-nav next">❯</button>
            </div>
        @endif
    </div>
      </section>
      <!-- end client section -->
      <style>
   feedbacks-slider-container {
    position: relative;
    overflow: hidden;
    width: 50%;
    max-width: 500px;
    margin: 0 auto;
}

.feedbacks-slider {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.feedbacks-slide {
    min-width: 100%;
    box-sizing: border-box;
    text-align: center;
}

.feedbacks-slide img {
    width: 150px; /* Set a fixed width for the image */
    height: 150px; /* Set a fixed height for the image */
    object-fit: cover; /* Ensure the image fits inside the container */
    border-radius: 50%; /* Makes the image oval */
    margin: 0 auto; /* Centers the image */
    display: block; /* Centers the image inside the div */
}

.feedbacks-slide-info {
    padding: 10px;
    background: rgba(243, 240, 240, 0.7);
    color: rgb(14, 13, 13);
    text-align: center;
}

.feedbacks-slide-in {
    padding: 5px;
    background: rgba(243, 240, 243, 0.61);
    color: rgba(92, 89, 104, 0.863);
    text-align: center;
}

/* Navigation buttons */
.feedbacks-slider-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(175, 11, 79, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    font-size: 24px;
}

.feedbacks-slider-nav.prev {
    left: 10px;
}

.feedbacks-slider-nav.next {
    right: 10px;
}

.feedbacks-slider-nav:hover {
    background: rgba(0, 0, 0, 0.7);
}
    </style>


    <!-- Custom JS for the slider -->
    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.querySelector('.feedbacks-slider');
            const slides = document.querySelectorAll('.feedbacks-slide');
            const prevButton = document.querySelector('.feedbacks-slider-nav.prev');
            const nextButton = document.querySelector('.feedbacks-slider-nav.next');

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
