@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)

<div class="container">
    
    <div class="flex mt-4">
  
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
       
    </div>


    @if (session('error'))
        <div class="notification is-danger has-text-centered my-4">
        <button class="delete"></button>
            {{ session('error') }}
        </div>
    @endif  
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @if($titres->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucun titre n'existe
        </div>
    @else

    @foreach ($titres as $titre)
    <div class="card my-6">
        
        <div class="card-content">
            <div class="media">
                
            
            <div class="media-content">
            @if($titre->sessionID)
            <p class="title is-6 mb-0">Session ID:</p>
                <p class="title is-4">{{$titre->sessionID}}</p>
            @endif
            <p class="title is-6 mb-0">Date:</p>
                <p class="title is-4">{{$titre->date_obtention}}</p>
            <p class="title is-6 mb-0">Stagiaire:</p>
                <p class="title is-4">{{$titre->prenom}} {{$titre->nom}}</p>
            <p class="title is-6 mb-0">Intitulé:</p>
                <p class="title is-4">{{$titre->intitule}}</p>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                  
                    <div class="flex-bottom">
                
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$titre->id}}">Supprimer</a>
                            </p>
                            <p>
                                <a class = "button is-success button-card modal-button" href="{{Route('viewTitre',$titre->id)}}">Voir</a>
                            </p>
                            <div id="{{$titre->id}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Suppression du titre de {{$titre->prenom}} {{$titre->nom}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer le titre de {{$titre->prenom}} {{$titre->nom}} ?
                                    </section>
                                    <form action="{{ route('titre.destroy', $titre->id) }}" method="POST">
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
Votre titre a expiré !
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