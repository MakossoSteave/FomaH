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
    <h2 class="title is-2 has-text-centered mt-6">Ajouter une formation</h2>
    <form action="{{ route('cursus.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf

        <div class="field">
            <label class="label">Titre de la formation</label>
                <div class="control">
                    <input name="libelle" class="input" type="text" placeholder="Titre de la formation">
                </div>
        </div>

        <div class="field">
            <label class="label">Description</label>
                <div class="control">
                    <input name="description" class="input" type="text" placeholder="Description">
                </div>
        </div>

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
            <label class="label">Volume horaire</label>
                <div class="control">
                    <input name="volume_horaire" class="input" type="number" placeholder="Volume horaire">
                </div>
        </div>

        <div class="field">
            <label class="label">Prix</label>
                <div class="control">
                    <input name="prix" class="input" type="number" placeholder="Prix">
                </div>
        </div>

        <div class="field">
            <label class="label">Choisir la categorie</label>
                <div class="control">
                    <div class="select">
                    <select name="categorie_id">
                        @foreach ($categories as $categorie)
                            <option value="{{$categorie->id}}">{{$categorie->designation}}</option>
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
@endsection