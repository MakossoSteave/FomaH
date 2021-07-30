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
    <h2 class="title is-2 has-text-centered mt-6">Modifier un chapitre</h2>
    <form action="{{ route('chapitre.update', $chapitre->id_chapitre) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')
        <div class="field">
            <label class="label">Titre du chapitre</label>
                <div class="control">
                    <input name="designation" class="input" type="text" placeholder="Titre du chapitre" value="{{$chapitre->designation}}">
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
                                            @if($chapitre->etat == 1) value="1"
                                            @else value="0"
                                            @endif selected>
                                            @if($chapitre->etat == 1) Activé
                                            @else Désactivé
                                            @endif
                                            </option>
                                            <option
                                            @if(!$chapitre->etat == 1) value="1"
                                            @else value="0"
                                            @endif>
                                            @if(!$chapitre->etat == 1) Activé
                                            @else Désactivé
                                            @endif
                                            </option>
                                        </select>
        </div>

            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Modifier</button>
            </div>
        </div>
    </form>
</div>
@endsection