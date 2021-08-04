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
    <h2 class="title is-2 has-text-centered mt-6">Modifier une session</h2>
    <form action="{{ route('session.update', $session->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')
        <input name="id" type="hidden" value="{{$session->id}}">

        <div class="field">
            <label class="label">Date de début</label>
                <div class="control">
                    <input name="date_debut" class="input" type="date" placeholder="Date de début" value="{{$session->date_debut}}">
                </div>
        </div>

        <div class="field">
            <label class="label">Date de fin</label>
                <div class="control">
                    <input name="date_fin" class="input" type="date" placeholder="Date de fin" value="{{$session->date_fin}}"></input>
                </div>
        </div>

        <div class="field">
            <label class="label">Choisir le cursus</label>
                <div class="control">
                    <div class="select">
                    <select name="formation_id">
                        @foreach ($formations as $formation)
                            <option value="{{$formation->id}}"{{ ($formation->id == $session->formations_id) ? 'selected' : '' }}>{{$formation->libelle}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>

        <div class="field">
            <label class="label">Choisir le statut</label>
                <div class="control">
                    <div class="select">
                    <select name="statut_id">
                        @foreach ($statuts as $statut)
                            <option value="{{$statut->id}}" {{ ($statut->id == $session->statut_id) ? 'selected' : '' }}>{{$statut->statut}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>

        <div class="field">
            <label class="label">Choisir le formateur référent (facultatif)</label>
                <div class="control">
                    <div class="select">
                    <select name="formateur_id">
                        <option value="">Aucun</option>
                        @foreach ($formateurs as $formateur)
                            <option value="{{$formateur->id}}" {{ ($formateur->id == $session->formateur_id) ? 'selected' : '' }}>{{$formateur->nom}} {{$formateur->prenom}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>

        <div class="field">
            <label class="label">Etat</label>                      
                <select class="form-select block w-full mt-1"  name="etat">   
                    <option 
                    @if($session->etat == 1) value="1"
                    @else value="0"
                    @endif selected>
                    @if($session->etat == 1) Activé
                    @else Désactivé
                    @endif
                    </option>
                    <option
                    @if(!$session->etat == 1) value="1"
                    @else value="0"
                    @endif>
                    @if(!$session->etat == 1) Activé
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