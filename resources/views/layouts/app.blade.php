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

</head>
<body class="">
    <div id="app">
                        @guest
                            @if (Route::has('login'))
                            
                            @endif
                            
                            @if (Route::has('register'))
                                
                            @endif
                        @else
                            @if (Auth::user()->role==1)
                                            <link href="https://fonts.googleapis.com/css?family=Nunito:400,700,800" rel="stylesheet">

                <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
                <link href="https://unpkg.com/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
                <!--Replace with your tailwind.css once created-->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">

                <div id="sidebar" class="h-screen w-16 menu bg-white text-white px-4 flex items-center nunito static fixed shadow">
                <body class="flex h-screen bg-gray-100 font-sans">
                <ul class="list-reset ">
                    <li class="my-2 md:my-0">
                        <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                            <i class="fas fa-home fa-fw mr-3"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Acceuil</span>
                        </a>
                    </li>
                    <li class="my-2 md:my-0 ">
                        <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                            <i class="fas fa-tasks fa-fw mr-3"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Nouveauté</span>
                        </a>
                    </li>
                    <li class="my-2 md:my-0">
                        <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                            <i class="fa fa-envelope fa-fw mr-3"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Messages</span>
                        </a>
                    </li>
                    <li class="my-2 md:my-0">
                        <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                            <i class="fas fa-chart-area fa-fw mr-3 text-indigo-400"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Statistique</span>
                        </a>
                    </li>
                
                </ul>
                </div>

                             @endif
                             @if(Auth::user()->role ==2)
                             
                             @endif

                        @endguest
                 
        <main class="">
            
            @yield('content')
        </main>
    </div>
    
</body>
</html>
