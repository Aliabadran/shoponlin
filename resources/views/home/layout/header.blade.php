<header class="header_section">
    <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container">
            @if(auth()->check() && auth()->user()->hasRole(['Admin', 'Super Admin']))
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    <img width="250" src="{{ asset('/images/logo.png') }}" alt="#" />
                </a>
            @else
                <a class="navbar-brand" href="#">
                    <img width="250" src="{{ asset('/images/logo.png') }}" alt="#" />
                </a>
            @endif

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class=""> </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                            About <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">

                          @can('index contacts')
                            <li><a href="{{ route('contact.index') }}">Contact</a></li>
                            @endcan
                            <li><a href="{{ route('blog.index') }}">Blog</a></li>
                            <li><a href="{{ route('general') }}">General Feedback</a></li>
                            <li><a href="{{ route('feedback.form') }}">Submit Feedback</a></li>
                            <li><a href="{{ route('feedback.index') }}">Reply Feedback</a></li>

                            @can('view user ads')
                            <li><a href="{{ route('user.ads') }}">View Recommended Ads</a></li>
                             @endcan
                          @can('view user ads')
                            <li><a href="{{ route('ads.interaction_ads') }}"> Ads</a></li>
                           @endcan

                        </ul>
                    </li>

                      @can('view user products')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home.product') }}">Products</a>
                    </li>
                     @endcan
                     @can('view user categories')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home.category') }}">Category</a>
                   </li>
                     @endcan
                     @can('view cart')
                    <li class="nav-item">
                        <a class="nav-link">
                            <!-- SVG Cart Icon !-->
                            <a class="nav-link" href="{{ route('cart.show') }}">
                                <i class="fa fa-shopping-cart"></i>
                                @auth
                                @if(isset($cartItemCount) && $cartItemCount > 0)
                                <span class="badgecart badge-second">{{ $cartItemCount }}</span>
                            @endif
                            @endauth
                        </a>
                    </li>
                     @endcan
                     @can('view user orders')
                     <!-- Order Icon -->
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">
                            <i class="fa fa-shopping-bag"></i>
                            <!-- Display the number of orders with a badge -->
                            @if(isset($orderCount) && $orderCount > 0)
                                <span class="badgeorder bg-primary">{{ $orderCount }}</span>
                            @endif
                        </a>
                    </li>
                     @endcan
                    @can('view user notifications')
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ route('notifications.index-user') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell"></i> <span class="badge badge-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li >
                           <a href="{{ route('notifications.index-user') }}" class="nav-link"> See Notifications </a></li>
                            @foreach (Auth::user()->unreadNotifications as $notification)
                                <li>{{ $notification->data['message'] }}</li>
                            @endforeach
                        </ul>
                    </li>
                     @endauth
                      @endcan

                    <form class="form-inline" action="{{ route('search') }}" method="GET">
                        <input type="text" name="query" placeholder="Search products and categories" required>
                        <button type="submit" >Search</button>
                    </form>


                    @auth

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a href="{{ url('/profile') }}">Profile</a></li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a></li>
                                </form>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="fa fa-user" aria-hidden="true" style="padding: 1px 4px " href="{{ route('login') }}">Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="fa fa-vcard"  style="color: rgb(218, 29, 92) ; padding:1px 8px " aria-hidden="true" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul>

                </ul>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>
 </header>


 <style>





    .nav-link .fa-shopping-bag,


    .nav-link .fa-bell {
        font-size: 20px;
        position: relative;
    }

    .badge {
        position: absolute;
        top: 0;
        right: 10px;
        font-size: 1px;
        border-radius: 1%;
        padding: 1px 5px;
    }

    .badge-danger {
        background-color: red;
        color: white;
    }


    .badgeorder {
    position: absolute;
    top: -10px; /* Move the badge above the icon */
    right: 320px; /* Adjust to the right side of the icon */
    background-color: blue; /* Change the background color for the badge */
    color: white;
    font-size: 10px; /* Smaller font size for the badge text */
    padding: 1px 1px; /* Padding inside the badge */
    border-radius: 50%; /* Make the badge circular */
    min-width: 20px; /* Minimum width to accommodate numbers like 10 or 100 */
    text-align: center; /* Center align the number in the badge */
}



.badgecart {
    position: absolute;
    top: -10px; /* Move the badge above the icon */
    right: 390px; /* Adjust to the right side of the icon */
    background-color: blue; /* Change the background color for the badge */
    color: white;
    font-size: 10px; /* Smaller font size for the badge text */
    padding: 1px 1px; /* Padding inside the badge */
    border-radius: 50%; /* Make the badge circular */
    min-width: 20px; /* Minimum width to accommodate numbers like 10 or 100 */
    text-align: center; /* Center align the number in the badge */
}
    .badge-second {
        background-color: rgb(0, 255, 136);
        color: white;
    }
    .nav-link:hover {
    color: #007bff;
}
</style>
