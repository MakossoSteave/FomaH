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
    <h2 class="title is-2 has-text-centered mt-6">Ajouter un chapitre</h2>
    <form action="{{ route('chapitre.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf

        <div class="field">
            <label class="label">Titre du chapitre</label>
                <div class="control">
                    <input name="designation" class="input" type="text" placeholder="Titre du chapitre">
                </div>
        </div>

        <div class="field">
            <label class="label">Ajouter une image</label>
            <div id="file-js-image-chapitre" class="file has-name">
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
                const fileInput = document.querySelector('#file-js-image-chapitre input[type=file]');
                fileInput.onchange = () => {
                    if (fileInput.files.length > 0) {
                    const fileName = document.querySelector('#file-js-image-chapitre .file-name');
                    fileName.textContent = fileInput.files[0].name;
                    }
                }
                </script>
        </div>

        <div class="field">
            <label class="label">Ajouter une video</label>
            <div id="file-js-video-chapitre" class="file has-name" >
                    <label class="file-label">
                        <input class="file-input" type="file" name="video">
                        <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                            Choisir une video
                        </span>
                        </span>
                        <span class="file-name">
                            Aucune video
                        </span>
                    </label>
            </div>

                <script>
                const fileInputVideo = document.querySelector('#file-js-video-chapitre input[type=file]');
                fileInputVideo.onchange = () => {
                    if (fileInputVideo.files.length > 0) {
                    const fileNameVideo = document.querySelector('#file-js-video-chapitre .file-name');
                    fileNameVideo.textContent = fileInputVideo.files[0].name;
                    }
                }
                </script>
        </div>

        <div id="addSection"></div>

        <div class="flex">
            <div></div>
            <div class="mt-2 mb-2">
                <a id="buttonAddSection" class="has-icons-right has-text-black" onclick="addSection()">
                    Ajouter une section
                    <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
                </a>
            </div>
        </div>
       <!-- <div class="field">
            <label class="label">Etat chapitre</label>
                                    
                                    <select class="form-select block w-full mt-1"  name="etat">
                                          
                                            <option value="1">
                                                 Activé
                                            </option>
                                            <option value="0" selected>
                                                 Désactivé
                                            </option>
                                        </select>
        </div>-->
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