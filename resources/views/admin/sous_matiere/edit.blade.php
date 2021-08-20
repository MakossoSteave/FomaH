@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)
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
    <div class="hauteur100"></div>
    <div class="notification">
        <h2 class="title is-2 has-text-centered mt-6">Modifier une sous-matiere //sous_matiere.edit.blade</h2>
        <form action="{{ route('sousmatiere.update', $sousmatiere->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
            @csrf
            @method('PUT')
            <input name="id"  type="hidden" value="{{$sousmatiere->id}}">

            <div class="field">
                <label class="label">Nom de la sous_matiere</label>
                    <div class="control">
                        <input name="designation_sous_matiere" class="input" type="text" placeholder="Nom de la sous matiere" value="{{$sousmatiere->designation_sous_matiere}}">
                    </div>
            </div>

                <div class="control mt-4 mb-4">
                    <button type="submit" class="button is-fullwidth is-link is-rounded">Modifier</button>
                </div>
            </div>
        </form>
    </div>
</div>
@else
<div class="notification is-danger has-text-centered my-4">
@if(Auth::user() && Auth::user()->role_id!=1)
Vous n'êtes pas autorisé !
@else
Votre session a expiré !
@endif

</div>
<button type="button" class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                         @if(Auth::user() && Auth::user()->role_id==2)
                        <a href="/centre">
                        @elseif(Auth::user() && Auth::user()->role_id==3)
                        <a href="/stagiaire">
                        @elseif(Auth::user() && Auth::user()->role_id==4)
                        <a href="/formateur">
                        @elseif(Auth::user() && Auth::user()->role_id==5)
                        <a href="/organisme">
                        @else
                        <a href="/">
                        @endif
                        <i class="fas fa-home"></i>
                            <span>Acceuil</span>
                        </a>

</button>
@endif
@endsection