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
    <form action="{{ route('addCours', $id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf

        <div class="field" id="center-cours-select">
            <label class="label is-size-3">Choisir le cours à ajouter</label>
                <div class="control">
                    <div class="select is-large mt-4 mb-4" id="marg-select">
                    <select name="id_cours">
                        @foreach ($cours as $cour)
                            <option value="{{$cour->id_cours}}">{{$cour->designation}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>

            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Ajouter</button>
            </div>
        </div>
    </form>
</div>
@endsection