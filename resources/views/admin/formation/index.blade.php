@extends('layouts.app')

@section('content')

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ url('addFormation')}}" class="has-icons-right" id="link-black">
            Ajouter une formation
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a>
    </div>
    
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @foreach ($formations as $formation)
    <div class="card my-6">
        <div class="card-content">
            <div class="media">
            <div class="media-left">
                <img class="image is-4by3" src="{{ URL::asset('/') }}img/formation/{{$formation->image}}" alt="Placeholder image">
            </div>
            <div class="media-content">
                <p class="title is-4">{{$formation->libelle}}</p>
                <p class="subtitle is-6">{{$formation->description}}</p>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                        <p class="subtitle is-6">Volume horaire : {{$formation->volume_horaire}}h</p>
                        <p class="subtitle is-6">Nombre de cours : {{$formation->nombre_cours_total}}</p>
                        <p class="subtitle is-6">Nombre de chapitre : {{$formation->nombre_chapitre_total}}</p>
                        <p class="subtitle is-6">Prix: {{$formation->prix}}€</p>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endforeach

</div>

@endsection