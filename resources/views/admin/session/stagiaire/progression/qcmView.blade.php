@extends('layouts.app')

@section('content')
@if(Auth::user() && (Auth::user()->role_id==1 || Auth::user()->role_id==4))

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

    @if($qcm==null))
        <div class="notification is-warning has-text-centered my-4">
            Aucun QCM n'existe pour ce stagiaire
        </div>
    @else

   
    <div class="card my-6">
        <div class="card-content">
            <div class="media">
            <div class="media-content">
          
                <p class="title is-4">{{$qcm->designation}}</p>
                @foreach($qcm->question_qcm as $questions)
                <p class="subtitle is-5 mt-4"> {{$questions->question}}</p>
                <p class="subtitle is-5"> {{$questions->explication}}</p>
                @foreach($questions->reponse_question_qcm as $reponses)
                    <p class="subtitle is-6 {{ ($reponses->validation == 1) ?  'has-text-success' : 'has-text-danger'}}"> {{$reponses->reponse}}</p>
                    @endforeach
                @endforeach
                
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

  
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
