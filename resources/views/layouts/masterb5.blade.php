
<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title> {{ __('front.global.calculate_shipping_cost') }} </title>
    <meta name="theme-color" content="#7952b3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  {{--  <title>{{ __('front.global.main.online_shop) }} </title>--}}

    <style>
        body, html {
            height: 100%;
            width: 100%;
            max-width: 100%;
            padding: 0;
            margin: 0;
        }

        body {
        font-family:Roboto,sans-serif;
            padding-top: 40px  !important;
            margin: 0;
            font-size: 1rem  !important;
            font-weight: 400;
            line-height: 1.5  !important;
            -webkit-text-size-adjust: 100%  !important;
        }
        main {
            display: block;
        }
        .navbar {
            --bs-navbar-padding-x: 0;
            --bs-navbar-padding-y: .5rem;
            --bs-navbar-brand-padding-y: .3125rem;
            --bs-navbar-brand-margin-end: 1rem;
            --bs-navbar-brand-font-size: 1.25rem;
            --bs-navbar-nav-link-padding-x: .5rem;
            --bs-navbar-toggler-padding-y: .25rem;
            --bs-navbar-toggler-padding-x: .75rem;
            --bs-navbar-toggler-font-size: 1.25rem;
            --bs-navbar-toggler-icon-bg: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.55%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e);
            --bs-navbar-toggler-border-radius: .375rem;
            --bs-navbar-toggler-focus-width: .25rem;
            --bs-navbar-toggler-transition: box-shadow .15s ease-in-out;
            position: relative;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            padding: var(--bs-navbar-padding-y) var(--bs-navbar-padding-x);
        }
        .navbar-brand {
            padding-top: .3125rem;
            padding-bottom: .3125rem;
            margin-right: 1rem;
            font-size:  1.25rem;
            white-space: nowrap;
        }
        .navbar-dark {
             --bs-navbar-color: rgba(255, 255, 255, .55);
             --bs-navbar-hover-color: rgba(255, 255, 255, .75);
             --bs-navbar-disabled-color: rgba(255, 255, 255, .25);
             --bs-navbar-active-color: #fff;
             --bs-navbar-brand-color: #fff;
             --bs-navbar-brand-hover-color: #fff;
             --bs-navbar-toggler-border-color: rgba(255, 255, 255, .1);
             --bs-navbar-toggler-icon-bg: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.55%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e);
        }

        .bg-light {
            --bs-bg-opacity: 1;
            background-color: rgba(248, 249, 250, 1)!important;
        }
        .navbar>.container, .navbar>.container-fluid, .navbar>.container-sm, .navbar>.container-md, .navbar>.container-lg, .navbar>.container-xl, .navbar>.container-xxl {
            display: flex;
            flex-wrap: inherit;
            align-items: center;
            justify-content: space-between;
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            width: 100% !important;
        }
        .navbar-toggler-icon {
            display: inline-block;
            width: 1.5em;
            height: 1.5em;
            vertical-align: middle;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.55%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100%;
        }

        .py-5 {
            padding-top: 3rem!important;
            padding-bottom: 3rem!important;
        }
        *, *:before, *:after {
            box-sizing: border-box;
        }

        @media (min-width: 576px){
            .container-sm, .container {
                max-width: 540px;
            }
        }

        .collapse:not(.show) {
            display: none;
        }

        .navbar-collapse {
            flex-basis: 100%;
            flex-grow: 1;
            align-items: center;
        }
        .bg-dark {
            --bs-bg-opacity: 1;
            background-color: rgba(33,37,41,1)!important;
        }

        .starter-template {
            padding: 20px 15px;
            text-align: center;
        }
        table {
            text-align: left;
        }
        div.thumbnail img {
            height: 160px !important;
            max-height: 200px  !important;
        }
        .card {
            --bs-card-spacer-y: 1rem;
            --bs-card-spacer-x: 1rem;
            --bs-card-title-spacer-y: .5rem;
            --bs-card-border-width: 1px;
            --bs-card-border-radius: .375rem;
            --bs-card-inner-border-radius: calc(.375rem - 1px);
            --bs-card-cap-padding-y: .5rem;
            --bs-card-cap-padding-x: 1rem;
            --bs-card-img-overlay-padding: 1rem;
            --bs-card-group-margin: .75rem;
            display: flex;
            min-width: 0;
            height: 100%;
        }
        img {
            max-width: 100%  !important;
         /*   height:auto  !important;*/
        }
        h1, .h1 {
            font-family: Roboto, sans-serif;
            font-weight: 400;
            font-size: calc(1.375rem + 1.5vw)  !important;
            margin-top: 0 !important;
            margin-bottom: 0.5rem !important;
            line-height: 1.2 !important;
        }
        .flex-column {
            flex-direction: column !important;
        }
        .fixed-top {
            position: fixed  !important;
            top: 0  !important;
            right: 0  !important;
            left: 0  !important;
            z-index: 1030;
        }
        .h-100 {
            height: 100% !important;
        }
        .d-flex {
            display: flex!important;
        }
        .container, .container-fluid, .container-xxl, .container-xl, .container-lg, .container-md, .container-sm {
            --bs-gutter-x: 1.5rem !important;
            --bs-gutter-y: 0 !important;
            width: 100% !important;
            padding-right: calc(var(--bs-gutter-x) * .5) !important;
            padding-left: calc(var(--bs-gutter-x) * .5) !important;
            margin-right: auto !important;
            margin-left: auto !important;
        }
        main > .container {
            padding: 60px 15px 0  !important;
        }
        ul.dropdown-menu.dropdown-category{
            width: 15rem !important;
        }
        ul.dropdown-menu.dropdown-category a{
            padding-left: 8px !important;
        }
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }
        .navbar-toggler {
            padding: var(--bs-navbar-toggler-padding-y) var(--bs-navbar-toggler-padding-x) !important;
            font-size: var(--bs-navbar-toggler-font-size) !important;
            line-height: 1 !important;
            border: var(--bs-border-width) solid var(--bs-navbar-toggler-border-color) !important;
            border-radius: var(--bs-navbar-toggler-border-radius) !important;
            transition: var(--bs-navbar-toggler-transition) !important;
        }
        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <!-- Custom styles for this template -->
   {{-- <link href="sticky-footer-navbar.css" rel="stylesheet">--}}

</head>
<body class="d-flex flex-column h-100">

<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('index') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="false">{{ LaravelLocalization::getCurrentLocaleNative() }}</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                                <li>
                                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        {{ $properties['native'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>


                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</header>

<!-- Begin page content -->
<main class="">

    <div class="container">
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="starter-template">
                    @if(session()->has('success'))
                        <p class="alert alert-success">{{ session()->get('success') }}</p>
                    @endif
                    @if(session()->has('warning'))
                        <p class="alert alert-warning">{{ session()->get('warning') }}</p>
                    @endif
                     <h1> {{ __('front.global.calculate_shipping_cost') }} </h1>
                        @yield('content')
            </div>

        </div>
    </div>
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])

</body>
</html>
