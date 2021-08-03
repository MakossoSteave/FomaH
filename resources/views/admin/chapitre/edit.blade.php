@extends('layouts.app')

@section('content')
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
    <div id="formUpdateSection">
    <div id="questionUpdateSection">
    <h2 class="title is-2 has-text-centered mt-6">Modifier un chapitre</h2>
    @foreach($chapitre as $chapitres)
    <form action="{{ route('chapitre.update', $chapitres->id_chapitre) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')

        <div class="field">
            <label class="label">Titre du chapitre</label>
                <div class="control">
                    <input name="designation" class="input" type="text" placeholder="Titre du chapitre" value="{{$chapitres->designation}}">
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

        <div class="field">
            <label class="label">Etat</label>
                                    
                                    <select class="form-select block w-full mt-1"  name="etat">
                                          
                                            <option 
                                            @if($chapitres->etat == 1) value="1"
                                            @else value="0"
                                            @endif selected>
                                            @if($chapitres->etat == 1) Activé
                                            @else Désactivé
                                            @endif
                                            </option>
                                            <option
                                            @if(!$chapitres->etat == 1) value="1"
                                            @else value="0"
                                            @endif>
                                            @if(!$chapitres->etat == 1) Activé
                                            @else Désactivé
                                            @endif
                                            </option>
                                        </select>
        </div>
            @foreach($chapitres->section as $keySection => $sections)

            <input type="hidden" name="updateSection[{{$keySection}}][sectionID]" value="{{$sections->id}}">

            <div class='flex'>
                <div>

                </div>
                <div class='mt-2 mb-2'>
                    <a id="{{$sections->id}}" class='has-icons-right has-text-danger deleteUpdateSection'>
                        Supprimer la section
                        <span class='icon is-small is-right'>
                        <i class='fas fa-trash-alt'></i>
                        </span>
                    </a>
                </div>
            </div>

            <div class="field">
                <label class="label">Titre de la section</label>
                    <div class="control">
                        <input name="updateSection[{{$keySection}}][designation]" class="input" type="text" placeholder="Titre de la section" value="{{$sections->designation}}">
                    </div>
            </div>

            <div class="field">
                <label class="label">Contenu</label>
                    <div class="control">
                        <textarea name="updateSection[{{$keySection}}][contenu]" class="textarea" type="text" placeholder="Contenu">{{$sections->contenu}}</textarea>
                    </div>
            </div>

            <div class="field">
                <label class="label">Ajouter une image</label>
                <div id="file-js-image-cours" class="file has-name">
                        <label class="file-label">
                            <input class="file-input" type="file" name="updateSection[{{$keySection}}][image]">
                            <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Choisir un image
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
                <label class="label">Etat</label>                      
                    <select class="form-select block w-full mt-1"  name="updateSection[][etat]">   
                        <option 
                        @if($sections->etat == 1) value="1"
                        @else value="0"
                        @endif selected>
                        @if($sections->etat == 1) Activé
                        @else Désactivé
                        @endif
                        </option>
                        <option
                        @if(!$sections->etat == 1) value="1"
                        @else value="0"
                        @endif>
                        @if(!$sections->etat == 1) Activé
                        @else Désactivé
                        @endif
                        </option>
                    </select>
            </div>
            @endforeach
        @endforeach

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

            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Modifier</button>
            </div>
        </div>
    </form>
    </div>
    </div> 
</div>
@endsection