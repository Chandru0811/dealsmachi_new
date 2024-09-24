<!-- Header Start -->
<section class="header">
    <nav id="NavBar" class="navbar mainNav fixed-top navbar-expand-xl navbar-light"
        style="background-color: #fff !important">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="/" class="text-decoration-none">
                <img src="{{ asset('assets/images/home/header-logo.png') }}" alt="header-logo"
                    class="mx-2 img-fluid header-logo" width="200" />
            </a>
            <div class="d-flex align-items-center mb-1">
                <span class="navbar-text d-xl-none align-items-center justify-content-end">
                    <button
                        class="btn btn-button userlogin-button py-2 px-3 d-flex justify-content-center align-items-center"
                        type="submit">
                        Login
                    </button>
                </span>
                &nbsp;&nbsp;&nbsp;
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarText">
                <!-- Collapsed View (Small Screens) -->
                <ul class="navbar-nav mx-auto lg-0 d-xl-none d-flex pt-2" id="default-search">
                    <li class="nav-item mb-2">
                        <div class="input-wrapper w-100">
                            <input type="text" placeholder="Search..." class="form-control mx-1 search-input" />
                            <i class="fa-solid fa-magnifying-glass icon-input" style="font-size: 20px"></i>
                        </div>
                    </li>
                </ul>
                <!-- Expanded View (Large Screens) -->
                <div class="d-flex justify-content-between align-items-center">
                    <ul class="navbar-nav mx-auto lg-0 d-flex flex-row justify-content-center align-items-center pt-2 d-none d-xl-flex"
                        id="default-search">
                        <li class="nav-item mb-2">
                            <div class="input-wrapper">
                                <input type="text" placeholder="Search...."
                                    class="form-control me-2 search-input-large" />
                                <i class="fa-solid fa-magnifying-glass icon-input" style="font-size: 20px"></i>
                            </div>
                        </li>
                    </ul>
                    <a href="{{ url('/wishlist') }}" class="text-decoration-none p-1"
                        style="text-decoration: none;">
                        <i class="fa-regular fa-bookmark" style="color: #ff0060;"></i>
                    </a>
                </div>
                <span class="navbar-text d-none d-xl-inline align-items-center justify-content-end"
                    style="margin-left: 10px">
                    <button
                        class="btn btn-button login-button userlogin-button-large py-2 px-4 d-flex justify-content-center align-items-center"
                        type="submit">
                        Login
                    </button>
                </span>
                &nbsp;&nbsp;
            </div>
        </div>
    </nav>
</section>
<!-- Header End  -->