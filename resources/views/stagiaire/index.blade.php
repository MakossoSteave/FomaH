@extends('layouts.app')

@section('content')

<div class="relative bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">

            <div class="flex justify-start lg:w-0 lg:flex-1">
                <ul>
                    <li><i class="fas fa-user"> </i>
                        <a href="#">
                            <span
                                class="group bg-white rounded-md text-blue-500 inline-flex items-center text-base font-medium hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{Auth::user()->name}} </span>
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
                        <svg class="flex-shrink-0 h-6 w-6 text-indigo-600 " xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>Notification</span>
                    </button>
                </div>
            </nav>
            <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">

                <a href="{{ route('logout')}}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();" class=" ml-8
        whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border
        border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600
        hover:bg-indigo-700">
                    Deconnection
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

    </div>


</div>


<section class="py-12 px-8">
    <div class="flex flex-wrap -mx-4">
        <div class="w-full lg:w-1/2 px-4 mb-8 lg:mb-0">
            <div class="flex flex-col  p-8 bg-gray-100 rounded">
                <h2 class="text-3xl indigo-500 font-heading">Formahuub </h2>
                <p class="text-gray-500 "> formahuub , garantie une qualité avec des prix défiant toute concurence
                </p>
                <br>
                <img class=" pte-7"
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTA2JFgAzKqwq5wfr3i60FDcMCydweHn8fIRg&usqp=CAU"><br>
                <a class=" px-9 py-1 border border-transparent rounded-md shadow-sm text-base font-medium text-white
                    bg-indigo-600 hover:bg-indigo-700">
                    Voici nos formations à la une
                </a>
            </div>

        </div>
        <div class="lg:w-1/2 px-6">
            <div class="flex flex-wrap -m-2">
                <div class="w-1/3 p-2"><img class="rounded shadow"
                        src="https://www.lesfurets.com/mutuelle-sante/guide/wp-content/uploads/sites/9/2017/01/iStock-1156717900-1.jpg"
                        alt="">
                    <a class="text-right text-indigo-600 hover:underline" href="#">Formation de psychatre</a>
                </div>
                <div class="w-1/3 p-2"><img class="rounded shadow"
                        src="https://i2.wp.com/managersante.com/wp-content/uploads/2020/03/infirmiere-pratique-avancee-hospitaliers.jpg?fit=1080%2C727&ssl=1"
                        alt="">
                    <a class="text-right text-indigo-600 hover:underline" href="#">Formation d'infirmiere</a>
                </div>
                <div class="w-1/3 p-2"><img class="rounded shadow"
                        src="https://www.lesfurets.com/mutuelle-sante/guide/wp-content/uploads/sites/9/2017/03/Dermatologue.jpg"
                        alt="">
                    <a class="text-right text-indigo-600 hover:underline" href="#">Formation dermatologue</a>
                </div>
                <div class="w-1/3 p-2"><img class="rounded shadow"
                        src="https://cdn.futura-sciences.com/buildsv6/images/mediumoriginal/2/2/a/22aa85ecd1_50148008_chimiste-analytique2.jpg"
                        alt="">
                    <a class="text-right text-indigo-600 hover:underline" href="#">Formation de chimiste</a>

                </div>
                <div class="w-1/3 p-2"><img class="rounded shadow"
                        src="https://prospecvente.com/wp-content/uploads/2011/03/bon-vendeur.jpg" alt="">
                    <a class="text-right text-indigo-600 hover:underline" href="#">Formation de vendeur</a>

                </div>
            </div>
        </div>
    </div>
</section>

