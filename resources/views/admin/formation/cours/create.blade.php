@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)
<div class="container is-max-desktop">
    @if ($errors->any())
    <div class="notification is-danger">
        <button class="delete"></button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
    </div>
    @endif
    <h2 class="title is-2 has-text-centered mt-6">Ajouter un cours</h2>
    <form action="{{ route('addCours', $id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf

        <div class="field has-text-centered">
            <label class="label is-size-3">Choisir le cours à ajouter</label>
                <div class="control">
                    <div class="select is-large mt-4 mb-4" id="center-cours-select">
                    <select name="id_cours">
                        @foreach ($cours as $cour)
                            <option value="{{$cour->id_cours}}">{{$cour->designation}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
            <div class="control mt-4 mb-4">
                <button type="submit" class="button width-forma-button is-link is-rounded">Ajouter</button>
            </div>
        </div>
    </form>

    <form action="{{ route('newCours', $id) }}" method="GET" enctype="multipart/form-data" class="mt-6">
        @csrf

        <div class="field has-text-centered mt-4">
            <p class="field has-text-centered mt-2">Ou</p>
                <label class="label is-size-3">Créer le cours à ajouter</label>
            <div class="control mt-4 mb-4">
                <button type="submit" class="button width-forma-button is-link is-rounded">Créer</button>
            </div>
        </div>
    </form>
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