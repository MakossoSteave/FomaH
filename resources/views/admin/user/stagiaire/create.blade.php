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
    <h2 class="title is-2 has-text-centered mt-6">Ajouter un stagiaire</h2>
    <form action="{{ route('cours.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf

        <div class="field">
            <label class="label">Nom</label>
                <div class="control">
                    <input name="nom" class="input" type="text" placeholder="Nom du stagiaire">
                </div>
        </div>
        <div class="field">
            <label class="label">Prénom</label>
                <div class="control">
                    <input name="prenom" class="input" type="text" placeholder="Prénom du stagiaire">
                </div>
        </div>
        <div class="field">
            <label class="label">Email</label>
                <div class="control">
                    <input name="email" class="input" type="text" placeholder="Email du stagiaire">
                </div>
        </div>
        <div class="field">
            <label class="label">Téléphone</label>
                <div class="control">
                    <input name="telephone" class="input" type="text" placeholder="Téléphone du stagiaire">
                </div>
        </div>
        <div class="field">
            <label class="label">Image de profil</label>
            <div id="file-js-image-cours" class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="image">
                        <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                            Choisir une image
                        </span>
                        </span>
                        <span class="file-name">
                            Aucune image
                        </span>
                    </label>
            </div>

                <script>
                const fileInput = document.querySelector('#file-js-image-cours input[type=file]');
                fileInput.onchange = () => {
                    if (fileInput.files.length > 0) {
                    const fileName = document.querySelector('#file-js-image-cours .file-name');
                    fileName.textContent = fileInput.files[0].name;
                    }
                }
                </script>
        </div>
        <div class="field">
            <label class="label">Type d'inscriptions</label>
                <div class="control">
                    <div class="select">
                    <select id="select" name="inscription_id">
                        @foreach ($typeInscriptions as $typeInscription)
                            <option value="{{$typeInscription->id}}">{{$typeInscription->type}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>
        <div class="field" id="selectOrganisation">
            <label class="label">Organisations</label>
                <div class="control">
                    <div class="select">
                    <select name="inscription_id">
                        @foreach ($organisations as $organisation)
                            <option value="{{$organisation->id}}">{{$organisation->designation}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>
        <div class="field" id="selectCentre">
            <label class="label">Centre</label>
                <div class="control">
                    <div class="select">
                    <select name="inscription_id">
                        @foreach ($centres as $centre)
                            <option value="{{$centre->id}}">{{$centre->designation}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>
        <div class="field">
            <label class="label">Coach</label>
                <div class="control">
                    <div class="select">
                    <select name="formateur_id">
                    <option value=""  selected>Aucun</option>
                        @foreach ($formateurs as $formateur)
                            <option value="{{$formateur->id}}">{{$formateur->prenom}} {{$formateur->nom}}</option>
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