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
    @if (session('error'))
        <div class="notification is-danger has-text-centered my-4">
        <button class="delete"></button>
            {{ session('error') }}
        </div>
    @endif
    <h2 class="title is-2 has-text-centered mt-6">Modifier résultat projet</h2>
    <form action="{{ Route('editResultProjetStagiaire',[$projet->id_projet,$projet->id_stagiaire])}}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
    
    
        <div class="field">
            <label class="label">validation</label>
                                    
                                    <select class="form-select block w-full mt-1"  name="validation">
                                          
                                            <option value="1"
                                             @if($projet->statut_reussite == 1  )
                                                selected
                                                @endif >
                                                 Réussit
                                            </option>
                                            <option value="0" @if($projet->statut_reussite == 0)
                                                selected
                                                @endif>
                                                 Échoue
                                            </option>
                                        </select>
        </div>
        <div class='field'><label class='label'>Description du résultat</label><div class='control'><textarea name='resultat' class='textarea' type='text' placeholder='Description du résultat' >{{$projet->resultat_description}}</textarea></div></div>
            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Modifier</button>
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