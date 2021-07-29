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
    <h2 class="title is-2 has-text-centered mt-6">Ajouter un QCM</h2>
    <form action="{{ route('qcm.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf

        <div class="field">
            <label class="label">Titre du QCM</label>
                <div class="control">
                    <input name="designation" class="input" type="text" placeholder="Titre du QCM">
                </div>
        </div>

        <!-- <div class="field">
            <label class="label">Question</label>
                <div class="control">
                    <input name="question" class="input" type="text" placeholder="Question">
                </div>
        </div>

        <div class="field">
            <label class="label">Explication</label>
                <div class="control">
                    <input name="explication" class="input" type="text" placeholder="Explication">
                </div>
        </div> -->
        <div id="addQuestion"></div>
        
        <div class="flex">
            <div></div>
            <div class="mt-2 mb-2">
                <a id="buttonAddQuestion" class="has-icons-right has-text-black" onclick="addQuestion()">
                    Ajouter une question
                    <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
                </a>
            </div>
        </div>

        <div class="field">
            <label class="label">Choisir le chapitre du QCM</label>
                <div class="control">
                    <div class="select">
                    <select name="id_chapitre">
                        @foreach ($chapitres as $chapitre)
                            <option value="{{$chapitre->id_chapitre}}">{{$chapitre->designation}}</option>
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