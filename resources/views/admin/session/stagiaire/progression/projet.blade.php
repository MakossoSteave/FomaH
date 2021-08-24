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

    @if($projets->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucun projet n'existe pour ce stagiaire
        </div>
    @else

  
    <div class="columns is-multiline mt-3">
    @foreach($projets as $projet)
            <div class="column is-4">
            <div class="card is-shady">
                <div class="card-image">
                <img src="{{ URL::asset('/') }}img/projet.jpg" alt="" class="img is-4by3">
                </div>
                <div class="card-content  @if($projet->resultat_description && $projet->statut_reussite!==null) {{$projet->statut_reussite==1? 'has-background-success':'has-background-danger'}} @endif">
                <div class="content">
                    <h4 >{{$projet->description}}</h4>
                    @if($projet->lien)
                    @if(substr($projet->lien,-4)=='.pdf')
                    <p> Document:  <embed class="image is-4by3" src="{{ URL::asset('/') }}doc/faireProjet/{{ $projet->lien }}" scale="tofit" /></p>
                    @else
                    <p> Lien: {{$projet->lien }}</p>
                   
                    @endif
                    @endif
                    @if($projet->resultat_description && $projet->statut_reussite)
                    <p> Description résultat: {{$projet->resultat_description }}</p>
                   
                    @endif
                    <a href="{{ Route('projetStagiaireModifierResultat',[$projet->id_projet,$projet->id_stagiaire,$projet->id_session])}}" class="button is-link modal-button">Modifier le résultat</a>
                        <a href="{{ Route('projetViewStagiaire',$projet->id_projet)}}" class="button is-link modal-button">Voir le Projet</a>
                </div>
                </div>
            </div>
        </div>
      @endforeach
    </div>
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
                        <a href="/qcm">
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
