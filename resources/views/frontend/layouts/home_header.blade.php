<!-- Heder Area -->
<header class="header-area">
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <ul class="left-info">
                        <li>
                            <a href="mailto:hello@atorn.com">
                                <i class="las la-envelope"></i>
                                hello@atorn.com
                            </a>
                        </li>
                        <li>
                            <a href="tel:+823-456-879">
                                <i class="las la-phone"></i>
                                +0123 456 789
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="right-info">
                        <li>
                            <a href="#" target="_blank">
                                <i class="lab la-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                                <i class="lab la-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                                <i class="lab la-instagram"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                                <i class="lab la-google-plus"></i>
                            </a>
                        </li>

                        <li class="heder-btn">
                            <a href="#">Get A Schedule</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Navbar Area -->
    <div class="navbar-area">
        <div class="atorn-responsive-nav">
            <div class="container">
                <div class="atorn-responsive-menu">
                    <div class="logo">
                        <a href="index.html">
                            <img src="assets/img/logo.png" alt="logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="atorn-nav">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <a class="navbar-brand" href="index.html">
                        <img style="max-height: 60px;" src="assets/img/logo.png" alt="logo">
                    </a>

                    <!-- Navbar-->
                    <nav class="navbar navbar-expand-lg navbar-dark position-sticky" aria-label="Fifth navbar example"
                        style="top: 0!important;">
                        <div class="container">

                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarsExample05" aria-controls="navbarsExample05"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse mean-menu">
                                @foreach ($sections as $section)
                                @if (count($section->subCategories) > 0)
                                <ul class="navbar-nav ms-auto">
                                    <!-- <li class="nav-item">
                    <a href="#" class="nav-link active">
                        {{ $section->name }} <i class="las la-angle-down"></i>
                    </a>
                </li> -->

                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            {{ $section->name }} <i class="las la-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($section->subCategories as $subCategory)
                                            <li class="nav-item">
                                                <a href="services.html" class="nav-link">{{ $subCategory->name }}</a>
                                            </li>
                                            @endforeach
                                            <!-- <li class="nav-item">
                            <a href="service-details.html" class="nav-link">Directorio</a>
                        </li>
                            <li class="nav-item">
                            <a href="service-details.html" class="nav-link">Marco legal</a>
                        </li> -->
                                        </ul>
                                    </li>
                                    @else

                                    <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        Servicios  <i class="las la-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a href="case-study.html" class="nav-link">Guía de trámite</a>
                        </li>

                        <li class="nav-item">
                            <a href="case-study-details.html" class="nav-link">TUPA</a>
                        </li>
                    </ul>
                </li> -->

                                    <li class="nav-item">
                                        <a href="contact.html" class="nav-link">{{ $section->name }}</a>
                                        @endif
                                    </li>
                                    @endforeach
                                    <li class="nav-item">
                                        <a href="javascript:void(0)" class="nav-link search-box">Contacto
                                            <i class="las la-search"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </nav>
            </div>
        </div>
    </div>
    <!-- End Navbar Area -->
</header>
<!-- End Heder Area -->