<div class="">
    <h1 class="text-center text-indigo-800 text-3xl font-heading font-black">Formation disponible</h1>
    <div class="">
        <div class="bg-white-400 p-6">
            <div class="inline bg-white-400 text-center text-1xl p-3"><a href="">General</a></div>
            <div class="inline bg-white-400 text-center text-1xl p-3"><a href="">Informatique</a></div>
            <div class="inline bg-white-400 text-center text-1xl p-3"><a href="">Design</a></div>
            <div class="inline bg-white-400 text-center text-1xl p-3"><a href="">Science</a></div>
        </div>
    </div>

    <div class="sm:w-3/1 px-20">
        <div class="flex flex-wrap ">
            <div class="w-1/4 p-2"><img class="rounded shadow"
                    src="https://www.lesfurets.com/mutuelle-sante/guide/wp-content/uploads/sites/9/2017/01/iStock-1156717900-1.jpg"
                    alt="">
                <a class="text-right text-indigo-600 hover:underline" href="{{route('formationshow')}}">Formation de
                    psychatre</a>
            </div>
            <div class="w-1/4 p-2"><img class="rounded shadow"
                    src="https://i2.wp.com/managersante.com/wp-content/uploads/2020/03/infirmiere-pratique-avancee-hospitaliers.jpg?fit=1080%2C727&ssl=1"
                    alt="">
                <a class="text-right text-indigo-600 hover:underline" href="#">Formation d'infirmiere</a>
            </div>
            <div class="w-1/4 p-2"><img class="rounded shadow"
                    src="https://www.lesfurets.com/mutuelle-sante/guide/wp-content/uploads/sites/9/2017/03/Dermatologue.jpg"
                    alt="">
                <a class="text-right text-indigo-600 hover:underline" href="#">Formation dermatologue</a>
            </div>
            <div class="w-1/4 p-2"><img class="rounded shadow"
                    src="https://www.lesfurets.com/mutuelle-sante/guide/wp-content/uploads/sites/9/2017/01/iStock-1156717900-1.jpg"
                    alt="">
                <a class="text-right text-indigo-600 hover:underline" href="#">Formation de controleur</a>

            </div>
            <div class="w-1/4 p-2"><img class="rounded shadow"
                    src="https://www.lesfurets.com/mutuelle-sante/guide/wp-content/uploads/sites/9/2017/03/Dermatologue.jpg"
                    alt="">
                <a class="text-right text-indigo-600 hover:underline" href="#">Formation dermatologue</a>
            </div>
            <div class="w-1/4 p-2"><img class="rounded shadow"
                    src="https://img.actionco.fr/Img/BREVE/2016/11/310512/astuces-conduite-economique-F.jpg" alt="">
                <a class="text-right text-indigo-600 hover:underline" href="#">Formation conduite</a>

            </div>
            <div class="w-1/4 p-2"><img class="rounded shadow"
                    src="https://www.lesfurets.com/mutuelle-sante/guide/wp-content/uploads/sites/9/2017/01/iStock-1156717900-1.jpg"
                    alt="">
                <a class="text-right text-indigo-600 hover:underline" href="#">Formation de controleur</a>

            </div>
            <div class="w-1/4 p-2"><img class="rounded shadow"
                    src="https://image.over-blog.com/29KdRhlwxe1nJd3ZhXF0pta8GbM=/fit-in/500x500/filters:no_upscale()/image%2F1188309%2F20200429%2Fob_8de675_formation-secourisme-securite-paris.jpg"
                    alt="">
                <a class="text-right text-indigo-600 hover:underline" href="#">Secourisme</a>

            </div>

        </div>
    </div>
