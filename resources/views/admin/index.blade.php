@extends('layouts.app')

@section('content')

<style>
        .nunito {
            font-family: 'nunito', font-sans;
        }
        
        .border-b-1 {
            border-bottom-width: 1px;
        }
        
        .border-l-1 {
            border-left-width: 1px;
        }
        
        hover\:border-none:hover {
            border-style: none;
        }
        
        #sidebar {
            transition: ease-in-out all .3s;
            z-index: 9999;
        }
        
        #sidebar span {
            opacity: 0;
            position: absolute;
            transition: ease-in-out all .1s;
        }
        
        #sidebar:hover {
            width: 150px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            /*shadow-2xl*/
        }
        
        #sidebar:hover span {
            opacity: 1;
        }
    </style>
<div class="flex flex-row flex-wrap flex-1 flex-grow content-start pl-16">

<div class="h-40 lg:h-20 w-full flex flex-wrap">
    <nav id="header" class="bg-gray-200 w-full lg:max-w-sm flex items-center border-b-1 border-gray-300 order-2 lg:order-1">

        <div class="px-2 w-full">
            <select name="" class="bg-gray-300 border-2 border-gray-200 rounded-full w-full py-3 px-4 text-gray-500 font-bold leading-tight focus:outline-none focus:bg-white focus:shadow-md" id="form-field2">
                <option value="Default">Géneral</option>
                <option value="A">Stagiaire</option>
                <option value="B">Formateur</option>
                <option value="C">Centre de formation</option>
                <option value="C">Institution</option>
            </select>
        </div>

    </nav>
    <nav id="header1" class="bg-gray-100 w-auto flex-1 border-b-1 border-gray-300 order-1 lg:order-2">

        <div class="flex h-full justify-between items-center">

            <!--Search-->
            <div class="relative w-full max-w-3xl px-6">
                <div class="absolute h-10 mt-1 left-0 top-0 flex items-center pl-10">
                    <svg class="h-4 w-4 fill-current text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
                    </svg>
                </div>

                <input id="search-toggle" type="search" placeholder="search" class="block w-full bg-gray-200 focus:outline-none focus:bg-white focus:shadow-md text-gray-700 font-bold rounded-full pl-12 pr-4 py-3" onkeyup="updateSearchResults(this.value);">

            </div>
            <!-- / Search-->

            <!--Menu-->

            <div class="flex relative inline-block pr-6">

                <div class="relative text-sm">
                    <button id="userButton" class="flex items-center focus:outline-none mr-3">
                        <img class="w-8 h-8 rounded-full mr-4" src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200" alt="Avatar of User"> <span class="hidden md:inline-block">Bonjour, {{ Auth::user()->name }} </span>
                        <svg class="pl-2 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                            <g>
                                <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"></path>
                            </g>
                        </svg>
                    </button>
                    <div id="userMenu" class="bg-white nunito rounded shadow-md mt-2 absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30 invisible">
                        <ul class="list-reset">
                            <li><a href="#" class="px-4 py-2 block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline">Mon compte</a></li>
                            <li><a href="#" class="px-4 py-2 block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline">Notifications</a></li>
                            <li>
                                <hr class="border-t mx-2 border-gray-400">
                            </li>
                            <li><a href="{{ route('logout')}}" class="px-4 py-2 block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                                     >Deconnection</a></li>
                            

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- / Menu -->

        </div>

    </nav>
</div>

