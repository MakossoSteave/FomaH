@extends('layouts.appIntranetFormateur')

@section('content')
@if(Auth::user())
{{dd($sessionFormateur)}}
        <div class="column is-9">
            <div class="content is-medium">
            <h3 class="has-text-centered">Votre session</h2>
                <span class="percentage mb-4"></span>
                <h1 class="has-text-centered mb-4 is-size-3"></h1>
                    <p class="mb-4"></p>
            </div>
        </div>
    </section>

@else
<div class="notification is-danger has-text-centered my-4">
Votre session a expiré !
</div>
<button type="button" class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <a href="/">
                        <i class="fas fa-home"></i>
                            <span>Acceuil</span>
                        </a>

</button>
@endif
@endsection