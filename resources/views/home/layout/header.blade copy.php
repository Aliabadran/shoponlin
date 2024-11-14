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
                           Pages <span class="caret"></span>
                       </a>
                       <ul class="dropdown-menu">
                           <li><a href="about.html">About</a></li>
                           <li><a href="{{ route('notifications.index-user') }}">Notifications</a></li>
                           <li><a href="{{ route('cart.show') }}">Cart</a></li>
                           <li><a href="{{ route('orders.index') }}">Orders</a></li>
                           <li><a href="{{ route('contact.index') }}">Contact</a></li>
                           <li><a href="{{ route('general') }}">General Feedback</a></li>
                           <li><a href="{{ route('feedback.form') }}">Submit Feedback</a></li>
                           <li><a href="{{ route('feedback.index') }}">Reply Feedback</a></li>
                           <li><a href="{{ route('blog.index') }}">Blog</a></li>
                       </ul>
                   </li>

                   <li class="nav-item">
                       <a class="nav-link" href="{{ route('home.product') }}">Products</a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="{{ route('home.category') }}">Category</a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="{{ route('cart.show') }}">
                           <!-- SVG Cart Icon -->
                       </a>
                   </li>

                   <form class="form-inline" action="{{ route('search') }}" method="GET">
                       <input type="text" name="query" placeholder="Search products and categories" required>
                       <button type="submit">Search</button>
                   </form>

                   @auth
                       <li class="nav-item dropdown">
                           <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                               Notifications <span class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                           </a>
                           <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                               @foreach (auth()->user()->unreadNotifications as $notification)
                                   <li>{{ $notification->data['message'] }}</li>
                               @endforeach
                           </ul>
                       </li>

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
                           <a class="fa fa-user" aria-hidden="true" href="{{ route('login') }}">Log in</a>
                       </li>
                       @if (Route::has('register'))
                           <li class="nav-item">
                               <a class="fa fa-vcard"  style="color: rgb(173, 29, 218)" aria-hidden="true" href="{{ route('register') }}">Register</a>
                           </li>
                       @endif
                   @endauth
               </ul>
           </div>
       </nav>
   </div>
</header>




<!-- Header section starts -->
<header class="header_section">
    <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container d-flex justify-content-between align-items-center">
            <!-- Logo Section -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img width="150" src="{{ asset('/images/logo.png') }}" alt="Logo">
            </a>

            <!-- Search Form -->
            <form class="form-inline d-none d-lg-flex" action="{{ route('search') }}" method="GET">
                <input type="text" name="query" class="form-control mr-2" placeholder="Search products and categories" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <!-- Links Section -->
            <div class="navbar-collapse collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto d-flex align-items-center">
                    <!-- Conditional Links for Authenticated Users -->
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('notifications.index-user') }}">Notifications</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ url('/profile') }}">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
                                </form>
                            </div>
                        </li>
                    @else
                        <!-- Links for Guests -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Log in</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endauth

                    <!-- Cart Icon -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.show') }}">
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>
</header>
<!-- Header section ends -->

<!-- Custom CSS for beautifying the header -->
<style>
    .header_section {
        padding: 15px 0;
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand img {
        max-height: 50px;
    }

    .form-inline {
        max-width: 400px;
    }

    .navbar-nav .nav-item {
        margin-left: 20px;
    }

    .navbar-nav .nav-link {
        color: #333;
    }

    .navbar-nav .nav-link:hover {
        color: #007bff;
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%280, 0, 0, 0.5%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }
</style>




<form class="form-inline my-2 my-lg-0 ml-lg-3" action="{{ route('search') }}" method="GET">
    <input type="text" name="query" class="form-control mr-sm-2" placeholder="Search" required>
    <button type="submit" class="btn btn-outline-primary my-2 my-sm-0">Search</button>
</form>
<ul class="navbar-nav mx-auto">
    <!-- Navigation links -->
</ul>
<a class="navbar-brand mr-4" href="{{ url('/') }}">
   <img width="150" src="{{ asset('/images/logo.png') }}" alt="Logo" />
</a>
<li class="nav-item active mx-2">
   <a class="nav-link" href="{{ url('/') }}">Home</a>
</li>





<!-- Header Section Starts -->
<header class="header_section">
    <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container d-flex justify-content-between align-items-center">
            <!-- Logo Section -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img width="150" src="{{ asset('/images/logo.png') }}" alt="Logo">
            </a>

            <!-- Search Form -->
            <form class="form-inline d-none d-lg-flex" action="{{ route('search') }}" method="GET">
                <input type="text" name="query" class="form-control mr-2" placeholder="Search products and categories" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <!-- Links Section -->
            <div class="navbar-collapse collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto d-flex align-items-center">
                    <!-- Notification Icon -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('notifications.index-user') }}">
                            <i class="fa fa-bell"></i>
                            <!-- Notification Badge -->
                            <span class="badge badge-danger">0</span>
                        </a>
                    </li>

                    <!-- Other Links for Authenticated Users -->
                    @auth
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <!-- Add other menu items here as needed -->

                        <!-- User Dropdown Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ url('/profile') }}">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
                                </form>
                            </div>
                        </li>
                    @else
                        <!-- Links for Guests -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Log in</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endauth

                    <!-- Cart Icon -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.show') }}">
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('notifications.index-user') }}">
                            <i class="fa fa-bell"></i>
                            <!-- Notification Badge -->
                            <span class="badge badge-danger">0</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </nav>
    </div>
</header>
<!-- Header Section Ends -->

<!-- Custom CSS for the Notification Icon -->
<style>
    .nav-link .fa-bell {
        font-size: 20px;
        position: relative;
    }

    .badge-danger {
        position: absolute;
        top: 0;
        right: -1px;
        font-size: 12px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 2px 5px;
    }
</style>






<!-- Header Section Starts -->
<header class="header_section">
    <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container d-flex justify-content-between align-items-center">
            <!-- Logo Section -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img width="150" src="{{ asset('/images/logo.png') }}" alt="Logo">
            </a>

            <!-- Search Form -->
            <form class="form-inline d-none d-lg-flex" action="{{ route('search') }}" method="GET">
                <input type="text" name="query" class="form-control mr-2" placeholder="Search products and categories" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <!-- Links Section -->
            <div class="navbar-collapse collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto d-flex align-items-center">
                    <!-- Notification Icon -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('notifications.index-user') }}">
                            <i class="fa fa-bell"></i>
                            <span class="badge badge-danger">5</span>
                        </a>
                    </li>

                    <!-- Order Icon -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">
                            <i class="fa fa-shopping-bag"></i>
                            <!-- Optionally, add a badge to show the number of orders -->
                            <span class="badge badge-primary">3</span>
                        </a>
                    </li>

                    <!-- Other Links for Authenticated Users -->
                    @auth
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <!-- Add other menu items here as needed -->

                        <!-- User Dropdown Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ url('/profile') }}">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
                                </form>
                            </div>
                        </li>
                    @else
                        <!-- Links for Guests -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Log in</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endauth

                    <!-- Cart Icon -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.show') }}">
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>
</header>
<!-- Header Section Ends -->

<!-- Custom CSS for the Icons -->
<style>
    .nav-link .fa-shopping-bag,
    .nav-link .fa-bell {
        font-size: 20px;
        position: relative;
    }

    .badge {
        position: absolute;
        top: 0;
        right: -10px;
        font-size: 12px;
        border-radius: 50%;
        padding: 2px 5px;
    }

    .badge-danger {
        background-color: red;
        color: white;
    }

    .badge-primary {
        background-color: blue;
        color: white;
    }
</style>
