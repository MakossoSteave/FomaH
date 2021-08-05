@extends('layouts.app')

@section('content')

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ route('addProjet', request()->route('id') ) }}" class="has-icons-right" id="link-black">
            Ajouter un projet
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a>
    </div>
    
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @if($projets->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucun projet n'existe pour ce cours
        </div>
    @else

    @foreach ($projets as $projet)
    <div class="card my-6">
        <div class="card-content">
            <div class="media-content">
                <div class="flex">
                    <div>
                        <p class="title is-4">{{$projet->description}}</p>
                    @if(! empty($projet->date_debut))
                        <p class="title is-4">{{$projet->date_debut}}</p>
                    @endif
                    @if(! empty($projet->date_fin))
                        <p class="title is-4">{{$projet->date_fin}}</p>
                    @endif
                        <a class="{{ $projet->etat == 1 ? 'text-green-600' : 'text-red-600'  }} mb-8" href="{{ route('etatProjet', $projet->id) }}">
                            @if($projet->etat == 1) 
                            Activé
                            @else
                            Désactivé
                            @endif
                        </a>
                    </div>
                    <div>
                    <p class="subtitle is-4"><span class="subtitle is-6">Créé par</span> {{$projet->formateurPrenom}} {{$projet->formateurNom}}</p>
                    </div>
                </div>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                    </div>
                    <div class="flex-bottom">
                        <form action="{{ route('projet.edit', $projet->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form>
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$projet->id}}">Supprimer</a>
                            </p>
                            <div id="{{$projet->id}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Confirmez-vous la suppression de {{$projet->description}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer la catégorie {{$projet->description}} ?
                                    </section>
                                    <form action="{{ route('projet.destroy', $projet->id) }}" method="POST">
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

@endsection