<!--Dash Content -->
<div id="dash-content" class="bg-gray-200 py-6 lg:py-0 w-full lg:max-w-sm flex flex-wrap content-start">

    <div class="w-1/2 lg:w-full">
        <div class="border-2 border-gray-400 border-dashed hover:border-transparent hover:bg-white hover:shadow-xl rounded p-6 m-2 md:mx-10 md:my-6">
            <div class="flex flex-col items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-3 bg-gray-300"><i class="fa fa-wallet fa-fw fa-inverse text-indigo-500"></i></div>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-3xl">3249 € <span class="text-green-500"><i class="fas fa-caret-up"></i></span></h3>
                    <h5 class="font-bold text-gray-500">Total Revenue cette semaine</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="w-1/2 lg:w-full">
        <div class="border-2 border-gray-400 border-dashed hover:border-transparent hover:bg-white hover:shadow-xl rounded p-6 m-2 md:mx-10 md:my-6">
            <div class="flex flex-col items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-3 bg-gray-300"><i class="fas fa-users fa-fw fa-inverse text-indigo-500"></i></div>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-3xl">5691 <span class="text-orange-500"><i class="fas fa-exchange-alt"></i></span></h3>
                    <h5 class="font-bold text-gray-500">Total d'utilisateurs</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="w-1/2 lg:w-full">
        <div class="border-2 border-gray-400 border-dashed hover:border-transparent hover:bg-white hover:shadow-xl rounded p-6 m-2 md:mx-10 md:my-6">
            <div class="flex flex-col items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-3 bg-gray-300"><i class="fas fa-user-plus fa-fw fa-inverse text-indigo-500"></i></div>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-3xl">3 <span class="text-yellow-600"><i class="fas fa-caret-up"></i></span></h3>
                    <h5 class="font-bold text-gray-500">Nouveau Utilisateurs</h5>
                </div>
            </div>
        </div>
    </div>



</div>