</div>
<div>
    <div class="flex justify-center items-center h-screen md:-mx-2">
        <div class="w-full my-80 bg-gray-100 h-30"
            style="background-image:url(https://www.bricorama.fr/media/catalog/product/9/0/903f59fb0c4503523cdf0cbacd4b7aa35562f261_3256610707182_2.jpg)">
            <h2 class="text-center font-black text-3xl text-indigo-700 pt-10">Formahuub propose</h2>
            <div class="swiper-container w-43">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide px-10 py-6 flex items-center justify-center">
                        <div class="py-6">
                            <div class="flex jusify-center py-4 text-gray-200 text-center text-2xl">
                                La securité
                            </div>
                            <p></p>
                            <div class="flex justify-center py-4">
                                <img class="h-20 w-21 rounded-full"
                                    src="https://e7.pngegg.com/pngimages/994/40/png-clipart-padlock-computer-security-padlock-technic-logo.png">
                            </div>
                            <div class="text-sm flex justify-center text-gray-300">Perfect Ingenieurie</div>
                        </div>
                    </div>
                    <div class="swiper-slide px-20 flex items-center justify-center">
                        <div class="py-6">

                            <div class="flex jusify-center py-4 text-gray-200 text-center text-2xl">
                                La fiabilité
                            </div>
                            <div class="flex justify-center py-4">
                                <img class="h-20 w-21 rounded-full"
                                    src="https://img2.freepng.fr/20180616/lgu/kisspng-reliability-engineering-computer-icons-validity-5b24fd24e49099.4449293015291507569362.jpg">
                            </div>
                            <div class="text-sm flex justify-center text-gray-300">Perfect Ingenieurie</div>
                        </div>
                    </div>

                </div>
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev bg-white w-16 h-16 text-xs rounded-full text-green-500 mx-5"></div>
                <div class="swiper-button-next bg-white w-16 h-16 text-xs rounded-full text-green-500 mx-5"></div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>
            </div </div>
        </div>
        <script>
        var mySwiper = new Swiper('.swiper-container', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
            },
        })
        </script>
    </div>

    <section class="py-6 px-8">
        <h2 class="text-center text-indigo-800 text-4xl font-heading font-black">Mes Droits </h2>
        <div class="flex flex-wrap -mx-4">
            <div class="lg:w-1/3 px-4 mb-8 lg:mb-0">
                <div class="h-full">
                    <img class="mb-3" src="https://www.datocms-assets.com/17507/1606813387-shutterstock318703970.jpg"
                        alt=""><small>Par nos partenaires</small>
                    <h3 class="text-2xl mt-2 mb-3 font-heading">Suivis personnalisé</h3>
                    <a class="text-indigo-600 hover:underline" href="#">En savoir plus »</a>
                </div>
            </div>
            <div class="lg:w-1/3 px-4 mb-8 lg:mb-0">
                <div class="h-full">
                    <img class="mb-3"
                        src="https://1819.brussels/sites/default/files/styles/image_style_1_2_landscape_xs_wide/public/eighteennineteen/galleries/reduction_de_prix.jpg?itok=OjALCPy2"
                        alt=""><small>Par nos partenaires</small>
                    <h3 class=" text-2xl mt-2 mb-3 font-heading">Réduction</h3>
                    <a class="text-indigo-600 hover:underline" href="#">En savoir plus »</a>
                </div>
            </div>
            <div class="lg:w-1/3 px-4 mb-8 lg:mb-0">
                <div class="">
                    <img class="mb-3"
                        src="https://www.ville-clichy.fr/uploads/Image/d7/IMF_ACCROCHE/GAB_CLICHY/58481_979_creation-d-entreprise.jpg"
                        alt=""><small>Par nos partenaires</small>
                    <h3 class="text-2xl mt-2 mb-3 font-heading">Entreprise</h3>
                    <a class="text-indigo-600 hover:underline" href="#">En savoir plus »</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-gray-100 bg-gray-800">
        <div class="max-w-3xl mx-auto py-6">
            <h1 class="text-center text-lg lg:text-2xl">
                Nous rejoindre <br>
                c'est avoir les conseils d'un professionnel
            </h1>
            <div class="flex justify-center mt-6">
                <div class=" bg-white rounded-md">
                    <div class="flex flex-wrap justify-between md:flex-row">
                        <input type="email"
                            class="m-1 p-2 appearance-none text-gray-700 text-sm focus:placeholder-transparent"
                            placeholder="Entrez votre email" aria-label="Entrez votre email">
                        <button
                            class="w-full m-1 p-2 text-sm bg-gray-800 rounded font-semibold uppercase lg:w-auto hover:bg-gray-700">
                            s'abonner
                        </button>
                    </div>
                </div>
            </div>
            <hr class="h-px mt-6 bg-gray-700 border-none">
            <div class="flex flex-col items-center justify-between mt-6 md:flex-row">
                <div>
                    <a href="#" class="text-xl font-bold text-gray-100 hover:text-gray-400">Perfect Ingénieurie</a>
                </div>
                <div class="flex mt-4 md:m-0">
                    <a href="" class="px-4 text-sm text-gray-100 font medium hover:text-gray-400">A propos de nous </a>
                    <a href="" class="px-4 text-sm text-gray-100 font medium hover:text-gray-400">Contactez nous </a>
                    <a href="" class="px-4 text-sm text-gray-100 font medium hover:text-gray-400">Blog</a>
                </div>
            </div>
        </div>
    </footer>


    @endsection