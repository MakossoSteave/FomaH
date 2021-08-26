@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)

<div class="container">
    
    <div class="flex mt-4">
  
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ route('addSession') }}" class="has-icons-right" id="link-black">
            Ajouter une session
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a>
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

    @if($sessions->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucune session n'existe
        </div>
    @else

    @foreach ($sessions as $session)
    <div class="card my-6">
        
        <div class="card-content">
            <div class="media">
                
            
            <div class="media-content">
            <div class="media-content">
                <div class="flex">
                 <div></div>
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
                        

                            <a href="{{ route('StagiaireSession', $session->id) }}" class="dropdown-item">
                                Stagiaires
                            </a>
                            @if(date('Y-m-d')>=$session->date_fin && $session->statut_id!==1 && $session->statut_id!==2)
                            <a href="{{ route('titre.show', $session->id) }}" class="dropdown-item">
                                Titres
                            </a>
                            @endif
                            <a href="{{ route('Session_Projet', $session->id) }}"  class="dropdown-item">
                                Projets
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <p class="title is-6 mb-0">Date:</p>
                <p class="title is-4">{{date('d-m-Y', strtotime($session->date_debut))}}</p>
                <p class="subtitle is-6">{{date('d-m-Y', strtotime($session->date_fin))}}</p>
                <p><span class="title is-6"> Cursus: </span> <span class="subtitle is-6"> {{$session->libelle}}</span></p>
                <p><span class="title is-6"> Formateur: </span> <span class="subtitle is-6"> {{$session->nom}} {{$session->prenom}}</span></p>
                <p><span class="title is-6"> Statut: </span> <span class="subtitle is-6"> {{$session->statut}}</span></p>
            
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                        <a class="{{ $session->etat == 1 ? 'text-green-600' : 'text-red-600'  }} mb-8" href="{{ route('etatSession', $session->id) }}">
                        @if($session->etat == 1) 
                        Activé
                        @else
                        Désactivé
                        @endif
                        </a>
                    </div>
                    <div class="flex-bottom">
                        <form action="{{ route('session.edit', $session->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form>
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$session->id}}">Supprimer</a>
                            </p>
                            <form action="{{ route('cursus.show', $session->formations_id) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-primary">Voir le cursus</button>
                        </form>
                            <div id="{{$session->id}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Suppression de la session du {{date('d-m-Y', strtotime($session->date_debut))}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer la session du {{date('d-m-Y', strtotime($session->date_debut))}} au {{date('d-m-Y', strtotime($session->date_fin))}} ?
                                    </section>
                                    <form action="{{ route('session.destroy', $session->id) }}" method="POST">
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
    {!! $sessions->links() !!}
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