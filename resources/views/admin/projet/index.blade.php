@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)
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
    @if (session('error'))
        <div class="notification is-danger has-text-centered my-4">
            {{ session('error') }}
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
                        <div class="media">
                        @foreach($projet->document as $document)
                        @if(!empty($document->lien))
                        <div class="media-left">
                            <embed class="image is-4by3" src="{{ URL::asset('/') }}doc/projet/{{ $document->lien }}" />
                        </div>
                        @endif
                        @endforeach
                        <div class="media-content">
                            <div class="flex">
                                <p class="title is-4">{{$projet->description}}</p>
                            </div>
                        </div>
                    </div>
                    <a class="{{ $projet->etat == 1 ? 'text-green-600' : 'text-red-600'  }} mb-8" href="{{ route('etatProjet', $projet->id) }}">
                            @if($projet->etat == 1) 
                            Activé
                            @else
                            Désactivé
                            @endif
                    </a>
                    <!-- <div>
                    <p class="subtitle is-4"><span class="subtitle is-6">Créé par</span> {{-- $formateur->prenom --}} {{-- $formateur->nom --}}</p>
                    </div> -->
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
                            <input type="hidden" name="id_cours" value="{{request()->route('id')}}">
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
    {!! $projets->links() !!}
    @endif

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