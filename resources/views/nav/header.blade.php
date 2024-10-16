    <!-- Header Start -->
    <section class="header">
        <nav id="NavBar" class="navbar mainNav fixed-top navbar-expand-xl navbar-light"
            style="background-color: #fff !important">
            <div class="container d-flex align-items-center justify-content-between">
                <a href="/" class="text-decoration-none">
                    <img src="{{ asset('assets/images/home/header-logo.webp') }}" alt="header-logo"
                        class="mx-2 img-fluid header-logo" width="200" />
                </a>
                <div class="d-flex align-items-center mb-1">
                    <span class="navbar-text d-xl-none align-items-center justify-content-end">
                        <a href="https://dealsmachi.com/dealsmachiVendor/" style="text-decoration: none">
                        <button
                            class="btn btn-button userlogin-button py-1 px-2 d-flex justify-content-center align-items-center"
                            type="submit">
                            Post your Deal
                        </button>
                        </a>
                    </span>
                    &nbsp;&nbsp;&nbsp;
                    <button class="btn btn-button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Bookmark"
                        style="border: none; position: relative;">
                        <a href="{{ url('/bookmarks') }}" class="text-decoration-none d-xl-none"
                            style="text-decoration: none;">
                            <i class="fa-regular fa-bookmark fa-xl" style="color: #ff0060;"></i>
                        </a>
                        <span
                            class="totalItemsCount total-count translate-middle d-xl-none" style="position: absolute;top: 2px">
                            <!-- Count will be displayed here -->
                        </span>
                    </button>

                    &nbsp;&nbsp;&nbsp;
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarText">
                    <!-- Collapsed View (Small Screens) -->
                    <form action="{{ url('/search') }}" method="GET" class="mx-auto d-xl-none">
                        <ul class="navbar-nav pt-2" id="default-search">
                            <li class="nav-item mb-2">
                                <div class="input-wrapper w-100">
                                    <input type="text" name="q" placeholder="Search..." class="form-control mx-1 search-input" />
                                    <i class="fa-solid fa-magnifying-glass icon-input" style="font-size: 20px"></i>
                                </div>
                            </li>
                        </ul>
                    </form>

                    <!-- Expanded View (Large Screens) -->
                    <div class="d-flex justify-content-between align-items-center">
                        <form action="{{ url('/search') }}" method="GET" class="d-none d-xl-flex justify-content-center align-items-center pt-2">
                            <ul class="navbar-nav" id="default-search">
                                <li class="nav-item mb-2">
                                    <div class="input-wrapper">
                                        <input type="text" name="q" placeholder="Search..." class="form-control me-2 search-input-large" />
                                        <i class="fa-solid fa-magnifying-glass icon-input" style="font-size: 20px"></i>
                                    </div>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <button class="btn btn-button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Bookmark"
                        style="border: none; position: relative;">
                        <a href="{{ url('/bookmarks') }}" class="text-decoration-none px-1 py-1 d-none d-xl-inline"
                            style="text-decoration: none; position: relative;">
                            <i class="fa-regular fa-bookmark fa-xl" style="color: #ff0060;"></i>
                        </a>
                        <span
                            class="totalItemsCount total-count translate-middle d-none d-xl-block" style="position: absolute;top: 2px">
                        </span>
                    </button>
                    <span class="navbar-text d-none d-xl-inline align-items-center justify-content-end"
                        style="margin-left: 10px">
                        <a href="https://dealsmachi.com/dealsmachiVendor/" style="text-decoration: none">
                        <button
                            class="btn btn-button login-button userlogin-button-large py-2 px-4 d-flex justify-content-center align-items-center"
                            type="submit">
                            Post your Deal
                        </button>
                    </a>
                    </span>
                    &nbsp;&nbsp;
                </div>
            </div>
        </nav>
    </section>

    <!-- Header End  -->
