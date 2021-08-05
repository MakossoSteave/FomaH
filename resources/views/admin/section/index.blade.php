@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <!-- <a href="{{-- route('addSection', $idChapitre) --}}" class="has-icons-right" id="link-black">
            Ajouter une section
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a> -->
    </div>
    
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @if($sections->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucune section n'existe pour ce chapitre
        </div>
    @else

    @foreach ($sections as $section)
    <div class="card my-6">
        <div class="card-content">
            <div class="media">
            @if(! empty($section->image))
            <div class="media-left">
                <img class="image is-4by3" src="{{ URL::asset('/') }}img/section/{{$section->image}}" alt="Placeholder image">
            </div>
            @endif
            <div class="media-content">
                <p class="title is-4">{{$section->designation}}</p>
                <p class="subtitle is-6">{{$section->contenu}}</p>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                        <a class="{{ $section->etat == 1 ? 'text-green-600' : 'text-red-600'  }} mb-8" href="{{ route('etatSection', $section->id) }}">
                        @if($section->etat == 1) 
                        Activé
                        @else
                        Désactivé
                        @endif
                        </a>
                    </div>
                    <div class="flex-bottom">
                        <!-- <form action="{{-- route('section.edit', $section->id) --}}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form> -->
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$section->id}}">Supprimer</a>
                            </p>
                            <div id="{{$section->id}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Confirmez-vous la suppression de {{$section->designation}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer la section {{$section->designation}} ?
                                    </section>
                                    <form action="{{ route('section.destroy', $section->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <footer class="modal-card-foot">
                                    <button class="button is-success">Confirmer</button>
                                    </footer>
                                    </form>
                                </div>
                            </div>
                            <script>
                            $(".modal-button").click(function() {
                                var target = $(this).data("target");
                                $("html").addClass("is-clipped");
                                $(target).addClass("is-active");
                            });
                            
                            $(".delete").click(function() {
                                var target = $(".modal-button").data("target");
                                $("html").removeClass("is-clipped");
                                $(target).removeClass("is-active");
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endforeach

    @endif

</div>

@else
<div class="notification is-danger has-text-centered my-4">
@if(Auth::user() && Auth::user()->role_id!=1)
Vous n'êtes pas autorisé !
@else
Votre session a expiré !
@endif
</div>
<button type="button" class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                         @if(Auth::user() && Auth::user()->role_id==2)
                        <a href="/centre">
                        @elseif(Auth::user() && Auth::user()->role_id==3)
                        <a href="/stagiaire">
                        @elseif(Auth::user() && Auth::user()->role_id==4)
                        <a href="/formateur">
                        @elseif(Auth::user() && Auth::user()->role_id==5)
                        <a href="/organisme">
                        @else
                        <a href="/">
                        @endif
                        <i class="fas fa-home"></i>
                            <span>Acceuil</span>
                        </a>

</button>
@endif
@endsection