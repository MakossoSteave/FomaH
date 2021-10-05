<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro|Roboto&display=swap" rel="stylesheet">
    <link
        href=" https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap "
        rel=" feuille de style ">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
    <link rel="stylesheet" href="{{ URL::asset('/') }}css/app.css" />
    <link rel="shortcut icon" href="{{ URL::asset('/') }}/favicon.ico">
    <link rel="icon" type="image/png" href="{{ URL::asset('/') }}/favicon.ico">
</head>


<body class="">
    <div id="app">
     
    @if (Auth::user()->role_id == 4)

        <div class="relative bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">

                    <div class="flex justify-start lg:w-0 lg:flex-1">
                        <ul>
                            <li><i class="fas fa-user"> </i>
                                <a href="#">
                                    <span
                                        class="group bg-white rounded-md text-blue-500 inline-flex items-center text-base font-medium hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{Str::upper(Auth::user()->name)}} </span>
                                </a>
                            </li>
                            <li> <i class="fas fa-envelope text-blue-900 font-medium"></i>
                                <a href="{{route('message',[Auth::user()->id]) }}">
                                    <span
                                        class="group bg-white rounded-md text-base font-medium hover:text-blue-900 text-blue-500">Messages
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <nav class="hidden md:flex space-x-10">
                        <div class="relative">
                            <i class="fas fa-sliders-h "></i>
                            <button type="button"
                                class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <a href="{{ route('parametre', [Auth::user()->id]) }}">
                                    <span>Parametre</span>
                                </a>

                            </button>
                        </div>
                        <div class="relative">
                            <button type="button"
                                class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <img src="{{url('/img/alerte.svg')}}" alt="Image" />
                                <a href=""><span>Notification</span>
                                </a>

                            </button>
                        </div>
                        @if(Auth::user()->role_id == 4)
                        <div class=" relative">
                            <button type="button"
                                class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="flex-shrink-0 h-6 w-6 text-indigo-600 " xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                
                                <form action="" method="POST">
                                @csrf
                                    <button id="intranetNav">Intranet</button>
                                </form>
                            
                            </button>
                        </div>
                        @endif

                    </nav>
                    <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">

                        <a href="{{ route('logout')}}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();" class=" ml-8
                whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border
                border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600
                hover:bg-indigo-700">
                            Deconnexion
                        </a>
                        <form id="logout-form" fn action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <main class="">
       
       @yield('content')

   </main>
   
</div>

        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="{{ URL::asset('/') }}js/addFieldForm.js"></script>
        <script src="{{ URL::asset('/') }}js/toggle.js"></script>
        <script src="https://unpkg.com/popper.js@1/dist/umd/popper.min.js"></script>
        <script src="https://unpkg.com/tippy.js@4"></script>
    </body>
</html>