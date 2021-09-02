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
    @if (session('error'))
        <div class="notification is-danger has-text-centered my-4">
        <button class="delete"></button>
            {{ session('error') }}
        </div>
    @endif
    <h2 class="title is-2 has-text-centered mt-6">Modifier un stagiaire</h2>
    <form action="{{ route('stagiaire.update',$stagiaire->user_id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')

        <div class="field">
            <label class="label">Nom</label>
                <div class="control">
                    <input name="nom" class="input" type="text" placeholder="Nom du stagiaire" value="{{$stagiaire->nom}}">
                </div>
        </div>
        <div class="field">
            <label class="label">Prénom</label>
                <div class="control">
                    <input name="prenom" class="input" type="text" placeholder="Prénom du stagiaire" value="{{$stagiaire->prenom}}">
                </div>
        </div>
        <div class="field">
            <label class="label">Email</label>
                <div class="control">
                    <input name="email" class="input" type="text" placeholder="Email du stagiaire" value="{{$stagiaire->email}}">
                </div>
        </div>
        <div class="field">
            <label class="label">Téléphone</label>
                <div class="control">
                    <input name="telephone" class="input" type="text" placeholder="Téléphone du stagiaire" value="{{$stagiaire->telephone}}">
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
                    <select id="selectTypeInscription" name="typeInscription">
                        @foreach ($typeInscriptions as $typeInscription)
                            <option value="{{$typeInscription->id}}" @if($typeInscription->id==$stagiaire->type_inscription_id)selected @endif>{{$typeInscription->type}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>
        <div class="field" @if($stagiaire->organisation_id==null)  id="selectOrganisation" @endif>
            <label class="label">Organisations</label>
                <div class="control">
                    <div class="select">
                    <select  name="organisation_id">
                    @if(!$stagiaire->organisation_id)
                     <option value=""  selected>Aucune</option>
                    @endif
                        @foreach ($organisations as $organisation)
                            <option value="{{$organisation->id}}"  @if($organisation->id==$stagiaire->organisation_id)selected @endif>{{$organisation->designation}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>
        
        <div class="field" @if($stagiaire->entreprise_id==null) id="selectEntreprise" @endif>
            <label class="label">Entreprise</label>
                <div class="control">
                    <div class="select">
                    <select name="entreprise_id">
                    @if(!$stagiaire->entreprise_id)
                     <option value=""  selected>Aucune</option>
                    @endif
                        @foreach ($entreprises as $Entreprise)
                            <option value="{{$Entreprise->id}}"  
                                @if($Entreprise->id==$stagiaire->entreprise_id)selected @endif>{{$Entreprise->designation}}</option>
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
                    <option value="" 
                     @if(!$stagiaire->formateur_id) selected @endif
                     >Aucun</option>
                        @foreach ($formateurs as $formateur)
                            <option value="{{$formateur->id}}"
                            @if($stagiaire->formateur_id == $formateur->id) selected @endif   
                            >{{$formateur->prenom}} {{$formateur->nom}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>
        <div class="field">
            <label class="label">Mot de passe</label>
                <div class="control">
                    <input name="Oldmotdepasse" class="input" type="password" placeholder="Mot de passe du stagiaire">
                </div>
        </div>
        <div class="field">
            <label class="label">Nouveau mot de passe</label>
                <div class="control">
                    <input name="motdepasse" class="input" type="password" placeholder="Nouveau mot de passe du stagiaire">
                </div>
        </div>
        <div class="field">
            <label class="label">Confirmation du mot de passe</label>
                <div class="control">
                    <input name="motdepasse_confirmation" class="input" type="password" placeholder="Confirmation du mot de passe du stagiaire">
                </div>
        </div>
            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Modifier</button>
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
                        <a href="/Entreprise">
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