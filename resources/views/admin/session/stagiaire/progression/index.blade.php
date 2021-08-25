@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)

<div class="container mt-6">
 
    
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
    <div class="card is-shady">
        <div class="card-content">

            <div class="content">
                <div class="flex">
                    <div>
                    <p><span class="title is-6">  Progression: </span>@if($progress) {{$progress}}@else 0 @endif<span class="title is-6">% </span></p>
                    <p><span class="title is-6">  Dernier cours suivis: </span>@if($stagiaire->NomCours) {{$stagiaire->NomCours}}
                    @else Aucun @endif </p>
                    <p><span class="title is-6">  Dernier chapitre suivis: </span>@if($stagiaire->NomChapitre) {{$stagiaire->NomChapitre}}
                    @else Aucun @endif </p> 
                    <p><span class="title is-6">  Nombre total de chapitres lus: </span>@if($stagiaire->nombre_chapitre_lu) {{$stagiaire->nombre_chapitre_lu}}
                    @else 0 @endif</p>   
                    
                   
                    </div>
                    <div class="flex-bottom">
                    <form action="{{ route('qcmStagiaire',  [$stagiaire->id_stagiaire,$stagiaire->id_session]) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info" style="width:200px;">Voir résultat des QCM</button>
                    </form>
                    <form action="{{ route('projetStagiaire',  [$stagiaire->id_stagiaire,$stagiaire->id_session]) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Voir les projets</button>
                    </form>
                   
                          
                           
                             
                               
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
