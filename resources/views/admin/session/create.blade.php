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
    <h2 class="title is-2 has-text-centered mt-6">Ajouter une session</h2>
    <form action="{{ route('session.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf

        <div class="field">
            <label class="label">Date de début</label>
                <div class="control">
                    <input name="date_debut" class="input" type="date" placeholder="Date de début">
                </div>
        </div>

        <div class="field">
            <label class="label">Date de fin</label>
                <div class="control">
                    <input name="date_fin" class="input" type="date" placeholder="Date de fin"></input>
                </div>
        </div>

        <div class="field">
            <label class="label">Choisir le cursus</label>
                <div class="control">
                    <div class="select">
                    <select name="formation_id">
                        @foreach ($formations as $formation)
                            <option value="{{$formation->id}}">{{$formation->libelle}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>

        <div class="field">
            <label class="label">Choisir le statut</label>
                <div class="control">
                    <div class="select">
                    <select name="statut_id">
                        @foreach ($statuts as $statut)
                            <option value="{{$statut->id}}">{{$statut->statut}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>

        <div class="field">
            <label class="label">Choisir le formateur référent (facultatif)</label>
                <div class="control">
                    <div class="select">
                    <select name="formateur_id">
                        <option value="">Aucun</option>
                        @foreach ($formateurs as $formateur)
                            <option value="{{$formateur->id}}">{{$formateur->nom}} {{$formateur->prenom}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>

            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Créer</button>
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