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
    <h2 class="title is-2 has-text-centered mt-6">Ajouter un cours</h2>
    <form action="{{ route('cours.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf

        <div class="field">
            <label class="label">Titre du cours</label>
                <div class="control">
                    <input name="designation" class="input" type="text" placeholder="Titre du cours">
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
            <label class="label">Prix</label>
                <div class="control">
                    <input name="prix" class="input" type="number" placeholder="Prix">
                </div>
        </div>

        <div class="field">
            <label class="label">Choisir la formation</label>
                <div class="control">
                    <div class="select">
                    <select name="formation_id">
                    <option value="" {{ ($id == null) ?  'selected' : ''}}>Aucune</option>
                        @foreach ($formations as $formation)
                            <option value="{{$formation->id}}" {{ ($id == $formation->id) ? 'selected' : '' }}>{{$formation->libelle}}</option>
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