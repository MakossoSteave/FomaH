@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ url('addCours')}}" class="has-icons-right" id="link-black">
            Ajouter un cours
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
        <button class="delete"></button>
            {{ session('error') }}
        </div>
    @endif

    @if($cours->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucun cours n'existe pour cette formation
        </div>
    @else

  

    @foreach ($cours as $cour)
    <div class="card my-6">
        <div class="card-content">
            <div class="media">
            @if(! empty($cour->image))
            <div class="media-left">
                <img class="image is-4by3" src="{{ URL::asset('/') }}img/cours/{{$cour->image}}" alt="Placeholder image">
            </div>
            @endif
            
            <div class="media-content">
                <div class="flex">
            <div>
                <p class="title is-4">{{$cour->designation}}</p>
            </div>
                <div class="dropdown is-right is-hoverable">
                    <div class="dropdown-trigger">
                        <button class="button borderNone is-right"
                                aria-haspopup="true"
                                aria-controls="dropdown-menu">
                        <span class="icon is-small is-right"><i class="fas fa-bars"></i></span>
                        <span class="icon is-small">
                        </span>
                        </button>
                    </div>
            
                    <div class="dropdown-menu" 
                        id="dropdown-menu" 
                        role="menu">
                        <div class="dropdown-content">
                        <form action="{{ route('chapitre', $cour->id_cours) }}" method="GET">
                            @csrf
                            <button type="submit" class="dropdown-item">Chapitres</button>
                        </form>

                        <a href="{{ route('projet', $cour->id_cours) }}" class="dropdown-item">
                            Projets
                        </a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                        <p class="subtitle is-4"><span class="subtitle is-6">Créé par</span> {{$cour->formateurPrenom}} {{$cour->formateurNom}}</p>
                        <p class="title is-6 mt-4">Nombre de chapitres actifs: {{$cour->nombre_chapitres}}</p>
                        <p class="title is-6">Prix: {{$cour->prix}}€</p>
                        <a class="{{ $cour->etat == 1 ? 'text-green-600' : 'text-red-600'  }} mb-8" href="{{ route('etatCours', $cour->id_cours) }}">
                        @if($cour->etat == 1) 
                        Activé
                        @else
                        Désactivé
                        @endif
                        </a>
                    </div>
                    <div class="flex-bottom">
                        <form action="{{ route('cours.edit', $cour->id_cours) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form>
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$cour->id_cours}}">Supprimer</a>
                            </p>
                            <div id="{{$cour->id_cours}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Confirmez-vous la suppression de {{$cour->designation}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer le cours {{$cour->designation}} ?
                                    </section>
                                    <form action="{{ route('cours.destroy', $cour->id_cours) }}" method="POST">
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
    {!! $cours->links() !!}
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