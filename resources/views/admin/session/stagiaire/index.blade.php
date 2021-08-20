@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
       
        @if(($stagiairesCount < $effectif) && ($sessionStatut==1 || $sessionStatut==2 || $sessionStatut==3 ))
        <a href="{{ route('AddStagiaireSession',$id) }}" class="has-icons-right" id="link-black">
            Ajouter un stagiaire
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a>
        @endif
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

    @if($stagiaires->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucun stagiaire n'existe pour cette session
        </div>
    @else

  

    @foreach ($stagiaires as $stagiaire)
    <div class="card my-6 
@if($stagiaire->validation!==null && ($sessionStatut==4 || $sessionStatut==5) ) {{ $stagiaire->validation == 1 ? 'has-background-success' : 'has-background-danger'  }} @endif">
@if($stagiaire->etat == 1) 
<div class="media-content">
                <div class="flex">
                 <div></div>
                    <div class="dropdown is-right is-hoverable">
                        <div class="dropdown-trigger">
                            <button class="button borderNone is-right  @if($stagiaire->validation!==null && ($sessionStatut==4 || $sessionStatut==5) ) {{ $stagiaire->validation == 1 ? 'has-background-success' : 'has-background-danger'  }} @endif"
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
                        

                            <a href="{{ route('progressionStagiaire', [$stagiaire->stagiaireID,$id]) }}" class="dropdown-item">
                               Voir la progression
                            </a>
                           
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            @endif
        <div class="card-content">
            <div class="media">
            @if(! empty($stagiaire->image))
            <div class="media-left">
            <figure class="image is-96x96 containerProfil">
                <img class="image is-rounded" src="{{ URL::asset('/') }}img/user/{{$stagiaire->image}}" alt="Placeholder image">
            </figure>
            </div>
            @endif
            
           <!--<div class="media-content">
                <div class="flex">
            <div>
              
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
                        <form action="" method="GET">
                            @csrf
                            <button type="submit" class="dropdown-item">Suivis</button>
                        </form>

                        <a href="" class="dropdown-item">
                            Projets
                        </a>
                        </div>
                    </div>
                </div>
                </div></div></div>-->
            
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                        <p><span class="title is-6"> {{$stagiaire->prenom}} {{$stagiaire->nom}} </span> </p>
                        @if($stagiaire->resultat_description && ($sessionStatut==4 || $sessionStatut==5 ))
                        <p><span class="title is-6">Description du résultat:</span> </p><p><span class="subtitle is-5 has-text-white">{{$stagiaire->resultat_description}}</span></p>
                        @endif
                        
                        
                        <a class="{{ $stagiaire->etat == 1 ? 'text-green-600' : 'text-red-600'  }} mb-8" href="{{ route('etatStagiaireSession', [$stagiaire->stagiaireID,$id]) }}">
                        @if($stagiaire->etat == 1) 
                        Activé
                        @else
                        Désactivé
                        @endif
                        </a>
                    </div>
                    <div class="flex-bottom">
                    @if(($sessionStatut==4 || $sessionStatut==5) && $stagiaire->etat == 1  && ( $sessionEtat==1) )
                        <form action="{{ route('editStagiaireSession', [$stagiaire->stagiaireID,$id]) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier le résultat</button>
                        </form>
                    @endif
                    @if( $stagiaire->etat == 1 && $stagiaire->validation==1 && ($sessionStatut==4 || $sessionStatut==5)  && ( $sessionEtat==1) )
                    <form action="{{ route('createPDF', [$stagiaire->stagiaireID,$id]) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Générer le diplôme</button>
                    </form>
                    @endif
                            <p>
                                <a class = "button is-warning button-card modal-button" style="width:200px;" data-target = "#{{$stagiaire->stagiaireID}}">Supprimer de la session</a>
                            </p>
                            <div id="{{$stagiaire->stagiaireID}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Suppression du stagiaire {{$stagiaire->prenom}} {{$stagiaire->nom}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer le/la stagiaire {{$stagiaire->prenom}} {{$stagiaire->nom}} de la session ?
                                    </section>
                                    <form action="{{ route('removeStagiaire', [$stagiaire->stagiaireID,$id]) }}" method="POST">
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
    {!! $stagiaires->links() !!}
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
