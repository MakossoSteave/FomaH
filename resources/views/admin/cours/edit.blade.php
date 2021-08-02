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
    <h2 class="title is-2 has-text-centered mt-6">Modifier un cours</h2>
    <form action="{{ route('cours.update', $cours->id_cours) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="formation_id" value="{{$idFormation}}">
        <input name="id_cours" type="hidden" value="{{$cours->id_cours}}">
        <input name="numero_cours" type="hidden" value="{{$cours->numero_cours}}">

        <div class="field">
            <label class="label">Titre du cours</label>
                <div class="control">
                    <input name="designation" class="input" type="text" placeholder="Titre du cours" value="{{$cours->designation}}">
                </div>
        </div>

        <input name="image-link" type="hidden" value="{{$cours->image}}">
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
            <label class="label">Prix</label>
                <div class="control">
                    <input name="prix" class="input" type="number" placeholder="Prix" value="{{$cours->prix}}">
                </div>
        </div>
        <div class="field">
            <label class="label">Etat</label>
                                    
                                    <select class="form-select block w-full mt-1"  name="etat">
                                          
                                            <option 
                                            @if($cours->etat == 1) value="1"
                                            @else value="0"
                                            @endif selected>
                                            @if($cours->etat == 1) Activé
                                            @else Désactivé
                                            @endif
                                            </option>
                                            <option
                                            @if(!$cours->etat == 1) value="1"
                                            @else value="0"
                                            @endif>
                                            @if(!$cours->etat == 1) Activé
                                            @else Désactivé
                                            @endif
                                            </option>
                                        </select>
        </div>
        <input name="formateur" type="hidden" value="{{$cours->formateur}}">

            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Modifier</button>
            </div>
        </div>
    </form>
</div>
@endsection