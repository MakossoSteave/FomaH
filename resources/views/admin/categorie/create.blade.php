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
    <h2 class="title is-2 has-text-centered mt-6">Ajouter une catégorie</h2>
    <form action="{{ route('categorie.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf

        <div class="field">
            <label class="label">Nom de la catégorie</label>
                <div class="control">
                    <input name="designation" class="input" type="text" placeholder="Nom de la catégorie">
                </div>
        </div>

            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Créer</button>
            </div>
        </div>
    </form>
</div>
@endsection