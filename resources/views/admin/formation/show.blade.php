@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)

<div class="container">
  
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="notification is-danger has-text-centered my-4">
        <button class="delete"></button>
            {{ session('error') }}
        </div>
    @endif
    
  

  
    <div class="card my-6">
        <div class="card-content">
        <div class="media">
            @if(!empty($formation->image))
            <div class="media-left">
                <img class="image is-4by3" src="{{ URL::asset('/') }}img/formation/{{$formation->image}}" alt="Placeholder image">
            </div>
                @endif
            <div class="media-content">
            <div class="flex">
                <div>
                        <p class="title is-4">{{$formation->libelle}}</p>
                        <p class="subtitle is-6">{{$formation->description}}</p>
                </div>
                <a href="{{ route('createCours', $formation->id) }}" class="has-icons-right" id="link-black">
                    Ajouter un cours
                    <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
                </a>
            </div>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                        <p class="subtitle is-6">Volume horaire : {{$formation->volume_horaire}}h</p>
                        <p class="subtitle is-6">Nombre de cours actifs: {{$formation->nombre_cours_total}}</p>
                        <p class="subtitle is-6">Nombre de chapitre actifs: {{$formation->nombre_chapitre_total}}</p>
                        <p class="subtitle is-6">Prix: {{$formation->prix}}€</p>
                        <p class="subtitle is-6">Effectif: {{$formation->effectif}}</p>
                        <a class="{{ $formation->etat == 1 ? 'text-green-600' : 'text-red-600'  }} mb-8" href="{{ route('etatFormation', $formation->id) }}">
                        @if($formation->etat == 1) 
                        Activé
                        @else
                        Désactivé
                        @endif
                        </a>
                    </div>
                    <div class="flex-bottom">
                        <form action="{{ route('cursus.edit', $formation->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form>
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$formation->id}}">Supprimer</a>
                            </p>
                            <div id="{{$formation->id}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Confirmez-vous la suppression de {{$formation->libelle}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer le formation {{$formation->libelle}} ?
                                    </section>
                                    <form action="{{ route('cursus.destroy', $formation->id) }}" method="POST">
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
                        <form action="{{ route('coursFilter', $formation->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-primary">Voir les cours</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

  
  
  

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