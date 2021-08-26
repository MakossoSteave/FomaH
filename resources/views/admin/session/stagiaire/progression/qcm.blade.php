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

    @if($qcms->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucun qcm n'existe pour ce stagiaire
        </div>
    @else

  
    <div class="columns is-multiline mt-3">
    @foreach($qcms as $qcm)
           
            <div class="column is-4">
            <div class="card is-shady">
                <div class="card-image">
                <img src="{{ URL::asset('/') }}img/quiz.jpg" alt="" class="img is-4by3">
                </div>
                <div class="card-content">
                <div class="content">
                    <h4>{{$qcm->designation}}</h4>
                   
                        <span class="percentage mb-4">{{$qcm->resultat}}% de réussite</span>
                        <progress class="progress @if($qcm->resultat!==null) {{ $qcm->resultat>=60? 'is-success' : 'is-danger'  }} @endif" value="{{$qcm->resultat}}" max="100"></progress>
                   
                        <a href="{{ Route('qcmViewStagiaire',$qcm->qcm_id)}}" class="button is-link modal-button">Voir le QCM</a>
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