<!--Graph Content -->
<div id="main-content" class="w-full flex-1">

    <div class="flex flex-1 flex-wrap">

        <div class="w-full xl:w-2/3 p-6 xl:max-w-6xl">

            <!--"Container" for the graphs"-->
            <div class="max-w-full lg:max-w-3xl xl:max-w-5xl">

                <!--Graph Card-->
                <div class="border-b p-3">
                    <h5 class="font-bold text-black">Graphique</h5>
                </div>
                <div class="p-5">
                    <div class="ct-chart ct-golden-section" id="chart1"></div>
                </div>
        
                <div class="p-3">
                    <div class="border-b p-3">
                        <h5 class="font-bold text-black">Nouveauté</h5>
                    </div>
                    <div class="p-5">
                        <table class="w-full p-5 text-gray-700">
                            <thead>
                                <tr>
                                    <th class="text-left text-blue-900">Nom</th>
                                    <th class="text-left text-blue-900">Role</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Michel</td>
                                    <td>Formateur</td>
                                </tr>
                                <tr>
                                    <td>Leonard</td>
                                    <td>Stagiaire</td>
                                </tr>
                                <tr>
                                    <td>PA School</td>
                                    <td>Centre de formation</td>
                                </tr>
                            </tbody>
                        </table>


                    </div>
                </div>

            </div>

        </div>

        <div class="w-full xl:w-1/3 p-6 xl:max-w-4xl border-l-1 border-gray-300">

            <div class="max-w-sm lg:max-w-3xl xl:max-w-5xl">


                <div class="border-b p-3">
                    <h5 class="font-bold text-black">Statistique</h5>
                </div>
                <div class="p-5">
                    <div class="ct-chart ct-golden-section" id="chart2"></div>
                </div>

                <div class="border-b p-3">
                    <h5 class="font-bold text-black">Visite</h5>
                </div>
                <div class="p-5">
                    <div class="ct-chart ct-golden-section" id="chart3"></div>
                </div>

        
                <div class="border-b p-3">
                    <h5 class="font-bold text-black">Statistique utilisateurs</h5>
                </div>
                <div class="p-5">
                    <div class="ct-chart ct-golden-section" id="chart4"></div>
                </div>

    
                <div class="p-3">
                    <div class="border-b p-3">
                        <h5 class="font-bold text-black"></h5>
                    </div>
                    <div class="p-5">

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <script>

        var mainChart = new Chartist.Line('#chart1', {
            labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            series: [
                [1, 5, 2, 5, 4, 3],
                [2, 3, 4, 8, 1, 2],
                [5, 4, 3, 2, 1, 0.5]
            ]
        }, {
            low: 0,
            showArea: true,
            showPoint: false,
            fullWidth: true
        });

        mainChart.on('draw', function(data) {
            if (data.type === 'line' || data.type === 'area') {
                data.element.animate({
                    d: {
                        begin: 1000 * data.index,
                        dur: 1000,
                        from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                        to: data.path.clone().stringify(),
                        easing: Chartist.Svg.Easing.easeOutQuint
                    }
                });
            }
        });

        var chartScatter = new Chartist.Line('#chart2', {
            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            series: [
                [12, 9, 7, 8, 5, 4, 6, 2, 3, 3, 4, 6],
                [4, 5, 3, 7, 3, 5, 5, 3, 4, 4, 5, 5],
                [5, 3, 4, 5, 6, 3, 3, 4, 5, 6, 3, 4],
                [3, 4, 5, 6, 7, 6, 4, 5, 6, 7, 6, 3]
            ]
        }, {
            low: 0
        });

        chartScatter.on('draw', function(data) {
            if (data.type === 'line' || data.type === 'area') {
                data.element.animate({
                    d: {
                        begin: 500 * data.index,
                        dur: 1000,
                        from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                        to: data.path.clone().stringify(),
                        easing: Chartist.Svg.Easing.easeOutQuint
                    }
                });
            }
        });

        var chartBar = new Chartist.Bar('#chart3', {
            labels: ['Semaine 1', 'Semaine 2', 'Semaine 3', 'Semaine 4'],
            series: [
                [800000, 1200000, 1400000, 1300000],
                [200000, 400000, 500000, 300000],
                [100000, 200000, 400000, 600000]
            ]
        }, {
            stackBars: true,
            axisY: {
                labelInterpolationFnc: function(value) {
                    return (value / 1000) + 'k';
                }
            }
        })

        chartBar.on('draw', function(data) {
            if (data.type === 'bar') {
                data.element.attr({
                        style: 'stroke-width: 30px'
                    }),
                    data.element.animate({
                        y2: {
                            dur: '0.5s',
                            from: data.y1,
                            to: data.y2
                        }
                    });
            }
        });

        var chartPie = new Chartist.Pie('#chart4', {
            series: [10, 20, 50, 20, 5, 50, 15],
            labels: [1, 2, 3, 4, 5, 6, 7]
        }, {
            donut: true,
            showLabel: true
        });

        chartPie.on('draw', function(data) {
            if (data.type === 'slice') {
                var pathLength = data.element._node.getTotalLength();
                data.element.attr({
                    'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
                });

                var animationDefinition = {
                    'stroke-dashoffset': {
                        id: 'anim' + data.index,
                        dur: 200,
                        from: -pathLength + 'px',
                        to: '0px',
                        easing: Chartist.Svg.Easing.easeOutQuint,
                        fill: 'freeze'
                    }
                };

                if (data.index !== 0) {
                    animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
                }

                data.element.attr({
                    'stroke-dashoffset': -pathLength + 'px'
                });

                data.element.animate(animationDefinition, false);
            }
        });
    </script>

    <script>
        /*Toggle dropdown list*/
        /*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

        var userMenuDiv = document.getElementById("userMenu");
        var userMenu = document.getElementById("userButton");

        document.onclick = check;

        function check(e) {
            var target = (e && e.target) || (event && event.srcElement);

            //User Menu
            if (!checkParent(target, userMenuDiv)) {
                // click NOT on the menu
                if (checkParent(target, userMenu)) {
                    // click on the link
                    if (userMenuDiv.classList.contains("invisible")) {
                        userMenuDiv.classList.remove("invisible");
                    } else {
                        userMenuDiv.classList.add("invisible");
                    }
                } else {
                    // click both outside link and outside menu, hide menu
                    userMenuDiv.classList.add("invisible");
                }
            }

        }

        function checkParent(t, elm) {
            while (t.parentNode) {
                if (t == elm) {
                    return true;
                }
                t = t.parentNode;
            }
            return false;
        }
    </script>
</div>


@endsection

</div>
