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
    <h2 class="title is-2 has-text-centered mt-6">Modifier un projet</h2>
    <form action="{{ route('projet.update', $projet->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')

        <div class="field">
            <label class="label">Descritpion du projet</label>
                <div class="control">
                    <textarea name="description" class="textarea" type="text" placeholder="Descritpion du projet" value="{{$projet->description}}"></textarea>
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