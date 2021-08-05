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
    <h2 class="title is-2 has-text-centered mt-6">Modifier un projet</h2>
    <form action="{{ route('projet.update', $projet->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')

        <div class="field">
            <label class="label">Descritpion du projet</label>
                <div class="control">
                    <input name="description" class="input" type="text" placeholder="Descritpion du projet" value="{{$projet->description}}">
                </div>
        </div>

        <div class="field">
            <label class="label">Date de début (facultatif)</label>
                <div class="control">
                    <input name="date_debut" class="input" type="date" placeholder="Date de début (facultatif)" value="{{$projet->date_debut}}">
                </div>
        </div>

        <div class="field">
            <label class="label">Date de fin (facultatif)</label>
                <div class="control">
                    <input name="date_fin" class="input" type="date" placeholder="Date de fin (facultatif)" value="{{$projet->date_fin}}">
                </div>
        </div>

        <div class="field">
            <label class="label">Choisir le statut</label>
                <div class="control">
                    <div class="select">
                    <select name="statut_id">
                        @foreach ($statuts as $statut)
                            <option value="{{$statut->id}}" {{ ($statut->id == $projet->statut_id) ? 'selected' : '' }}>{{$statut->statut}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>

        <div class="field">
            <label class="label">Etat</label>                      
                <select class="form-select block w-full mt-1"  name="etat">   
                    <option 
                    @if($projet->etat == 1) value="1"
                    @else value="0"
                    @endif selected>
                    @if($projet->etat == 1) Activé
                    @else Désactivé
                    @endif
                    </option>
                    <option
                    @if(!$projet->etat == 1) value="1"
                    @else value="0"
                    @endif>
                    @if(!$projet->etat == 1) Activé
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