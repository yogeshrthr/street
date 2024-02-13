<!DOCTYPE html>
<html lang="en">
@props(['metaTags' => []])

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Street Bolt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://fonts.googleapis.com/css?family=Source Sans Pro' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/example.css" />
    <link rel="stylesheet" href="css/pygments.css" />
    <link rel="stylesheet" href="css/easyzoom.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/10.2.0/swiper-bundle.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        @foreach ($metaTags as $item)
            {!! $item !!}
        @endforeach


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            /* Style the dropdown container */
                .profile-dropdown {
                    position: relative;
                    display: inline-block;
                }

                /* Style the dropdown content (hidden by default) */
                .dropdown-content {
                    display: none;
                    position: absolute;
                    background-color: #f9f9f9;
                    min-width: 160px;
                    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                    z-index: 1;
                }

                /* Style the links inside the dropdown */
                .dropdown-content a {
                    color: black;
                    padding: 12px 16px;
                    text-decoration: none;
                    display: block;
                }

                /* Change color on hover */
                .dropdown-content a:hover {
                    background-color: #f1f1f1;
                }

                /* Show the dropdown content on hover */
                .profile-dropdown:hover .dropdown-content {
                    display: block;
                }

        </style>
</head>

<body>
    @php
        $categories = \App\Models\Category::get();
    @endphp
    <header class="fixed-header container-fluid {{\Request::is('/') ? '' : 'border-bottom bg-light'}}" onclick="closeNavPanel()">
        <div class="navToggle" onclick="toggleNavPanel()">
            <div class="nav-burger-bar"></div>
            <div class="nav-burger-bar"></div>
        </div>
        <div class="header-logo-wrapper">
            <a href="{{ route('home') }}">
                <img src="images/logo.png" alt="" />
            </a>
            <div class="primary-nav-wrapper">
                @foreach ($categories as $category)
                    <div onclick="slideBackground(this)" class="primary-nav-item d-none d-md-inline d-lg-inline"
                        data-nav-id="{{ $category->id }}" data-nav-background="{{ $category->banner }}">
                        {{ strtoupper($category->title) }}
                    </div>
                @endforeach
                <div class="primary-nav-panel text-center d-none">
                    <div class="primary-nav-panel-logo-wrap position-relative">
                        <svg onclick="toggleNavPanel()" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                            fill="currentColor"
                            class="bi bi-x-lg primary-nav-panel-logo-wrap-close"
                            viewBox="0 0 16 16">
                            <path
                                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                        </svg>
                        <a href="{{ route('home') }}">
                            <img src="images/logo.png" />
                        </a>
                    </div>
                    <div class="primary-nav-panel-item-wrap d-flex justify-content-end">
                        @foreach ($categories as $category)
                            <div onclick="slideBackground(this)" id="navItem_{{ $category->id }}"
                                class="primary-nav-item" data-nav-id="{{ $category->id }}"
                                data-nav-background="{{ $category->banner }}">
                                {{ strtoupper($category->title) }}
                            </div>
                        @endforeach
                    </div>
                    @foreach ($categories as $category)
                        <div class="nav-panel-links-wrap" id="navLink_{{ $category->id }}">
                            <div class="nav-links-group d-flex justify-content-end flex-wrap">
                                @php
                                    $sub_categories = \App\Models\SubCategory::where('category_id',$category->id)->get();
                                @endphp
                                @foreach($sub_categories as $sub_category)
                                    <a href="#" class="nav-link-badge">{{strtoupper($sub_category->name)}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="secondary-nav-wrapper">
                @if(!session()->has('customer'))
                <div class="primary-nav-item d-none d-md-inline d-lg-inline text-dark" onclick="LoginNow()">Login
                </div>
                @endif
                <div class="primary-nav-item d-none d-md-inline d-lg-inline text-dark">Help</div>
                <a href="{{ route('cart') }}" style="text-decoration:none;">
                    <div class="primary-nav-item text-dark" id="CartCounter">Shopping Bag(0)</div>
                </a>
                <!-- Profile dropdown -->
                @if(session()->has('customer'))
                    <div class="profile-dropdown">
                        <div class="primary-nav-item text-dark" id="profile-trigger">Profile</div>
                        <div class="dropdown-content">
                            <a href="#">My Orders</a>
                            <a href="#" onclick="document.getElementById('logoutForm').submit();">Logout</a>
                        </div>
                    </div>
                    <form style="display:none" action="{{ route('user-logout') }}" method="POST" id="logoutForm">
                        @csrf
                    </form>
                @endif
            </div>
            
        </div>
    </header>
