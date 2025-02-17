<ul>
    <li class="nav-item @if(request()->routeIs('home')) active @endif">
        <a href="{{ route('home') }}">
              <span class="icon">
                <svg width="22" height="22" viewBox="0 0 22 22">
                  <path
                          d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z"
                  />
                </svg>
              </span>
            <span class="text">{{ __('Dashboard') }}</span>
        </a>
    </li>

{{--    <li class="nav-item @if(request()->routeIs('users.index')) active @endif">--}}
{{--        <a href="{{ route('users.index') }}">--}}
{{--              <span class="icon">--}}
{{--                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">--}}
{{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>--}}
{{--                </svg>--}}
{{--              </span>--}}
{{--            <span class="text">{{ __('Users') }}</span>--}}
{{--        </a>--}}
{{--    </li>--}}


    @if(auth()->user()->isAdmin())
    <li class="nav-item nav-item-has-children">
        <a class="collapsed" href="#0" class="" data-bs-toggle="collapse" data-bs-target="#ddmenu_1"
           aria-controls="ddmenu_1" aria-expanded="true" aria-label="Toggle navigation">
            <span class="icon">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M12.8334 1.83325H5.50008C5.01385 1.83325 4.54754 2.02641 4.20372 2.37022C3.8599 2.71404 3.66675 3.18036 3.66675 3.66659V18.3333C3.66675 18.8195 3.8599 19.2858 4.20372 19.6296C4.54754 19.9734 5.01385 20.1666 5.50008 20.1666H16.5001C16.9863 20.1666 17.4526 19.9734 17.7964 19.6296C18.1403 19.2858 18.3334 18.8195 18.3334 18.3333V7.33325L12.8334 1.83325ZM16.5001 18.3333H5.50008V3.66659H11.9167V8.24992H16.5001V18.3333Z">
                    </path>
                </svg>
            </span>
            <span class="text">Master</span>
        </a>
        <ul id="ddmenu_1" class="dropdown-nav collapse" style="">
            <li>
                <a href="{{ route('users.index') }}">Master Pengguna</a>
            </li>
            <li>
                <a href="{{ route('provinces.index') }}">Master Province</a>
            </li>
            <li>
                <a href="{{ route('cities.index') }}">Master City</a>
            </li>
            <li>
                <a href="{{ route('subdistricts.index') }}">Master Subdistrict</a>
            </li>
        </ul>
    </li>
    @endif
    <ul class="nav">
        <li class="nav-item nav-item-has-children">
            <a class="collapsed" href="#0" data-bs-toggle="collapse" data-bs-target="#ddmenu_ecommerce"
               aria-controls="ddmenu_ecommerce" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon">
                <!-- Icon Shopping Cart -->
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 2L3 6V19A1 1 0 0 0 4 20H20A1 1 0 0 0 21 19V6L18 2H6ZM10 14V8L16 11L10 14Z" fill="currentColor"></path>
                </svg>
            </span>
                <span class="text">E-Commerce</span>
            </a>
            <ul id="ddmenu_ecommerce" class="dropdown-nav collapse" data-bs-parent=".nav">
                <li><a href="{{ route('merchants.index') }}">Merchant</a></li>
                <li><a href="{{ route('products.index') }}">Product</a></li>
                <li><a href="{{ route('product-category.index') }}">Product Category</a></li>
            </ul>
        </li>

        <li class="nav-item nav-item-has-children">
            <a class="collapsed" href="#0" data-bs-toggle="collapse" data-bs-target="#ddmenu_monitoring"
               aria-controls="ddmenu_monitoring" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon">
                <!-- Icon Monitoring -->
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 3H21V7H3V3ZM3 10H21V14H3V10ZM3 17H21V21H3V17Z" fill="currentColor"></path>
                </svg>
            </span>
                <span class="text">Monitoring</span>
            </a>
            <ul id="ddmenu_monitoring" class="dropdown-nav collapse" data-bs-parent=".nav">
                <li><a href="{{ route('cart-items.index') }}">Cart Item</a></li>
                <li><a href="{{ route('merchant-payments.index') }}">Merchant Payment</a></li>
                <li><a href="{{ route('shipments.index') }}">Shipments</a></li>
                <li><a href="{{ route('sales-reports.index') }}">Sales Report</a></li>
            </ul>
        </li>
    </ul>
    <li class="nav-item @if(request()->routeIs('about')) active @endif">
        <a href="{{ route('about') }}">
            <span class="icon">
                <svg width="22" height="22" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                </svg>
            </span>
            <span class="text">{{ __('About us') }}</span>
        </a>
    </li>
</ul>
