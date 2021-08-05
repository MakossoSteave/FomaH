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
    <h2 class="title is-2 has-text-centered mt-6">Ajouter un projet</h2>
    <form action="{{ route('projet.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf

        <input name="id_cours" type="hidden" value="{{request()->route('id')}}">

        <div class="field">
            <label class="label">Descritpion du projet</label>
                <div class="control">
                    <input name="description" class="input" type="text" placeholder="Descritpion du projet">
                </div>
        </div>

        <div class="field">
            <label class="label">Date de début (facultatif)</label>
                <div class="control">
                    <input name="date_debut" class="input" type="date" placeholder="Date de début (facultatif)">
                </div>
        </div>

        <div class="field">
            <label class="label">Date de fin (facultatif)</label>
                <div class="control">
                    <input name="date_fin" class="input" type="date" placeholder="Date de fin (facultatif)">
                </div>
        </div>

        <div class="field">
            <label class="label">Choisir le statut</label>
                <div class="control">
                    <div class="select">
                    <select name="statut_id">
                        @foreach ($statuts as $statut)
                            <option value="{{$statut->id}}">{{$statut->statut}}</option>
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