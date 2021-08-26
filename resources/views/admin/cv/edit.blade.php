@extends('layouts.app')

@section('content')
@if(Auth::user())




        <div class="container">
        <h2></h2>
        
        <img class="img-responsive" src="{{ URL::asset('/') }}doc/cv/{{$cv->lien}}" > 
        </div>

        <br>
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

@else
        <div class="notification is-danger has-text-centered my-4">
        Votre session a expiré !
        </div>
        <button type="button" class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <a href="/">
                                <i class="fas fa-home"></i>
                                    <span>Acceuil</span>
                                </a>

        </button>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
  (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
    const $notification = $delete.parentNode;

    $delete.addEventListener('click', () => {
      $notification.parentNode.removeChild($notification);
    });
  });
});
</script>

@endsection