<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Finance Lens</title>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/033521daa8.js" crossorigin="anonymous"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .navbar-nav li {
            font-size: 18px;
        }

        .navbar-nav .nav-link:hover {
            background-color: #c3e0b8;
            color: #77a06a !important;
            /* Forces the color to change */
            transition: color 0.3s ease;
            border-radius: 4px;
        }
    </style>
</head>

<body style="background-color: #D3E4CC;">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: #D2E6D3">
        <div class="container">

            <!-- Brand -->
            <a href="#" class="navbar-brand fw-bold" style="font-size: 26px; color: #649857">
                Finance Lens
            </a>

            <!-- Toggler -->
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarToggler"
                aria-controls="navbarToggler"
                aria-expanded="false"
                aria-label="Toggle navigation">

                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarToggler">

                <!-- Navigation Links -->
                <ul class="navbar-nav ms-auto text-center gap-1">

                    <li class="nav-item" style="min-width: 100px; font-size: 14px;">
                        <a class="nav-link" href="/">
                            HOME
                        </a>
                    </li>

                    @auth
                    <li class="nav-item" style="min-width: 100px; font-size: 14px;">
                        <a class="nav-link" href="{{ route('redirect.dashboard') }}">
                            DASHBOARD
                        </a>
                    </li>
                    @else
                    <li class="nav-item" style="min-width: 100px; font-size: 14px;">
                        <a class="nav-link" href="{{ route('register') }}">
                            SIGN UP
                        </a>
                    </li>

                    <li class="nav-item" style="min-width: 100px; font-size: 14px;">
                        <a class="nav-link" href="{{ route('login') }}">
                            SIGN IN
                        </a>
                    </li>
                    @endauth

                    <li class="nav-item" style="min-width: 100px; font-size: 14px;">
                        <a class="nav-link" href="#">
                            ABOUT
                        </a>
                    </li>

                </ul>

            </div>

        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero py-5">
        <div class="container">

            <div class="d-flex flex-column flex-lg-row flex-lg-row-reverse align-items-center align-items-lg-start">

                <!-- Image -->
                <div class="mb-4 col-lg-6 p-lg-4 mt-lg-5">

                    <img
                        src="/image/banner1.jpg"
                        alt="Finance Dashboard"
                        class="img-fluid rounded shadow">

                </div>

                <!-- Text -->
                <div class="col-lg-6 p-lg-4">

                    <h2 class="fw-bold" style="font-size: 36px; color: #649857">Join Our Community</h2>
                    <h1 class="display-5 fw-bold mb-4" style="font-size: 50px;">
                        Manage Your Money Smarter
                    </h1>

                    <p class="" style="font-size: 18px;">
                        We are officially live, but we are keeping it exclusive.
                    </p>
                    <p class="" style="font-size: 18px;">
                        Our system can only support <span class="fw-bold">a limited number of early users</span> right now. This ensures the best experience and speed for our first adopters.
                    </p>
                    <p class="" style="font-size: 18px;">
                        Want to be one of them?
                    </p>
                    <p class="" style="font-size: 18px;">
                        Claim your spot today to try what we've built before the doors close. Early users can enjoy all features for free.
                    </p>

                    <button
                        class="btn btn-lg mt-3 rounded-pill text-white"
                        style="
                            background-color: #649857; 
                            font-size: 18px;
                            ">
                        Get Started
                    </button>

                    <div class="social-links mt-4 d-flex gap-3">
                        <button
                            class="btn text-white rounded-circle"
                            style="
                                background-color: #649857;
                                width: 50px;
                                height: 50px;
                            ">
                            <i class="fa-brands fa-facebook-f fs-4"></i>
                        </button>

                        <button
                            class="btn text-white rounded-circle"
                            style="
                                background-color: #649857; 
                                width: 50px; 
                                height: 50px;
                                ">
                            <i class="fa-brands fa-linkedin fs-4"></i>
                        </button>

                        <button
                            class="btn text-white rounded-circle"
                            style="
                                background-color: #649857; 
                                width: 50px; 
                                height: 50px;
                                ">
                            <i class="fa-solid fa-at fs-4"></i>
                        </button>
                    </div>
                </div>



            </div>

        </div>
    </section>

</body>

</html>