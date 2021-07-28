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
    <h2 class="title is-2 has-text-centered mt-6">Modifier une section</h2>
    <form action="{{ route('section.update', $section->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')
        <input name="id" type="hidden" value="{{$section->id}}">
        
        <input type="hidden" name="id_chapitre" value="{{$section->id_chapitre}}">

        <div class="field">
            <label class="label">Titre de la section</label>
                <div class="control">
                    <input name="designation" class="input" type="text" placeholder="Titre de la section" value="{{$section->designation}}">
                </div>
        </div>

        <div class="field">
            <label class="label">Contenu</label>
                <div class="control">
                    <input name="contenu" class="input" type="text" placeholder="Contenu" value="{{$section->contenu}}">
                </div>
        </div>

        <input name="image-link" type="hidden" value="{{$section->image}}">
        <div class="field">
            <label class="label">Ajouter une image</label>
            <div id="file-js-image-cours" class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="image">
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
                <select class="form-select block w-full mt-1"  name="etat">   
                    <option 
                    @if($section->etat == 1) value="1"
                    @else value="0"
                    @endif selected>
                    @if($section->etat == 1) Activé
                    @else Désactivé
                    @endif
                    </option>
                    <option
                    @if(!$section->etat == 1) value="1"
                    @else value="0"
                    @endif>
                    @if(!$section->etat == 1) Activé
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