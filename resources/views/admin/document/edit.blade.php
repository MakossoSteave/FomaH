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
    <h2 class="title is-2 has-text-centered mt-6">Modifier un document</h2>
    <form action="{{ route('document.update', $document->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')

        <div class="field">
            <label class="label">Nom de la catégorie</label>
                <div class="control">
                    <input name="designation" class="input" type="text" placeholder="Nom de la catégorie" value="{{$document->designation}}">
                </div>
        </div>

        <div class="field">
            <label class="label">Ajouter un document</label>
            <div id="file-js-doc-cours" class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="lien">
                        <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                            Choisir un document
                        </span>
                        </span>
                        <span class="file-name">
                            Aucun document
                        </span>
                    </label>
            </div>

                <script>
                const fileInput = document.querySelector('#file-js-doc-cours input[type=file]');
                fileInput.onchange = () => {
                    if (fileInput.files.length > 0) {
                    const fileName = document.querySelector('#file-js-doc-cours .file-name');
                    fileName.textContent = fileInput.files[0].name;
                    }
                }
                </script>
        </div>

            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Modifier</button>
            </div>
        </div>
    </form>
</div>
@endsection