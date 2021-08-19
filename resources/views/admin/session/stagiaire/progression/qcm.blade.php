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
            Aucun qcm n'existe pour cette session
        </div>
    @else

  

    @foreach ($qcms as $qcm)
    <div class="card my-6 
@if($qcm->resultat!==null) {{ $qcm->resultat>=60? 'has-background-success' : 'has-background-danger'  }} @endif">
<div class="content">
                <div class="flex">
                    <div>
                    <p class="mt-3 ml-3"><span class="title is-4">  QCM: </span><a class="title is-6 has-text-white"  href="{{ Route('qcmViewStagiaire',$qcm->qcm_id)}}">@if($qcm->designation) {{$qcm->designation}} @endif</a></p>
                    <p><span class="title is-4 ml-3">  Résultat: </span><span class="title is-6 has-text-white" >@if($qcm->resultat){{$qcm->resultat}}% @else 0% @endif</span></p>
                    <p class="mb-3"><span class="title is-4 ml-3">  Date: </span><span class="title is-6 has-text-white" >@if($qcm->updated_at){{$qcm->updated_at}}  @endif</span></p>
                    </div>
</div>
                    </div>

    </div>
    @endforeach
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
